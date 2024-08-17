<?php declare(strict_types=1);


namespace App\Model\Logic;


use App\Common\Model\BaseLogic;
use App\Common\Model\Getter\BooksGetter;
use App\Common\Model\Searcher\BooksSearcher;
use App\Exception\ApiException;
use App\Model\Dao\BooksDao;
use App\Model\Entity\Books;
use App\Validator\BooksDataValidator;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Log\Logger;
use Swoft\Redis\Redis;
use Swoft\Task\Task;

/**
 * Class BooksLogic
 * @Bean()
 */
class BooksLogic extends BaseLogic
{
    /**
     * @Inject()
     * @var BooksDao
     */
    protected $booksDao;

    /**
     * @param string $no
     * @param string $title
     * @param string $author
     * @param int $type
     * @param float $price
     * @param string $publish_date
     * @param int $level
     * @return int
     * @throws ApiException
     */
    public function addBooks(
        string $no,
        string $title,
        string $author,
        int    $type,
        float  $price,
        string $publish_date,
        int    $level
    ): int
    {
        $validateData = [
            'no' => $no,
            'title' => $title,
            'author' => $author,
            'type' => $type,
            'price' => $price,
            'publish_date' => $publish_date,
            'level' => $level,
        ];
        validates($validateData, BooksDataValidator::class);
        return $this->booksDao->create($no, $title, $author, $type, $price, $publish_date, $level);
    }

    /**
     * @param int $booksId
     * @return bool
     * @throws ApiException
     */
    public function deleteBooks(int $booksId): bool
    {
        return $this->booksDao->delete($booksId);
    }

    /**
     * @param int $booksId
     * @param array $updateData
     * @return bool
     * @throws ApiException
     */
    public function updateBooks(int $booksId, array $updateData): bool
    {
        $allowUpdateKeys = [
            'title',
            'author',
            'no',
            'type',
            'price',
            'publish_date',
            'level',
        ];
        $update = [];
        foreach ($allowUpdateKeys as $key) {
            if (array_key_exists($key, $updateData)) {
                $update[$key] = $updateData[$key];
            }
        }
        validates($update, BooksDataValidator::class);
        return $this->booksDao->update($booksId, $update);
    }

    /**
     * @param int $booksId
     * @return array
     * @throws ApiException
     */
    public function getBookDetail(int $booksId): array
    {
        $books = $this->booksDao->findOneById($booksId);
        if (is_null($books)) {
            throw new ApiException('记录不存在');
        }
        $books = $books->toArray();
        return self::handleItemByGetter($books, BooksGetter::class);
    }

    /**
     * @param array $filter
     * @param array $column
     * @param array $pageParams
     * @param array $orderByParams
     * @return array
     */
    public function getBooksPageList(array $filter = [], array $column = [], array $pageParams = [], array $orderByParams = []): array
    {
        self::setColumnIfEmpty($column);
        $column = self::getFieldNameArrayWithTableName($column, Books::tableName());
        $queryBuilder = DB::table(Books::tableName());
        self::buildQueryWithContext($queryBuilder);
        self::buildQueryWithSearchCondition($queryBuilder, $filter, BooksSearcher::class, [
            'title',
            'author',
            'no',
            'type',
            'price',
            'publish_date',
            'level'
        ], Books::tableName());
        self::buildQueryWithPageParams($queryBuilder, $pageParams);
        self::buildQueryWithOrderByParams($queryBuilder, $orderByParams, [], Books::tableName());
        self::buildQueryWithSoftDeleteKey($queryBuilder, 'deleted_at', 0, Books::tableName());
        $list = $queryBuilder->get($column);
        $list->transform(function ($item, $key) {
            return self::handleItemByGetter($item, BooksGetter::class);
        });
        return $list->toArray();
    }

    /**
     * @param array $filter
     * @return int
     */
    public function getBooksTotal(array $filter = []): int
    {
        $queryBuilder = DB::table(Books::tableName());
        self::buildQueryWithContext($queryBuilder);
        self::buildQueryWithSearchCondition($queryBuilder, $filter, BooksSearcher::class, [
            'title',
            'author',
            'no',
            'type',
            'price',
            'publish_date',
            'level',
        ], Books::tableName());
        self::buildQueryWithSoftDeleteKey($queryBuilder, 'deleted_at', 0, App::tableName());
        return $queryBuilder->count();
    }

    /**
     * 获取书籍编号缓存key
     * @param string $bookNo
     * @return string
     */
    public function getBookCacheKey(string $bookNo)
    {
        return 'books:' . $bookNo;
    }

    /**
     * @param string $bookNo
     * @return array|int
     */
    public function getBookCache(string $bookNo)
    {
        $cacheKey = $this->getBookCacheKey($bookNo);
        $cache = Redis::get($cacheKey);
        if ($cache === false) {
            $cache = $this->refreshBookCache($bookNo);
        } else {
            $cache = (int)$cache;
        }
        return $cache;
    }

    /**
     * @param string $bookNo
     * @param string $book
     * @return bool
     */
    public function setBookCache(string $bookNo, string $book)
    {
        $cacheKey = $this->getBookCacheKey($bookNo);
        Redis::set($cacheKey, $book, 86400);
        return true;
    }

    /**
     * @param string $bookNo
     * @return array
     */
    public function refreshBookCache(string $bookNo)
    {
        self::useWritePdo();
        $book = $this->booksDao->findOneByBookNo($bookNo);
        $basicInfo = [];
        if (!is_null($book)) {
            $basicInfo = $book->toArray();
        }
        $bookNo = $basicInfo['no'] ?? '';
        $this->setBookCache($bookNo, json_encode($book));
        return $bookNo;
    }

    /**
     * @param string $bookNo
     * @return bool
     */
    public function removeBookCache(string $bookNo)
    {
        $cacheKey = $this->getBookCacheKey($bookNo);
        Redis::del($cacheKey);
        return true;
    }
}
<?php declare(strict_types=1);


namespace App\Rpc\Service\V1;


use App\Exception\ApiException;
use App\Model\Logic\BooksLogic;
use App\Rpc\Lib\BooksInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Rpc\Server\Annotation\Mapping\Service;

/**
 * Class BooksService
 * @Service()
 */
class BooksService implements BooksInterface
{
    /**
     * @Inject()
     * @var BooksLogic
     */
    protected $booksLogic;

    /**
     * 创建
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
    public function addBook(
        string $no,
        string $title,
        string $author,
        int    $type,
        float  $price,
        string $publish_date,
        int    $level
    ): int
    {
        return $this->booksLogic->addBooks($no, $title, $author, $type, $price, $publish_date, $level);
    }

    /**
     * 删除
     * @param int $bookId
     * @return bool
     * @throws ApiException
     */
    public function deleteBook(int $bookId): bool
    {
        return $this->booksLogic->deleteBooks($bookId);
    }

    /**
     * 更新
     * @param int $bookId
     * @param array $updateData
     * @return bool
     * @throws ApiException
     */
    public function updateBook(
        int   $bookId,
        array $updateData
    ): bool
    {
        return $this->booksLogic->updateBooks($bookId, $updateData);
    }

    /**
     * 获取应用详情
     * @param int $bookId
     * @return array
     * @throws ApiException
     */
    public function getBookDetail(int $bookId): array
    {
        return $this->booksLogic->getBookDetail($bookId);
    }

    /**
     * 获取分页列表
     * @param array $filter
     * @param array $column
     * @param array $pageParams
     * @param array $orderByParams
     * @return array
     */
    public function getBooksPageList(array $filter = [], array $column = [], array $pageParams = [], array $orderByParams = []): array
    {
        return $this->booksLogic->getBooksPageList($filter, $column, $pageParams, $orderByParams);
    }

    /**
     * 获取总数
     * @param array $filter
     * @return int
     */
    public function getBooksTotal(array $filter = []): int
    {
        return $this->booksLogic->getBooksTotal($filter);
    }

    /**
     * 获取缓存
     * @param string $bookNo
     * @return array
     */
    public function getBookCache(string $bookNo): array
    {
        return $this->booksLogic->getBookCache($bookNo);
    }
}
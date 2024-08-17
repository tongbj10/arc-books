<?php declare(strict_types=1);


namespace App\Model\Dao;


use App\Common\Model\BaseDao;
use App\Exception\ApiException;
use App\Model\Entity\Books;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\Eloquent\Builder;
use Swoft\Db\Eloquent\Model;

/**
 * Class BooksDao
 * @Bean()
 */
class BooksDao extends BaseDao
{
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
    public function create(
        string $no,
        string $title,
        string $author,
        int    $type,
        float  $price,
        string $publish_date,
        int    $level
    ): int
    {
        if ($this->issetByNo($no)) {
            throw new ApiException('该书籍编号已存在，不可重复创建');
        }
        $books = Books::new();
        $books->setTitle($title);
        $books->setNo($no);
        $books->setAuthor($author);
        $books->setType($type);
        $books->setPrice($price);
        $books->setLevel($level);
        $books->setPublishDate($publish_date);
        $books->save();
        return $books->getId();
    }

    /**
     * @param int $id
     * @return bool
     * @throws ApiException
     */
    public function delete(int $id): bool
    {
        $books = $this->findOneById($id);
        if (is_null($books)) {
            throw new ApiException('记录不存在，删除失败');
        }
        $books->setDeletedAt(time());
        return $books->save();
    }

    /**
     * @param int $id
     * @param array $updateData
     * @return bool
     * @throws ApiException
     */
    public function update(int $id, array $updateData)
    {
        if (empty($updateData)) {
            return true;
        }
        /**
         * @var $books Books|null
         */
        $books = $this->findOneById($id);
        if (is_null($books)) {
            throw new ApiException('更新失败，记录不存在');
        }
        if (array_key_exists('no', $updateData)
            && $books->getNo() != $updateData['no']
            && $this->issetByNo($updateData['no'])) {
            throw new ApiException('更新失败, 该书籍编号已存在');
        }
        $this->updateBySetter($books, $updateData, [
            'title',
            'author',
            'no',
            'type',
            'price',
            'publish_date',
            'level',
        ]);
        return $books->save();
    }

    /**
     * @param string $no
     * @return bool
     */
    public function issetByNo(string $no)
    {
        if (self::isUseWritePdo()) {
            return Books::useWritePdo()->where('no', $no)->where('deleted_at', '=', 0)->exists();
        } else {
            return Books::where('no', $no)->where('deleted_at', '=', 0)->exists();
        }
    }

    /**
     * @param int $id
     * @param bool $withTrashed
     * @return object|Builder|Model|null
     */
    public function findOneById(int $id, bool $withTrashed = false)
    {
        /**
         * @var $app Books|null
         */
        if ($withTrashed) {
            if (self::isUseWritePdo()) {
                $app = Books::useWritePdo()->find($id);
            } else {
                $app = Books::find($id);
            }
        } else {
            if (self::isUseWritePdo()) {
                $app = Books::useWritePdo()->where('deleted_at', '=', 0)->find($id);
            } else {
                $app = Books::where('deleted_at', '=', 0)->find($id);
            }
        }

        return $app;
    }

    /**
     * @param string $bookNo
     * @param bool $withTrashed
     * @return object|Builder|Model|null
     */
    public function findOneByBookNo(string $bookNo, bool $withTrashed = false)
    {
        /**
         * @var $app Books|null
         */
        if ($withTrashed) {
            if (self::isUseWritePdo()) {
                $app = Books::useWritePdo()->where('no', $bookNo)->where('deleted_at', '=', 0)->first();
            } else {
                $app = Books::where('no', $bookNo)->where('deleted_at', '=', 0)->first();;
            }
        } else {
            if (self::isUseWritePdo()) {
                $app = Books::useWritePdo()->where('no', $bookNo)->where('deleted_at', '=', 0)->first();
            } else {
                $app = Books::where('no', $bookNo)->where('deleted_at', '=', 0)->first();
            }
        }
        return $app;
    }
}
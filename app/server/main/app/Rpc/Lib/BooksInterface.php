<?php declare(strict_types=1);


namespace App\Rpc\Lib;

interface BooksInterface
{
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
     */
    public function addBook(
        string $no,
        string $title,
        string $author,
        int    $type,
        float  $price,
        string $publish_date,
        int    $level
    ): int;

    /**
     * 删除
     * @param int $bookId
     * @return bool
     */
    public function deleteBook(int $bookId): bool;

    /**
     * 更新
     * @param int $bookId
     * @param array $updateData
     * @return bool
     */
    public function updateBook(
        int   $bookId,
        array $updateData
    ): bool;

    /**
     * 获取应用详情
     * @param int $bookId
     * @return array
     */
    public function getBookDetail(int $bookId): array;

    /**
     * 获取分页列表
     * @param array $filter
     * @param array $column
     * @param array $pageParams
     * @param array $orderByParams
     * @return array
     */
    public function getBooksPageList(array $filter = [], array $column = [], array $pageParams = [], array $orderByParams = []): array;

    /**
     * 获取总数
     * @param array $filter
     * @return int
     */
    public function getBooksTotal(array $filter = []): int;

    /**
     * 获取缓存
     * @param string $bookNo
     * @return array
     */
    public function getBookCache(string $bookNo): array;
}
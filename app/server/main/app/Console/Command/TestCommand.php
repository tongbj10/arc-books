<?php declare(strict_types=1);


namespace App\Console\Command;


use App\Exception\ApiException;
use App\Model\Entity\Books;
use App\Model\Entity\BooksSaleLog;
use App\Model\Logic\BooksLogic;
use App\Model\Logic\BooksSaleLogLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Console\Annotation\Mapping\Command;
use Swoft\Console\Annotation\Mapping\CommandArgument;
use Swoft\Console\Annotation\Mapping\CommandMapping;
use Swoft\Console\Input\Input;
use Swoft\Console\Output\Output;
use Swoft\Db\DB;
use Swoft\Db\Eloquent\Collection;
use Swoft\Redis\Redis;

/**
 * Class TestCommand
 * @Command()
 */
class TestCommand
{
    /**
     * @Inject()
     * @var BooksLogic
     */
    protected $booksLogic;

    /**
     * @Inject()
     * @var BooksSaleLogLogic
     */
    protected $booksSaleLogLogic;

    /**
     * @CommandMapping()
     * @param Input $input
     * @param Output $output
     * @return true
     * @throws ApiException
     */
    public function test(Input $input, Output $output)
    {
        // 以下是一些测试验证方法mock数据
        // 添加
//        $bookId = $this->booksLogic->addBooks('books1','第一本书','tbj',1,15.00,'2024-08-17',6);

        // 删除
//        $bookId = 1;
//        $this->booksLogic->deleteBooks($bookId);

        // 编辑
//        $bookId = 2;
//        $updateData = [
//            'no' => 'books222'
//        ];
//        $this->booksLogic->updateBooks($bookId, $updateData);

        // 获取详情
//        $bookId = 2;
//        $info = $this->booksLogic->getBookDetail($bookId);

        // 获取分页列表
//        $filter = [];
//        $column = [];
//        $pageParams = [
//            'page' => 1,
//            'pageSize' => 10,
//        ];
//        $orderByParams = [
//            'publish_date' => 'desc',
//        ];
//        $pageList = $this->booksLogic->getBooksPageList($filter,$column,$pageParams,$orderByParams);

        // 添加图书售卖记录
//        $this->booksSaleLogLogic->addBooksSaleLog('book1',1,'2024-08-17');
//        // 获取热销前十
//        $list = $this->booksSaleLogLogic->getTopTenBooks();
//
//        vdump($list);
        return true;
    }
}
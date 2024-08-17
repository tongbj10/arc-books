<?php declare(strict_types=1);


namespace App\Task;


use App\Model\Logic\BooksLogic;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Task\Annotation\Mapping\Task;
use Swoft\Task\Annotation\Mapping\TaskMapping;

/**
 * Class BooksTask
 * @Task()
 */
class BooksTask
{
    /**
     * @Inject()
     * @var BooksLogic
     */
    protected $booksLogic;

    /**
     * @TaskMapping()
     * @param string $bookNo
     */
    public function removeCache(string $bookNo)
    {
        $this->booksLogic->removeBookCache($bookNo);
    }
}
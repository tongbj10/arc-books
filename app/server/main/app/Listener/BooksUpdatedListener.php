<?php declare(strict_types=1);


namespace App\Listener;


use App\Model\Entity\Books;
use App\Task\BooksTask;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Task\Task;

/**
 * Class BooksUpdatedListener
 * @Listener("swoft.model.books.updated")
 */
class BooksUpdatedListener implements EventHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event): void
    {
        /**
         * @var $books Books
         */
        $books = $event->getTarget();
        if (!empty($books->getDeletedAt())) {
            // 清除缓存
            Task::async(BooksTask::class,'removeBookCache',[
                $books->getId()
            ]);
        }
    }
}
<?php declare(strict_types=1);


namespace App\Listener;


use App\Model\Entity\Books;
use App\Task\BooksTask;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Task\Task;

/**
 * Class BooksCreatedListener
 * @Listener("swoft.model.books.created")
 */
class BooksCreatedListener implements EventHandlerInterface
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
        Task::async(BooksTask::class,'removeBookCache',[
            $books->getNo()
        ]);
    }
}
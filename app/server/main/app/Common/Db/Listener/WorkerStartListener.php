<?php declare(strict_types=1);


namespace App\Common\Db\Listener;


use App\Common\Db\DbPool;
use Swoft\Bean\BeanFactory;
use Swoft\Connection\Pool\Exception\ConnectionPoolException;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Server\ServerEvent;

/**
 * Class WorkerStartListener
 * @Listener(event=ServerEvent::WORK_PROCESS_START)
 */
class WorkerStartListener implements EventHandlerInterface
{
    /**
     * @param EventInterface $event
     *
     * @throws ConnectionPoolException
     */
    public function handle(EventInterface $event): void
    {
        $pools = BeanFactory::getBeans(DbPool::class);

        /* @var DbPool $pool */
        foreach ($pools as $pool) {
            $pool->initPool();
            $pool->intervalCheck();
        }
    }
}
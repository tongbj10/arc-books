<?php declare(strict_types=1);


namespace App\Common\Db\Listener;


use App\Common\Db\DbPool;
use Swoft\Bean\BeanFactory;
use Swoft\Event\Annotation\Mapping\Subscriber;
use Swoft\Event\EventInterface;
use Swoft\Event\EventSubscriberInterface;
use Swoft\Log\Helper\CLog;
use Swoft\Server\SwooleEvent;
use Swoft\SwoftEvent;
use Swoft\Timer;

/**
 * Class WorkerStopAndErrorListener
 * @Subscriber()
 */
class WorkerStopAndErrorListener implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SwooleEvent::WORKER_STOP    => 'handle',
            SwoftEvent::WORKER_SHUTDOWN => 'handle',
        ];
    }

    /**
     * @param EventInterface $event
     *
     */
    public function handle(EventInterface $event): void
    {
        $pools = BeanFactory::getBeans(DbPool::class);

        /* @var DbPool $pool */
        foreach ($pools as $pool) {
            $count = $pool->close();

            CLog::info('Close %d database connection on %s!', $count, $event->getName());
        }
        Timer::clearAll();
    }
}
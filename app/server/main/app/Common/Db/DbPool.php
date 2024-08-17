<?php declare(strict_types=1);


namespace App\Common\Db;


use Swoft\Connection\Pool\Contract\ConnectionInterface;
use Swoft\Db\Connection\Connection;
use Swoft\Db\Pool;
use Swoft\Timer;
use Swoole\Coroutine\Channel;
use Throwable;
use Swoft\Log\Helper\CLog;

class DbPool extends Pool
{
    public function intervalCheck()
    {
        Timer::tick(1000 * 60, function () {
            $this->checkPool();
        });
    }

    public function checkPool()
    {
        CLog::info('check pool start');
        if (!empty($this->channel) && $this->channel instanceof Channel) {
            $size = $this->channel->length();
            while (!$this->channel->isEmpty() && $size >= 0) {
                $size--;
                /* @var ConnectionInterface $connection */
                $connection = $this->channel->pop();
                if (!$connection || !($connection instanceof ConnectionInterface)) {
                    continue;
                }
                $lastTime   = $connection->getLastTime();

                // Out of `maxIdleTime`
                if (time() - $lastTime > $this->maxIdleTime) {
                    try {
                        // Fix expired connection not released, May be disconnected
                        $connection->close();
                    } catch (Throwable $e) {
                        CLog::warning('popByChannel close connection error ' . $e->getMessage());
                    }
                    $this->remove();
                } else {
                    // 执行一个ping，检查活性
                    if (!$this->connectionPing($connection)) {
                        // 无活性，回收
                        unset($connection);
                        $this->remove();
                    } else {
                        // 回归channel
                        $this->release($connection);
                    }
                }
            }
        }
        CLog::info('check pool end');
    }

    /**
     * @param ConnectionInterface $connection
     * @return bool
     */
    public function connectionPing(ConnectionInterface $connection): bool
    {
        /**
         * @var $connection Connection
         */
        try {
            //执行一个sql触发活跃信息
            $dbSelector = $this->database->getDbSelector();

            /* @var Connection $connection select db */
            if (!empty($dbSelector)) {
                $dbSelector->select($connection);
            }
            $connection->select('select 1');
            $connection->select('select 1',[],false);
            return true;
        } catch (\Throwable $throwable){
            //异常说明该链接出错了，return 进行回收
            return false;
        }
    }
}
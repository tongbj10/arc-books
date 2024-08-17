<?php

namespace Swoole\Http;

/**
 * @since 4.4.16
 */
class Server extends \Swoole\Server
{


    /**
     * @param int $ms
     * @param callable $callback
     * @return mixed
     */
    public function after(int $ms, callable $callback){}

    /**
     * @param int $ms
     * @param callable $callback
     * @return mixed
     */
    public function tick(int $ms, callable $callback){}

    /**
     * @param int $timer_id
     * @return mixed
     */
    public function clearTimer(int $timer_id){}

    /**
     * @param callable $callback
     * @return mixed
     */
    public function defer(callable $callback){}
}
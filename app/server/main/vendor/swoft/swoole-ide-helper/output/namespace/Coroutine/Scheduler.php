<?php

namespace Swoole\Coroutine;

/**
 * @since 4.4.16
 */
class Scheduler
{


    /**
     * @param callable $func
     * @param ...$params
     * @return mixed
     */
    public function add(callable $func, ...$params){}

    /**
     * @param $n
     * @param callable $func
     * @param ...$params
     * @return mixed
     */
    public function parallel($n, callable $func = null, ...$params){}

    /**
     * @param array $settings
     * @return mixed
     */
    public function set(array $settings){}

    /**
     * @return mixed
     */
    public function start(){}
}
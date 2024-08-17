<?php

namespace Swoole\Coroutine\MySQL;

/**
 * @since 4.4.16
 */
class Statement
{

    // property of the class Statement
    public $id;
    public $affected_rows;
    public $insert_id;
    public $error;
    public $errno;

    /**
     * @param array $params
     * @param float $timeout
     * @return bool
     */
    public function execute(array $params = null, float $timeout = null): bool{}

    /**
     * @param float $timeout
     * @return ?array
     */
    public function fetch(float $timeout = null): ?array{}

    /**
     * @param float $timeout
     * @return ?array
     */
    public function fetchAll(float $timeout = null): ?array{}

    /**
     * @param float $timeout
     * @return ?bool
     */
    public function nextResult(float $timeout = null): ?bool{}

    /**
     * @param float $timeout
     * @return mixed
     */
    public function recv(float $timeout = null){}

    /**
     * @return mixed
     */
    public function close(){}
}
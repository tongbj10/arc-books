<?php declare(strict_types=1);


namespace App\Common\Log;


use Swoft\Bean\BeanFactory;
use Swoft\Log\Logger;

class Log
{
    /**
     * @return Logger
     */
    public static function getLogger(): Logger
    {
        return BeanFactory::getBean('logger');
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function emergency(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->emergency($message, $context);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function debug(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        if (APP_DEBUG) {
            return self::getLogger()->debug($message, $context);
        }

        return true;
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function alert(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->alert($message, $context);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function info(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->info($message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @param mixed ...$params
     * @return bool
     * @throws \Exception
     */
    public static function trace(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->addTrace($message, $context);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function warning(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->warning($message, $context);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return bool
     */
    public static function error(string $message, array $context = [], ...$params): bool
    {
        $message = self::formatLog($message, $params);

        return self::getLogger()->error($message, $context);
    }

    /**
     * Push log
     *
     * @param string $key
     * @param mixed  $val
     *
     */
    public static function pushLog(string $key, $val): void
    {
        self::getLogger()->pushLog($key, $val);
    }

    /**
     * Profile start
     *
     * @param string $name
     * @param array  $params
     *
     */
    public static function profileStart(string $name, ...$params): void
    {
        if ($params) {
            $name = sprintf($name, ...$params);
        }

        self::getLogger()->profileStart($name);
    }

    /**
     * @param string   $name
     * @param int      $hit
     * @param int|null $total
     *
     */
    public static function counting(string $name, int $hit, int $total = null): void
    {
        self::getLogger()->counting($name, $hit, $total);
    }

    /**
     * Profile end
     *
     * @param string $name
     * @param array  $params
     *
     */
    public static function profileEnd(string $name, ...$params): void
    {
        if ($params) {
            $name = sprintf($name, ...$params);
        }

        self::getLogger()->profileEnd($name);
    }

    /**
     * @param string $message
     * @param array  $params
     *
     * @return string
     */
    public static function formatLog(string $message, array $params): string
    {
        if ($params) {
            $message = sprintf($message, ...$params);
        }

        return $message;
    }
}
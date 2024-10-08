<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Log\Helper\CLog;
use App\Common\Log\Log;
use Swoft\Rpc\Error;
use Swoft\Rpc\Server\Exception\Handler\RpcErrorHandler;
use Swoft\Rpc\Server\Response;
use Throwable;

/**
 * Class RpcExceptionHandler
 *
 * @since 2.0
 *
 * @ExceptionHandler(\Throwable::class)
 */
class RpcExceptionHandler extends RpcErrorHandler
{
    /**
     * @param Throwable $e
     * @param Response  $response
     *
     * @return Response
     */
    public function handle(Throwable $e, Response $response): Response
    {
        // Debug is false
        if (!APP_DEBUG) {
            // just show error message
            $error = Error::new(500, $e->getMessage(), null);
            // Log error message
        } else {
            $message = sprintf(' %s At %s line %d', $e->getMessage(), $e->getFile(), $e->getLine());
            $error   = Error::new(500, $message, null);
        }
        Log::error('%s. (At %s line %d)',[], $e->getMessage(), $e->getFile(), $e->getLine());
        CLog::error('%s. (At %s line %d)', $e->getMessage(), $e->getFile(), $e->getLine());

        $response->setError($error);

        // Debug is true
        return $response;
    }
}
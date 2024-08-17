<?php declare(strict_types=1);


namespace App\Exception\Handler;


use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Rpc\Error;
use Swoft\Rpc\Server\Exception\Handler\AbstractRpcServerErrorHandler;
use Swoft\Rpc\Server\Response;
use Throwable;
use App\Exception\ApiException;

/**
 * Class ApiExceptionHandler
 * @ExceptionHandler(ApiException::class)
 */
class ApiExceptionHandler extends AbstractRpcServerErrorHandler
{

    /**
     * @inheritDoc
     */
    public function handle(Throwable $e, Response $response): Response
    {
        $error = Error::new(200, $e->getMessage(), null);
        $response->setError($error);
        return $response;
    }
}
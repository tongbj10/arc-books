<?php declare(strict_types=1);


namespace App\Common\Log\Handler;


use Monolog\Handler\AbstractProcessingHandler;
use Swoft\Co;
use Swoft\Log\Logger;
use Swoft\Stdlib\Helper\JsonHelper;

class ReporterHandler extends AbstractProcessingHandler
{
    /**
     * Write log levels
     *
     * @var string
     */
    protected $levels = '';

    /**
     * Write log file
     *
     * @var string
     */
    protected $logFile = '';

    /**
     * @var array
     */
    protected $levelValues = [];

    /**
     * Will exec on construct
     */
    public function init(): void
    {
        $this->logFile = alias($this->logFile);
        $this->createDir();

        if (is_array($this->levels)) {
            $this->levelValues = $this->levels;
            return;
        }

        // Levels like 'notice,error'
        if (is_string($this->levels)) {
            $levelNames        = explode(',', $this->levels);
            $this->levelValues = Logger::getLevelByNames($levelNames);
        }
    }

    /**
     * Write file
     *
     * @param array $records
     */
    protected function write(array $record): void
    {
        $message = trim($record['messages']);
        $data = [
            'message' => $message,
            'level' => $record['level'] ?? '',
            'level_name' => $record['level_name'] ?? ''
        ];
        if ($record['datetime'] instanceof \DateTime) {
            $data['datetime'] = $record['datetime']->format('Y-m-d H:i:s');
        } else {
            $data['datetime'] = $record['datetime'] ?? '';
        }
        if (method_exists(context(),'getRequest')) {
            $request = context()->getRequest() ?? null;
        } else {
            $request = null;
        }
        if (!is_null($request)) {
            $data['request'] = get_class($request);
            if ($request instanceof \Swoft\Rpc\Server\Request) {
                $data['request_info'] = [
                    'version' => $request->getVersion(),
                    'interface' => $request->getInterface(),
                    'method' => $request->getMethod(),
                    'params' => $request->getParamsMap()
                ];
            } elseif ($request instanceof \Swoft\Http\Message\Request) {
                $data['request_info'] = [
                    'ip' => $request->getHeaderLine('x-real-ip') ?? '',
                    'method' => $request->getMethod(),
                    'url' => $request->getUriPath(),
                    'header' => $request->header(),
                    'body' => $request->input()
                ];
            } else {
                $data['request_info'] = [];
            }
        } else {
            $data['request'] = '';
            $data['request_info'] = [];
        }
        $data['context'] = $record['context'] ?? [];
        $dataJson = JsonHelper::encode($data,JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES) . PHP_EOL;
        $logFile = $this->formatFile($this->logFile);
        if (Co::id() <= 0) {
            $count = file_put_contents($logFile, $message, FILE_APPEND);
            if ($count === false) {
                throw new \InvalidArgumentException(sprintf('Unable to append to log file: %s', $logFile));
            }
        } else {
            $res = Co::writeFile($logFile, $dataJson, FILE_APPEND);
            if ($res === false) {
                throw new \InvalidArgumentException(sprintf('Unable to append to log file: %s', $logFile));
            }
        }
    }

    /**
     * Create dir
     */
    private function createDir(): void
    {
        $logDir = dirname($this->logFile);

        if ($logDir !== null && !is_dir($logDir)) {
            $status = mkdir($logDir, 0777, true);
            if ($status === false) {
                $errMsg = sprintf('There is no existing directory at "%s" and its not buildable', $logDir);
                throw new \UnexpectedValueException($errMsg);
            }
        }
    }

    /**
     * Whether to handler log
     *
     * @param array $record
     *
     * @return bool
     */
    public function isHandling(array $record): bool
    {
        if (empty($record['messages'])) {
            return false;
        }
        if (empty($this->levelValues)) {
            return true;
        }

        return in_array($record['level'], $this->levelValues, true);
    }

    /**
     * @param string $logFile
     *
     * @return string
     */
    public function formatFile(string $logFile): string
    {
        $math     = [];
        $fileName = basename($logFile);
        if (!preg_match('/%(.*)\{(.*)\}/', $fileName, $math)) {
            return $logFile;
        }

        $type  = $math[1];
        $value = $math[2];

        // Date format
        $formatFile = $logFile;
        switch ($type) {
            case 'd':
                $formatValue = date($value);
                $formatFile  = str_replace("%{$type}{{$value}}", $formatValue, $logFile);
                break;
        }

        return $formatFile;
    }
}
<?php declare(strict_types=1);


namespace App\Common;


use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Config\Annotation\Mapping\Config;
use Swoft\Stdlib\Helper\Str;

/**
 * Class Service
 * @Bean()
 */
class Service
{
    /**
     * @Config("service.name")
     * @var string
     */
    private $serviceName;

    /**
     * @Config("service.host")
     * @var string
     */
    private $serviceHost;

    /**
     * @Config("service.port")
     * @var int
     */
    private $servicePort;

    /**
     * @var string
     */
    private $serviceId;

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getServiceHost(): string
    {
        return $this->serviceHost;
    }

    /**
     * @return int
     */
    public function getServicePort(): int
    {
        return $this->servicePort;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        if (empty($this->serviceId)) {
            try {
                $this->serviceId = $this->serviceName . '_' . env('SERVICE_ID',1) . '_' . $this->serviceHost;
            } catch (\Exception $e) {
                $this->serviceId = $this->serviceName . '_' . $this->serviceHost;
            }
        }
        return $this->serviceId;
    }
}
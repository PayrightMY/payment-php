<?php
namespace Payright;

use Psr\Http\Client\ClientInterface;

class Client
{
    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $endpoint = 'https://payright.my/api';

    /**
     * @var
     */
    protected $paymentCompletion;

    /**
     * @var bool
     */
    protected $useSandbox = false;

    /**
     * @var string
     */
    protected $defaultVersion = 'v1';

    /**
     * @var string[]
     */
    protected $supportedVersions = [
        'v1' => 'One',
    ];

    /**
     * Client constructor.
     * @param ClientInterface $httpClient
     * @param array $config
     */
    public function __construct(ClientInterface $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @param ClientInterface $httpClient
     * @param array $config
     * @return static
     */
    public static function make(ClientInterface $httpClient, array $config): self
    {
        return new self($httpClient, $config);
    }

    /**
     * @return $this
     */
    public function v1(): self
    {
        $this->defaultVersion = 'v1';
        return $this;
    }

    /**
     * @param string|null $version
     * @return mixed
     */
    public function collections( ? string $version = null)
    {
        return $this->uses('Collection', $version);
    }

    /**
     * @param string|null $version
     * @return mixed
     */
    public function bills( ? string $version = null)
    {
        return $this->uses('Bill', $version);
    }

    /**
     * @param string|null $version
     * @return mixed
     */
    public function transactions( ? string $version = null)
    {
        return $this->uses('Transaction', $version);
    }

    /**
     * @param string|null $version
     * @return mixed
     */
    public function paymentchannel( ? string $version = null)
    {
        return $this->uses('PaymentChannel', $version);
    }

    /**
     * @return string
     */
    public function endpoint() : string
    {
        return $this->useSandbox() ? $this->sandbox() : $this->endpoint;
    }

    /**
     * @return string
     */
    public function sandbox() : string
    {
        return 'https://sandbox.payright.my/api';
    }

    /**
     * @return string
     */
    public function useSandbox() : string
    {
        if (!array_key_exists('use_sandbox', $this->config())) {
            $this->useSandbox = false;
        } else {
            $this->useSandbox = $this->config()['use_sandbox'];
        }

        return $this->useSandbox;
    }

    /**
     * @return array
     */
    public function config() : array
    {
        return $this->config;
    }

    /**
     * @return BearerAuth
     */
    public function auth(): \Payright\BearerAuth
    {
        return \Payright\BearerAuth::make($this);
    }

    /**
     * @param string $service
     * @param string|null $version
     * @return mixed
     */
    public function uses(string $service,  ? string $version)
    {
        if (\is_null($version) || !\array_key_exists($version, $this->supportedVersions)) {
            $version = $this->defaultVersion;
        }

        $name = str_replace('.', '\\', $service);

        $class = sprintf('%s\%s\%s', $this->getResourceNamespace(), $this->supportedVersions[$version], $name);

        if (!class_exists($class)) {
            throw new InvalidArgumentException("Resource [{$service}] for version [{$version}] is not available.");
        }

        return new $class($this);
    }

    /**
     * @return string
     */
    public function version() : string
    {
        return $this->version;
    }

    /**
     * @return ClientInterface
     */
    public function httpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->config);
    }

    /**
     * @return string
     */
    public function getResourceNamespace()
    {
        return __NAMESPACE__;
    }
}

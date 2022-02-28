<?php
namespace Payright;

use Payright\Contracts\Authenticable;

class BearerAuth implements Authenticable
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * BearerAuth constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return static
     */
    public static function make(Client $client): self
    {
        return new self($client);
    }

    /**
     * @return string[]
     */
    public function credentials(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->client->config()['api_key'],
        ];
    }

    /**
     * @return Client
     */
    public function client(): Client
    {
        return $this->client;
    }

}

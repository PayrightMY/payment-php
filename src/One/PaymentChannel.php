<?php
namespace Payright\One;

use Payright\Client;
use Payright\Request;

class PaymentChannel extends Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * PaymentChannel constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return PaymentChannel
     */
    public static function make(Client $client)
    {
        return new self($client);
    }

    /**
     * @param $collection
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function all($collection)
    {
        $endpoint = $this->client->endpoint();

        $response = $this->client->httpClient()
            ->request('GET', $endpoint.'/v1/collections/'.$collection.'/channels', [
                'headers' => array_merge(
                    $this->client->auth()->credentials(),
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                    ]
                ),
            ]);

        return $this->responseWith($response);
    }

    /**
     * @param $collection
     * @param $body
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function update($collection, $body)
    {
        $endpoint = $this->client->endpoint();

        $response = $this->client->httpClient()
            ->request('POST', $endpoint.'/v1/collections/'.$collection.'/channels', [
                'body' => json_encode($body),
                'headers' => array_merge(
                    $this->client->auth()->credentials(),
                    [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                    ]
                ),
            ]);

        return $this->responseWith($response);
    }

}

<?php
namespace Payright\One;

use Payright\Client;
use Payright\Request;

class Transaction extends Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Transaction constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return Transaction
     */
    public static function make(Client $client)
    {
        return new self($client);
    }

    /**
     * @param $bill
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function all($bill)
    {
        $endpoint = $this->client->endpoint();

        $response = $this->client->httpClient()
            ->request('GET', $endpoint.'/v1/bills/'.$bill.'/transactions', [
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

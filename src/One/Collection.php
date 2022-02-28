<?php
namespace Payright\One;

use Payright\Client;
use Payright\Request;

class Collection extends Request
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Collection constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     * @return Collection
     */
    public static function make(Client $client)
    {
        return new self($client);
    }

    /**
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function all()
    {
        $endpoint = $this->client->endpoint();

        $response = $this->client->httpClient()
            ->request('GET', $endpoint.'/v1/collections', [
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
     * @param array $data
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function create($data = [])
    {
        $endpoint = $this->client->endpoint();

        $body = $this->mergeApiBody(
            array_merge(
                $data
            )
        );

        $response = $this->client->httpClient()
            ->request('POST', $endpoint.'/v1/collections', [
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

    /**
     * @param $id
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function get($id)
    {
        $endpoint = $this->client->endpoint();

        $response = $this->client->httpClient()
            ->request('GET', $endpoint.'/v1/collections/'.$id, [
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
     * @param $id
     * @param array $data
     * @return \Laravie\Codex\Common\Response|\Laravie\Codex\Contracts\Response
     */
    public function update($id, $data = [])
    {
        $endpoint = $this->client->endpoint();

        $body = $this->mergeApiBody(
            array_merge(
                $data
            )
        );

        $response = $this->client->httpClient()
            ->request('POST', $endpoint.'/v1/collections/'.$id, [
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

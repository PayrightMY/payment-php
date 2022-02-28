<?php

namespace Payright\Tests\Feature;

use Codexpert\Faker\HttpFaker;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery as m;
use Payright\BearerAuth;
use Payright\Client;
use Payright\Tests\TestCase;

class TransactionResourceTest extends TestCase
{

    protected function tearDown(): void
    {
        m::close();
    }

    public function testShouldReturnCollectionsOfTransaction()
    {

        $response = '{"status":200,"message":"test created","data":[]}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->transactions('v1')->all('bill');

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertIsArray($body['data']);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

}

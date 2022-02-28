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

class CollectionResourceTest extends TestCase
{

    protected function tearDown(): void
    {
        m::close();
    }

    public function testShouldReturnCollectionsOfCollection()
    {

        $response = '{"status":200,"message":"test created","data":[]}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->collections('v1')->all();

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertIsArray($body['data']);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

    public function testItShouldCreateCollections()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $body = [
            'name' => 'test two',
            'status' => 'active',
        ];

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->collections('v1')->create();

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

    public function testShouldGetCollection()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->collections('v1')->get(1);

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

    public function testShouldUpdateCollection()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $body = [
            'name' => 'test two',
            'status' => 'active',
        ];

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->collections('v1')->update(1, $body);

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

}

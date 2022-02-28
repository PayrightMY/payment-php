<?php
namespace Payright\Tests\Feature;

use Codexpert\Faker\HttpFaker;
use Mockery as m;
use Payright\Client;
use Payright\Tests\TestCase;

class BillResourceTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testItShouldCreateBills()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $body = [
            'collection' => 'test',
            'biller_name' => 'test',
            'biller_email' => 'test',
            'biller_mobile' => 'test',
            'description' => 'test',
            'amount' => 100,
            'callback_url' => 'https://webhook.site/4370e625-4197-4059-911c-f4e16d6489f6',
            'redirect_url' => 'https://example.com/redirect/',
            'due_at' => '2021-12-01',
        ];

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->bills('v1')->create();

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

    public function testShouldGetBill()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->bills('v1')->get(1);

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }

    public function testShouldDeleteBill()
    {

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), [
            'api_key' => $this->getApiKey(),
            'use_sandbox' => true,
        ]);

        $resource = $client->bills('v1')->delete(1);

        $body = json_decode($resource->getBody(), true);

        $this->assertEquals(200, $resource->getStatusCode());
        $this->assertArrayHasKey('data', $body);
        $this->assertArrayHasKey('status', $body);
        $this->assertArrayHasKey('message', $body);

        $this->assertEquals(['Authorization' => "Bearer ".$this->getApiKey()], $client->auth()->credentials());
        $this->assertInstanceOf('Payright\Client', $client);
    }
}

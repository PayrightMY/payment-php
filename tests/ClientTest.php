<?php
namespace Payright\Tests;

use Codexpert\Faker\HttpFaker;
use Mockery as m;
use Payright\Client;
use Psr\Http\Client\ClientInterface;

class ClientTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testItInstantiateMessage()
    {

        $apikey = 'test';

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $client = new Client($httpFaker->faker(), ['api_key' => $apikey, 'sandbox' => false]);
        $viaStatic = Client::make($httpFaker->faker(), ['api_key' => $apikey, 'sandbox' => false]);

        $this->assertInstanceOf('Payright\Client', $client);
        $this->assertInstanceOf('Payright\Client', $viaStatic);
        $this->assertInstanceOf(ClientInterface::class, $client->httpClient());

        $this->assertEquals(array_merge(['api_key' => $apikey, 'sandbox' => false]), $client->config());
    }
}

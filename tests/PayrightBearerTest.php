<?php
namespace Payright\Tests;

use Codexpert\Faker\HttpFaker;
use Mockery as m;
use Payright\BearerAuth;
use Payright\Client;
use Payright\Tests\TestCase;

class PayrightBearerTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testItInstantiateClass()
    {
        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $instance = new BearerAuth(Client::make($httpFaker->faker(), []));
        $viaStatic = BearerAuth::make(Client::make($httpFaker->faker(), []));

        $this->assertInstanceOf('Payright\BearerAuth', $instance);
        $this->assertInstanceOf('Payright\BearerAuth', $viaStatic);
    }

    public function testItReturnCorrectCredentials()
    {
        $data = 'test';

        $response = '{"status":200,"message":"test created","data":{"id":"test"}}';

        $httpFaker = HttpFaker::create()->shouldResponseJson(200, [], $response);

        $auth = BearerAuth::make(new Client($httpFaker->faker(), [
            'api_key' => $data,
        ]));

        $this->assertEquals(['Authorization' => "Bearer ".$data], $auth->credentials());
        $this->assertInstanceOf('Payright\Client', $auth->client());
    }
}

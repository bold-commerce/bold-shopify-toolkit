<?php
namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Exceptions\TooManyRequestsException;
use \PHPUnit\Framework\TestCase;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Shop;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class ClientTest extends TestCase
{
    protected $client;

    protected $mockShopBaseInfo;

    protected $mockShopAccessInfo;

    protected $mockRequestHookInterface;

    protected $myShopifyDomain;

    protected function setUp()
    {
        $this->myShopifyDomain = 'fight-club.myshopify.com';

        // shop base info
        $this->mockShopBaseInfo = $this->getMockBuilder(ShopBaseInfo::class)->getMock();

        // shop access info
        $this->mockShopAccessInfo = $this->getMockBuilder(ShopAccessInfo::class)->getMock();

        // request hook interface
        $this->mockRequestHookInterface = $this->getMockBuilder(RequestHookInterface::class)->getMock();
    }


    public function testClientWillThrottleWhenUsingARateLimiterWhenConfigured()
    {
        $times = 10;

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        // mock request hook interface
        $this->mockRequestHookInterface->expects($this->exactly($times))->method('beforeRequest');
        $this->mockRequestHookInterface->expects($this->exactly($times))->method('afterRequest');

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->client = new Client($this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface);

        for($i = 0; $i < $times; $i++){
            $raw = $this->client->get("admin/orders/1.json");
        }
    }

    public function testClientWillThrowExceptionWhenGetting429()
    {
        // mock http client
        $mock = new MockHandler([new Response(429)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));;

        $this->expectException(TooManyRequestsException::class);

        $this->client = new Client($this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface);

        $this->client->get("admin/orders/1.json");
    }
}

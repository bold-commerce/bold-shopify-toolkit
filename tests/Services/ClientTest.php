<?php
namespace BoldApps\Common\Test\Services\Shopify;

use \PHPUnit\Framework\TestCase;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Shop;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\ApiSleeper;
use BoldApps\ShopifyToolkit\Contracts\ApiRateLimiter;
use BoldApps\ShopifyToolkit\Contracts\RateLimitKeyGenerator;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class ClientTest extends TestCase
{
    protected $client;

    protected $mockShopBaseInfo;

    protected $mockShopAccessInfo;

    protected $mockApiSleeper;

    protected $mockRateLimiter;

    protected $mockRateLimitKeyGenerator;

    protected $myShopifyDomain;

    protected function setUp()
    {
        $this->myShopifyDomain = 'fight-club.myshopify.com';

        // shop base info
        $this->mockShopBaseInfo = $this->getMockBuilder(ShopBaseInfo::class)->getMock();

        // shop access info
        $this->mockShopAccessInfo = $this->getMockBuilder(ShopAccessInfo::class)->getMock();

        // api sleeper
        $this->mockApiSleeper = $this->getMockBuilder(ApiSleeper::class)->getMock();
    }


    public function testClientWillThrottleWhenUsingARateLimiterWhenConfigured()
    {
        $times = 10;

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);


        $generatedKey = 'shopify-api:'.$this->myShopifyDomain;

        // mock rate limit key generator
        $this->mockRateLimitKeyGenerator = $this->getMockBuilder(RateLimitKeyGenerator::class)->getMock();
        $this->mockRateLimitKeyGenerator->expects($this->exactly($times))
            ->method('getKey')
            ->will($this->returnValue($generatedKey));

        // mock rate limiter
        $this->mockRateLimiter = $this->getMockBuilder(ApiRateLimiter::class)->getMock();
        $this->mockRateLimiter->expects($this->exactly($times))
            ->method('throttle')
            ->with($generatedKey);


        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->client = new Client($this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockApiSleeper, $this->mockRateLimiter, $this->mockRateLimitKeyGenerator);

        for($i = 0; $i < $times; $i++){
            $raw = $this->client->get("admin/orders/1.json");
        }
    }
}

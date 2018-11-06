<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Exceptions\NotFoundException;
use BoldApps\ShopifyToolkit\Exceptions\TooManyRequestsException;
use BoldApps\ShopifyToolkit\Services\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockBuilder as Mock;

class ClientTest extends TestCase
{
    /** @var Client */
    protected $client;

    /** @var Mock | ShopBaseInfo */
    protected $mockShopBaseInfo;

    /** @var Mock | ShopAccessInfo */
    protected $mockShopAccessInfo;

    /** @var Mock | RequestHookInterface */
    protected $mockRequestHookInterface;

    /** @var string */
    protected $myShopifyDomain;

    protected function setUp()
    {
        $this->myShopifyDomain = 'fight-club.myshopify.com';

        $this->mockShopBaseInfo = $this->getMockBuilder(ShopBaseInfo::class)->getMock();
        $this->mockShopAccessInfo = $this->getMockBuilder(ShopAccessInfo::class)->getMock();
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

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        for ($i = 0; $i < $times; ++$i) {
            $raw = $this->client->get('admin/orders/1.json');
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
            ->will($this->returnValue($this->myShopifyDomain));

        $this->expectException(TooManyRequestsException::class);

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $this->client->get('admin/orders/1.json');
    }

    /**
     * @param null|string $expected
     * @param int         $responseCode
     * @param array       $responseHeader
     * @param mixed       $exceptionClass
     *
     * @dataProvider getRedirectLocationProvider
     */
    public function testGetRedirectLocation($expected, $responseCode, $responseHeader, $exceptionClass)
    {
        $mock = new MockHandler([new Response($responseCode, $responseHeader)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        if (!is_null($exceptionClass)) {
            $this->expectException($exceptionClass);
        }

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $result = $this->client->getRedirectLocation('admin/discount_codes/lookup.json', ['code' => 'DISCOUNT_CODE']);
        $this->assertSame($expected, $result);
    }

    public function testClientWillApplyPostHeadersProperly()
    {
        $expectedHeaders = [
            'Content-Length' => [
                    0 => '4',
                ],
            'Host' => [
                    0 => 'fight-club.myshopify.com',
                ],
            'X-Shopify-Access-Token' => [
                    0 => '',
                ],
            'Content-Type' => [
                    0 => 'application/json',
                ],
            'charset' => [
                    0 => 'utf-8',
                ],
            'X-Shopify-Api-Features' => [
                    0 => 'creates-test-orders',
                ],
        ];

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $container = [];
        $history = Middleware::history($container);
        $handlerStack = HandlerStack::create($mock);
        // Add the history middleware to the handler stack.
        $handlerStack->push($history);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $raw = $this->client->post(
            'admin/orders.json',
            [],
            '{}',
            [],
            null,
            false,
            ['X-Shopify-Api-Features' => 'creates-test-orders']
        );

        /* @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $sentHeaders = $sentRequest->getHeaders();
        //User agent varies per system.
        unset($sentHeaders['User-Agent']);

        $this->assertEquals($expectedHeaders, $sentHeaders);
    }

    public static function getRedirectLocationProvider()
    {
        $shopDomain = 'coolshop.myshopify.com';
        $adminURI = 'admin/price_rules/294645137513/discount_codes/1318545293417';

        return [
            [
                'expected' => null,
                'responseCode' => 404,
                'responseHeader' => [],
                'exceptionClass' => NotFoundException::class,
            ],
            [
                'expected' => null,
                'responseCode' => 500,
                'responseHeader' => [],
                'exceptionClass' => RequestException::class,
            ],
            ['expected' => null, 'responseCode' => 200, 'responseHeader' => [], 'exceptionClass' => null],
            ['expected' => null, 'responseCode' => 303, 'responseHeader' => [], 'exceptionClass' => null],
            [
                'expected' => null,
                'responseCode' => 303,
                'responseHeader' => ['Location' => []],
                'exceptionClass' => null,
            ],
            [
                'expected' => null,
                'responseCode' => 303,
                'responseHeader' => ['Connection' => ['keep-alive']],
                'exceptionClass' => null,
            ],
            [
                'expected' => null,
                'responseCode' => 303,
                'responseHeader' => ['Location' => ['this/is/not/a/valid/url']],
                'exceptionClass' => null,
            ],
            [
                'expected' => "$adminURI.json",
                'responseCode' => 303,
                'responseHeader' => ['Location' => ["https://$shopDomain/$adminURI"]],
                'exceptionClass' => null,
            ],
            [
                'expected' => "$adminURI.json",
                'responseCode' => 303,
                'responseHeader' => ['Location' => ["https://$shopDomain/$adminURI.json"]],
                'exceptionClass' => null,
            ],
        ];
    }
}

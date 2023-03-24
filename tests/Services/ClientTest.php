<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Exceptions\BadRequestException;
use BoldApps\ShopifyToolkit\Exceptions\NotAcceptableException;
use BoldApps\ShopifyToolkit\Exceptions\NotFoundException;
use BoldApps\ShopifyToolkit\Exceptions\SeverErrorException;
use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Exceptions\TooManyRequestsException;
use BoldApps\ShopifyToolkit\Exceptions\UnauthorizedException;
use BoldApps\ShopifyToolkit\Exceptions\UnprocessableEntityException;
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

    /** @var Mock|ShopBaseInfo */
    protected $mockShopBaseInfo;

    /** @var Mock|ShopAccessInfo */
    protected $mockShopAccessInfo;

    /** @var Mock|RequestHookInterface */
    protected $mockRequestHookInterface;

    /** @var string */
    protected $myShopifyDomain;

    protected function setUp(): void
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

    /**
     * @param int    $responseCode
     * @param mixed  $exceptionClass
     * @param string $header
     * @param string $requestId
     * @param string $expectedRequestId
     *
     * @dataProvider getClientExceptionsProvider
     */
    public function testClientWillThrowExceptions($responseCode, $exceptionClass, $header, $requestId, $expectedRequestId)
    {
        // mock http client
        $mock = new MockHandler([new Response($responseCode, [$header => $requestId])]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->expectException($exceptionClass);

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        try {
            $this->client->get('admin/orders/1.json');
        } catch (ShopifyException $e) {
            $this->assertEquals($expectedRequestId, $e->getRequestId());
            throw $e;
        }
    }

    /**
     * @param string|null $expected
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
        // User agent varies per system.
        unset($sentHeaders['User-Agent']);

        $this->assertEquals($expectedHeaders, $sentHeaders);
    }

    public function testClientWillApplyPollingInfoHeaders()
    {
        $headers = [
            'retry-after' => [
                0 => '4',
            ],
            'location' => [
                0 => 'fight-club.myshopify.com/admin/draft_orders/123.json',
            ],
        ];

        // mock http client
        $mock = new MockHandler([
            new Response(202, $headers, '{"draft_order":{"id":"123"}}'),
        ]);

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
            'admin/draft_orders.json',
            [],
            '{}',
            [],
            null,
            false,
            []
        );

        $pollingInfo = $this->client->getPollingInfo();
        $this->assertEquals($pollingInfo->getLocation(), $headers['location'][0]);
        $this->assertEquals($pollingInfo->getRetryAfter(), $headers['retry-after'][0]);
    }

    public function testPostWithPasswordSendsPasswordAuthenticationRequest()
    {
        $expectedHeaders = [
            'Content-Length' => [0 => '17'],
            'Host' => [0 => 'fight-club.myshopify.com'],
            'Content-Type' => [0 => 'application/x-www-form-urlencoded'],
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
            $this->mockShopBaseInfo,
            $this->mockShopAccessInfo,
            $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $raw = $this->client->post(
            'admin/orders.json',
            [],
            '{}',
            [],
            'password',
            false,
            ['X-Shopify-Api-Features' => 'creates-test-orders']
        );

        /* @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $sentHeaders = $sentRequest->getHeaders();
        // User agent varies per system.
        unset($sentHeaders['User-Agent']);

        $this->assertEquals($expectedHeaders, $sentHeaders);
    }

    /**
     * @param array $data
     *
     * @dataProvider getLinkHeaderProvider
     */
    public function testClientParsePageInfo($data)
    {
        $expectedNextPageInfo = $data['next'];
        $expectedPrevPageInfo = $data['prev'];
        $linkHeader = $data['link_header'];

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $this->callMethod($this->client, 'parsePageInfo', [$linkHeader]);

        $pageInfo = $this->client->getPageInfo();

        $parsedNextPageInfo = $pageInfo->getNext();
        $parsedPrevPageInfo = $pageInfo->getPrev();

        $this->assertEquals($expectedNextPageInfo, $parsedNextPageInfo);
        $this->assertEquals($expectedPrevPageInfo, $parsedPrevPageInfo);
    }

    /**
     * @param array $data
     *
     * @dataProvider getLinkHeaderProvider
     */
    public function testClientParseHeader($data)
    {
        $expectedHeaderLinks = [
            'next' => $data['next_link'],
            'prev' => $data['prev_link'],
        ];

        $linkHeader = $data['link_header'];

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->mockShopBaseInfo->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue($this->myShopifyDomain));

        $this->client = new Client(
            $this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface
        );

        $parsedLinks = $this->callMethod($this->client, 'parseHeader', [$linkHeader]);

        $this->assertEquals($expectedHeaderLinks, $parsedLinks);
    }

    /**
     * @param object $obj
     * @param string $name
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    private static function callMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method->invokeArgs($obj, $args);
    }

    public static function getLinkHeaderProvider()
    {
        return [
            'previous_and_next' => [
                'data' => [
                'link_header' => '<https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0>; rel="previous", <https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9>; rel="next"',
                'next_link' => 'https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9',
                'prev_link' => 'https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0',
                'next' => 'eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9',
                'prev' => 'eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0',
                ],
            ],
            'no_previous' => [
                'data' => [
                    'link_header' => '<https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9>; rel="next"',
                    'next_link' => 'https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9',
                    'prev_link' => '',
                    'next' => 'eyJkaXJlY3Rpb24iOiJuZXh0IiwibGFzdF9pZCI6NDU3MjI5OTkxOTUwMCwibGFzdF92YWx1ZSI6IjIgU3R1cGlkIERvZ3MgVC1TaGlydCJ9',
                    'prev' => '',
                ],
            ],
            'no_next' => [
                'data' => [
                    'link_header' => '<https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0>; rel="previous"',
                    'next_link' => '',
                    'prev_link' => 'https://fight-club.myshopify.com/admin/api/2020-01/products.json?limit=5&page_info=eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0',
                    'next' => '',
                    'prev' => 'eyJkaXJlY3Rpb24iOiJwcmV2IiwibGFzdF9pZCI6NDU3Mzk0ODk2OTEwMCwibGFzdF92YWx1ZSI6IipOU1lOQyBULVNoaXJ0In0',
                ],
            ],
        ];
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
                'responseHeader' => ['Location' => ['']],
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

    public static function getClientExceptionsProvider()
    {
        return [
            [
                'responseCode' => 400,
                'exceptionClass' => BadRequestException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 400,
                'exceptionClass' => BadRequestException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 401,
                'exceptionClass' => UnauthorizedException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 401,
                'exceptionClass' => UnauthorizedException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 404,
                'exceptionClass' => NotFoundException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 404,
                'exceptionClass' => NotFoundException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 406,
                'exceptionClass' => NotAcceptableException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 406,
                'exceptionClass' => NotAcceptableException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 422,
                'exceptionClass' => UnprocessableEntityException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 422,
                'exceptionClass' => UnprocessableEntityException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 429,
                'exceptionClass' => TooManyRequestsException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 429,
                'exceptionClass' => TooManyRequestsException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 500,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 500,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 501,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 501,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 502,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 502,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
            [
                'responseCode' => 599,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => 'testrequestid',
            ],
            [
                'responseCode' => 599,
                'exceptionClass' => SeverErrorException::class,
                'header' => 'x-not-request-id',
                'requestId' => 'testrequestid',
                'expectedRequestId' => '',
            ],
        ];
    }
}

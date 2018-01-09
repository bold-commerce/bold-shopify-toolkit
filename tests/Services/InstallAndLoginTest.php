<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Contracts\ApiSleeper;
use BoldApps\ShopifyToolkit\Contracts\ApplicationInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Services\InstallAndLogin;
use GuzzleHttp\Client as HttpClient;
use \PHPUnit\Framework\TestCase;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;


/**
 * Class InstallAndLoginTest
 * @package BoldApps\Common\Test\Services\Shopify
 */
class InstallAndLoginTest extends TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockBuilder */
    protected $applicationMock;

    /** @var  \PHPUnit_Framework_MockObject_MockBuilder */
    protected $shopBaseInfoMock;

    /** @var  HttpClient */
    protected $client;

    /**
     *
     */
    public function setUp()
    {
        $this->applicationMock = $this->getMockBuilder(ApplicationInfo::class)->getMock();
        $this->shopBaseInfoMock = $this->getMockBuilder(ShopBaseInfo::class)->getMock();
        $this->client = $this->getMockBuilder(HttpClient::class)->getMock();

        $this->applicationMock->expects($this->any())
            ->method('getApiKey')
            ->will($this->returnValue('1234567890'));

        $this->shopBaseInfoMock->expects($this->any())
            ->method('getMyShopifyDomain')
            ->will($this->returnValue('testshop.myshopify.com'));
    }

    /**
     *
     */
    public function testAuthorizeUrlNoRedirect()
    {
        $installService = new InstallAndLogin($this->applicationMock, $this->shopBaseInfoMock,
            $this->client);

        $this->assertEquals($installService->getAuthorizeUrl('read_products,write_products', ""),
            'https://testshop.myshopify.com/admin/oauth/authorize?client_id=1234567890&scope=read_products%2Cwrite_products');
    }

    /**
     *
     */
    public function testAuthorizeUrlWithRedirect()
    {
        $installService = new InstallAndLogin($this->applicationMock, $this->shopBaseInfoMock,
            $this->client);

        $this->assertEquals($installService->getAuthorizeUrl('read_products,write_products', "https://redirecturi.com"),
            'https://testshop.myshopify.com/admin/oauth/authorize?client_id=1234567890&scope=read_products%2Cwrite_products&redirect_uri=https%3A%2F%2Fredirecturi.com');
    }

    /**
     *
     */
    public function testGetAccessTokenSuccess()
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'abcdefedgegeadfasdfasdasf'])),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $installService = new InstallAndLogin($this->applicationMock, $this->shopBaseInfoMock,
            $client);

        $code = $installService->getAccessToken("thisisthecode");

        $this->assertEquals('abcdefedgegeadfasdfasdasf', $code);
    }

    /**
     * @expectedException \BoldApps\ShopifyToolkit\Exceptions\BadRequestException
     */
    public function testGetAccessTokenBadToken()
    {
        $mock = new MockHandler([
            new RequestException("Error Communicating with Server", new Request('GET', 'test'), new Response(400))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handler]);

        $installService = new InstallAndLogin($this->applicationMock, $this->shopBaseInfoMock,
            $client);

        $installService->getAccessToken("thisisthecode");

    }


    /**
     *
     */
    public function testValidateSignature()
    {
        $installService = new InstallAndLogin($this->applicationMock, $this->shopBaseInfoMock, 
            $this->client);

        $requestQuery = [
            "hmac" => "2859abdbed593e40eb72b7f7f81eba364f7809a71eeeb5f2997b69c6edfde1d6",
            "protocol" => "https://",
            "shop" => "testshop.myshopify.com",
            "timestamp" => "1485030030",
        ];

        $this->assertEquals($installService->validateSignature($requestQuery), true);
    }
}
<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\ApiSleeper;
use BoldApps\ShopifyToolkit\Contracts\ApiRateLimiter;
use BoldApps\ShopifyToolkit\Contracts\RateLimitKeyGenerator;
use BoldApps\ShopifyToolkit\Exceptions\UnauthorizedException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

/**
 * Class Client.
 */
class Client
{
    /**
     * @var ShopBaseInfo
     */
    protected $shopBaseInfo;

    /**
     * @var ShopAccessInfo
     */
    protected $shopAccessInfo;

    /**
     * @var Client|GuzzleClient
     */
    protected $client;

    /**
     * @var ApiSleeper
     */
    protected $apiSleeper;

    /**
     * @var ApiRateLimiter
     */
    protected $rateLimiter;

    /**
     * @var RateLimitKeyGenerator
     */
    protected $rateLimitKeyGenerator;

    /**
     * Client constructor.
     * @param ShopBaseInfo $shopBaseInfo
     * @param ShopAccessInfo $shopAccessInfo
     * @param GuzzleClient $client
     * @param ApiSleeper $apiSleeper
     * @param ApiRateLimiter $rateLimiter
     */
    public function __construct(ShopBaseInfo $shopBaseInfo, ShopAccessInfo $shopAccessInfo, GuzzleClient $client, ApiSleeper $apiSleeper, ApiRateLimiter $rateLimiter = null, RateLimitKeyGenerator $rateLimitKeyGenerator)
    {
        $this->shopBaseInfo = $shopBaseInfo;
        $this->shopAccessInfo = $shopAccessInfo;
        $this->client = $client;
        $this->apiSleeper = $apiSleeper;
        $this->rateLimiter = $rateLimiter;
        $this->rateLimitKeyGenerator = $rateLimitKeyGenerator;
    }

    /**
     * @param $path
     * @param array $params
     * @param array $cookies
     * @param string $password
     * @param bool $frontendApi
     *
     * If password is set it will auth to /password before it does anything. Useful for frontend calls.
     * Cookies is an array of SetCookie objects. See the Cart service for an example.
     *
     * @return array
     */
    public function get($path, $params = [], array $cookies = [], $password = null, $frontendApi = false)
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken()];

        $domain = $frontendApi ? $this->shopBaseInfo->getDomain() : $this->shopBaseInfo->getMyShopifyDomain();

        $uri = new Uri(sprintf('https://%s/%s', $domain, $path));
        $uri = $uri->withQuery(http_build_query($params));
        $request = new Request('GET', $uri, $headers);

        return $this->sendRequestToShopify($request, $cookies, $password);
    }

    /**
     * @param $path
     * @param array $params
     * @param array $cookies
     * @param string $password
     * @param bool $frontendApi
     *
     * If password is set it will auth to /password before it does anything. Useful for frontend calls.
     * Cookies is an array of SetCookie objects. See the Cart service for an example.
     *
     * @return array
     */
    public function post($path, $params = [], $body, array $cookies = [], $password = null, $frontendApi = false)
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken(), 'Content-Type' => 'application/json', 'charset' => 'utf-8'];

        $domain = $frontendApi ? $this->shopBaseInfo->getDomain() : $this->shopBaseInfo->getMyShopifyDomain();

        $uri = new Uri(sprintf('https://%s/%s', $domain, $path));
        $uri = $uri->withQuery(http_build_query($params));

        $json = \GuzzleHttp\json_encode($body);

        $request = new Request('POST', $uri, $headers, $json);

        return $this->sendRequestToShopify($request, $cookies, $password);
    }

    /**
     * @param $path
     * @param array $params
     * @param $body
     *
     * @return array
     */
    public function put($path, $params = [], $body)
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken(), 'Content-Type' => 'application/json', 'charset' => 'utf-8'];
        $uri = new Uri(sprintf('https://%s/%s', $this->shopBaseInfo->getMyShopifyDomain(), $path));
        $uri = $uri->withQuery(http_build_query($params));

        $json = \GuzzleHttp\json_encode($body);

        $request = new Request('PUT', $uri, $headers, $json);

        return $this->sendRequestToShopify($request);
    }

    /**
     * @param $path
     * @param array $params
     *
     * @return array
     */
    public function delete($path, $params = [])
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken(), 'charset' => 'utf-8'];
        $uri = new Uri(sprintf('https://%s/%s', $this->shopBaseInfo->getMyShopifyDomain(), $path));
        $uri = $uri->withQuery(http_build_query($params));

        $request = new Request('DELETE', $uri, $headers);

        return $this->sendRequestToShopify($request);
    }

    /**
     * @param Request $request
     * @param array $cookies
     * @param string | null $password
     *
     * $cookies is an array of SetCookie objects. see the Cart service for examples.
     * If password is set it will attempt to authenticate with the frontend /password route first.
     *
     * @return array|null
     * @throws UnauthorizedException
     */
    private function sendRequestToShopify(Request $request, array $cookies = [], $password = null)
    {
        $result = null;

        $cookieJar = new \GuzzleHttp\Cookie\CookieJar();
        $options = [
            'cookies' => $cookieJar,
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36'
        ];

        try {
            $domain = $request->getUri()->getHost();

            if($password) {

                $uri = new Uri(sprintf('https://%s/password', $domain));
                $uri = $uri->withQuery(http_build_query(['password' => $password]));
                $authRequest = new Request('GET', $uri);
                $this->client->send($authRequest,$options);

            }

            foreach($cookies as $cookie) {
                //set the cookies that were passed in for the next request
                $cookie->setDomain($domain);
                $cookieJar->setCookie($cookie);
            }

            // rate limit
            if($this->rateLimitingEnabled()) {
                $key = $this->rateLimitKeyGenerator->getKey($this->shopBaseInfo->getMyShopifyDomain());
                $this->rateLimiter->throttle($key);
            }

            $response = $this->client->send($request,$options);

            $result = \GuzzleHttp\json_decode((string) $response->getBody(), true);
        }
        catch (RequestException $e) {
            $response = $e->getResponse();
            switch ($response->getStatusCode()) {
                case 401:
                    throw new UnauthorizedException($e->getMessage());
                //TODO: Add exceptions
                default:
                    throw $e;
            }
        }
        catch (\Exception $e){
            $response = null;
        }
        finally {
            $this->apiSleeper->sleep($response);
        }

        return $result;
        }


    /**
     * If rate limiting is enabled (rate limiter and key generator configured)
     */
    private function rateLimitingEnabled() {
        return ($this->rateLimiter != null && $this->rateLimitKeyGenerator != null);
    }
}

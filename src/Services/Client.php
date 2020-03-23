<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;
use BoldApps\ShopifyToolkit\Exceptions\BadRequestException;
use BoldApps\ShopifyToolkit\Exceptions\NotAcceptableException;
use BoldApps\ShopifyToolkit\Exceptions\NotFoundException;
use BoldApps\ShopifyToolkit\Exceptions\TooManyRequestsException;
use BoldApps\ShopifyToolkit\Exceptions\UnauthorizedException;
use BoldApps\ShopifyToolkit\Exceptions\UnprocessableEntityException;
use BoldApps\ShopifyToolkit\Models\PageInfo;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use function GuzzleHttp\Psr7\parse_header;

class Client
{
    /** @var ShopBaseInfo */
    protected $shopBaseInfo;

    /** @var ShopAccessInfo */
    protected $shopAccessInfo;

    /** @var Client|GuzzleClient */
    protected $client;

    /** @var ApiSleeper */
    protected $apiSleeper;

    /** @var ApiRateLimiter */
    protected $rateLimiter;

    /** @var RateLimitKeyGenerator */
    protected $rateLimitKeyGenerator;

    /** @var PageInfo */
    protected $pageInfo;

    /**
     * Client constructor.
     *
     * @param ShopBaseInfo         $shopBaseInfo
     * @param ShopAccessInfo       $shopAccessInfo
     * @param GuzzleClient         $client
     * @param RequestHookInterface $requestHookInterface
     */
    public function __construct(ShopBaseInfo $shopBaseInfo, ShopAccessInfo $shopAccessInfo, GuzzleClient $client, RequestHookInterface $requestHookInterface)
    {
        $this->shopBaseInfo = $shopBaseInfo;
        $this->shopAccessInfo = $shopAccessInfo;
        $this->client = $client;
        $this->requestHookInterface = $requestHookInterface;
    }

    /**
     * @param $path
     * @param array  $params
     * @param array  $cookies
     * @param string $password
     * @param bool   $frontendApi
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
     * @param string $path
     * @param array  $params
     */
    public function getRedirectLocation($path, $params = [])
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken()];

        $domain = $this->shopBaseInfo->getMyShopifyDomain();

        $uri = new Uri(sprintf('https://%s/%s', $domain, $path));
        $uri = $uri->withQuery(http_build_query($params));
        $request = new Request('GET', $uri, $headers);

        return $this->getRedirectResponseFromShopify($request);
    }

    /**
     * @param $path
     * @param array  $params
     * @param array  $cookies
     * @param string $password
     * @param bool   $frontendApi
     *
     * If password is set it will auth to /password before it does anything. Useful for frontend calls.
     * Cookies is an array of SetCookie objects. See the Cart service for an example.
     *
     * @return array
     */
    public function post($path, $params, $body, array $cookies = [], $password = null, $frontendApi = false, $extraHeaders = [])
    {
        $headers = ['X-Shopify-Access-Token' => $this->shopAccessInfo->getToken(), 'Content-Type' => 'application/json', 'charset' => 'utf-8'];
        $headers = array_merge($headers, $extraHeaders);

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
    public function put($path, $params, $body)
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
     * @param Request       $request
     * @param array         $cookies
     * @param string | null $password
     *
     * $cookies is an array of SetCookie objects. see the Cart service for examples.
     * If password is set it will attempt to authenticate with the frontend /password route first.
     *
     * @return array|null
     *
     * @throws UnauthorizedException
     * @throws NotFoundException
     * @throws NotAcceptableException
     * @throws UnprocessableEntityException
     * @throws TooManyRequestsException
     * @throws BadRequestException
     */
    private function sendRequestToShopify(Request $request, array $cookies = [], $password = null)
    {
        $result = null;

        $cookieJar = new \GuzzleHttp\Cookie\CookieJar();
        $options = [
            'cookies' => $cookieJar,
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36',
        ];

        try {
            $domain = $request->getUri()->getHost();

            if ($password) {
                $uri = new Uri(sprintf('https://%s/password', $domain));
                $uri = $uri->withQuery(http_build_query(['password' => $password]));
                $authRequest = new Request('GET', $uri);
                $this->client->send($authRequest, $options);
            }

            foreach ($cookies as $cookie) {
                //set the cookies that were passed in for the next request
                $cookie->setDomain($domain);
                $cookieJar->setCookie($cookie);
            }

            $this->requestHookInterface->beforeRequest($request);

            $response = $this->client->send($request, $options);

            $result = \GuzzleHttp\json_decode((string) $response->getBody(), true);

            $linkHeader = $response->getHeader('Link');
            if ($linkHeader) {
                $this->parsePageInfo($linkHeader);
            } else {
                $this->clearPageInfo();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (!$response) {
                throw $e;
            }

            switch ($response->getStatusCode()) {
                case 400:
                    throw new BadRequestException($e->getMessage());
                case 401:
                    throw new UnauthorizedException($e->getMessage());
                case 404:
                    throw new NotFoundException($e->getMessage());
                case 406:
                    throw new NotAcceptableException($e->getMessage());
                case 422:
                    throw new UnprocessableEntityException($e->getMessage());
                case 429:
                    throw new TooManyRequestsException($e->getMessage());
                default:
                    throw $e;
            }
        } catch (\Exception $e) {
            $response = null;
        } finally {
            $this->requestHookInterface->afterRequest($response);
        }

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return null|string
     *
     * @throws NotAcceptableException
     * @throws NotFoundException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws BadRequestException
     */
    private function getRedirectResponseFromShopify(Request $request)
    {
        $result = null;
        $locationIndex = 'Location';

        $options = [
            'allow_redirects' => false,
        ];

        try {
            $this->requestHookInterface->beforeRequest($request);

            $response = $this->client->send($request, $options);

            // Redirect response
            if ($response->getStatusCode() >= 300 && $response->getStatusCode() < 400) {
                $headers = $response->getHeaders();

                if (!empty($headers) && !empty($headers[$locationIndex]) && count($headers[$locationIndex]) > 0) {
                    $result = $this->validateRedirectLocation($headers[$locationIndex][0]);
                }
            }

            $linkHeader = $response->getHeader('Link');
            if ($linkHeader) {
                $this->parsePageInfo($linkHeader);
            } else {
                $this->clearPageInfo();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (!$response) {
                throw $e;
            }

            switch ($response->getStatusCode()) {
                case 400:
                    throw new BadRequestException($e->getMessage());
                case 401:
                    throw new UnauthorizedException($e->getMessage());
                case 404:
                    throw new NotFoundException($e->getMessage());
                case 406:
                    throw new NotAcceptableException($e->getMessage());
                case 422:
                    throw new UnprocessableEntityException($e->getMessage());
                case 429:
                    throw new TooManyRequestsException($e->getMessage());
                default:
                    throw $e;
            }
        } catch (\Exception $e) {
            $response = null;
        } finally {
            $this->requestHookInterface->afterRequest($response);
        }

        return $result;
    }

    /**
     * @param string $location
     *
     * @return null|string
     */
    private function validateRedirectLocation($location)
    {
        $redirectLocation = null;

        $isValidURL = filter_var($location, FILTER_VALIDATE_URL);

        if (false !== $isValidURL) {
            // Shopify sets the location header to the full URL
            $adminEndpoint = substr($location, strpos($location, 'admin'));
            if (false !== $adminEndpoint) {
                // Shopify gives us text/html content
                $redirectLocation = preg_match('/\.json$/', $adminEndpoint) ? $adminEndpoint : "$adminEndpoint.json";
            }
        }

        return $redirectLocation;
    }

    /**
     * @return object
     */
    public function getPageInfo()
    {
        return $this->pageInfo;
    }

    /**
     * Parses the links out of the link header and returns them as an array.
     *
     * @param string $linkHeader
     *
     * @return array
     */
    private function parseHeader($linkHeader)
    {
        $next = null;
        $prev = null;

        $links = parse_header($linkHeader);
        foreach ($links as $link) {
            $rel = isset($link['rel']) ? $link['rel'] : null;
            if ('previous' == $rel) {
                $prev = trim($link[0], '<>');
            } elseif ('next' == $rel) {
                $next = trim($link[0], '<>');
            }
        }

        return [
            'prev' => $prev,
            'next' => $next,
        ];
    }

    /**
     * Parses the next and previous page info from the links and sets the pageInfo of the client.
     *
     * @param $linkHeader
     */
    private function parsePageInfo($linkHeader)
    {
        $headerLinks = $this->parseHeader($linkHeader);
        $nextPageInfo = '';
        $previousPageInfo = '';
        if (isset($headerLinks['next'])) {
            $nextUrlComponents = parse_url($headerLinks['next']);
            parse_str($nextUrlComponents['query'], $nextParams);
            $nextPageInfo = $nextParams['page_info'] ? $nextParams['page_info'] : '';
        }
        if (isset($headerLinks['prev'])) {
            $prevUrlComponents = parse_url($headerLinks['prev']);
            parse_str($prevUrlComponents['query'], $prevParams);
            $previousPageInfo = $prevParams['page_info'] ? $prevParams['page_info'] : '';
        }

        $pageInfo = new PageInfo();
        $pageInfo->setNext($nextPageInfo);
        $pageInfo->setPrev($previousPageInfo);

        $this->pageInfo = $pageInfo;
    }

    /**
     * Clears the next and previous page info for the Client.
     */
    private function clearPageInfo()
    {
        $pageInfo = new PageInfo();
        $this->pageInfo = $pageInfo;
    }
}

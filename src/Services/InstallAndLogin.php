<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Contracts\ApplicationInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Exceptions\BadRequestException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class InstallAndLogin
{
    /** @var ApplicationInfo */
    protected $applicationInfo;

    /** @var HttpClient */
    protected $client;

    /** @var ShopBaseInfo */
    protected $shopBaseInfo;

    /**
     * InstallAndLogin constructor.
     *
     * @param ApplicationInfo $applicationInfo
     * @param ShopBaseInfo    $shopBaseInfo
     * @param HttpClient      $client
     */
    public function __construct(
        ApplicationInfo $applicationInfo,
        ShopBaseInfo $shopBaseInfo,
        HttpClient $client
    ) {
        $this->applicationInfo = $applicationInfo;
        $this->shopBaseInfo = $shopBaseInfo;
        $this->client = $client;
    }

    /**
     * @param $scope
     * @param string $redirect_url
     *
     * @return string
     */
    public function getAuthorizeUrl($scope, $redirect_url = '')
    {
        $url = sprintf('https://%s/admin/oauth/authorize?client_id=%s&scope=%s',
            $this->shopBaseInfo->getMyShopifyDomain(), $this->applicationInfo->getApiKey(), urlencode($scope));
        if ('' != $redirect_url) {
            $url .= sprintf('&redirect_uri=%s', urlencode($redirect_url));
        }

        return $url;
    }

    /**
     * @param $code
     *
     * @return string
     *
     * @throws BadRequestException
     */
    public function getAccessToken($code)
    {
        $result = '';
        $path = 'admin/oauth/access_token.json';
        $body = [
            'client_id' => $this->applicationInfo->getApiKey(),
            'client_secret' => $this->applicationInfo->getApiSecret(),
            'code' => $code,
        ];

        $uri = new Uri(sprintf('https://%s/%s', $this->shopBaseInfo->getMyShopifyDomain(), $path));

        $json = json_encode($body, JSON_FORCE_OBJECT);

        $request = new Request('POST', $uri, ['Content-Type' => 'application/json'], $json);

        try {
            $response = $this->client->send($request);

            $responseObject = json_decode($response->getBody(), true);

            if (isset($responseObject['access_token'])) {
                $result = $responseObject['access_token'];
            }
        } catch (RequestException $e) {
            if (!$e->hasResponse()) {
                throw $e;
            }

            switch ($e->getResponse()->getStatusCode()) {
                case 400:
                    throw new BadRequestException(400, null, $e);
                default:
                    throw $e;
            }
        }

        return $result;
    }

    /**
     * This usually will be something the ParameterBag from a symphony request object toArrayed.
     *
     * @param $query
     *
     * @return bool
     */
    public function validateSignature($query)
    {
        if (!is_array($query) || empty($query['hmac']) || !is_string($query['hmac'])) {
            return false;
        }

        $dataString = array();

        foreach ($query as $key => $value) {
            if ($key == 'hmac') {
                continue;
            }
            $key = str_replace('=', '%3D', $key);
            $key = str_replace('&', '%26', $key);
            $key = str_replace('%', '%25', $key);
            $value = str_replace('&', '%26', $value);
            $value = str_replace('%', '%25', $value);
            $dataString[] = $key.'='.$value;
        }

        sort($dataString);

        $string = implode('&', $dataString);
        $signature = hash_hmac('sha256', $string, $this->applicationInfo->getApiSecret());

        return $query['hmac'] == $signature;
    }
}

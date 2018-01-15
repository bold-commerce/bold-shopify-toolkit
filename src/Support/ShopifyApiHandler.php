<?php

namespace BoldApps\ShopifyToolkit\Support;

use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;
use BoldApps\ShopifyToolkit\Contracts\ApiSleeper;

/**
 * Class ShopifyApiHandler
 * @package BoldApps\Common\Support
 */
class ShopifyApiHandler implements RequestHookInterface, ApiSleeper
{

    /**
     * @var \GuzzleHttp\Psr7\Response|null $response
     */
    private $response;

    /**
     * @param \GuzzleHttp\Psr7\Request|null $request
     */
    public function beforeRequest($request)
    {
    }

    /**
     * @param \GuzzleHttp\Psr7\Response|null $response
     */
    public function afterRequest($response)
    {
        $this->sleep($response);
    }

    /**
     * @param \GuzzleHttp\Psr7\Response|null $response
     */
    public function sleep($response)
    {
        $this->response = $response;
        $percent = $this->getCallLimitPercent();

        if($percent > 98) {
            sleep(15);
        } elseif($percent > 96) {
            sleep(13);
        } elseif($percent > 94) {
            sleep(10);
        } elseif($percent > 92) {
            sleep(8);
        } elseif($percent > 90) {
            sleep(5);
        } elseif($percent > 75) {
            sleep(3);
        }

    }

    /**
     * @return int
     */
    private function getCallLimitPercent() {

        $callLimitRatio = $this->getCallLimitRatio();
        $callsMade = $callLimitRatio[0];
        $callLimit = $callLimitRatio[1];

        if($callLimit == 0) {
            return 100;
        }

        return $callsMade / $callLimit * 100;
    }

    /**
     * @return array
     */
    private function getCallLimitRatio() {
        if($this->response !== null) {

            $callLimitHeader = $this->response->getHeader('http_x_shopify_shop_api_call_limit');

            if(isset($callLimitHeader[0])) {
                return explode('/', $callLimitHeader[0]);
            }
        }

        return array(1,100);
    }

}

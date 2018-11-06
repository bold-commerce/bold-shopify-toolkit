<?php

namespace BoldApps\ShopifyToolkit\Contracts;

interface ApiSleeper
{
    /**
     * @param \GuzzleHttp\Psr7\Response|null $response
     */
    public function sleep($response);
}

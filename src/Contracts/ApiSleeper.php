<?php

namespace BoldApps\ShopifyToolkit\Contracts;

/**
 * Interface ApiSleeper.
 */
interface ApiSleeper
{
    /**
     * @param \GuzzleHttp\Psr7\Response|null $response
     * @return void
     */
    public function sleep($response);
}

<?php

namespace BoldApps\ShopifyToolkit\Contracts;

/**
 * ApiRateLimiter defines a client-side rate limiter.
 */
interface ApiRateLimiter
{
    /**
     * Throttle using key for limit per interval.
     */
    public function throttle($key);
}

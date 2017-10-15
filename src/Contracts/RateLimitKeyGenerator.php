<?php

namespace BoldApps\ShopifyToolkit\Contracts;

/**
 * RateLimitKeyGenerator creates a key used for Shopify API rate limiting.
 */
interface RateLimitKeyGenerator
{
    /**
     * Generate a rate limit key for a given shopify domain.
     */
    public function getKey($myShopifyDomain);
}

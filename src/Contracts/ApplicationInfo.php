<?php

namespace BoldApps\ShopifyToolkit\Contracts;

/**
 * Interface ApplicationInfo.
 */
interface ApplicationInfo
{
    /**
     * @return string
     */
    public function getApiKey();

    /**
     * @return string
     */
    public function getApiSecret();
}

<?php

namespace BoldApps\ShopifyToolkit\Contracts;

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

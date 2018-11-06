<?php

namespace BoldApps\ShopifyToolkit\Contracts;

interface ShopBaseInfo
{
    /**
     * @return string
     */
    public function getMyShopifyDomain();

    /**
     * @return string
     */
    public function getDomain();
}

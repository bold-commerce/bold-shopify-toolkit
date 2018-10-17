<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Option as ShopifyOption;

class Option extends Base
{
    /**
     * @param array $array
     *
     * @return ShopifyOption | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyOption::class);
    }
}

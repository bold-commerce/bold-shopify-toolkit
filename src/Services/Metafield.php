<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;

class Metafield extends Base
{
    /**
     * @param array $array
     *
     * @return ShopifyMetafield|object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyMetafield::class);
    }
}

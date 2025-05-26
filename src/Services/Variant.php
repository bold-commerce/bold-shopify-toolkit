<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Variant as ShopifyVariant;
use Illuminate\Support\Collection;

class Variant extends Base
{


    /**
     * @param array $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyVariant::class);
    }


    /**
     * @param ShopifyVariant $variant
     *
     * @return array
     */
    public function serializeVariantCreateUpdate($variant)
    {
        $serializedModel = $this->serializeModel($variant);

        unset($serializedModel['inventory_quantity']);
        unset($serializedModel['old_inventory_quantity']);
        unset($serializedModel['inventory_quantity_adjustment']);

        return ['variant' => $serializedModel];
    }
}

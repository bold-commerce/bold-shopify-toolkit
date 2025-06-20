<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Country as ShopifyCountry;
use Illuminate\Support\Collection;

/** @deprecated  */
class Country extends Base
{
    /**
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyCountry::class);
    }
}

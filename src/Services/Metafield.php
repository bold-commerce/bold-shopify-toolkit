<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as MetafieldModel;

/**
 * Class Metafield.
 */
class Metafield extends Base
{
    /**
     * @param $array
     *
     * @return MetafieldModel | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, MetafieldModel::class);
    }
}

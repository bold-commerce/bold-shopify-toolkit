<?php

namespace BoldApps\ShopifyToolkit\Traits;

/**
 * Trait Order
 * @package BoldApps\ShopifyToolkit\Traits
 */
trait Order
{
    /**
     * @param $orderProperties
     * @return array
     */
    private static function translatePropertiesArray($orderProperties)
    {
        $translatedOrderProperties = [];
        foreach ($orderProperties as $name => $value) {
            if (!empty($name) && !empty($value)) {
                $translatedOrderProperties[] = [
                    'name' => $name,
                    'value' => $value,
                ];
            }
        }
        return $translatedOrderProperties;
    }
}

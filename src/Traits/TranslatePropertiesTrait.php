<?php

namespace BoldApps\ShopifyToolkit\Traits;

/**
 * Trait TranslatePropertiesTrait
 * @package BoldApps\ShopifyToolkit\Traits
 */
trait TranslatePropertiesTrait {
    /**
     * @param $orderProperties
     * @return array
     */
    private static function translateProperties($orderProperties)
    {
        $translatedOrderProperties = [];
        foreach ($orderProperties as $name => $value) {
            if (!empty($name) && isset($value) ) {
                $translatedOrderProperties[] = [
                    'name' => $name,
                    'value' => $value,
                ];
            }
        }
        return $translatedOrderProperties;
    }
}

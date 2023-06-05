<?php

namespace BoldApps\ShopifyToolkit\Traits;

trait TranslatePropertiesTrait
{
    /**
     * @return array
     */
    private static function translateProperties($orderProperties)
    {
        $translatedOrderProperties = [];
        foreach ($orderProperties as $name => $value) {
            if (!empty($name) && isset($value)) {
                $translatedOrderProperties[] = [
                    'name' => $name,
                    'value' => $value,
                ];
            }
        }

        return $translatedOrderProperties;
    }
}

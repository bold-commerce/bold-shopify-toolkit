<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Fulfillment as ShopifyFulfillment;

class Fulfillment extends Base
{
    /**
     * @param ShopifyFulfillment $fulfillment
     *
     * @return ShopifyFulfillment | object
     */
    public function create(ShopifyFulfillment $fulfillment)
    {
        $serializedModel = ['fulfillment' => $this->serializeModel($fulfillment)];

        $raw = $this->client->post("admin/orders/{$fulfillment->getOrderId()}/fulfillments.json", [], $serializedModel);

        return $this->unserializeModel($raw['fulfillment'], ShopifyFulfillment::class);
    }

    /**
     * @param array $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyFulfillment::class);
    }
}

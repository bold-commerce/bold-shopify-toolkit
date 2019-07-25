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
     * @param string $orderId
     *
     * @return ShopifyFulfillment | collection
     */
    public function get($orderId)
    {
        $raw = $this->client->get("admin/orders/{$orderID}/fulfillments.json", []);
	$results = collect();
        foreach($raw['fulfillments'] as $fulfillment) {
           $results->push($this->unserializeModel($fulfillment,ShopifyFulfillment::class));
        }

        return $results;
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

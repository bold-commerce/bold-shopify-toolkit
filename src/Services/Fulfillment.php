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

        $raw = $this->client->post("{$this->getApiBasePath()}/orders/{$fulfillment->getOrderId()}/fulfillments.json", [], $serializedModel);

        return $this->unserializeModel($raw['fulfillment'], ShopifyFulfillment::class);
    }

    /**
     * @param int $orderId
     *
     * @return ShopifyFulfillment | \Illuminate\Support\Collection
     */
    public function get($orderId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/{$orderId}/fulfillments.json", []);
        $results = collect();
        foreach ($raw['fulfillments'] as $fulfillment) {
            $results->push($this->unserializeModel($fulfillment, ShopifyFulfillment::class));
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

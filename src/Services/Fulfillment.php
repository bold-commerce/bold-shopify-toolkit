<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Fulfillment as ShopifyFulfillment;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Fulfillment extends Base
{
    /**
     * @return ShopifyFulfillment | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyFulfillment $fulfillment)
    {
        $serializedModel = ['fulfillment' => $this->serializeModel($fulfillment)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders/{$fulfillment->getOrderId()}/fulfillments.json", [], $serializedModel);

        return $this->unserializeModel($raw['fulfillment'], ShopifyFulfillment::class);
    }

    /**
     * @return ShopifyFulfillment | Collection
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function get(int $orderId)
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

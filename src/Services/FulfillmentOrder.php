<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\FulfillmentOrder as ShopifyFulfillmentOrder;

class FulfillmentOrder extends Base
{
    protected $nameMap = [
        'assigned_location_id' => 'assigned_location_id',
        'delivery_method' => 'delivery_method',
        'fulfill_at' => 'fulfill_at',
        'fulfill_by' => 'fulfill_by',
        'fulfillment_holds' => 'fulfillment_holds',
        'international_duties' => 'international_duties',
        'line_items' => 'line_items',
        'request_status' => 'request_status',
        'shop_id' => 'shop_id',
        'supported_actions' => 'supported_actions',
        'merchant_requests' => 'merchant_requests',
        'assigned_location' => 'assigned_location',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
    ];

    /**
     * @return ShopifyFulfillmentOrder|\Illuminate\Support\Collection
     */
    public function get(int $orderId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/{$orderId}/fulfillment_orders.json", []);
        $results = collect();
        foreach ($raw['fulfillment_orders'] as $fulfillmentOrder) {
            $results->push($this->unserializeModel($fulfillmentOrder, ShopifyFulfillmentOrder::class));
        }

        return $results;
    }

    /**
     * @return object
     */
    public function createFromArray(array $array)
    {
        return $this->unserializeModel($array, ShopifyFulfillmentOrder::class);
    }
}

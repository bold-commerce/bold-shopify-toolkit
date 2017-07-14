<?php

namespace BoldApps\ShopifyToolkit\Services;


use BoldApps\ShopifyToolkit\Models\UsageCharge as ShopifyUsageCharge;

/**
 * Class UsageCharge
 * @package BoldApps\ShopifyToolkit\Services
 */
class UsageCharge extends Base
{
    /**
     * @param $recurringChargeId
     * @param ShopifyUsageCharge $usageCharge
     * @return object
     */
    public function create($recurringChargeId, ShopifyUsageCharge $usageCharge)
    {

        $serializedModel = ['usage_charge' => $this->serializeModel($usageCharge)];

        $raw = $this->client->post("admin/recurring_application_charges/$recurringChargeId/usage_charges.json", [], $serializedModel);

        return $this->unserializeModel($raw['usage_charge'], ShopifyUsageCharge::class);
    }

}
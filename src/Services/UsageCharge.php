<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\UsageCharge as ShopifyUsageCharge;
use GuzzleHttp\Exception\GuzzleException;

class UsageCharge extends Base
{
    /**
     * @param $recurringChargeId
     *
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create($recurringChargeId, ShopifyUsageCharge $usageCharge)
    {
        $serializedModel = ['usage_charge' => $this->serializeModel($usageCharge)];

        $raw = $this->client->post("{$this->getApiBasePath()}/recurring_application_charges/$recurringChargeId/usage_charges.json", [], $serializedModel);

        return $this->unserializeModel($raw['usage_charge'], ShopifyUsageCharge::class);
    }

    /**
     * @param $recurringChargeId
     *
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById($recurringChargeId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/recurring_application_charges/$recurringChargeId/usage_charges.json", []);

        return $this->unserializeModel($raw['usage_charges'], ShopifyUsageCharge::class);
    }
}

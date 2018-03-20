<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\RecurringApplicationCharge as ShopifyRecurringApplicationCharge;

/**
 * Class RecurringApplicationCharge
 * @package BoldApps\ShopifyToolkit\Services
 */
class RecurringApplicationCharge extends Base
{

    /**
     * @param ShopifyRecurringApplicationCharge $recurringApplicationCharge
     *
     * @return ShopifyRecurringApplicationCharge \ object
     */
    public function create(ShopifyRecurringApplicationCharge $recurringApplicationCharge)
    {
        $serializedModel = ['recurring_application_charge' => $this->serializeModel($recurringApplicationCharge)];

        $raw = $this->client->post('admin/recurring_application_charges.json', [], $serializedModel);

        return $this->unserializeModel($raw['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }


    /**
     * @param $id
     *
     * @return ShopifyRecurringApplicationCharge \ object
     */
    public function getById($id)
    {
        $charge = $this->client->get("admin/recurring_application_charges/$id.json");

        return $this->unserializeModel($charge['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }

    /**
     * @param ShopifyRecurringApplicationCharge $recurringApplicationCharge
     *
     * @return ShopifyRecurringApplicationCharge \ object
     */
    public function activate(ShopifyRecurringApplicationCharge $recurringApplicationCharge)
    {
        $id = $recurringApplicationCharge->getId();
        $serializedModel = ['recurring_application_charge' => $this->serializeModel($recurringApplicationCharge)];

        $raw = $this->client->post("admin/recurring_application_charges/$id/activate.json", [], $serializedModel);

        return $this->unserializeModel($raw['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }
}

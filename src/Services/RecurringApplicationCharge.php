<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\RecurringApplicationCharge as ShopifyRecurringApplicationCharge;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class RecurringApplicationCharge extends Base
{
    /**
     * @return ShopifyRecurringApplicationCharge \ object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyRecurringApplicationCharge $recurringApplicationCharge)
    {
        $serializedModel = ['recurring_application_charge' => $this->serializeModel($recurringApplicationCharge)];

        $raw = $this->client->post("{$this->getApiBasePath()}/recurring_application_charges.json", [], $serializedModel);

        return $this->unserializeModel($raw['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyRecurringApplicationCharge \ object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById($id)
    {
        $charge = $this->client->get("{$this->getApiBasePath()}/recurring_application_charges/$id.json");

        return $this->unserializeModel($charge['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/recurring_application_charges.json");
        $charges = array_map(function ($charge) {
            return $this->unserializeModel($charge, ShopifyRecurringApplicationCharge::class);
        }, $raw['recurring_application_charges']);

        return new Collection($charges);
    }

    /**
     * @return ShopifyRecurringApplicationCharge \ object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function activate(ShopifyRecurringApplicationCharge $recurringApplicationCharge)
    {
        $id = $recurringApplicationCharge->getId();
        $serializedModel = ['recurring_application_charge' => $this->serializeModel($recurringApplicationCharge)];

        $raw = $this->client->post("{$this->getApiBasePath()}/recurring_application_charges/$id/activate.json", [], $serializedModel);

        return $this->unserializeModel($raw['recurring_application_charge'], ShopifyRecurringApplicationCharge::class);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyRecurringApplicationCharge $recurringApplicationCharge): array
    {
        return $this->client->delete("{$this->getApiBasePath()}/recurring_application_charges/{$recurringApplicationCharge->getId()}.json");
    }

    /**
     * @param $array
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyRecurringApplicationCharge::class);
    }
}

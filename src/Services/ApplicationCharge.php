<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\ApplicationCharge as ShopifyApplicationCharge;

class ApplicationCharge extends Base
{
    /**
     * @return ShopifyApplicationCharge \ object
     */
    public function create(ShopifyApplicationCharge $applicationCharge)
    {
        $serializedModel = ['application_charge' => $this->serializeModel($applicationCharge)];

        $raw = $this->client->post("{$this->getApiBasePath()}/application_charges.json", [], $serializedModel);

        return $this->unserializeModel($raw['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyApplicationCharge \ object
     */
    public function getById($id)
    {
        $charge = $this->client->get("{$this->getApiBasePath()}/application_charges/$id.json");

        return $this->unserializeModel($charge['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @return ShopifyApplicationCharge \ object
     */
    public function activate(ShopifyApplicationCharge $applicationCharge)
    {
        $id = $applicationCharge->getId();
        $serializedModel = ['application_charge' => $this->serializeModel($applicationCharge)];

        $raw = $this->client->post("{$this->getApiBasePath()}/application_charges/$id/activate.json", [], $serializedModel);

        return $this->unserializeModel($raw['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @return array
     */
    public function delete(ShopifyApplicationCharge $applicationCharge)
    {
        return $this->client->delete("{$this->getApiBasePath()}/application_charges/{$applicationCharge->getId()}.json");
    }
}

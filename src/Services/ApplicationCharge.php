<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\ApplicationCharge as ShopifyApplicationCharge;

class ApplicationCharge extends Base
{
    /**
     * @param ShopifyApplicationCharge $applicationCharge
     *
     * @return ShopifyApplicationCharge \ object
     */
    public function create(ShopifyApplicationCharge $applicationCharge)
    {
        $serializedModel = ['application_charge' => $this->serializeModel($applicationCharge)];

        $raw = $this->client->post('admin/application_charges.json', [], $serializedModel);

        return $this->unserializeModel($raw['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyApplicationCharge \ object
     */
    public function getById($id)
    {
        $charge = $this->client->get("admin/application_charges/$id.json");

        return $this->unserializeModel($charge['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @param ShopifyApplicationCharge $applicationCharge
     *
     * @return ShopifyApplicationCharge \ object
     */
    public function activate(ShopifyApplicationCharge $applicationCharge)
    {
        $id = $applicationCharge->getId();
        $serializedModel = ['application_charge' => $this->serializeModel($applicationCharge)];

        $raw = $this->client->post("admin/application_charges/$id/activate.json", [], $serializedModel);

        return $this->unserializeModel($raw['application_charge'], ShopifyApplicationCharge::class);
    }

    /**
     * @param ShopifyApplicationCharge $applicationCharge
     *
     * @return array
     */
    public function delete(ShopifyApplicationCharge $applicationCharge)
    {
        return $this->client->delete("admin/application_charges/{$applicationCharge->getId()}.json");
    }
}

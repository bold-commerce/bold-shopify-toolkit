<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;

/**
 * Class ApplicationCharge
 * @package BoldApps\ShopifyToolkit\Services
 */
class DiscountCode extends Base
{

    /**
     * @param ShopifyDiscountCode $discountCode
     *
     * @return ShopifyDiscountCode \ object
     */
    public function create(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['discount_code' => $this->serializeModel($discountCode)];

        $raw = $this->client->post('admin/application_charges.json', [], $serializedModel);

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
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
}

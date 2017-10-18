<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;

/**
 * Class DiscountCode
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

        $raw = $this->client->post('admin/price_rules.json', [], $serializedModel);

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }


    /**
     * @param $id
     *
     * @return ShopifyDiscountCode \ object
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/price_rules/$id/discount_codes.json");

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }

    /**
     * @param ShopifyDiscountCode $discountCode
     *
     * @return object
     */
    public function update(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($discountCode)];

        $raw = $this->client->put("admin/price_rules/$discountCode->getPriceRuleId()/{$discountCode->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyDiscountCode::class);
    }

    /**
     * @param ShopifyDiscountCode $discountCode
     *
     * @return object
     */
    public function delete(ShopifyDiscountCode $discountCode)
    {
        return $this->client->delete("admin/price_rules/$discountCode->getPriceRuleId()/discount_codes/{$discountCode->getId()}.json");
    }
}

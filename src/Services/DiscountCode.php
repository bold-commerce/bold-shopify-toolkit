<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;
use Illuminate\Support\Collection;

class DiscountCode extends Base
{
    /**
     * @param ShopifyDiscountCode $discountCode
     *
     * @return ShopifyDiscountCode | object
     */
    public function create(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['discount_code' => $this->serializeModel($discountCode)];
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->post("admin/price_rules/$priceRuleId/discount_codes.json", [], $serializedModel);

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyDiscountCode::class);
    }

    /**
     * @param int   $priceRuleId
     * @param array $filter
     *
     * @return Collection
     */
    public function getAllByPriceRuleId($priceRuleId, $filter = [])
    {
        $raw = $this->client->get("admin/price_rules/$priceRuleId/discount_codes.json", $filter);

        $discountCodes = array_map(function ($discountCode) {
            return $this->unserializeModel($discountCode, ShopifyDiscountCode::class);
        }, $raw['discount_codes']);

        return new Collection($discountCodes);
    }

    /**
     * @param int $priceRuleId
     * @param int $discountCodeId
     *
     * @return ShopifyDiscountCode | object
     */
    public function getByDiscountCodeId($priceRuleId, $discountCodeId)
    {
        $raw = $this->client->get("admin/price_rules/$priceRuleId/discount_codes/$discountCodeId.json");

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
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->put("admin/price_rules/$priceRuleId/{$discountCode->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyDiscountCode::class);
    }

    /**
     * @param ShopifyDiscountCode $discountCode
     *
     * @return array
     */
    public function delete(ShopifyDiscountCode $discountCode)
    {
        $priceRuleId = $discountCode->getPriceRuleId();

        return $this->client->delete("admin/price_rules/$priceRuleId/discount_codes/{$discountCode->getId()}.json");
    }
}

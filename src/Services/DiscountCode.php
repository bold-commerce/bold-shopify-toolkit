<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;
use Illuminate\Support\Collection;

class DiscountCode extends Base
{
    /**
     * @return ShopifyDiscountCode|object
     */
    public function create(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['discount_code' => $this->serializeModel($discountCode)];
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->post("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes.json", [], $serializedModel);

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
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes.json", $filter);

        $discountCodes = array_map(function ($discountCode) {
            return $this->unserializeModel($discountCode, ShopifyDiscountCode::class);
        }, $raw['discount_codes']);

        return new Collection($discountCodes);
    }

    /**
     * @param int $priceRuleId
     * @param int $discountCodeId
     *
     * @return ShopifyDiscountCode|object
     */
    public function getByDiscountCodeId($priceRuleId, $discountCodeId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes/$discountCodeId.json");

        return $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
    }

    /**
     * @param string $discountCode
     *
     * @return ShopifyDiscountCode|object|null
     */
    public function lookup($discountCode)
    {
        $result = null;
        $redirectLocation = $this->client->getRedirectLocation("{$this->getApiBasePath()}/discount_codes/lookup.json", ['code' => $discountCode]);

        if (!empty($redirectLocation)) {
            $raw = $this->client->get($redirectLocation);
            $result = $this->unserializeModel($raw['discount_code'], ShopifyDiscountCode::class);
        }

        return $result;
    }

    /**
     * @return object
     */
    public function update(ShopifyDiscountCode $discountCode)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($discountCode)];
        $priceRuleId = $discountCode->getPriceRuleId();
        $raw = $this->client->put("{$this->getApiBasePath()}/price_rules/$priceRuleId/{$discountCode->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyDiscountCode::class);
    }

    /**
     * @return array
     */
    public function delete(ShopifyDiscountCode $discountCode)
    {
        $priceRuleId = $discountCode->getPriceRuleId();

        return $this->client->delete("{$this->getApiBasePath()}/price_rules/$priceRuleId/discount_codes/{$discountCode->getId()}.json");
    }
}

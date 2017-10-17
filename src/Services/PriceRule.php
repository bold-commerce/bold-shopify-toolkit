<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\PriceRule as ShopifyPriceRule;

/**
 * Class PriceRule
 * @package BoldApps\ShopifyToolkit\Services
 */
class PriceRule extends Base
{

    /**
     * @param ShopifyPriceRule $priceRule
     *
     * @return ShopifyPriceRule \ object
     */
    public function create(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($priceRule)];

        $raw = $this->client->post('admin/price_rules.json', [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyPriceRule \ object
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/price_rules/$id.json");

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @param ShopifyPriceRule $priceRule
     *
     * @return object
     */
    public function update(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($priceRule)];

        $raw = $this->client->put("admin/price_rules/{$priceRule->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @param ShopifyPriceRule $priceRule
     *
     * @return object
     */
    public function delete(ShopifyPriceRule $priceRule)
    {
        return $this->client->delete("admin/price_rules/{$priceRule->getId()}.json");
    }
}

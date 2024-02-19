<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\PriceRule as ShopifyPriceRule;
use Illuminate\Support\Collection;

class PriceRule extends CollectionEntity
{
    /**
     * @return ShopifyPriceRule|object
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$id.json");

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @deprecated Use getByParams()
     * @see getByParams()
     *
     * @param int   $page
     * @param int   $limit
     * @param array $filter
     *
     * @return Collection
     */
    public function getAll($page = 1, $limit = 50, $filter = [])
    {
        $raw = $this->client->get('admin/price_rules.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $priceRules = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyPriceRule::class);
        }, $raw['price_rules']);

        return new Collection($priceRules);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules.json", $params);

        $priceRules = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyPriceRule::class);
        }, $raw['price_rules']);

        return new Collection($priceRules);
    }

    /**
     * @return ShopifyPriceRule|object
     */
    public function create(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => array_merge($this->serializeModel($priceRule))];

        $raw = $this->client->post("{$this->getApiBasePath()}/price_rules.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyPriceRule::class);
    }

    /**
     * @return ShopifyPriceRule|object
     */
    public function update(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($priceRule)];

        $raw = $this->client->put("{$this->getApiBasePath()}/price_rules/{$priceRule->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @return ShopifyPriceRule|object
     */
    public function delete(ShopifyPriceRule $priceRule)
    {
        return $this->client->delete("{$this->getApiBasePath()}/price_rules/{$priceRule->getId()}.json");
    }
}

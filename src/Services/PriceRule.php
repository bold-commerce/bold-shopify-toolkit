<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\PriceRule as ShopifyPriceRule;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class PriceRule extends CollectionEntity
{
    /**
     * @param $id
     *
     * @return ShopifyPriceRule | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules/$id.json");

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @return Collection
     *
     * @throws ShopifyException
     * @throws GuzzleException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll(int $page = 1, int $limit = 50, array $filter = [])
    {
        $raw = $this->client->get('admin/price_rules.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $priceRules = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyPriceRule::class);
        }, $raw['price_rules']);

        return new Collection($priceRules);
    }

    /**
     * @return Collection
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/price_rules.json", $params);

        $priceRules = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyPriceRule::class);
        }, $raw['price_rules']);

        return new Collection($priceRules);
    }

    /**
     * @return ShopifyPriceRule | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => array_merge($this->serializeModel($priceRule))];

        $raw = $this->client->post("{$this->getApiBasePath()}/price_rules.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray(array $array)
    {
        return $this->unserializeModel($array, ShopifyPriceRule::class);
    }

    /**
     * @return ShopifyPriceRule | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyPriceRule $priceRule)
    {
        $serializedModel = ['price_rule' => $this->serializeModel($priceRule)];

        $raw = $this->client->put("{$this->getApiBasePath()}/price_rules/{$priceRule->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['price_rule'], ShopifyPriceRule::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyPriceRule $priceRule)
    {
        return $this->client->delete("{$this->getApiBasePath()}/price_rules/{$priceRule->getId()}.json");
    }
}

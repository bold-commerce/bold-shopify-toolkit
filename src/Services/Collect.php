<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Collect as ShopifyCollect;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use Illuminate\Support\Collection;

class Collect extends Base
{
    /**
     * Collect constructor.
     *
     * @param ShopifyClient $client
     */
    public function __construct(ShopifyClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param ShopifyCollect $collect
     *
     * @return ShopifyCollect | object
     */
    public function create(ShopifyCollect $collect)
    {
        $serializedModel = ['collect' => array_merge($this->serializeModel($collect))];

        $raw = $this->client->post("{$this->getApiBasePath()}/collects.json", [], $serializedModel);

        return $this->unserializeModel($raw['collect'], ShopifyCollect::class);
    }

    /**
     * @param int $id
     *
     * @return ShopifyCollect | object
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collects/$id.json");

        return $this->unserializeModel($raw['collect'], ShopifyCollect::class);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collects.json", $params);

        $priceRules = array_map(function ($collect) {
            return $this->unserializeModel($collect, ShopifyCollect::class);
        }, $raw['collects']);

        return new Collection($priceRules);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function count($params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collects/count.json", $params);

        return $raw['count'];
    }

    /**
     * @param ShopifyCollect $collect
     *
     * @return ShopifyCollect | array
     */
    public function delete(ShopifyCollect $collect)
    {
        return $this->client->delete("{$this->getApiBasePath()}/collects/{$collect->getId()}.json");
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyCollect::class);
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\CustomCollection as ShopifyCustomCollection;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class CustomCollection extends CollectionEntity
{
    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function create(ShopifyCustomCollection $collection, bool $publish = true)
    {
        $serializedModel = ['custom_collection' => array_merge($this->serializeModel($collection), ['published' => $publish])];

        $raw = $this->client->post("{$this->getApiBasePath()}/custom_collections.json", [], $serializedModel);

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyCustomCollection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/$id.json");

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll(int $page = 1, int $limit = 50, array $filter = [])
    {
        $raw = $this->client->get('admin/custom_collections.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $collection = array_map(function ($collection) {
            return $this->unserializeModel($collection, ShopifyCustomCollection::class);
        }, $raw['custom_collections']);

        return new Collection($collection);
    }

    /**
     * @param $params
     *
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections.json", $params);

        $collection = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomCollection::class);
        }, $raw['custom_collections']);

        return new Collection($collection);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyCustomCollection $collection)
    {
        $serializedModel = ['custom_collection' => $this->serializeModel($collection)];

        $raw = $this->client->put("{$this->getApiBasePath()}/custom_collections/{$collection->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyCustomCollection $collection)
    {
        return $this->client->delete("{$this->getApiBasePath()}/custom_collections/{$collection->getId()}.json");
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function countByParams(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/count.json", $filter);

        return $raw['count'];
    }
}

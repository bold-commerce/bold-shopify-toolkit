<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\CustomCollection as ShopifyCustomCollection;
use Illuminate\Support\Collection;

class CustomCollection extends CollectionEntity
{
    /**
     * @param bool $publish
     *
     * @return object
     */
    public function create(ShopifyCustomCollection $collection, $publish = true)
    {
        $serializedModel = ['custom_collection' => array_merge($this->serializeModel($collection), ['published' => $publish])];

        $raw = $this->client->post("{$this->getApiBasePath()}/custom_collections.json", [], $serializedModel);

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
    }

    /**
     * @return ShopifyCustomCollection
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/$id.json");

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
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
        $raw = $this->client->get('admin/custom_collections.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $collection = array_map(function ($collection) {
            return $this->unserializeModel($collection, ShopifyCustomCollection::class);
        }, $raw['custom_collections']);

        return new Collection($collection);
    }

    /**
     * @return \Illuminate\Support\Collection
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
     */
    public function update(ShopifyCustomCollection $collection)
    {
        $serializedModel = ['custom_collection' => $this->serializeModel($collection)];

        $raw = $this->client->put("{$this->getApiBasePath()}/custom_collections/{$collection->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['custom_collection'], ShopifyCustomCollection::class);
    }

    /**
     * @return object
     */
    public function delete(ShopifyCustomCollection $collection)
    {
        return $this->client->delete("{$this->getApiBasePath()}/custom_collections/{$collection->getId()}.json");
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return int
     */
    public function countByParams($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/custom_collections/count.json", $filter);

        return $raw['count'];
    }
}

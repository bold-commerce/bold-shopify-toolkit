<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Shop as ShopifyShop;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Shop extends Base
{
    /**
     * @return ShopifyShop
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function get()
    {
        return $this->unserializeModel($this->asArray(), ShopifyShop::class);
    }

    /**
     * @return mixed
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function asArray()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/shop.json");

        return $raw['shop'];
    }

    /**
     * @return ShopifyMetafield | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function createOrUpdateMetafield(ShopifyShop $shop, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("{$this->getApiBasePath()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return ShopifyMetafield | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMetafield(ShopifyMetafield $metafield)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/metafields/{$metafield->getId()}.json");

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMetafields(array $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/metafields.json", $params);

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function deleteMetafield(ShopifyMetafield $metafield)
    {
        return $this->client->delete("{$this->getApiBasePath()}/metafields/{$metafield->getId()}.json");
    }
}

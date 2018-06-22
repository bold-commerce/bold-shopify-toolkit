<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Shop as ShopifyShop;
use Illuminate\Support\Collection;

class Shop extends Base
{
    /**
     * @return ShopifyShop
     */
    public function get()
    {
        return $this->unserializeModel($this->asArray(), ShopifyShop::class);
    }

    /**
     * @return mixed
     */
    public function asArray()
    {
        $raw = $this->client->get('admin/shop.json');

        return $raw['shop'];
    }

    /**
     * @param ShopifyShop      $shop
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     */
    public function createOrUpdateMetafield(ShopifyShop $shop, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post('admin/metafields.json', [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @param ShopifyMetafield $metafield
     *
     * @return ShopifyMetafield | object
     */
    public function getMetafield(ShopifyMetafield $metafield)
    {
        $raw = $this->client->get("admin/metafields/{$metafield->getId()}.json");

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return Collection
     */
    public function getMetafields()
    {
        $raw = $this->client->get('admin/metafields.json');

        $metafields = array_map(function ($metafield) {
            return $this->unserializeModel($metafield, ShopifyMetafield::class);
        }, $raw['metafields']);

        return new Collection($metafields);
    }

    /**
     * @param ShopifyMetafield $metafield
     *
     * @return Collection
     */
    public function deleteMetafield(ShopifyMetafield $metafield)
    {
        return $this->client->delete("admin/metafields/{$metafield->getId()}.json");
    }
}

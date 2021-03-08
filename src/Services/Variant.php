<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Metafield as ShopifyMetafield;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Variant as ShopifyVariant;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Variant extends Base
{
    /**
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyProduct $product, ShopifyVariant $variant)
    {
        $serializedModel = $this->serializeVariantCreateUpdate($variant);

        $raw = $this->client->post("{$this->getApiBasePath()}/products/{$product->getId()}/variants.json", [], $serializedModel);

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @param array $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyVariant::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyVariant
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/variants/$id.json");

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getAllByProductId(int $productId, array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/$productId/variants.json", $filter);

        $variants = array_map(function ($variant) {
            return $this->unserializeModel($variant, ShopifyVariant::class);
        }, $raw['variants']);

        return new Collection($variants);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyVariant $variant)
    {
        $serializedModel = $this->serializeVariantCreateUpdate($variant);

        $raw = $this->client->put("{$this->getApiBasePath()}/variants/{$variant->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['variant'], ShopifyVariant::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyProduct $product, ShopifyVariant $variant)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}/variants/{$variant->getId()}.json");
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function createMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->post("{$this->getApiBasePath()}/variants/{$variant->getId()}/metafields.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function updateMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        $serializedModel = ['metafield' => array_merge($this->serializeModel($metafield))];

        $raw = $this->client->put("{$this->getApiBasePath()}/variants/{$variant->getId()}/metafields/{$metafield->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['metafield'], ShopifyMetafield::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMetafields(ShopifyVariant $variant, array $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/variants/{$variant->getId()}/metafields.json", $params);

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
    public function deleteMetafield(ShopifyVariant $variant, ShopifyMetafield $metafield)
    {
        return $this->client->delete("{$this->getApiBasePath()}/variants/{$variant->getId()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function deleteMetafieldById(ShopifyMetafield $metafield)
    {
        return $this->client->delete("{$this->getApiBasePath()}/metafields/{$metafield->getId()}.json");
    }

    /**
     * @return array
     */
    public function serializeVariantCreateUpdate(ShopifyVariant $variant)
    {
        $serializedModel = $this->serializeModel($variant);

        unset($serializedModel['inventory_quantity']);
        unset($serializedModel['old_inventory_quantity']);
        unset($serializedModel['inventory_quantity_adjustment']);

        return ['variant' => $serializedModel];
    }
}

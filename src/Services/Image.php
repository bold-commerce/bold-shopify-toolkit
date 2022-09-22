<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Image as ShopifyImage;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use Illuminate\Support\Collection;

class Image extends Base
{
    /**
     * @return object
     */
    public function createImageForProduct(ShopifyProduct $product, ShopifyImage $image)
    {
        $serializedModel = ['image' => $this->serializeModel($image)];

        $raw = $this->client->post("{$this->getApiBasePath()}/products/{$product->getId()}/images.json", [], $serializedModel);

        return $this->unserializeModel($raw['image'], ShopifyImage::class);
    }

    /**
     * @param $array
     *
     * @return ShopifyImage|object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyImage::class);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getAllProductImages(ShopifyProduct $product, $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/images.json", $params);

        $images = array_map(function ($image) {
            return $this->unserializeModel($image, ShopifyImage::class);
        }, $raw['images']);

        return new Collection($images);
    }

    /**
     * @param $id
     *
     * @return ShopifyImage|object
     */
    public function getProductImageById(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/images/{$id}.json");

        return $this->unserializeModel($raw['image'], ShopifyImage::class);
    }

    /**
     * @return array
     */
    public function deleteProductImage(ShopifyProduct $product, ShopifyImage $image)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}/images/{$image->getId()}.json");
    }
}

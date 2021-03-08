<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Image as ShopifyImage;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Image extends Base
{
    /**
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
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
     * @return ShopifyImage | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyImage::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getAllProductImages(ShopifyProduct $product, array $params = [])
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
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getProductImageById(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/products/{$product->getId()}/images/{$id}.json");

        return $this->unserializeModel($raw['image'], ShopifyImage::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function deleteProductImage(ShopifyProduct $product, ShopifyImage $image)
    {
        return $this->client->delete("{$this->getApiBasePath()}/products/{$product->getId()}/images/{$image->getId()}.json");
    }
}

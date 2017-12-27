<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use BoldApps\ShopifyToolkit\Models\Image as ShopifyImage;
use Illuminate\Support\Collection;

/**
 * Class Image.
 */
class Image extends Base
{
    /**
     * @param \BoldApps\ShopifyToolkit\Models\Product $product
     * @param \BoldApps\ShopifyToolkit\Models\Image $image
     *
     * @return object
     */
    public function createImageForProduct(ShopifyProduct $product, ShopifyImage $image)
    {
        $serializedModel = ['image' => $this->serializeModel($image)];

        $raw = $this->client->post("admin/products/{$product->getId()}/images.json", [], $serializedModel);

        return $this->unserializeModel($raw['image'], ShopifyImage::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyImage::class);
    }

    /**
     * @param \BoldApps\ShopifyToolkit\Models\Product $product
     * @param array $params
     * @return Collection
     */
    public function getAllProductImages(ShopifyProduct $product, $params = [])
    {
        $raw = $this->client->get("admin/products/{$product->getId()}/images.json", $params);

        $images = array_map(function($image) {
            return $this->unserializeModel($image, ShopifyImage::class);
        }, $raw['images']);

        return new Collection($images);
    }

    /**
     * @param \BoldApps\ShopifyToolkit\Models\Product $product
     * @param $id
     *
     * @return ShopifyImage
     */
    public function getProductImageById(ShopifyProduct $product, $id)
    {
        $raw = $this->client->get("admin/products/{$product->getId()}/images/{$id}");

        return $this->unserializeModel($raw['images'], ShopifyImage::class);
    }

    /**
     * @param \BoldApps\ShopifyToolkit\Models\Product $product
     * @param \BoldApps\ShopifyToolkit\Models\Image $image
     *
     * @return array
     */
    public function deleteProductImage(ShopifyProduct $product, ShopifyImage $image)
    {
        return $this->client->delete("admin/products/{$product->getId()}/images/{$image->getId()}.json");
    }

}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Collection as ShopifyCollection;
use BoldApps\ShopifyToolkit\Models\PageInfo;
use BoldApps\ShopifyToolkit\Models\Product as ShopifyProduct;
use Illuminate\Support\Collection as IlluminateCollection;

class Collection extends Base
{
    /**
     * @return PageInfo
     */
    public function getPageInfo()
    {
        return $this->client->getPageInfo();
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collections/$id.json");

        return $this->unserializeModel($raw['collection'], ShopifyCollection::class);
    }

    /**
     * Note: Shopify does not return variant information in the response of this API.
     *
     * @param $id
     * @param array $params
     *
     * @return IlluminateCollection
     */
    public function getCollectionProducts($id, $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/collections/$id/products.json", $params);

        $products = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyProduct::class);
        }, $raw['products']);

        return new IlluminateCollection($products);
    }

    /**
     * @param $id
     * @param string $pageInfo
     * @param int    $limit
     *
     * @return IlluminateCollection
     */
    public function getByPageInfo($id, $pageInfo, $limit = 50)
    {
        return $this->getCollectionProducts($id, [
            'page_info' => $pageInfo,
            'limit' => $limit,
        ]);
    }
}

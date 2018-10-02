<?php

namespace BoldApps\ShopifyToolkit\Services;

abstract class CollectionEntity extends Base
{
    /**
     * Loops through pages of results from shopify based on given filter
     * criteria and runs each page of the results through a given function.
     *
     * @param $func
     * @param array $filter
     * @param int   $limit
     * @param int   $pageNum
     */
    public function iterator($func, $filter = [], $limit = 250, $pageNum = 1)
    {
        $continue = true;
        while (false !== $continue
            && ($products = $this->getByParams(array_merge(['page' => $pageNum++, 'limit' => $limit], $filter)))
            && $products->isNotEmpty()) {
            foreach ($products as $product) {
                $continue = $func($product);
                if (false === $continue) {
                    break;
                }
            }
        }
    }

    /**
     * @param $params
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public function getByParams($params);
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

abstract class CollectionEntity extends Base
{
    /**
     * @return \Illuminate\Support\Collection
     */
    abstract public function getByParams($params);

    /**
     * @return PageInfo
     */
    public function getPageInfo()
    {
        return $this->client->getPageInfo();
    }

    /**
     * @param string $pageInfo
     * @param int    $limit
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByPageInfo($pageInfo, $limit = 5)
    {
        return $this->getByParams([
            'page_info' => $pageInfo,
            'limit' => $limit,
        ]);
    }
}

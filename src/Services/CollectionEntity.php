<?php

namespace BoldApps\ShopifyToolkit\Services;

abstract class CollectionEntity extends Base
{
    /**
     * @param $params
     *
     * @return \Illuminate\Support\Collection
     */
    abstract public function getByParams($params);

    /**
     * @return mixed
     */
    public function getPageInfo()
    {
        return $this->client->getPageInfo();
    }

    /**
     * @param $pageInfo
     * @param $limit
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

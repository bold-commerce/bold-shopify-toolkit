<?php

namespace BoldApps\ShopifyToolkit\Services;

abstract class CollectionEntity extends Base
{
    /**
     * @return \Illuminate\Support\Collection
     */
    abstract public function getByParams(array $params);

    /**
     * @return PageInfo
     */
    public function getPageInfo()
    {
        return $this->client->getPageInfo();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getByPageInfo(string $pageInfo, int $limit = 5)
    {
        return $this->getByParams([
            'page_info' => $pageInfo,
            'limit' => $limit,
        ]);
    }
}

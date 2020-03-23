<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Collection as ShopifyCollection;
use BoldApps\ShopifyToolkit\Services\Collection as CollectionService;

class CollectionTest extends \PHPUnit\Framework\TestCase
{
    /** @var CollectionService */
    private $collectionService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->collectionService = new CollectionService($client);
    }

    /**
     * @test
     */
    public function ShopifyCollectionDeserializesProperly()
    {
        $collectionJson = $this->getCollectionJson();
        $jsonArray = json_decode($collectionJson, true);
        $actual = $this->collectionService->unserializeModel($jsonArray, ShopifyCollection::class);

        $expected = $this->createShopifyCollectionEntity();

        $this->assertEquals($expected, $actual);
    }

    private function getCollectionJson()
    {
        return '{
            "id": 4391204235,
            "handle": "whole-store",
            "title": "Whole Store",
            "updated_at": "2020-03-28T21:20:10-04:00",
            "published_at": "2020-03-28T21:18:40-04:00",
            "sort_order": "best-selling",
            "template_suffix": "",
            "products_count": 269,
            "collection_type": "custom",
            "published_scope": "web",
            "body_html": ""
        }';
    }

    private function createShopifyCollectionEntity()
    {
        $shopifyCollection = new ShopifyCollection();
        $shopifyCollection->setId(4391204235);
        $shopifyCollection->setHandle('whole-store');
        $shopifyCollection->setTitle('Whole Store');
        $shopifyCollection->setUpdatedAt('2020-03-28T21:20:10-04:00');
        $shopifyCollection->setPublishedAt('2020-03-28T21:18:40-04:00');
        $shopifyCollection->setSortOrder('best-selling');
        $shopifyCollection->setTemplateSuffix('');
        $shopifyCollection->setProductsCount(269);
        $shopifyCollection->setCollectionType('custom');
        $shopifyCollection->setPublishedScope('web');
        $shopifyCollection->setBodyHtml('');

        return $shopifyCollection;
    }
}

<?php

use BoldApps\ShopifyToolkit\Models\Collect as ShopifyCollect;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\Collect as CollectService;
use PHPUnit\Framework\TestCase;

class CollectTest extends TestCase
{
    /** @var CollectService */
    private $collectService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->collectService = new CollectService($client);
    }

    /**
     * @test
     */
    public function shopifyCollectSerializesProperly()
    {
        $collectEntity = $this->createCollectEntity();

        $expected = $this->getCollectArray();
        $actual = $this->collectService->serializeModel($collectEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shopifyCollectDeserializesProperly()
    {
        $collectJson = $this->getCollectJson();
        $jsonArray = (array) json_decode($collectJson, true);

        $expected = $this->createCollectEntity();
        $actual = $this->collectService->unserializeModel($jsonArray, ShopifyCollect::class);

        $this->assertEquals($expected, $actual);
    }

    private function createCollectEntity()
    {
        /** @var ShopifyCollect $collectEntity */
        $collectEntity = $this->collectService->createFromArray($this->getCollectArray());

        return $collectEntity;
    }

    private function getCollectJson()
    {
        return '{
            "id": 6254851031051,
            "collection_id": 3465543691,
            "product_id": 327661486091,
            "featured": false,
            "created_at": "2018-01-08T10:56:48-06:00",
            "updated_at": "2018-01-08T10:56:48-06:00",
            "position": 1,
            "sort_value": "0000000001"
        }';
    }

    private function getCollectArray()
    {
        return [
            'id' => 6254851031051,
            'collection_id' => 3465543691,
            'product_id' => 327661486091,
            'featured' => false,
            'created_at' => '2018-01-08T10:56:48-06:00',
            'updated_at' => '2018-01-08T10:56:48-06:00',
            'position' => 1,
            'sort_value' => '0000000001',
        ];
    }
}

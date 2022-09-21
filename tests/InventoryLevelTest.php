<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\InventoryLevel as ShopifyInventoryLevel;
use BoldApps\ShopifyToolkit\Services\InventoryLevel as InventoryLevelService;
use PHPUnit\Framework\TestCase;

class InventoryLevelTest extends TestCase
{
    /** @var InventoryLevelService */
    private $inventoryLevelService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->inventoryLevelService = new InventoryLevelService($client);
    }

    /**
     * @test
     */
    public function ShopifyInventoryLevelSerializesProperly()
    {
        $inventoryLevelEntity = $this->inventoryLevelService->createFromArray($this->getInventoryLevelArray());

        $expected = $this->getInventoryLevelArray();
        $actual = $this->inventoryLevelService->serializeModel($inventoryLevelEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyInventoryLevelDeserializesProperly()
    {
        $inventoryLevelJson = $this->getInventoryLevelJson();
        $jsonArray = (array) json_decode($inventoryLevelJson, true);

        $expected = $this->inventoryLevelService->createFromArray($this->getInventoryLevelArray());
        $actual = $this->inventoryLevelService->unserializeModel($jsonArray, ShopifyInventoryLevel::class);

        $this->assertEquals($expected, $actual);
    }

    private function getInventoryLevelJson()
    {
        return '{
            "inventory_item_id": 9170708824106,
            "location_id": 11196792874,
            "available": null,
            "updated_at": "2018-06-12T11:49:05-04:00"
        }';
    }

    private function getInventoryLevelArray()
    {
        return [
            'inventory_item_id' => 9170708824106,
            'location_id' => 11196792874,
            'updated_at' => '2018-06-12T11:49:05-04:00',
        ];
    }
}

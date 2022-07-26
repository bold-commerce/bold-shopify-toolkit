<?php

use BoldApps\ShopifyToolkit\Models\InventoryItem as ShopifyInventoryItem;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\InventoryItem as InventoryItemService;

class InventoryItemTest extends \PHPUnit\Framework\TestCase
{
    /** @var InventoryItemService */
    private $inventoryItemService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->inventoryItemService = new InventoryItemService($client);
    }

    /**
     * @test
     */
    public function shopifyInventoryItemSerializesProperly()
    {
        $inventoryLevelEntity = $this->inventoryItemService->createFromArray($this->getInventoryItemArray());

        $expected = $this->getInventoryItemArray();
        $actual = $this->inventoryItemService->serializeModel($inventoryLevelEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shopifyInventoryItemDeserializesProperly()
    {
        $inventoryLevelJson = $this->getInventoryItemJson();
        $jsonArray = (array) json_decode($inventoryLevelJson, true);

        $expected = $this->inventoryItemService->createFromArray($this->getInventoryItemArray());
        $actual = $this->inventoryItemService->unserializeModel($jsonArray, ShopifyInventoryItem::class);

        $this->assertEquals($expected, $actual);
    }

    private function getInventoryItemJson()
    {
        return '{
            "id": 808950810,
            "sku": "IPOD2008PINK",
            "created_at": "2022-04-05T13:05:24-04:00",
            "updated_at": "2022-04-05T13:05:24-04:00",
            "requires_shipping": true,
            "cost": "25.00",
            "country_code_of_origin": null,
            "province_code_of_origin": null,
            "harmonized_system_code": null,
            "tracked": true,
            "country_harmonized_system_codes": [],
            "admin_graphql_api_id": "gid://shopify/InventoryItem/808950810"
          }';
    }

    private function getInventoryItemArray()
    {
        return [
            'id' => 808950810,
            'sku' => 'IPOD2008PINK',
            'created_at' => '2022-04-05T13:05:24-04:00',
            'updated_at' => '2022-04-05T13:05:24-04:00',
            'requires_shipping' => true,
            'cost' => '25.00',
            'tracked' => true,
            'country_harmonized_system_codes' => [],
        ];
    }
}

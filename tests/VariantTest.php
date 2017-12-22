<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Variant as ShopifyVariant;
use BoldApps\ShopifyToolkit\Services\Variant as VariantService;

class VariantTest extends \PHPUnit\Framework\TestCase
{
    /** @var VariantService */
    private $variantService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->variantService = new VariantService($client);
    }

    /**
     * @test
     */
    public function ShopifyVariantSerializesProperly()
    {
        $variantEntity = $this->createVariantEntity();

        $expected = $this->getVariantArray();
        $actual = $this->variantService->serializeModel($variantEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyVariantDeserializesProperly()
    {
        $variantJson = $this->getVariantJson();
        $jsonArray = (array)json_decode($variantJson, true);

        $expected = $this->createVariantEntity();
        $actual = $this->variantService->unserializeModel($jsonArray, ShopifyVariant::class);

        $this->assertEquals($expected, $actual);
    }

    private function createVariantEntity()
    {
        /** @var ShopifyVariant $variantEntity */
        $variantEntity = $this->variantService->createFromArray($this->getVariantArray());

        return $variantEntity;
    }

    private function getVariantJson()
    {
        return '{
            "id": 5303296294944,
            "product_id": 440883118112,
            "title": "Spooky",
            "price": "45.00",
            "sku": "",
            "position": 1,
            "inventory_policy": "deny",
            "compare_at_price": null,
            "fulfillment_service": "manual",
            "inventory_management": null,
            "option1": "Spooky",
            "option2": null,
            "option3": null,
            "created_at": "2017-12-08T13:35:42-05:00",
            "updated_at": "2017-12-21T09:49:41-05:00",
            "taxable": true,
            "barcode": "",
            "grams": 3000,
            "image_id": null,
            "inventory_quantity": 0,
            "weight": 3,
            "weight_unit": "kg",
            "inventory_item_id": 5292496748576,
            "old_inventory_quantity": 0,
            "requires_shipping": true
        }';
    }

    private function getVariantArray()
    {
        return [
            'id' => 5303296294944,
            'product_id' => 440883118112,
            'title' => 'Spooky',
            'price' => 45.0,
            'sku' => '',
            'position' => 1,
            'inventory_policy' => 'deny',
            'fulfillment_service' => 'manual',
            'option1' => 'Spooky',
            'created_at' => '2017-12-08T13:35:42-05:00',
            'updated_at' => '2017-12-21T09:49:41-05:00',
            'taxable' => true,
            'barcode' => '',
            'grams' => 3000,
            'inventory_item_id' => 5292496748576,
            'inventory_quantity' => 0,
            'weight' => '3',
            'weight_unit' => 'kg',
            'old_inventory_quantity' => 0,
            'requires_shipping' => true,
        ];
    }
}
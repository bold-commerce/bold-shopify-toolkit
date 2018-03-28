<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\DiscountCode as ShopifyDiscountCode;
use BoldApps\ShopifyToolkit\Services\DiscountCode as DiscountCodeService;

class DiscountCodeTest extends \PHPUnit\Framework\TestCase
{
    /** @var DiscountCodeService */
    private $discountCodeService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->discountCodeService = new DiscountCodeService($client);
    }

    /**
     * @test
     */
    public function ShopifyDiscountCodeSerializesProperly()
    {
        $discountCodeEntity = $this->createDiscountCodeEntity();

        $expected = $this->getDiscountCodeArray();
        $actual = $this->discountCodeService->serializeModel($discountCodeEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyDiscountCodeDeserializesProperly()
    {
        $discountCodeJson = $this->getDiscountCodeJson();
        $jsonArray = (array)json_decode($discountCodeJson, true);

        $expected = $this->createDiscountCodeEntity();
        $actual = $this->discountCodeService->unserializeModel($jsonArray, ShopifyDiscountCode::class);

        $this->assertEquals($expected, $actual);
    }

    private function createDiscountCodeEntity()
    {
        /** @var ShopifyDiscountCode $discountCodeEntity */
        $discountCodeEntity = $this->discountCodeService->createFromArray($this->getDiscountCodeArray());

        return $discountCodeEntity;
    }

    private function getDiscountCodeJson()
    {
        return '{
            "id": 48528162827,
            "price_rule_id": 19275055115,
            "code": "CARDINAL",
            "usage_count": 0,
            "created_at": "2018-01-02T11:54:46-06:00",
            "updated_at": "2018-01-02T11:55:11-06:00"
        }';
    }

    private function getDiscountCodeArray()
    {
        return [
            "id" => 48528162827,
            "price_rule_id" => 19275055115,
            "code" => "CARDINAL",
            "usage_count" => 0,
            "created_at" => "2018-01-02T11:54:46-06:00",
            "updated_at" => "2018-01-02T11:55:11-06:00",
        ];
    }
}
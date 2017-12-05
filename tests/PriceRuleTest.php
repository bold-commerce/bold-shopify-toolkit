<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\PriceRule as ShopifyPriceRule;
use BoldApps\ShopifyToolkit\Services\PriceRule as PriceRuleService;

class PriceRuleTest extends \PHPUnit\Framework\TestCase
{
    /** @var PriceRuleService */
    private $priceRuleService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->priceRuleService = new PriceRuleService($client);
    }

    /**
     * @test
     */
    public function ShopifyPriceRuleSerializesProperly()
    {
        $priceRuleEntity = $this->createPriceRuleEntity();

        $expected = $this->getPriceRuleArray();
        $actual = $this->priceRuleService->serializeModel($priceRuleEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyPriceRuleDeserializesProperly()
    {
        $priceRuleJson = $this->getPriceRuleJson();
        $jsonArray = (array)json_decode($priceRuleJson, true);

        $expected = $this->createPriceRuleEntity();
        $actual = $this->priceRuleService->unserializeModel($jsonArray, ShopifyPriceRule::class);

        $this->assertEquals($expected, $actual);
    }

    private function createPriceRuleEntity()
    {
        /** @var ShopifyPriceRule $priceRuleEntity */
        $priceRuleEntity = new ShopifyPriceRule();
        $priceRuleEntity->setId(507328175);
        $priceRuleEntity->setTitle('WINTER SALE');
        $priceRuleEntity->setTargetType('line_item');
        $priceRuleEntity->setTargetSelection('all');
        $priceRuleEntity->setAllocationMethod('across');
        $priceRuleEntity->setValueType('fixed_amount');
        $priceRuleEntity->setValue("-10.0");
        $priceRuleEntity->setOncePerCustomer(false);
        $priceRuleEntity->setUsageLimit(null);
        $priceRuleEntity->setCustomerSelection('all');
        $priceRuleEntity->setPrerequisiteSavedSearchIds([]);
        $priceRuleEntity->setPrerequisiteSubtotalRange(array("greater_than_or_equal_to" => "10.0"));
        $priceRuleEntity->setPrerequisiteShippingPriceRange(array("less_than_or_equal_to" => "17.0"));
        $priceRuleEntity->setEntitledProductIds([]);
        $priceRuleEntity->setEntitledVariantIds([]);
        $priceRuleEntity->setEntitledCollectionIds([]);
        $priceRuleEntity->setEntitledCountryIds([]);
        $priceRuleEntity->setStartsAt("2017-09-06T16:23:01-04:00");
        $priceRuleEntity->setEndsAt("2017-09-18T16:23:01-04:00");
        $priceRuleEntity->setCreatedAt("2017-09-12T16:23:01-04:00");
        $priceRuleEntity->setUpdatedAt("2017-09-12T16:23:01-04:00");

        return $priceRuleEntity;
    }

    private function getPriceRuleJson()
    {
        return '{
            "id": 507328175,
            "value_type": "fixed_amount",
            "value": "-10.0",
            "customer_selection": "all",
            "target_type": "line_item",
            "target_selection": "all",
            "allocation_method": "across",
            "once_per_customer": false,
            "usage_limit": null,
            "starts_at": "2017-09-06T16:23:01-04:00",
            "ends_at": "2017-09-18T16:23:01-04:00",
            "created_at": "2017-09-12T16:23:01-04:00",
            "updated_at": "2017-09-12T16:23:01-04:00",
            "entitled_product_ids": [],
            "entitled_variant_ids": [],
            "entitled_collection_ids": [],
            "entitled_country_ids": [],
            "prerequisite_saved_search_ids": [],
            "prerequisite_subtotal_range": {"greater_than_or_equal_to": "10.0"},
            "prerequisite_shipping_price_range": {"less_than_or_equal_to": "17.0"},
            "title": "WINTER SALE"
        }';
    }

    private function getPriceRuleArray()
    {
        return [
            "id" => 507328175,
            "value_type" => "fixed_amount",
            "value" => "-10.0",
            "customer_selection" => "all",
            "target_type" => "line_item",
            "target_selection" => "all",
            "allocation_method" => "across",
            "once_per_customer" => false,
            "starts_at" => "2017-09-06T16:23:01-04:00",
            "ends_at" => "2017-09-18T16:23:01-04:00",
            "created_at" => "2017-09-12T16:23:01-04:00",
            "updated_at" => "2017-09-12T16:23:01-04:00",
            "entitled_product_ids" => array(),
            "entitled_variant_ids" => array(),
            "entitled_collection_ids" => array(),
            "entitled_country_ids" => array(),
            "prerequisite_saved_search_ids" => array(),
            "prerequisite_subtotal_range" => array("greater_than_or_equal_to" => "10.0"),
            "prerequisite_shipping_price_range" => array("less_than_or_equal_to" => "17.0"),
            "title" => "WINTER SALE"
        ];
    }
}
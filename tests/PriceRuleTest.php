<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\PriceRule as ShopifyPriceRule;
use BoldApps\ShopifyToolkit\Services\PriceRule as PriceRuleService;
use PHPUnit\Framework\TestCase;

class PriceRuleTest extends TestCase
{
    /** @var PriceRuleService */
    private $priceRuleService;

    protected function setUp(): void
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
        $priceRuleEntity = $this->priceRuleService->createFromArray($this->getPriceRuleArray());

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
        $jsonArray = (array) json_decode($priceRuleJson, true);

        $expected = $this->priceRuleService->createFromArray($this->getPriceRuleArray());
        $actual = $this->priceRuleService->unserializeModel($jsonArray, ShopifyPriceRule::class);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyPriceRuleDeserializesProperlyWithCustomerSegments()
    {
        $priceRuleJson = $this->getPriceRuleJsonWithCustomerSegment();
        $jsonArray = (array) json_decode($priceRuleJson, true);

        $expected = $this->priceRuleService->createFromArray($this->getPriceRuleArrayWithCustomerSegment());
        $actual = $this->priceRuleService->unserializeModel($jsonArray, ShopifyPriceRule::class);

        $this->assertEquals($expected, $actual);
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
            "allocation_limit": 3,
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
            "prerequisite_customer_ids": [],
            "prerequisite_product_ids": [],
            "prerequisite_variant_ids": [],
            "prerequisite_collection_ids": [],
            "prerequisite_subtotal_range": {"greater_than_or_equal_to": "10.0"},
            "prerequisite_quantity_range": {"greater_than_or_equal_to": 5},
            "prerequisite_shipping_price_range": {"less_than_or_equal_to": "17.0"},
            "prerequisite_to_entitlement_quantity_ratio": {
                "prerequisite_quantity": 1,
                "entitled_quantity": 2
            },
            "prerequisite_to_entitlement_purchase": {
              "prerequisite_amount": 20
            },
            "title": "WINTER SALE"
        }';
    }

    private function getPriceRuleArray()
    {
        return [
            'id' => 507328175,
            'value_type' => 'fixed_amount',
            'value' => '-10.0',
            'customer_selection' => 'all',
            'target_type' => 'line_item',
            'target_selection' => 'all',
            'allocation_method' => 'across',
            'allocation_limit' => 3,
            'once_per_customer' => false,
            'starts_at' => '2017-09-06T16:23:01-04:00',
            'ends_at' => '2017-09-18T16:23:01-04:00',
            'created_at' => '2017-09-12T16:23:01-04:00',
            'updated_at' => '2017-09-12T16:23:01-04:00',
            'entitled_product_ids' => array(),
            'entitled_variant_ids' => array(),
            'entitled_collection_ids' => array(),
            'entitled_country_ids' => array(),
            'prerequisite_saved_search_ids' => array(),
            'prerequisite_customer_ids' => array(),
            'prerequisite_product_ids' => array(),
            'prerequisite_variant_ids' => array(),
            'prerequisite_collection_ids' => array(),
            'prerequisite_subtotal_range' => array('greater_than_or_equal_to' => '10.0'),
            'prerequisite_quantity_range' => array('greater_than_or_equal_to' => 5),
            'prerequisite_shipping_price_range' => array('less_than_or_equal_to' => '17.0'),
            'prerequisite_to_entitlement_quantity_ratio' => array('prerequisite_quantity' => 1, 'entitled_quantity' => 2),
            'prerequisite_to_entitlement_purchase' => array('prerequisite_amount' => 20),
            'title' => 'WINTER SALE',
        ];
    }

    private function getPriceRuleJsonWithCustomerSegment()
    {
        return '{
            "id": 507328175,
            "value_type": "fixed_amount",
            "value": "-10.0",
            "customer_selection": "all",
            "target_type": "line_item",
            "target_selection": "all",
            "allocation_method": "across",
            "allocation_limit": 3,
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
            "customer_segment_prerequisite_ids": [],
            "prerequisite_customer_ids": [],
            "prerequisite_product_ids": [],
            "prerequisite_variant_ids": [],
            "prerequisite_collection_ids": [],
            "prerequisite_subtotal_range": {"greater_than_or_equal_to": "10.0"},
            "prerequisite_quantity_range": {"greater_than_or_equal_to": 5},
            "prerequisite_shipping_price_range": {"less_than_or_equal_to": "17.0"},
            "prerequisite_to_entitlement_quantity_ratio": {
                "prerequisite_quantity": 1,
                "entitled_quantity": 2
            },
            "prerequisite_to_entitlement_purchase": {
              "prerequisite_amount": 20
            },
            "title": "WINTER SALE"
        }';
    }

    private function getPriceRuleArrayWithCustomerSegment()
    {
        return [
            'id' => 507328175,
            'value_type' => 'fixed_amount',
            'value' => '-10.0',
            'customer_selection' => 'all',
            'target_type' => 'line_item',
            'target_selection' => 'all',
            'allocation_method' => 'across',
            'allocation_limit' => 3,
            'once_per_customer' => false,
            'starts_at' => '2017-09-06T16:23:01-04:00',
            'ends_at' => '2017-09-18T16:23:01-04:00',
            'created_at' => '2017-09-12T16:23:01-04:00',
            'updated_at' => '2017-09-12T16:23:01-04:00',
            'entitled_product_ids' => array(),
            'entitled_variant_ids' => array(),
            'entitled_collection_ids' => array(),
            'entitled_country_ids' => array(),
            'prerequisite_saved_search_ids' => array(),
            'customer_segment_prerequisite_ids' => array(),
            'prerequisite_customer_ids' => array(),
            'prerequisite_product_ids' => array(),
            'prerequisite_variant_ids' => array(),
            'prerequisite_collection_ids' => array(),
            'prerequisite_subtotal_range' => array('greater_than_or_equal_to' => '10.0'),
            'prerequisite_quantity_range' => array('greater_than_or_equal_to' => 5),
            'prerequisite_shipping_price_range' => array('less_than_or_equal_to' => '17.0'),
            'prerequisite_to_entitlement_quantity_ratio' => array('prerequisite_quantity' => 1, 'entitled_quantity' => 2),
            'prerequisite_to_entitlement_purchase' => array('prerequisite_amount' => 20),
            'title' => 'WINTER SALE',
        ];
    }
}

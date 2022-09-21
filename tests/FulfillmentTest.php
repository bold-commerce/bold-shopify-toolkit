<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Fulfillment as ShopifyFulfillment;
use BoldApps\ShopifyToolkit\Services\Fulfillment as FulfillmentService;
use PHPUnit\Framework\TestCase;

class FulfillmentTest extends TestCase
{
    /** @var FulfillmentService */
    private $fulfillmentService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->fulfillmentService = new FulfillmentService($client);
    }

    /**
     * @test
     */
    public function ShopifyFulfillmentSerializesProperly()
    {
        $fulfillmentEntity = $this->createFulfillmentEntity();

        $expected = $this->getFulfillmentArray();
        $actual = $this->fulfillmentService->serializeModel($fulfillmentEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyFulfillmentDeserializesProperly()
    {
        $fulfillmentJson = $this->getFulfillmentJson();
        $jsonArray = (array) json_decode($fulfillmentJson, true);

        $expected = $this->createFulfillmentEntity();
        $actual = $this->fulfillmentService->unserializeModel($jsonArray, ShopifyFulfillment::class);

        $this->assertEquals($expected, $actual);
    }

    private function createFulfillmentEntity()
    {
        /** @var ShopifyFulfillment $fulfillmentEntity */
        $fulfillmentEntity = $this->fulfillmentService->createFromArray($this->getFulfillmentArray());

        return $fulfillmentEntity;
    }

    private function getFulfillmentJson()
    {
        return '{
            "id": 536610799721,
            "order_id": 521087516777,
            "status": "success",
            "created_at": "2018-08-10T11:52:00-05:00",
            "service": "manual",
            "updated_at": "2018-08-10T11:52:00-05:00",
            "tracking_company": null,
            "shipment_status": null,
            "location_id": 16109387,
            "tracking_number": null,
            "tracking_numbers": [],
            "tracking_url": null,
            "tracking_urls": [],
            "receipt": {},
            "name": "#1317.1",
            "line_items": [
                {
                    "id": 1308796420201,
                    "variant_id": 4425632841739,
                    "title": "Cardinal",
                    "quantity": 1,
                    "price": "67.00",
                    "sku": "",
                    "variant_title": "Small",
                    "vendor": "briannam-test-1",
                    "fulfillment_service": "manual",
                    "product_id": 588916686859,
                    "requires_shipping": true,
                    "taxable": true,
                    "gift_card": false,
                    "name": "Cardinal - Small",
                    "variant_inventory_management": "shopify",
                    "properties": [
                        {
                            "name": "_checkout_line_item_key",
                            "value": "85fc37b18c57097425b52fc7afbb6969d751713988987e9331980363e24189ce"
                        }
                    ],
                    "product_exists": true,
                    "fulfillable_quantity": 0,
                    "grams": 600,
                    "total_discount": "0.00",
                    "fulfillment_status": "fulfilled",
                    "price_set": {
                        "shop_money": {
                            "amount": "67.00",
                            "currency_code": "CAD"
                        },
                        "presentment_money": {
                            "amount": "67.00",
                            "currency_code": "CAD"
                        }
                    },
                    "total_discount_set": {
                        "shop_money": {
                            "amount": "0.00",
                            "currency_code": "CAD"
                        },
                        "presentment_money": {
                            "amount": "0.00",
                            "currency_code": "CAD"
                        }
                    },
                    "discount_allocations": [
                        {
                            "amount": "6.70",
                            "discount_application_index": 0,
                            "amount_set": {
                                "shop_money": {
                                    "amount": "6.70",
                                    "currency_code": "CAD"
                                },
                                "presentment_money": {
                                    "amount": "6.70",
                                    "currency_code": "CAD"
                                }
                            }
                        }
                    ],
                    "tax_lines": [
                        {
                            "title": "GST",
                            "price": "3.02",
                            "rate": 0.05,
                            "price_set": {
                                "shop_money": {
                                    "amount": "3.02",
                                    "currency_code": "CAD"
                                },
                                "presentment_money": {
                                    "amount": "3.02",
                                    "currency_code": "CAD"
                                }
                            }
                        },
                        {
                            "title": "PST",
                            "price": "4.82",
                            "rate": 0.08,
                            "price_set": {
                                "shop_money": {
                                    "amount": "4.82",
                                    "currency_code": "CAD"
                                },
                                "presentment_money": {
                                    "amount": "4.82",
                                    "currency_code": "CAD"
                                }
                            }
                        }
                    ]
                }
            ]
        }';
    }

    private function getFulfillmentArray()
    {
        return [
            'id' => 536610799721,
            'order_id' => 521087516777,
            'status' => 'success',
            'created_at' => '2018-08-10T11:52:00-05:00',
            'service' => 'manual',
            'updated_at' => '2018-08-10T11:52:00-05:00',
            'location_id' => 16109387,
            'tracking_numbers' => [],
            'tracking_urls' => [],
            'receipt' => [],
            'name' => '#1317.1',
            'line_items' => [
                [
                    'id' => 1308796420201,
                    'variant_id' => 4425632841739,
                    'title' => 'Cardinal',
                    'quantity' => 1,
                    'price' => '67.00',
                    'sku' => '',
                    'variant_title' => 'Small',
                    'vendor' => 'briannam-test-1',
                    'fulfillment_service' => 'manual',
                    'product_id' => 588916686859,
                    'requires_shipping' => true,
                    'taxable' => true,
                    'gift_card' => false,
                    'name' => 'Cardinal - Small',
                    'variant_inventory_management' => 'shopify',
                    'properties' => [
                        [
                            'name' => '_checkout_line_item_key',
                            'value' => '85fc37b18c57097425b52fc7afbb6969d751713988987e9331980363e24189ce',
                        ],
                    ],
                    'product_exists' => true,
                    'fulfillable_quantity' => 0,
                    'grams' => 600,
                    'total_discount' => '0.00',
                    'fulfillment_status' => 'fulfilled',
                    'price_set' => [
                        'shop_money' => [
                            'amount' => '67.00',
                            'currency_code' => 'CAD',
                        ],
                        'presentment_money' => [
                            'amount' => '67.00',
                            'currency_code' => 'CAD',
                        ],
                    ],
                    'total_discount_set' => [
                        'shop_money' => [
                            'amount' => '0.00',
                            'currency_code' => 'CAD',
                        ],
                        'presentment_money' => [
                            'amount' => '0.00',
                            'currency_code' => 'CAD',
                        ],
                    ],
                    'discount_allocations' => [
                        [
                            'amount' => '6.70',
                            'discount_application_index' => 0,
                            'amount_set' => [
                                'shop_money' => [
                                    'amount' => '6.70',
                                    'currency_code' => 'CAD',
                                ],
                                'presentment_money' => [
                                    'amount' => '6.70',
                                    'currency_code' => 'CAD',
                                ],
                            ],
                        ],
                    ],
                    'tax_lines' => [
                        [
                            'title' => 'GST',
                            'price' => '3.02',
                            'rate' => 0.05,
                            'price_set' => [
                                'shop_money' => [
                                    'amount' => '3.02',
                                    'currency_code' => 'CAD',
                                ],
                                'presentment_money' => [
                                    'amount' => '3.02',
                                    'currency_code' => 'CAD',
                                ],
                            ],
                        ],
                        [
                            'title' => 'PST',
                            'price' => '4.82',
                            'rate' => 0.08,
                            'price_set' => [
                                'shop_money' => [
                                    'amount' => '4.82',
                                    'currency_code' => 'CAD',
                                ],
                                'presentment_money' => [
                                    'amount' => '4.82',
                                    'currency_code' => 'CAD',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

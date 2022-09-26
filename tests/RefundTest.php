<?php

use PHPUnit\Framework\TestCase;
use BoldApps\ShopifyToolkit\Models\Refund as ShopifyRefund;
use BoldApps\ShopifyToolkit\Services\Refund as RefundService;
use BoldApps\ShopifyToolkit\Models\Transaction;
use BoldApps\ShopifyToolkit\Models\OrderAdjustment;
use BoldApps\ShopifyToolkit\Models\RefundLineItem;
use Illuminate\Support\Collection;

class RefundTest extends TestCase
{
    /** @var RefundService */
    private $refundService;

    protected function setUp()
    {
        $client = $this->createMock(\BoldApps\ShopifyToolkit\Services\Client::class);
        $refundLineItemService = new \BoldApps\ShopifyToolkit\Services\RefundLineItem($client);
        $transactionService = new \BoldApps\ShopifyToolkit\Services\Transaction($client);
        $this->refundService = new RefundService($client, $refundLineItemService, $transactionService);
    }

    /**
     * @test
     */
    public function ShopifyRefundSerializesProperly()
    {
        $refundEntity = new ShopifyRefund();
        $refundEntity->setOrderId(123456);
        $refundEntity->setShipping(25.00);
        $refundEntity->setCurrency('USD');

        $refundLineItem = new RefundLineItem();
        $refundLineItem->setLineItemId(222333);
        $refundLineItem->setRestockType('cancel');
        $refundLineItem->setLocationId(777777);
        $refundLineItem->setQuantity(1);
        $refundLineItem->setPrice(126.70);
        $refundLineItem->setDiscountedPrice(126.70);
        $refundLineItem->setDiscountedTotalPrice(126.70);
        $refundLineItem->setTotalCartDiscountAmount(0.00);
        $refundLineItem->setTotalTax(6.70);
        $refundLineItem->setSubtotal(126.70);

        $transactionLineItem = new Transaction();

        $transactionLineItem->setParentId(99999);
        $transactionLineItem->setAmount(126.70);
        $transactionLineItem->setKind('refund');
        $transactionLineItem->setGateway('bogus');
        $transactionLineItem->setOrderId(123456);
        $transactionLineItem->setCurrency('USD');
        $transactionLineItem->setMaximumRefundable(126.70);

        $refundEntity->setRefundLineItems(new Collection([$refundLineItem]));
        $refundEntity->setTransactions(new Collection([$transactionLineItem]));

        $expected = [
            'order_id' => 123456, //TODO: Remove this when ignored fields is implemented (Services\Base)
            'notify' => false,
            'shipping' => [
                'amount' => 25,
            ],
            'currency' => 'USD',
            'refund_line_items' => [
                [
                    'line_item_id' => 222333,
                    'restock_type' => 'cancel',
                    'quantity' => 1,
                    'location_id' => 777777,
                    'price' => 126.70,
                    'discounted_price' => 126.70,
                    'discounted_total_price' => 126.70,
                    'total_cart_discount_amount' => 0.00,
                    'subtotal' => 126.70,
                    'total_tax' => 6.70,
                ],
            ],
            'transactions' => [
                [
                    'parent_id' => 99999,
                    'amount' => 126.70,
                    'kind' => 'refund',
                    'gateway' => 'bogus',
                    'order_id' => 123456,
                    'currency' => 'USD',
                    'maximum_refundable' => 126.70,
                ],
            ],
        ];

        $actual = $this->refundService->serializeModel($refundEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyRefundDeserializesProperly()
    {
        $refundJson = '{
            "id": 929361464,
            "order_id": 450789469,
            "created_at": "2016-11-09T13:53:19-05:00",
            "note": "wrong size",
            "user_id": 0,
            "refund_line_items": [
                {
                    "id": 1058498311,
                    "quantity": 1,
                    "line_item_id": 518995019,
                    "subtotal": 195.67,
                    "total_tax": 3.98,
                    "restock_type": "cancel",
                    "location_id": 1234,
                    "price": "195.67",
                    "discounted_price": "195.67",
                    "discounted_total_price": "195.67",
                    "total_cart_discount_amount": "0.00",
                    "line_item": {
                        "id": 518995019,
                        "variant_id": 49148385,
                        "title": "IPod Nano - 8gb",
                        "quantity": 1,
                        "price": "199.00",
                        "grams": 200,
                        "sku": "IPOD2008RED",
                        "variant_title": "red",
                        "vendor": null,
                        "product_id": 632910392,
                        "requires_shipping": true,
                        "taxable": true,
                        "gift_card": false,
                        "name": "IPod Nano - 8gb - red",
                        "variant_inventory_management": "shopify",
                        "properties": [],
                        "product_exists": true,
                        "fulfillable_quantity": 0,
                        "total_discount": "0.00",
                        "fulfillment_status": null,
                        "tax_lines": [
                            {
                                "title": "State Tax",
                                "price": "3.98",
                                "rate": 0.06
                            }
                        ]
                    }
                }
            ],
            "transactions": [
                {
                    "id": 1068278485,
                    "order_id": 450789469,
                    "amount": "199.65",
                    "kind": "refund",
                    "gateway": "bogus",
                    "status": "success",
                    "message": "Bogus Gateway: Forced success",
                    "created_at": "2016-11-09T13:53:19-05:00",
                    "test": true,
                    "authorization": null,
                    "currency": "USD",
                    "location_id": null,
                    "user_id": null,
                    "parent_id": 801038806,
                    "device_id": null,
                    "receipt": {},
                    "error_code": null,
                    "source_name": "755357713",
                    "maximum_refundable": "199.65"
                }
            ],
            "order_adjustments": [
                {
                    "id": 152072455,
                    "order_id": 4822363655,
                    "refund_id": 209079047,
                    "amount": "2.37",
                    "tax_amount": "0.00",
                    "kind": "refund_discrepancy",
                    "reason": "Refund discrepancy"
                }
            ]
        }';

        $expected = new ShopifyRefund();
        $expected->setId(929361464);
        $expected->setOrderId(450789469);
        $expected->setCreatedAt('2016-11-09T13:53:19-05:00');
        $expected->setNote('wrong size');
        $expected->setUserId(0);

        $expectedRefundLineItem1 = new RefundLineItem();
        $expectedRefundLineItem1->setId(1058498311);
        $expectedRefundLineItem1->setQuantity(1);
        $expectedRefundLineItem1->setLineItemId(518995019);
        $expectedRefundLineItem1->setSubtotal(195.67);
        $expectedRefundLineItem1->setTotalTax(3.98);
        $expectedRefundLineItem1->setRestockType('cancel');
        $expectedRefundLineItem1->setLocationId(1234);
        $expectedRefundLineItem1->setTotalCartDiscountAmount(0.00);
        $expectedRefundLineItem1->setDiscountedTotalPrice(195.67);
        $expectedRefundLineItem1->setDiscountedPrice(195.67);
        $expectedRefundLineItem1->setPrice(195.67);

        $expectedTransactionLineItem1 = new Transaction();
        $expectedTransactionLineItem1->setId(1068278485);
        $expectedTransactionLineItem1->setOrderId(450789469);
        $expectedTransactionLineItem1->setAmount('199.65');
        $expectedTransactionLineItem1->setKind('refund');
        $expectedTransactionLineItem1->setGateway('bogus');
        $expectedTransactionLineItem1->setStatus('success');
        $expectedTransactionLineItem1->setMessage('Bogus Gateway: Forced success');
        $expectedTransactionLineItem1->setCreatedAt('2016-11-09T13:53:19-05:00');
        $expectedTransactionLineItem1->setTest(true);
        $expectedTransactionLineItem1->setAuthorization(null);
        $expectedTransactionLineItem1->setCurrency('USD');
        $expectedTransactionLineItem1->setLocationId(null);
        $expectedTransactionLineItem1->setUserId(null);
        $expectedTransactionLineItem1->setParentId(801038806);
        $expectedTransactionLineItem1->setDeviceId(null);
        $expectedTransactionLineItem1->setReceipt([]);
        $expectedTransactionLineItem1->setErrorCode(null);
        $expectedTransactionLineItem1->setSourceName('755357713');
        $expectedTransactionLineItem1->setMaximumRefundable(199.65);

        $expected->setRefundLineItems(new Collection([$expectedRefundLineItem1]));
        $expected->setTransactions(new Collection([$expectedTransactionLineItem1]));
        $expected->setOrderAdjustments(new Collection([
            new OrderAdjustment(152072455, 4822363655, 209079047, 2.37, 0.00, 'refund_discrepancy', 'Refund discrepancy'),
        ]));

        $jsonArray = (array) json_decode($refundJson, true);

        $actual = $this->refundService->createFromArray($jsonArray);

        $this->assertEquals($expected, $actual);
    }
}

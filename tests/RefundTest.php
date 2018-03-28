<?php
use \PHPUnit\Framework\TestCase;


use BoldApps\ShopifyToolkit\Models\Refund as ShopifyRefund;
use BoldApps\ShopifyToolkit\Services\Refund as RefundService;
use BoldApps\ShopifyToolkit\Models\Transaction;
use BoldApps\ShopifyToolkit\Models\OrderAdjustment;
use BoldApps\ShopifyToolkit\Models\RefundLineItem;

use Illuminate\Support\Collection;


class RefundTest extends TestCase
{
    /**
     * @var RefundService
     */
    private $refundService;

    protected function setUp()
    {
        $client = $this->createMock(\BoldApps\ShopifyToolkit\Services\Client::class);
        $this->refundService = new RefundService($client);
    }

    /**
     * @test
     */
    public function ShopifyRefundSerializesProperly()
    {
        $refundEntity = new ShopifyRefund();
        $refundEntity->setOrderId(123456);
        $refundEntity->setShipping(25.00);

        $refundLineItem = new RefundLineItem();
        $refundLineItem->lineItemId = 222333;
        $refundLineItem->quantity = 1;

        $transactionLineItem = new Transaction();

        $transactionLineItem->parentId = 99999;
        $transactionLineItem->amount = 126.70;
        $transactionLineItem->kind = 'refund';
        $transactionLineItem->gateway = 'bogus';

        $refundEntity->setRefundLineItems(new Collection([$refundLineItem]));
        $refundEntity->setTransactions(new Collection([$transactionLineItem]));

        $expected = [
            'restock' => true,
            'notify' => false,
            'shipping' => [
                'amount' => 25
            ],
            'refund_line_items' => [
                ['line_item_id' => 222333, 'quantity' => 1]
            ],
            'transactions' => [
                [
                    'parent_id' => 99999,
                    'amount' => 126.70,
                    'kind' => 'refund',
                    'gateway' => 'bogus',
                ]
            ]


            //TODO: When ignored fields is implemented (Services\Base), we should remove this
            , 'order_id' => 123456
        ];

        $actual = $this->refundService->serializeModel($refundEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyRefundDeserializesProperly()
    {

        //from the shopify documentation
        $refundJson = '{
            "id": 929361464,
            "order_id": 450789469,
            "created_at": "2016-11-09T13:53:19-05:00",
            "note": "wrong size",
            "restock": true,
            "user_id": 0,
            "refund_line_items": [
              {
                "id": 1058498311,
                "quantity": 1,
                "line_item_id": 518995019,
                "subtotal": 195.67,
                "total_tax": 3.98,
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
                  "fulfillment_service": "manual",
                  "product_id": 632910392,
                  "requires_shipping": true,
                  "taxable": true,
                  "gift_card": false,
                  "name": "IPod Nano - 8gb - red",
                  "variant_inventory_management": "shopify",
                  "properties": [
                  ],
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
                "source_name": "755357713"
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
        $expected->setCreatedAt("2016-11-09T13:53:19-05:00");
        $expected->setNote("wrong size");
        $expected->setRestock(true);
        $expected->setUserId(0);

        $expectedRefundLineItem1 = new RefundLineItem();
        $expectedRefundLineItem1->id = 1058498311;
        $expectedRefundLineItem1->quantity = 1;
        $expectedRefundLineItem1->lineItemId = 518995019;
        $expectedRefundLineItem1->subtotal = 195.67;
        $expectedRefundLineItem1->totalTax = 3.98;


        $expectedTransactionLineItem1 = new Transaction();
        $expectedTransactionLineItem1->id = 1068278485;
        $expectedTransactionLineItem1->orderId = 450789469;
        $expectedTransactionLineItem1->amount = "199.65";
        $expectedTransactionLineItem1->kind = "refund";
        $expectedTransactionLineItem1->gateway = "bogus";
        $expectedTransactionLineItem1->status = "success";
        $expectedTransactionLineItem1->message = "Bogus Gateway: Forced success";
        $expectedTransactionLineItem1->createdAt = "2016-11-09T13:53:19-05:00";
        $expectedTransactionLineItem1->test = true;
        $expectedTransactionLineItem1->authorization = null;
        $expectedTransactionLineItem1->currency = "USD";
        $expectedTransactionLineItem1->locationId = null;
        $expectedTransactionLineItem1->userId = null;
        $expectedTransactionLineItem1->parentId = 801038806;
        $expectedTransactionLineItem1->deviceId = null;
        $expectedTransactionLineItem1->receipt = [];
        $expectedTransactionLineItem1->errorCode = null;
        $expectedTransactionLineItem1->sourceName = "755357713";


        $expected->setRefundLineItems(new Collection([$expectedRefundLineItem1]));
        $expected->setTransactions(new Collection([$expectedTransactionLineItem1]));
        $expected->setOrderAdjustments(new Collection([
            new OrderAdjustment(152072455, 4822363655, 209079047, 2.37, 0.00, "refund_discrepancy", "Refund discrepancy")
        ]));

        $jsonArray = (array)json_decode($refundJson, true);

        $actual = $this->refundService->createFromArray($jsonArray);

        $this->assertEquals($expected, $actual);
    }
}
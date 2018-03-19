<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\OrderAdjustment;
use BoldApps\ShopifyToolkit\Models\Refund as ShopifyRefund;
use BoldApps\ShopifyToolkit\Models\RefundLineItem;
use BoldApps\ShopifyToolkit\Models\Transaction as ShopifyTransaction;
use Illuminate\Support\Collection;

/**
 * Class Refund.
 */
class Refund extends Base
{
    /**
     * @var array
     */
    protected $serializationExceptions = [
        'shipping' => 'serializeShipping',
        'refundLineItems' => 'serializeRefundLineItems',
        'transactions' => 'serializeTransactions',
        'orderAdjustments' => 'serializeOrderAdjustments',
    ];

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'shipping' => 'deserializeShipping',
        'refund_line_items' => 'deserializeRefundLineItems',
        'transactions' => 'deserializeTransactions',
        'order_adjustments' => 'deserializeOrderAdjustments'
    ];


    /**
     * @param ShopifyRefund $refund
     * @return ShopifyRefund | object
     */
    public function create(ShopifyRefund $refund)
    {
        $serializedModel = ['refund' => $this->serializeModel($refund)];

        $raw = $this->client->post("admin/orders/{$refund->getOrderId()}/refunds.json", [], $serializedModel);

        return $this->unserializeModel($raw['refund'], ShopifyRefund::class);
    }

    /**
     * @param $array
     *
     * @return ShopifyRefund | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyRefund::class);
    }

    /**
     * @param $entity
     * @return array|null
     */
    public function serializeShipping($entity)
    {
        if (null === $entity) {
            return null;
        }

        return [
            'amount' => $entity
        ];
    }

    /**
     * @param $data
     * @return float|Collection|null
     */
    public function deserializeShipping($data)
    {
        if (null === $data) {
            return null;
        }
        return (float)$data;
    }

    /**
     * @param Collection RefundLineItem $entities
     * @return Collection|null
     */
    public function serializeRefundLineItems($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count()===0) {
            return null;
        }

        return $entities->map(function (RefundLineItem $line) {
            return [
                'line_item_id' => $line->lineItemId,
                'quantity' => $line->quantity
            ];
        })->toArray();
    }

    /**
     * @param $data
     * @return Collection
     */
    public function deserializeRefundLineItems($data)
    {
        if (null === $data) {
            return new Collection([]);
        }

        $refundLineItems = array_map(function ($lineItem) {
            $rli = new RefundLineItem();

            $rli->id = $lineItem['id'];
            $rli->quantity = $lineItem['quantity'];
            $rli->lineItemId = $lineItem['line_item_id'];
            $rli->subtotal = $lineItem['subtotal'];
            $rli->totalTax = $lineItem['total_tax'];

            return $rli;
        }, $data);

        return new Collection($refundLineItems);
    }


    /**
     * @param Collection ShopifyTransaction $entities
     * @return Collection|null
     */
    public function serializeTransactions($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count()===0) {
            return null;
        }

        return $entities->map(function (ShopifyTransaction $transaction) {
            return [
                'parent_id' => $transaction->parentId,
                'amount' => $transaction->amount,
                'kind' => $transaction->kind,
                'gateway' => $transaction->gateway
            ];
        })->toArray();
    }

    /**
     * @param $data
     * @return Collection|null
     */
    public function deserializeTransactions($data)
    {
        if (null === $data) {
            return null;
        }

        $transactions = array_map(function ($transaction) {
            $tli = new ShopifyTransaction();
            $tli->id = $transaction['id'];
            $tli->orderId = $transaction['order_id'];
            $tli->amount = $transaction['amount'];
            $tli->kind = $transaction['kind'];
            $tli->gateway = $transaction['gateway'];
            $tli->status = $transaction['status'];
            $tli->message = $transaction['message'];
            $tli->createdAt = $transaction['created_at'];
            $tli->test = $transaction['test'];
            $tli->authorization = $transaction['authorization'];
            $tli->currency = $transaction['currency'];
            $tli->locationId = $transaction['location_id'];
            $tli->userId = $transaction['user_id'];
            $tli->parentId = $transaction['parent_id'];
            $tli->deviceId = $transaction['device_id'];
            $tli->receipt = $transaction['receipt'];
            $tli->errorCode = $transaction['error_code'];
            $tli->sourceName = $transaction['source_name'];

            return $tli;
        }, $data);

        return new Collection($transactions);
    }

    /**
     * @param $entities
     * @return array|null
     */
    public function serializeOrderAdjustments($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count()===0) {
            return null;
        }

        return $entities->map(function ($adjustment) {
            return [
                'id' => $adjustment->id,
                'order_id' => $adjustment->orderId,
                'refund_id' => $adjustment->refundId,
                'amount' => $adjustment->amount,
                'tax_amount' => $adjustment->taxAmount,
                'kind' => $adjustment->kind,
                'reason' => $adjustment->reason,
            ];
        })->toArray();
    }

    /**
     * @param $data
     * @return Collection|null
     */
    public function deserializeOrderAdjustments($data)
    {
        if (null === $data) {
            return null;
        }

        $orderAdjustments = array_map(function ($adjustment) {
            return new OrderAdjustment($adjustment['id'], $adjustment['order_id'], $adjustment['refund_id'], $adjustment['amount'], $adjustment['tax_amount'], $adjustment['kind'], $adjustment['reason']);
        }, $data);


        return new Collection($orderAdjustments);
    }
}

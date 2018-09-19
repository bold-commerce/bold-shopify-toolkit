<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\OrderAdjustment;
use BoldApps\ShopifyToolkit\Models\Refund as ShopifyRefund;
use BoldApps\ShopifyToolkit\Models\RefundLineItem;
use BoldApps\ShopifyToolkit\Models\Transaction as ShopifyTransaction;
use BoldApps\ShopifyToolkit\Services\RefundLineItem as RefundLineItemService;
use Illuminate\Support\Collection;

class Refund extends Base
{

    /**
     * @var \BoldApps\ShopifyToolkit\Services\RefundLineItem
     */
    protected $refundLineItemService;

    /**
     * @var Transaction
     */
    protected $transactionService;

    public function __construct(
        Client $client,
        RefundLineItemService $refundLineItemService,
        Transaction $transactionService
    )
    {
        $this->transactionService = $transactionService;
        $this->refundLineItemService = $refundLineItemService;
        parent::__construct($client);
    }

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
        'order_adjustments' => 'deserializeOrderAdjustments',
    ];

    /**
     * @param ShopifyRefund $refund
     *
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
     *
     * @return array|null
     */
    public function serializeShipping($entity)
    {
        if (null === $entity) {
            return null;
        }

        return [
            'amount' => $entity,
        ];
    }

    /**
     * @param $data
     *
     * @return float|Collection|null
     */
    public function deserializeShipping($data)
    {
        if (null === $data) {
            return null;
        }

        return (float) $data;
    }

    /**
     * @param Collection RefundLineItem $entities
     *
     * @return Collection|null
     */
    public function serializeRefundLineItems($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count() === 0) {
            return null;
        }

        $refundLineItemService = $this->refundLineItemService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($refundLineItemService) {
                return $refundLineItemService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param $data
     *
     * @return Collection
     */
    public function deserializeRefundLineItems($data)
    {
        if (null === $data) {
            return new Collection([]);
        }

        $refundLineItemService = $this->refundLineItemService;

        $refundLineItems = array_map(function ($option) use ($refundLineItemService) {
            return $refundLineItemService->unserializeModel($option, RefundLineItem::class);
        }, $data);

        return new Collection($refundLineItems);
    }

    /**
     * @param Collection ShopifyTransaction $entities
     *
     * @return Collection|null
     */
    public function serializeTransactions($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count() === 0) {
            return null;
        }

        $transactionService = $this->transactionService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($transactionService) {
                return $transactionService->serializeModel($entity);
            })->toArray();
        }

        return $entities;

    }

    /**
     * @param $data
     *
     * @return Collection|null
     */
    public function deserializeTransactions($data)
    {
        if (null === $data) {
            return null;
        }

        $transactionService = $this->transactionService;

        $transactions = array_map(function ($option) use ($transactionService) {
            return $transactionService->unserializeModel($option, ShopifyTransaction::class);
        }, $data);

        return new Collection($transactions);
    }

    /**
     * @param $entities
     * @return array|null
     */
    public function serializeOrderAdjustments($entities)
    {
        if (null === $entities || !($entities instanceof Collection) || $entities->count() === 0) {
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

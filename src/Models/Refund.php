<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;
use Illuminate\Support\Collection;

class Refund implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    public $id;

    /** @var int */
    public $orderId;

    /** @var string */
    public $note;

    /** @var string */
    public $createdAt;

    /** @var int */
    public $userId;

    /** @var float */
    protected $shipping;

    /** @var bool */
    protected $notify;

    /** @var Collection of Transaction */
    protected $transactions;

    /** @var Collection of RefundLineItem */
    protected $refundLineItems;

    /** @var Collection */
    public $orderAdjustments;

    /** @var string */
    protected $processedAt;

    /** @var string */
    protected $currency;

    public function __construct()
    {
        $this->notify = false;
        $this->transactions = new Collection([]);
        $this->refundLineItems = new Collection([]);
        $this->orderAdjustments = new Collection([]);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNotify()
    {
        return $this->notify;
    }

    public function setNotify($notify)
    {
        $this->notify = $notify;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getProcessedAt()
    {
        return $this->processedAt;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param float $shippingAmount
     */
    public function setShipping($shippingAmount)
    {
        $this->shipping = $shippingAmount;
    }

    /**
     * @return Collection of RefundLineItem
     */
    public function getRefundLineItems()
    {
        return $this->refundLineItems;
    }

    /**
     * @param Collection of RefundLineItem $refundLineItems
     */
    public function setRefundLineItems($refundLineItems)
    {
        $this->refundLineItems = $refundLineItems;
    }

    /**
     * @param RefundLineItem $refundLineItem
     */
    public function addRefundLineItem($refundLineItem)
    {
        $this->refundLineItems->push($refundLineItem);
    }

    /**
     * @return Collection of Transaction
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param Collection of Transaction $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @param Transaction $transaction
     */
    public function addTransaction($transaction)
    {
        $this->transactions->push($transaction);
    }

    /**
     * @return Collection of OrderAdjustment
     */
    public function getOrderAdjustments()
    {
        return $this->orderAdjustments;
    }

    /**
     * @param Collection of OrderAdjustment $orderAdjustments
     */
    public function setOrderAdjustments($orderAdjustments)
    {
        $this->orderAdjustments = $orderAdjustments;
    }

    /**
     * @param OrderAdjustment $orderAdjustment
     */
    public function addOrderAdjustment($orderAdjustment)
    {
        $this->orderAdjustments->push($orderAdjustment);
    }
}

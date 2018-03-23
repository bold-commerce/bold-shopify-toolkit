<?php
namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;


class Fulfillment implements Serializeable
{

    /** @var string */
    protected $createdAt;

    /** @var int */
    protected $id;

    /** @var array */
    protected $lineItems;

    /** @var bool */
    protected $notifyCustomer;

    /** @var int */
    protected $orderId;

    /** @var array */
    protected $receipt;

    /** @var string */
    protected $status;

    /** @var string */
    protected $trackingCompany;

    /** @var string */
    protected $trackingNumbers;

    /** @var string */
    protected $trackingUrls;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $variantInventoryManagement;

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
     * @return bool
     */
    public function getNotifyCustomer()
    {
        return $this->notifyCustomer;
    }

    /**
     * @param bool $notifyCustomer
     */
    public function setNotifyCustomer($notifyCustomer)
    {
        $this->notifyCustomer = $notifyCustomer;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @param array $lineItems
     */
    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
    }

    /**
     * @return array
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTrackingCompany()
    {
        return $this->trackingCompany;
    }

    /**
     * @param string $trackingCompany
     */
    public function setTrackingCompany($trackingCompany)
    {
        $this->trackingCompany = $trackingCompany;
    }

    /**
     * @return string
     */
    public function getTrackingNumbers()
    {
        return $this->trackingNumbers;
    }

    /**
     * @param string
     */
    public function setTrackingNumbers($trackingNumbers)
    {
        $this->trackingNumbers = $trackingNumbers;
    }

    /**
     * @return string
     */
    public function getTrackingUrls()
    {
        return $this->trackingUrls;
    }

    /**
     * @param array $trackingUrls
     */
    public function setTrackingUrls($trackingUrls)
    {
        $this->trackingUrls = $trackingUrls;
    }

    /**
     * @return string
     */
    public function getVariantInventoryManagement()
    {
        return $this->variantInventoryManagement;
    }

}

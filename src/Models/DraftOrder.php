<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use Illuminate\Support\Collection;

/**
 * Class DraftOrder
 */
class DraftOrder implements Serializeable
{
    /** @var  int */
    protected $id;

    /** @var  string */
    protected $note;

    /** @var  array */
    protected $noteAttributes;

    /** @var  string */
    protected $email;

    /** @var  bool */
    protected $taxesIncluded;

    /** @var  string */
    protected $currency;

    /** @var   string*/
    protected $subtotalPrice;

    /** @var  string */
    protected $totalTax;

    /** @var  string */
    protected $totalPrice;

    /** @var  string */
    protected $invoiceSentAt;

    /** @var  string */
    protected $createdAt;

    /** @var  string */
    protected $updatedAt;

    /** @var  bool */
    protected $taxExempt;

    /** @var  string */
    protected $completedAt;

    /** @var  string */
    protected $name;

    /** @var  string */
    protected $status;

    /** @var  collection */
    protected $lineItems;

    //TODO: implement object as a model
    /** @var  object */
    protected $shippingAddress;

    //TODO: implement object as a model
    /** @var  object */
    protected $billingAddress;

    /** @var  string */
    protected $invoiceUrl;

    /** @var  int */
    protected $orderId;

    //TODO: implement object as a model
    /** @var  object */
    protected $shippingLine;

    /** @var  array */
    protected $taxLines;

    /** @var  string */
    protected $tags;

    /** @var  object */
    protected $customer;

    /** @var  object */
    protected $appliedDiscount;

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

    /**
     * @return array
     */
    public function getNoteAttributes()
    {
        return $this->noteAttributes;
    }

    /**
     * @param array $noteAttributes
     */
    public function setNoteAttributes($noteAttributes)
    {
        $this->noteAttributes = $noteAttributes;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function getTaxesIncluded()
    {
        return $this->taxesIncluded;
    }

    /**
     * @param bool $taxesIncluded
     */
    public function setTaxesIncluded($taxesIncluded)
    {
        $this->taxesIncluded = $taxesIncluded;
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
     * @return string
     */
    public function getSubtotalPrice()
    {
        return $this->subtotalPrice;
    }

    /**
     * @param string $subtotalPrice
     */
    public function setSubtotalPrice($subtotalPrice)
    {
        $this->subtotalPrice = $subtotalPrice;
    }

    /**
     * @return string
     */
    public function getTotalTax()
    {
        return $this->totalTax;
    }

    /**
     * @param string $totalTax
     */
    public function setTotalTax($totalTax)
    {
        $this->totalTax = $totalTax;
    }

    /**
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param string $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return string
     */
    public function getInvoiceSentAt()
    {
        return $this->invoiceSentAt;
    }

    /**
     * @param string $invoiceSentAt
     */
    public function setInvoiceSentAt($invoiceSentAt)
    {
        $this->invoiceSentAt = $invoiceSentAt;
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
     * @return bool
     */
    public function getTaxExempt()
    {
        return $this->taxExempt;
    }

    /**
     * @param bool $taxExempt
     */
    public function setTaxExempt($taxExempt)
    {
        $this->taxExempt = $taxExempt;
    }

    /**
     * @return string
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * @param string $completedAt
     */
    public function setCompletedAt($completedAt)
    {
        $this->completedAt = $completedAt;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return Collection
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @param Collection $lineItems
     */
    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
    }

    /**
     * @return object
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param object $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return object
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param object $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return string
     */
    public function getInvoiceUrl()
    {
        return $this->invoiceUrl;
    }

    /**
     * @param string $invoiceUrl
     */
    public function setInvoiceUrl($invoiceUrl)
    {
        $this->invoiceUrl = $invoiceUrl;
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
     * @return object
     */
    public function getShippingLine()
    {
        return $this->shippingLine;
    }

    /**
     * @param object $shippingLine
     */
    public function setShippingLine($shippingLine)
    {
        $this->shippingLine = $shippingLine;
    }

    /**
     * @return array
     */
    public function getTaxLines()
    {
        return $this->taxLines;
    }

    /**
     * @param array $taxLines
     */
    public function setTaxLines($taxLines)
    {
        $this->taxLines = $taxLines;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return object
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param object $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return object
     */
    public function getAppliedDiscount()
    {
        return $this->appliedDiscount;
    }

    /**
     * @param object $appliedDiscount
     */
    public function setAppliedDiscount($appliedDiscount)
    {
        $this->appliedDiscount = $appliedDiscount;
    }
}

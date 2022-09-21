<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class RefundLineItem implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $lineItemId;

    /** @var float */
    protected $subtotal;

    /** @var float */
    protected $totalTax;

    /** @var string */
    protected $restockType;

    /** @var int */
    protected $locationId;

    /** @var float */
    protected $price;

    /** @var float */
    protected $discountedPrice;

    /** @var float */
    protected $discountedTotalPrice;

    /** @var float */
    protected $totalCartDiscountAmount;

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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getLineItemId()
    {
        return $this->lineItemId;
    }

    /**
     * @param int $lineItemId
     */
    public function setLineItemId($lineItemId)
    {
        $this->lineItemId = $lineItemId;
    }

    /**
     * @return float
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * @param float $subtotal
     */
    public function setSubtotal($subtotal)
    {
        $this->subtotal = $subtotal;
    }

    /**
     * @return float
     */
    public function getTotalTax()
    {
        return $this->totalTax;
    }

    /**
     * @param float $totalTax
     */
    public function setTotalTax($totalTax)
    {
        $this->totalTax = $totalTax;
    }

    /**
     * @param string $restockType
     */
    public function setRestockType($restockType)
    {
        $this->restockType = $restockType;
    }

    /**
     * @return string
     */
    public function getRestockType()
    {
        return $this->restockType;
    }

    /**
     * @param string int
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * @param float $discountedPrice
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;
    }

    /**
     * @return float
     */
    public function getDiscountedTotalPrice()
    {
        return $this->discountedTotalPrice;
    }

    /**
     * @param float $discountedTotalPrice
     */
    public function setDiscountedTotalPrice($discountedTotalPrice)
    {
        $this->discountedTotalPrice = $discountedTotalPrice;
    }

    /**
     * @return float
     */
    public function getTotalCartDiscountAmount()
    {
        return $this->totalCartDiscountAmount;
    }

    /**
     * @param float $totalCartDiscountAmount
     */
    public function setTotalCartDiscountAmount($totalCartDiscountAmount)
    {
        $this->totalCartDiscountAmount = $totalCartDiscountAmount;
    }
}

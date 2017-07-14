<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OrderLineItem.
 */
class OrderLineItem implements Serializeable
{

    /** @var  int */
    protected $id;

    /** @var  int */
    protected $variantId;

    /** @var  string */
    protected $title;

    /** @var  int */
    protected $quantity;

    /** @var  string */
    protected $price;

    /** @var  int */
    protected $grams;

    /** @var  string */
    protected $sku;

    /** @var  string */
    protected $variantTitle;

    /** @var  string */
    protected $vendor;

    /** @var  string */
    protected $fulfillmentService;

    /** @var  int */
    protected $productId;

    /** @var  boolean */
    protected $requiresShipping;

    /** @var  boolean */
    protected $taxable;

    /** @var  boolean */
    protected $giftCard;

    /** @var  string */
    protected $name;

    /** @var  string */
    protected $variantInventoryManagement;

    /** @var  array */
    protected $properties;

    /** @var  boolean */
    protected $productExists;

    /** @var  string */
    protected $fulfillmentStatus;

    /** @var  Collection */
    protected $taxLines;

    /*** @var int */
    protected $fulfillableQuantity;

    /*** @var int */
    protected $totalDiscount;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getGrams()
    {
        return $this->grams;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getVariantTitle()
    {
        return $this->variantTitle;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @return string
     */
    public function getFulfillmentService()
    {
        return $this->fulfillmentService;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return boolean
     */
    public function getRequiresShipping()
    {
        return $this->requiresShipping;
    }

    /**
     * @return boolean
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @return boolean
     */
    public function getGiftCard()
    {
        return $this->giftCard;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVariantInventoryManagement()
    {
        return $this->variantInventoryManagement;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return boolean
     */
    public function getProductExists()
    {
        return $this->productExists;
    }

    /**
     * @return string
     */
    public function getFulfillmentStatus()
    {
        return $this->fulfillmentStatus;
    }

    /**
     * @return Collection
     */
    public function getTaxLines()
    {
        return $this->taxLines;
    }

    /**
     * @return int
     */
    public function getFulfillableQuantity()
    {
        return $this->fulfillableQuantity;
    }

    /**
     * @return int
     */
    public function getTotalDiscount()
    {
        return $this->totalDiscount;
    }


}

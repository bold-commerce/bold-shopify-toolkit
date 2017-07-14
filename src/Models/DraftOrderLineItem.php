<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

/**
 * Class DraftOrderLineItem
 */
class DraftOrderLineItem implements Serializeable
{
    /**
     * @var int
     */
    protected $variantId;

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $variantTitle;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $vendor;

    /**
     * @var string
     */
    protected $price;

    /**
     * @var string
     */
    protected $grams;

    /**
     * @var string
     */
    protected $quantity;

    /**
     * @var bool
     */
    protected $requiresShipping;

    /**
     * @var bool
     */
    protected $taxable;

    /**
     * @var bool
     */
    protected $giftCard;

    /**
     * @var string
     */
    protected $fulfillmentService;

    /**
     * @var array
     */
    protected $taxLines;

    /**
     * @var DraftOrderAppliedDiscount
     */
    protected $appliedDiscount;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var bool
     */
    protected $custom;

    /**
     * @return int
     */
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * @param int $variantId
     */
    public function setVariantId($variantId)
    {
        $this->variantId = $variantId;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVariantTitle()
    {
        return $this->variantTitle;
    }

    /**
     * @param string $variantTitle
     */
    public function setVariantTitle($variantTitle)
    {
        $this->variantTitle = $variantTitle;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getGrams()
    {
        return $this->grams;
    }

    /**
     * @param string $grams
     */
    public function setGrams($grams)
    {
        $this->grams = $grams;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param string $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return bool
     */
    public function getRequiresShipping()
    {
        return $this->requiresShipping;
    }

    /**
     * @param bool $requiresShipping
     */
    public function setRequiresShipping($requiresShipping)
    {
        $this->requiresShipping = $requiresShipping;
    }

    /**
     * @return bool
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param bool $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
    }

    /**
     * @return bool
     */
    public function getGiftCard()
    {
        return $this->giftCard;
    }

    /**
     * @param bool $giftCard
     */
    public function setGiftCard($giftCard)
    {
        $this->giftCard = $giftCard;
    }

    /**
     * @return string
     */
    public function getFulfillmentService()
    {
        return $this->fulfillmentService;
    }

    /**
     * @param string $fulfillmentService
     */
    public function setFulfillmentService($fulfillmentService)
    {
        $this->fulfillmentService = $fulfillmentService;
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
     * @return DraftOrderAppliedDiscount
     */
    public function getAppliedDiscount()
    {
        return $this->appliedDiscount;
    }

    /**
     * @param DraftOrderAppliedDiscount $appliedDiscount
     */
    public function setAppliedDiscount($appliedDiscount)
    {
        $this->appliedDiscount = $appliedDiscount;
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
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return bool
     */
    public function getCustom()
    {
        return $this->custom;
    }

    /**
     * @param bool $custom
     */
    public function setCustom($custom)
    {
        $this->custom = $custom;
    }
}

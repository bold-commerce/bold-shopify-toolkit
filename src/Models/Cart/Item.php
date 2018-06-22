<?php

namespace BoldApps\ShopifyToolkit\Models\Cart;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

class Item implements Serializeable
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $properties;

    /** @var int */
    protected $quantity;

    /** @var int */
    protected $variantId;

    /** @var string */
    protected $key;

    /** @var string */
    protected $title;

    /** @var int */
    protected $price;

    /** @var int */
    protected $originalPrice;

    /** @var int */
    protected $discountedPrice;

    /** @var int */
    protected $linePrice;

    /** @var int */
    protected $originalLinePrice;

    /** @var int */
    protected $totalDiscount;

    /** @var array */
    protected $discounts;

    /** @var string */
    protected $sku;

    /** @var int */
    protected $grams;

    /** @var string */
    protected $vendor;

    /** @var int */
    protected $productId;

    /** @var bool */
    protected $giftCard;

    /** @var string */
    protected $url;

    /** @var string */
    protected $image;

    /** @var string */
    protected $handle;

    /** @var bool */
    protected $requiresShipping;

    /** @var string */
    protected $productType;

    /** @var string */
    protected $productTitle;

    /** @var string */
    protected $productDescription;

    /** @var string */
    protected $variantTitle;

    /** @var array */
    protected $variantOptions;

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
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
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
    public function getVariantId()
    {
        return $this->variantId;
    }

    /**
     * @param $variantId
     */
    public function setVariantId($variantId)
    {
        $this->variantId = $variantId;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
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
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * @param $originalPrice
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;
    }

    /**
     * @return int
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    /**
     * @param $discountedPrice
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;
    }

    /**
     * @return int
     */
    public function getLinePrice()
    {
        return $this->linePrice;
    }

    /**
     * @param $linePrice
     */
    public function setLinePrice($linePrice)
    {
        $this->linePrice = $linePrice;
    }

    /**
     * @return int
     */
    public function getOriginalLinePrice()
    {
        return $this->originalLinePrice;
    }

    /**
     * @param $originalLinePrice
     */
    public function setOriginalLinePrice($originalLinePrice)
    {
        $this->originalLinePrice = $originalLinePrice;
    }

    /**
     * @return int
     */
    public function getTotalDiscount()
    {
        return $this->totalDiscount;
    }

    /**
     * @param $totalDiscount
     */
    public function setTotalDiscount($totalDiscount)
    {
        $this->totalDiscount = $totalDiscount;
    }

    /**
     * @return array
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    /**
     * @param array $discounts
     */
    public function setDiscounts($discounts)
    {
        $this->discounts = $discounts;
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
     * @return int
     */
    public function getGrams()
    {
        return $this->grams;
    }

    /**
     * @param int $grams
     */
    public function setGrams($grams)
    {
        $this->grams = $grams;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return bool
     */
    public function getGiftCard()
    {
        return $this->giftCard;
    }

    /**
     * @param $giftCard
     */
    public function setGiftCard($giftCard)
    {
        $this->giftCard = $giftCard;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return bool
     */
    public function getRequiresShipping()
    {
        return $this->requiresShipping;
    }

    /**
     * @param $requiresShipping
     */
    public function setRequiresShipping($requiresShipping)
    {
        $this->requiresShipping = $requiresShipping;
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return string
     */
    public function getProductTitle()
    {
        return $this->productTitle;
    }

    /**
     * @param $productTitle
     */
    public function setProductTitle($productTitle)
    {
        $this->productTitle = $productTitle;
    }

    /**
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * @param $productDescription
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @return string
     */
    public function getVariantTitle()
    {
        return $this->variantTitle;
    }

    /**
     * @param $variantTitle
     */
    public function setVariantTitle($variantTitle)
    {
        $this->variantTitle = $variantTitle;
    }

    /**
     * @return array
     */
    public function getVariantOptions()
    {
        return $this->variantOptions;
    }

    /**
     * @param $variantOptions
     */
    public function setVariantOptions($variantOptions)
    {
        $this->variantOptions = $variantOptions;
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class LineItem implements Serializeable
{

    use HasAttributesTrait;

    /* @var string */
    protected $title;

    /* @var string */
    protected $productTitle;

    /* @var string */
    protected $variantTitle;

    /* @var string */
    protected $image;

    /* @var array */
    protected $properties;

    /* @var int */
    protected $quantity;

    /* @var int */
    protected $price;

    /* @var bool */
    protected $visible;

    /* @var bool */
    protected $taxable;

    /* @var string */
    protected $lineItemKey;

    /* @var int */
    protected $weight;

    /* @var string */
    protected $weightUnit;

    /* @var int */
    protected $id;

    /* @var Variant */
    protected $platformVariant;

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
    public function getProductTitle()
    {
        return $this->productTitle;
    }

    /**
     * @param string $productTitle
     */
    public function setProductTitle($productTitle)
    {
        $this->productTitle = $productTitle;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
     * @return bool
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
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
     * @return string
     */
    public function getLineItemKey()
    {
        return $this->lineItemKey;
    }

    /**
     * @param string $lineItemKey
     */
    public function setLineItemKey($lineItemKey)
    {
        $this->lineItemKey = $lineItemKey;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getWeightUnit()
    {
        return $this->weightUnit;
    }

    /**
     * @param string $weightUnit
     */
    public function setWeightUnit($weightUnit)
    {
        $this->weightUnit = $weightUnit;
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
     * @return Variant
     */
    public function getPlatformVariant()
    {
        return $this->platformVariant;
    }

    /**
     * @param Variant $platformVariant
     */
    public function setPlatformVariant($platformVariant)
    {
        $this->platformVariant = $platformVariant;
    }
}

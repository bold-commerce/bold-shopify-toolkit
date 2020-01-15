<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Variant implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var string */
    protected $id;

    /** @var string */
    protected $barcode;

    /** @var float */
    protected $compareAtPrice;

    /** @var string */
    protected $fulfillmentService;

    /** @var int */
    protected $grams;

    /** @var string */
    protected $inventoryManagement;

    /** @var string */
    protected $inventoryPolicy;

    /** @var string */
    protected $option1;

    /** @var string */
    protected $option2;

    /** @var string */
    protected $option3;

    /** @var string */
    protected $position;

    /** @var float */
    protected $price;

    /** @var int */
    protected $productId;

    /** @var bool */
    protected $requiresShipping;

    /** @var string */
    protected $sku;

    /** @var bool */
    protected $taxable;

    /** @var string */
    protected $taxCode;

    /** @var string */
    protected $title;

    /** @var int */
    protected $inventoryItemId;

    /** @var int */
    protected $inventoryQuantity;

    /** @var int */
    protected $oldInventoryQuantity;

    /** @var int */
    protected $inventoryQuantityAdjustment;

    /** @var int */
    protected $imageId;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $weight;

    /** @var string */
    protected $weightUnit;

    /** @var array */
    protected $metafields;

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
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return float
     */
    public function getCompareAtPrice()
    {
        return $this->compareAtPrice;
    }

    /**
     * @param float $compareAtPrice
     */
    public function setCompareAtPrice($compareAtPrice)
    {
        $this->compareAtPrice = $compareAtPrice;
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
    public function getInventoryManagement()
    {
        return $this->inventoryManagement;
    }

    /**
     * @param string $inventoryManagement
     */
    public function setInventoryManagement($inventoryManagement)
    {
        $this->inventoryManagement = $inventoryManagement;
    }

    /**
     * @return string
     */
    public function getInventoryPolicy()
    {
        return $this->inventoryPolicy;
    }

    /**
     * @param string $inventoryPolicy
     */
    public function setInventoryPolicy($inventoryPolicy)
    {
        $this->inventoryPolicy = $inventoryPolicy;
    }

    /**
     * @return string
     */
    public function getOption1()
    {
        return $this->option1;
    }

    /**
     * @param string $option1
     */
    public function setOption1($option1)
    {
        $this->option1 = $option1;
    }

    /**
     * @return string
     */
    public function getOption2()
    {
        return $this->option2;
    }

    /**
     * @param string $option2
     */
    public function setOption2($option2)
    {
        $this->option2 = $option2;
    }

    /**
     * @return string
     */
    public function getOption3()
    {
        return $this->option3;
    }

    /**
     * @param string $option3
     */
    public function setOption3($option3)
    {
        $this->option3 = $option3;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
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
    public function getTaxCode()
    {
        return $this->taxCode;
    }

    /**
     * @param string $taxCode
     */
    public function setTaxCode($taxCode)
    {
        $this->taxCode = $taxCode;
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
    public function getInventoryItemId()
    {
        return $this->inventoryItemId;
    }

    /**
     * @param int $inventoryItemId
     */
    public function setInventoryItemId($inventoryItemId)
    {
        $this->inventoryItemId = $inventoryItemId;
    }

    /**
     * @return int
     */
    public function getInventoryQuantity()
    {
        return $this->inventoryQuantity;
    }

    /**
     * @param int $inventoryQuantity
     */
    public function setInventoryQuantity($inventoryQuantity)
    {
        $this->inventoryQuantity = $inventoryQuantity;
    }

    /**
     * @return int
     */
    public function getOldInventoryQuantity()
    {
        return $this->oldInventoryQuantity;
    }

    /**
     * @param int $oldInventoryQuantity
     */
    public function setOldInventoryQuantity($oldInventoryQuantity)
    {
        $this->oldInventoryQuantity = $oldInventoryQuantity;
    }

    /**
     * @return int
     */
    public function getInventoryQuantityAdjustment()
    {
        return $this->inventoryQuantityAdjustment;
    }

    /**
     * @param int $inventoryQuantityAdjustment
     */
    public function setInventoryQuantityAdjustment($inventoryQuantityAdjustment)
    {
        $this->inventoryQuantityAdjustment = $inventoryQuantityAdjustment;
    }

    /**
     * @return int
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * @param int $imageId
     */
    public function setImageId($imageId)
    {
        $this->imageId = $imageId;
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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
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
     * @return array
     */
    public function getMetafields()
    {
        return $this->metafields;
    }

    /**
     * @param array $metafields
     */
    public function setMetafields($metafields)
    {
        $this->metafields = $metafields;
    }
}

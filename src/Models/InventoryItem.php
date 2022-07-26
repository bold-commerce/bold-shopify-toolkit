<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class InventoryItem implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var string */
    protected $cost;

    /** @var string|null */
    protected $countryCodeOfOrigin;

    /** @var array */
    protected $countryHarmonizedSystemCodes;

    /** @var int|null */
    protected $harmonizedSystemCode;

    /** @var int */
    protected $id;

    /** @var string|null */
    protected $provinceCodeOfOrigin;

    /** @var string */
    protected $sku;

    /** @var bool */
    protected $tracked;

    /** @var bool */
    protected $requiresShipping;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return string|null
     */
    public function getCountryCodeOfOrigin()
    {
        return $this->countryCodeOfOrigin;
    }

    /**
     * @param string|null $countryCodeOfOrigin
     */
    public function setCountryCodeOfOrigin($countryCodeOfOrigin)
    {
        $this->countryCodeOfOrigin = $countryCodeOfOrigin;
    }

    /**
     * @return array
     */
    public function getCountryHarmonizedSystemCodes()
    {
        return $this->countryHarmonizedSystemCodes;
    }

    /**
     * @param array $countryHarmonizedSystemCodes
     */
    public function setCountryHarmonizedSystemCodes($countryHarmonizedSystemCodes)
    {
        $this->countryHarmonizedSystemCodes = $countryHarmonizedSystemCodes;
    }

    /**
     * @return int|null
     */
    public function getHarmonizedSystemCode()
    {
        return $this->harmonizedSystemCode;
    }

    /**
     * @param int|null $harmonizedSystemCode
     */
    public function setHarmonizedSystemCode($harmonizedSystemCode)
    {
        $this->harmonizedSystemCode = $harmonizedSystemCode;
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
     * @return string|null
     */
    public function getProvinceCodeOfOrigin()
    {
        return $this->provinceCodeOfOrigin;
    }

    /**
     * @param string|null $provinceCodeOfOrigin
     */
    public function setProvinceCodeOfOrigin($provinceCodeOfOrigin)
    {
        $this->provinceCodeOfOrigin = $provinceCodeOfOrigin;
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
    public function getTracked()
    {
        return $this->tracked;
    }

    /**
     * @param bool $tracked
     */
    public function setTracked($tracked)
    {
        $this->tracked = $tracked;
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
}

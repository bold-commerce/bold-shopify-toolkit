<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Province implements Serializeable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    /** @var int */
    protected $countryId;

    /** @var string */
    protected $name;

    /** @var int */
    protected $shippingZoneId;

    /** @var float */
    protected $tax;

    /** @var string */
    protected $taxName;

    /** @var string */
    protected $taxType;

    /** @var float */
    protected $taxPercentage;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getShippingZoneId()
    {
        return $this->shippingZoneId;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getTaxName()
    {
        return $this->taxName;
    }

    /**
     * @return string
     */
    public function getTaxType()
    {
        return $this->taxType;
    }

    /**
     * @return float
     */
    public function getTaxPercentage()
    {
        return $this->taxPercentage;
    }
}

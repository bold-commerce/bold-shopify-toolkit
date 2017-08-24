<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

class ShippingZone implements Serializeable
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $countries;

    /**
     * @var array
     */
    protected $carrierShippingRateProviders;

    /**
     * @var array
     */
    protected $priceBasedShippingRates;

    /**
     * @var array
     */
    protected $weightBasedShippingRates;

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
     * @return array
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * @return array
     */
    public function getCarrierShippingRateProviders()
    {
        return $this->carrierShippingRateProviders;
    }


    /**
     * @return array
     */
    public function getPriceBasedShippingRates()
    {
        return $this->priceBasedShippingRates;
    }


    /**
     * @return array
     */
    public function getWeightBasedShippingRates()
    {
        return $this->weightBasedShippingRates;
    }
}
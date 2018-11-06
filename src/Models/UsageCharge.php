<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class UsageCharge implements Serializeable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $description;

    /** @var float */
    protected $price;

    /** @var string */
    protected $billingOn;

    /** @var float */
    protected $balanceUsed;

    /** @var float */
    protected $balanceRemaining;

    /** @var float */
    protected $riskLevel;

    /**
     * @return int $id
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return string
     */
    public function getBillingOn()
    {
        return $this->billingOn;
    }

    /**
     * @param string $billingOn
     */
    public function setBillingOn($billingOn)
    {
        $this->billingOn = $billingOn;
    }

    /**
     * @return float
     */
    public function getBalanceUsed()
    {
        return $this->balanceUsed;
    }

    /**
     * @param float $balanceUsed
     */
    public function setBalanceUsed($balanceUsed)
    {
        $this->balanceUsed = $balanceUsed;
    }

    /**
     * @return float
     */
    public function getBalanceRemaining()
    {
        return $this->balanceRemaining;
    }

    /**
     * @param float $balanceRemaining
     */
    public function setBalanceRemaining($balanceRemaining)
    {
        $this->balanceRemaining = $balanceRemaining;
    }

    /**
     * @return float
     */
    public function getRiskLevel()
    {
        return $this->riskLevel;
    }

    /**
     * @param float $riskLevel
     */
    public function setRiskLevel($riskLevel)
    {
        $this->riskLevel = $riskLevel;
    }
}

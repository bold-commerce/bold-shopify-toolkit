<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class RecurringApplicationCharge implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $activatedOn;

    /** @var string */
    protected $billingOn;

    /** @var string */
    protected $cancelledOn;

    /** @var float */
    protected $cappedAmount;

    /** @var string */
    protected $confirmationUrl;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $name;

    /** @var float */
    protected $price;

    /** @var string */
    protected $returnUrl;

    /** @var string */
    protected $status;

    /** @var string */
    protected $terms;

    /** @var bool */
    protected $test;

    /** @var int */
    protected $trialDays;

    /** @var string */
    protected $trialEndsOn;

    /** @var string */
    protected $updatedAt;

    /** @var int */
    protected $apiClientId;

    /** @var string */
    protected $decoratedReturnUrl;

    /** @var float */
    protected $balanceRemaining;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getActivatedOn()
    {
        return $this->activatedOn;
    }

    /**
     * @return string
     */
    public function getBillingOn()
    {
        return $this->billingOn;
    }

    /**
     * @return string
     */
    public function getCancelledOn()
    {
        return $this->cancelledOn;
    }

    /**
     * @return float
     */
    public function getCappedAmount()
    {
        return $this->cappedAmount;
    }

    public function setCappedAmount($cappedAmount)
    {
        $this->cappedAmount = $cappedAmount;
    }

    /**
     * @return float
     */
    public function getBalanceRemaining()
    {
        return $this->balanceRemaining;
    }

    public function seBalanceRemaining($balanceRemaining)
    {
        $this->balanceRemaining = $balanceRemaining;
    }

    /**
     * @return string
     */
    public function getConfirmationUrl()
    {
        return $this->confirmationUrl;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
    }

    public function setTerms($terms)
    {
        $this->terms = $terms;
    }

    /**
     * @return bool
     */
    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @return int
     */
    public function getTrialDays()
    {
        return $this->trialDays;
    }

    /**
     * @return string
     */
    public function setTrialDays($trialDays)
    {
        $this->trialDays = $trialDays;
    }

    /**
     * @return string
     */
    public function getTrialEndsOn()
    {
        return $this->trialEndsOn;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getApiClientId()
    {
        return $this->apiClientId;
    }

    /**
     * @return string
     */
    public function getDecoratedReturnUrl()
    {
        return $this->decoratedReturnUrl;
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Shop implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var string */
    protected $myshopifyDomain;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $email;

    /** @var string */
    protected $domain;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $province;

    /** @var string */
    protected $country;

    /** @var string */
    protected $address1;

    /** @var string */
    protected $zip;

    /** @var string */
    protected $city;

    /** @var string */
    protected $source;

    /** @var string */
    protected $phone;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $customerEmail;

    /** @var string */
    protected $latitude;

    /** @var string */
    protected $longitude;

    /** @var int */
    protected $primaryLocationId;

    /** @var string */
    protected $primaryLocale;

    /** @var string */
    protected $address2;

    /** @var string */
    protected $countryCode;

    /** @var string */
    protected $countryName;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $timezone;

    /** @var string */
    protected $ianaTimezone;

    /** @var string */
    protected $shopOwner;

    /** @var string */
    protected $moneyFormat;

    /** @var string */
    protected $moneyWithCurrencyFormat;

    /** @var string */
    protected $provinceCode;

    /** @var bool */
    protected $taxesIncluded;

    /** @var bool */
    protected $taxShipping;

    /** @var bool */
    protected $countryTaxes;

    /** @var string */
    protected $planDisplayName;

    /** @var string */
    protected $planName;

    /** @var string */
    protected $hasDiscounts;

    /** @var string */
    protected $hasGiftCards;

    /** @var string */
    protected $googleAppsDomain;

    /** @var string */
    protected $googleAppsLoginEnabled;

    /** @var string */
    protected $moneyInEmailsFormat;

    /** @var string */
    protected $moneyWithCurrencyInEmailsFormat;

    /** @var bool */
    protected $eligibleForPayments;

    /** @var bool */
    protected $requiresExtraPaymentsAgreement;

    /** @var bool */
    protected $passwordEnabled;

    /** @var bool */
    protected $hasStorefront;

    /** @var string */
    protected $eligibleForCardReaderGiveaway;

    /** @var string */
    protected $setupRequired;

    /**
     * @return string
     */
    public function getCountyTaxes()
    {
        return $this->countyTaxes;
    }

    /** @var string */
    protected $countyTaxes;

    /**
     * @return string
     */
    public function getMyshopifyDomain()
    {
        return $this->myshopifyDomain;
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
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
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
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getPrimaryLocationId()
    {
        return $this->primaryLocationId;
    }

    /**
     * @return string
     */
    public function getPrimaryLocale()
    {
        return $this->primaryLocale;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return bool
     */
    public function getTaxesIncluded()
    {
        return $this->taxesIncluded;
    }

    /**
     * @return bool
     */
    public function getTaxShipping()
    {
        return $this->taxShipping;
    }

    /**
     * @return bool
     */
    public function getCountryTaxes()
    {
        return $this->countryTaxes;
    }

    /**
     * @return bool
     */
    public function getEligibleForPayments()
    {
        return $this->eligibleForPayments;
    }

    /**
     * @return bool
     */
    public function getRequiresExtraPaymentsAgreement()
    {
        return $this->requiresExtraPaymentsAgreement;
    }

    /**
     * @return bool
     */
    public function getPasswordEnabled()
    {
        return $this->passwordEnabled;
    }

    /**
     * @return bool
     */
    public function getHasStorefront()
    {
        return $this->hasStorefront;
    }

    /**
     * @return string
     */
    public function getIanaTimezone()
    {
        return $this->ianaTimezone;
    }

    /**
     * @return string
     */
    public function getShopOwner()
    {
        return $this->shopOwner;
    }

    /**
     * @return string
     */
    public function getMoneyFormat()
    {
        return $this->moneyFormat;
    }

    /**
     * @return string
     */
    public function getMoneyWithCurrencyFormat()
    {
        return $this->moneyWithCurrencyFormat;
    }

    /**
     * @return string
     */
    public function getProvinceCode()
    {
        return $this->provinceCode;
    }

    /**
     * @return bool
     */
    public function isTaxesIncluded()
    {
        return $this->taxesIncluded;
    }

    /**
     * @return bool
     */
    public function isTaxShipping()
    {
        return $this->taxShipping;
    }

    /**
     * @return bool
     */
    public function isCountryTaxes()
    {
        return $this->countryTaxes;
    }

    /**
     * @return string
     */
    public function getPlanDisplayName()
    {
        return $this->planDisplayName;
    }

    /**
     * @return string
     */
    public function getPlanName()
    {
        return $this->planName;
    }

    /**
     * @return string
     */
    public function getHasDiscounts()
    {
        return $this->hasDiscounts;
    }

    /**
     * @return string
     */
    public function getHasGiftCards()
    {
        return $this->hasGiftCards;
    }

    /**
     * @return string
     */
    public function getGoogleAppsDomain()
    {
        return $this->googleAppsDomain;
    }

    /**
     * @return string
     */
    public function getGoogleAppsLoginEnabled()
    {
        return $this->googleAppsLoginEnabled;
    }

    /**
     * @return string
     */
    public function getMoneyInEmailsFormat()
    {
        return $this->moneyInEmailsFormat;
    }

    /**
     * @return string
     */
    public function getMoneyWithCurrencyInEmailsFormat()
    {
        return $this->moneyWithCurrencyInEmailsFormat;
    }

    /**
     * @return bool
     */
    public function isEligibleForPayments()
    {
        return $this->eligibleForPayments;
    }

    /**
     * @return bool
     */
    public function isRequiresExtraPaymentsAgreement()
    {
        return $this->requiresExtraPaymentsAgreement;
    }

    /**
     * @return bool
     */
    public function isPasswordEnabled()
    {
        return $this->passwordEnabled;
    }

    /**
     * @return bool
     */
    public function isHasStorefront()
    {
        return $this->hasStorefront;
    }

    /**
     * @return string
     */
    public function getEligibleForCardReaderGiveaway()
    {
        return $this->eligibleForCardReaderGiveaway;
    }

    /**
     * @return string
     */
    public function getSetupRequired()
    {
        return $this->setupRequired;
    }
}

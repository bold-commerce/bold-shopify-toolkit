<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use Illuminate\Support\Collection;

class Order implements Serializeable
{
    /** @var int */
    protected $id;

    /** @var bool */
    protected $buyerAcceptsMarketing;

    /** @var string */
    protected $cancelReason;

    /** @var string */
    protected $cancelledAt;

    /** @var string */
    protected $cartToken;

    /** @var string */
    protected $checkoutToken;

    /** @var string */
    protected $closedAt;

    /** @var bool */
    protected $confirmed;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $currency;

    /** @var int */
    protected $deviceId;

    /** @var string */
    protected $email;

    /** @var string */
    protected $financialStatus;

    /** @var string */
    protected $gateway;

    /** @var string */
    protected $landingSite;

    /** @var int */
    protected $locationId;

    /** @var string */
    protected $name;

    /*** @var string */
    protected $referringSite;

    /** @var string */
    protected $note;

    /** @var int */
    protected $number;

    /** @var string */
    protected $processedAt;

    /** @var string */
    protected $reference;

    /** @var string */
    protected $referencingSite;

    /** @var string */
    protected $sourceIdentifier;

    /** @var string */
    protected $sourceUrl;

    /** @var string */
    protected $subtotalPrice;

    /** @var bool */
    protected $taxesIncluded;

    /** @var bool */
    protected $test;

    /** @var string */
    protected $token;

    /** @var float */
    protected $totalDiscounts;

    /** @var float */
    protected $totalLineItemsPrice;

    /** @var float */
    protected $totalPrice;

    /** @var float */
    protected $totalPriceUsd;

    /** @var float */
    protected $totalTax;

    /** @var int */
    protected $totalWeight;

    /** @var string */
    protected $updatedAt;

    /** @var int */
    protected $userId;

    /** @var string */
    protected $browserIp;

    /** @var string */
    protected $landingSiteRef;

    /** @var int */
    protected $orderNumber;

    /** @var  array */
    protected $paymentGatewayNames;

    /** @var string */
    protected $processingMethod;

    /** @var string */
    protected $source;

    /** @var id */
    protected $checkoutId;

    /** @var string */
    protected $sourceName;

    /** @var string */
    protected $fulfillmentStatus;

    /** @var string */
    protected $tags;

    /** @var array */
    protected $discountCodes;

    /** @var array */
    protected $noteAttributes;

    /** @var array */
    protected $taxLines;

    /** @var Collection */
    protected $lineItems;

    /** @var array */
    protected $shippingLines;

    /** @var object */
    protected $billingAddress;

    /** @var object */
    protected $shippingAddress;

    /** @var array */
    protected $fulfillments;

    /** @var object */
    protected $clientDetails;

    /** @var array */
    protected $refunds;

    /** @var object */
    protected $paymentDetails;

    /** @var object */
    protected $customer;

    /** @var  string */
    protected $contactEmail;

    /** @var  string */
    protected $orderStatusUrl;

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
     * @return bool
     */
    public function getBuyerAcceptsMarketing()
    {
        return $this->buyerAcceptsMarketing;
    }

    /**
     * @return string
     */
    public function getCancelReason()
    {
        return $this->cancelReason;
    }

    /**
     * @return string
     */
    public function getCancelledAt()
    {
        return $this->cancelledAt;
    }

    /**
     * @return string
     */
    public function getCartToken()
    {
        return $this->cartToken;
    }

    /**
     * @return string
     */
    public function getCheckoutToken()
    {
        return $this->checkoutToken;
    }

    /**
     * @return string
     */
    public function getClosedAt()
    {
        return $this->closedAt;
    }

    /**
     * @return bool
     */
    public function getConfirmed()
    {
        return $this->confirmed;
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
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getDeviceId()
    {
        return $this->deviceId;
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
    public function getFinancialStatus()
    {
        return $this->financialStatus;
    }

    /**
     * @param string $financialStatus
     */
    public function setFinancialStatus($financialStatus)
    {
        $this->financialStatus = $financialStatus;
    }

    /**
     * @return string
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @return string
     */
    public function getlandingSite()
    {
        return $this->landingSite;
    }

    /**
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
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
    public function getProcessedAt()
    {
        return $this->processedAt;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getReferringSite()
    {
        return $this->referencingSite;
    }

    /**
     * @return string
     */
    public function getSourceIdentifier()
    {
        return $this->sourceIdentifier;
    }

    /**
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->sourceUrl;
    }

    /**
     * @return string
     */
    public function getSubtotalPrice()
    {
        return $this->subtotalPrice;
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
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return float
     */
    public function getTotalDiscounts()
    {
        return $this->totalDiscounts;
    }

    /**
     * @return float
     */
    public function getTotalLineItemsPrice()
    {
        return $this->totalLineItemsPrice;
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return float
     */
    public function getTotalPriceUsd()
    {
        return $this->totalPriceUsd;
    }

    /**
     * @return float
     */
    public function getTotalTax()
    {
        return $this->totalTax;
    }

    /**
     * @return int
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getBrowserIp()
    {
        return $this->browserIp;
    }

    /**
     * @return string
     */
    public function getLandingSiteRef()
    {
        return $this->landingSiteRef;
    }

    /**
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getProcessingMethod()
    {
        return $this->processingMethod;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return int
     9*/
    public function getCheckoutId()
    {
        return $this->checkoutId;
    }

    /**
     * @return string
     */
    public function getSourceName()
    {
        return $this->sourceName;
    }

    /**
     * @return string
     */
    public function getFulfillmentStatus()
    {
        return $this->fulfillmentStatus;
    }

    /**
     * @param $status
     */
    public function setFulfillmentStatus($status)
    {
        $this->fulfillmentStatus = $status;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @return array
     */
    public function getDiscountCodes()
    {
        return $this->discountCodes;
    }

    /**
     * @return array
     */
    public function getNoteAttributes()
    {
        return $this->noteAttributes;
    }

    /**
     * @return array
     */
    public function getTaxLines()
    {
        return $this->taxLines;
    }

    /**
     * @return Collection
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * @return array
     */
    public function getShippingLines()
    {
        return $this->shippingLines;
    }

    /**
     * @return object
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @return object
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @return array
     */
    public function getFulfillments()
    {
        return $this->fulfillments;
    }

    /**
     * @return object
     */
    public function getClientDetails()
    {
        return $this->clientDetails;
    }

    /**
     * @return array
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     * @return object
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * @return object
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getReferencingSite()
    {
        return $this->referencingSite;
    }

    /**
     * @return array
     */
    public function getPaymentGatewayNames()
    {
        return $this->paymentGatewayNames;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @return string
     */
    public function getOrderStatusUrl()
    {
        return $this->orderStatusUrl;
    }
}

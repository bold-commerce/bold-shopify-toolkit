<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;
use Illuminate\Support\Collection;

class Order implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

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
    protected $landingSite;

    /** @var int */
    protected $locationId;

    /** @var string */
    protected $name;

    /** @var string */
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

    /** @var array */
    protected $paymentGatewayNames;

    /** @var string */
    protected $processingMethod;

    /** @var string */
    protected $source;

    /** @var int */
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

    /** @var mixed */
    protected $tax;

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

    /** @var string */
    protected $contactEmail;

    /** @var string */
    protected $orderStatusUrl;

    /** @var string */
    protected $transactions;

    /** @var bool */
    protected $sendWebhooks;

    /** @var bool */
    protected $sendReceipt;

    /** @var string */
    protected $inventoryBehaviour;

    /** @var bool */
    protected $sendFulfillmentReceipt;

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
     */
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

    /**
     * @return string
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param bool $buyerAcceptsMarketing
     */
    public function setBuyerAcceptsMarketing($buyerAcceptsMarketing)
    {
        $this->buyerAcceptsMarketing = $buyerAcceptsMarketing;
    }

    /**
     * @param string $cancelReason
     */
    public function setCancelReason($cancelReason)
    {
        $this->cancelReason = $cancelReason;
    }

    /**
     * @param string $cancelledAt
     */
    public function setCancelledAt($cancelledAt)
    {
        $this->cancelledAt = $cancelledAt;
    }

    /**
     * @param string $cartToken
     */
    public function setCartToken($cartToken)
    {
        $this->cartToken = $cartToken;
    }

    /**
     * @param string $checkoutToken
     */
    public function setCheckoutToken($checkoutToken)
    {
        $this->checkoutToken = $checkoutToken;
    }

    /**
     * @param string $closedAt
     */
    public function setClosedAt($closedAt)
    {
        $this->closedAt = $closedAt;
    }

    /**
     * @param bool $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param int $deviceId
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $landingSite
     */
    public function setLandingSite($landingSite)
    {
        $this->landingSite = $landingSite;
    }

    /**
     * @param int $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $referringSite
     */
    public function setReferringSite($referringSite)
    {
        $this->referringSite = $referringSite;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param string $processedAt
     */
    public function setProcessedAt($processedAt)
    {
        $this->processedAt = $processedAt;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @param string $referencingSite
     */
    public function setReferencingSite($referencingSite)
    {
        $this->referencingSite = $referencingSite;
    }

    /**
     * @param string $sourceIdentifier
     */
    public function setSourceIdentifier($sourceIdentifier)
    {
        $this->sourceIdentifier = $sourceIdentifier;
    }

    /**
     * @param string $sourceUrl
     */
    public function setSourceUrl($sourceUrl)
    {
        $this->sourceUrl = $sourceUrl;
    }

    /**
     * @param string $subtotalPrice
     */
    public function setSubtotalPrice($subtotalPrice)
    {
        $this->subtotalPrice = $subtotalPrice;
    }

    /**
     * @param bool $taxesIncluded
     */
    public function setTaxesIncluded($taxesIncluded)
    {
        $this->taxesIncluded = $taxesIncluded;
    }

    /**
     * @param bool $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param float $totalDiscounts
     */
    public function setTotalDiscounts($totalDiscounts)
    {
        $this->totalDiscounts = $totalDiscounts;
    }

    /**
     * @param float $totalLineItemsPrice
     */
    public function setTotalLineItemsPrice($totalLineItemsPrice)
    {
        $this->totalLineItemsPrice = $totalLineItemsPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param float $totalPriceUsd
     */
    public function setTotalPriceUsd($totalPriceUsd)
    {
        $this->totalPriceUsd = $totalPriceUsd;
    }

    /**
     * @param float $totalTax
     */
    public function setTotalTax($totalTax)
    {
        $this->totalTax = $totalTax;
    }

    /**
     * @param int $totalWeight
     */
    public function setTotalWeight($totalWeight)
    {
        $this->totalWeight = $totalWeight;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $browserIp
     */
    public function setBrowserIp($browserIp)
    {
        $this->browserIp = $browserIp;
    }

    /**
     * @param string $landingSiteRef
     */
    public function setLandingSiteRef($landingSiteRef)
    {
        $this->landingSiteRef = $landingSiteRef;
    }

    /**
     * @param int $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @param array $paymentGatewayNames
     */
    public function setPaymentGatewayNames($paymentGatewayNames)
    {
        $this->paymentGatewayNames = $paymentGatewayNames;
    }

    /**
     * @param string $processingMethod
     */
    public function setProcessingMethod($processingMethod)
    {
        $this->processingMethod = $processingMethod;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @param int $checkoutId
     */
    public function setCheckoutId($checkoutId)
    {
        $this->checkoutId = $checkoutId;
    }

    /**
     * @param string $sourceName
     */
    public function setSourceName($sourceName)
    {
        $this->sourceName = $sourceName;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param array $discountCodes
     */
    public function setDiscountCodes($discountCodes)
    {
        $this->discountCodes = $discountCodes;
    }

    /**
     * @param object $noteAttributes
     */
    public function setNoteAttributes($noteAttributes)
    {
        $this->noteAttributes = $noteAttributes;
    }

    /**
     * @param array $taxLines
     */
    public function setTaxLines($taxLines)
    {
        $this->taxLines = $taxLines;
    }

    /**
     * @param Collection $lineItems
     */
    public function setLineItems($lineItems)
    {
        $this->lineItems = $lineItems;
    }

    /**
     * @param array $shippingLines
     */
    public function setShippingLines($shippingLines)
    {
        $this->shippingLines = $shippingLines;
    }

    /**
     * @param object $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @param object $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @param array $fulfillments
     */
    public function setFulfillments($fulfillments)
    {
        $this->fulfillments = $fulfillments;
    }

    public function setFulfillmentStatus($status)
    {
        $this->fulfillmentStatus = $status;
    }

    /**
     * @param string $financialStatus
     */
    public function setFinancialStatus($financialStatus)
    {
        $this->financialStatus = $financialStatus;
    }

    /**
     * @param object $clientDetails
     */
    public function setClientDetails($clientDetails)
    {
        $this->clientDetails = $clientDetails;
    }

    /**
     * @param array $refunds
     */
    public function setRefunds($refunds)
    {
        $this->refunds = $refunds;
    }

    /**
     * @param object $paymentDetails
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * @param object $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param string $contactEmail
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
    }

    /**
     * @param string $orderStatusUrl
     */
    public function setOrderStatusUrl($orderStatusUrl)
    {
        $this->orderStatusUrl = $orderStatusUrl;
    }

    /**
     * @param array $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return bool
     */
    public function getSendWebhooks()
    {
        return $this->sendWebhooks;
    }

    /**
     * @param bool $sendWebhooks
     */
    public function setSendWebhooks($sendWebhooks)
    {
        $this->sendWebhooks = $sendWebhooks;
    }

    /**
     * @return bool
     */
    public function getSendReceipt()
    {
        return $this->sendReceipt;
    }

    /**
     * @param bool $sendReceipt
     */
    public function setSendReceipt($sendReceipt)
    {
        $this->sendReceipt = $sendReceipt;
    }

    /**
     * @return string
     */
    public function getInventoryBehaviour()
    {
        return $this->inventoryBehaviour;
    }

    /**
     * @param string $inventoryBehaviour
     */
    public function setInventoryBehaviour($inventoryBehaviour)
    {
        $this->inventoryBehaviour = $inventoryBehaviour;
    }

    /**
     * @return bool
     */
    public function getSendFulfillmentReceipt()
    {
        return $this->sendFulfillmentReceipt;
    }

    /**
     * @param bool $sendFulfillmentReceipt
     */
    public function setSendFulfillmentReceipt($sendFulfillmentReceipt)
    {
        $this->sendFulfillmentReceipt = $sendFulfillmentReceipt;
    }
}

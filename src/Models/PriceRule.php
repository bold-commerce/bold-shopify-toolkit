<?php
namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

class PriceRule implements Serializeable
{

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $priceRuleId;
    /**
     * @var string
     */
    protected $usageCount;
    /**
     * @var string
     */
    protected $createdAt;
    /**
     * @var string
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $targetType;

    /**
     * @var string
     */
    protected $customerSelection;


    /**
     * @var string
     */
    protected $targetSelection;

    /**
     * @var string
     */
    protected $allocationMethod;


    /**
     * @var string
     */
    protected $valueType;


    /**
     * @var string
     */
    protected $value;


    /**
     * @var string
     */
    protected $oncePerCustomer;


    /**
     * @var string
     */
    protected $usageLimit;
    /**
     * @var string
     */
    protected $prerequisiteSavedSearchIds;


    /**
     * @var string
     */
    protected $prerequisiteSubtotalRange;


    /**
     * @var string
     */
    protected $prerequisiteShippingPriceRange;


    /**
     * @var array[]
     */
    protected $entitledProductIds;


    /**
     * @var array[]
     */
    protected $entitledVariantIds;

    /**
     * @var array[]
     */
    protected $entitledCollectionIds;

    /**
     * @var array[]
     */
    protected $entitledCountryIds;

    /**
     * @var array[]
     */
    protected $startsAt;

    /**
     * @var array[]
     */
    protected $endsAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return int
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $code
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPriceRuleId()
    {
        return $this->priceRuleId;
    }

    /**
     * @param $priceRuleId
     */
    public function setPriceRuleId($priceRuleId)
    {
        $this->priceRuleId = $priceRuleId;
    }

    /**
     * @return int
     */
    public function getUsageCount()
    {
        return $this->usageCount;
    }

    /**
     * @param $usageCount
     */
    public function setUsageCount($usageCount)
    {
        $this->priceRuleId = $usageCount;
    }

    /**
     * @return string
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * @param $targetType
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;
    }


    /**
     * @return string
     */
    public function getTargetSelection()
    {
        return $this->targetSelection;
    }

    /**
     * @param $targetSelection
     */
    public function setTargetSelection($targetSelection)
    {
        $this->targetSelection = $targetSelection;
    }


    /**
     * @return string
     */
    public function getAllocationMethod()
    {
        return $this->allocationMethod;
    }

    /**
     * @param $allocationMethod
     */
    public function setAllocationMethod($allocationMethod)
    {
        $this->allocationMethod = $allocationMethod;
    }

    /**
     * @return string
     */
    public function getValueType()
    {
        return $this->valueType;
    }

    /**
     * @param $valueType
     */
    public function setValueType($valueType)
    {
        $this->valueType = $valueType;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getOncePerCustomer()
    {
        return $this->oncePerCustomer;
    }

    /**
     * @param $oncePerCustomer
     */
    public function SetOncePerCustomer($oncePerCustomer)
    {
        $this->oncePerCustomer = $oncePerCustomer;
    }

    /**
     * @return string
     */
    public function getUsageLimit()
    {
        return $this->usageLimit;
    }

    /**
     * @param $usageLimit
     */
    public function SetUsageLimit($usageLimit)
    {
        $this->usageLimit = $usageLimit;
    }

    /**
     * @return string
     */
    public function getCustomerSelection()
    {
        return $this->customerSelection;
    }

    /**
     * @param $customerSelection
     */
    public function setCustomerSelection($customerSelection)
    {
        $this->customerSelection = $customerSelection;
    }

    /**
     * @return string
     */
    public function getPrerequisiteSavedSearchIds()
    {
        return $this->prerequisiteSavedSearchIds;
    }

    /**
     * @param $prerequisiteSavedSearchIds
     */
    public function setPrerequisiteSavedSearchIds($prerequisiteSavedSearchIds)
    {
        $this->prerequisiteSavedSearchIds = $prerequisiteSavedSearchIds;
    }

    /**
     * @return string
     */
    public function getPrerequisiteSubtotalRange()
    {
        return $this->prerequisiteSubtotalRange;
    }

    /**
     * @param $prerequisiteSubtotalRange
     */
    public function setPrerequisiteSubtotalRange($prerequisiteSubtotalRange)
    {
        $this->prerequisiteSubtotalRange = $prerequisiteSubtotalRange;
    }

    /**
     * @return string
     */
    public function getPrerequisiteShippingPriceRange()
    {
        return $this->prerequisiteShippingPriceRange;
    }

    /**
     * @param $prerequisiteShippingPriceRange
     */
    public function setPrerequisiteShippingPriceRange($prerequisiteShippingPriceRange)
    {
        $this->prerequisiteShippingPriceRange = $prerequisiteShippingPriceRange;
    }

    /**
     * @return string
     */
    public function getEntitledProductIds()
    {
        return $this->entitledProductIds;
    }

    /**
     * @param $entitledProductIds
     */
    public function setEntitledProductIds($entitledProductIds)
    {
        $this->entitledProductIds = $entitledProductIds;
    }

    /**
     * @return string
     */
    public function getEntitledVariantIds()
    {
        return $this->entitledVariantIds;
    }

    /**
     * @param $entitledVariantIds
     */
    public function setEntitledVariantIds($entitledVariantIds)
    {
        $this->entitledVariantIds = $entitledVariantIds;
    }

    /**
     * @return string
     */
    public function getEntitledCollectionIds()
    {
        return $this->entitledCollectionIds;
    }

    /**
     * @param $entitledCollectionIds
     */
    public function setEntitledCollectionIds($entitledCollectionIds)
    {
        $this->entitledCollectionIds = $entitledCollectionIds;
    }

    /**
     * @return string
     */
    public function getEntitledCountryIds()
    {
        return $this->entitledCountryIds;
    }

    /**
     * @param $entitledCountryIds
     */
    public function setEntitledCountryIds($entitledCountryIds)
    {
        $this->entitledCountryIds = $entitledCountryIds;
    }

    /**
     * @return string
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param $startsAt
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return string
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * @param $endsAt
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;
    }
}

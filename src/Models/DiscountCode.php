<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class DiscountCode implements Serializeable
{

    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var int */
    protected $priceRuleId;

    /** @var string */
    protected $code;

    /** @var int */
    protected $usageCount;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

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
     * @return int
     */
    public function getPriceRuleId()
    {
        return $this->priceRuleId;
    }

    /**
     * @param int $priceRuleId
     */
    public function setPriceRuleId($priceRuleId)
    {
        $this->priceRuleId = $priceRuleId;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getUsageCount()
    {
        return $this->usageCount;
    }

    /**
     * @param int $usageCount
     */
    public function setUsageCount($usageCount)
    {
        $this->usageCount = $usageCount;
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
}

<?php

namespace BoldApps\ShopifyToolkit\Models\Cart;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Cart implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var string */
    protected $note;

    /** @var string */
    protected $token;

    /** @var array */
    protected $attributes;

    /** @var int */
    protected $originalTotalPrice;

    /** @var int */
    protected $totalPrice;

    /** @var int */
    protected $totalDiscount;

    /** @var int */
    protected $totalWeight;

    /** @var int */
    protected $itemCount;

    /** @var bool */
    protected $requiresShipping;

    /** @var array */
    protected $items;

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getOriginalTotalPrice()
    {
        return $this->originalTotalPrice;
    }

    public function setOriginalTotalPrice($value)
    {
        $this->originalTotalPrice = $value;
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    public function setTotalPrice($value)
    {
        $this->totalPrice = $value;
    }

    /**
     * @return int
     */
    public function getTotalDiscount()
    {
        return $this->totalDiscount;
    }

    public function setTotalDiscount($value)
    {
        $this->totalDiscount = $value;
    }

    /**
     * @return int
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
    }

    public function setTotalWeight($value)
    {
        $this->totalWeight = $value;
    }

    /**
     * @return int
     */
    public function getItemCount()
    {
        return $this->itemCount;
    }

    public function setItemCount($value)
    {
        $this->itemCount = $value;
    }

    /**
     * @return bool
     */
    public function getRequiresShipping()
    {
        return $this->requiresShipping;
    }

    public function setRequiresShipping($value)
    {
        $this->requiresShipping = $value;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    public function setItems($values)
    {
        $this->items = $values;
    }
}

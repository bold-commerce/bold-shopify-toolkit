<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;


class InventoryLevel implements Serializeable
{
    use HasAttributesTrait;

    /** @var int */
    protected $available;

    /** @var int */
    protected $inventoryItemId;

    /** @var int */
    protected $locationId;

    /** @var string */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param int $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return int
     */
    public function getInventoryItemId()
    {
        return $this->inventoryItemId;
    }

    /**
     * @param int $inventoryItemId
     */
    public function setInventoryItemId($inventoryItemId)
    {
        $this->inventoryItemId = $inventoryItemId;
    }

    /**
     * @return int
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param int $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}
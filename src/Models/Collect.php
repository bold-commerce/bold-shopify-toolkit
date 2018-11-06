<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Collect implements Serializeable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var int */
    protected $collectionId;

    /** @var int */
    protected $productId;

    /** @var bool */
    protected $featured;

    /** @var int */
    protected $position;

    /** @var string */
    protected $sortValue;

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
    public function getCollectionId()
    {
        return $this->collectionId;
    }

    /**
     * @param int $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return bool
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * @param bool $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getSortValue()
    {
        return $this->sortValue;
    }

    /**
     * @param string $sortValue
     */
    public function setSortValue($sortValue)
    {
        $this->sortValue = $sortValue;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
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

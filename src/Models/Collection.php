<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Collection implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $handle;

    /** @var string */
    protected $title;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $bodyHtml;

    /** @var string */
    protected $publishedAt;

    /** @var string */
    protected $sortOrder;

    /** @var string|null */
    protected $templateSuffix;

    /** @var int|null */
    protected $productsCount;

    /** @var string|null */
    protected $collectionType;

    /** @var string|null */
    protected $publishedScope;

    /** @var array */
    protected $image;

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
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getBodyHtml()
    {
        return $this->bodyHtml;
    }

    /**
     * @param $bodyHtml
     */
    public function setBodyHtml($bodyHtml)
    {
        $this->bodyHtml = $bodyHtml;
    }

    /**
     * @return string
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return null|string
     */
    public function getTemplateSuffix()
    {
        return $this->templateSuffix;
    }

    /**
     * @param $templateSuffix
     */
    public function setTemplateSuffix($templateSuffix)
    {
        $this->templateSuffix = $templateSuffix;
    }

    /**
     * @return int|null
     */
    public function getProductsCount()
    {
        return $this->productsCount;
    }

    /**
     * @param $productsCount
     */
    public function setProductsCount($productsCount)
    {
        $this->productsCount = $productsCount;
    }

    /**
     * @return string|null
     */
    public function getCollectionType()
    {
        return $this->collectionType;
    }

    /**
     * @param $collectionType
     */
    public function setCollectionType($collectionType)
    {
        $this->collectionType = $collectionType;
    }

    /**
     * @return null|string
     */
    public function getPublishedScope()
    {
        return $this->publishedScope;
    }

    /**
     * @param $scope
     */
    public function setPublishedScope($scope)
    {
        $this->publishedScope = $scope;
    }

    /**
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}

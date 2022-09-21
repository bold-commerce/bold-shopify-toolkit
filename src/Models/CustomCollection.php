<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class CustomCollection implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $handle;

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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
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
    public function getBodyHtml()
    {
        return $this->bodyHtml;
    }

    /**
     * @return string
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @return string|null
     */
    public function getTemplateSuffix()
    {
        return $this->templateSuffix;
    }

    /**
     * @return string|null
     */
    public function getPublishedScope()
    {
        return $this->publishedScope;
    }

    /**
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }
}

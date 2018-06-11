<?php


namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;
use Illuminate\Support\Collection;

class SmartCollection implements Serializeable
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

    /** @var bool */
    protected $disjunctive;

    /** @var Collection */
    protected $rules;

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
     * @return null|string
     */
    public function getTemplateSuffix()
    {
        return $this->templateSuffix;
    }

    /**
     * @return null|string
     */
    public function getPublishedScope()
    {
        return $this->publishedScope;
    }

    /**
     * @return bool
     */
    public function getDisjunctive()
    {
        return $this->disjunctive;
    }

    /**
     * @return Collection
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string $bodyHtml
     */
    public function setBodyHtml($bodyHtml)
    {
        $this->bodyHtml = $bodyHtml;
    }

    /**
     * @param string $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @param string $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @param string $templateSuffix
     */
    public function setTemplateSuffix($templateSuffix)
    {
        $this->templateSuffix = $templateSuffix;
    }

    /**
     * @param string $publishedScope
     */
    public function setPublishedScope($publishedScope)
    {
        $this->publishedScope = $publishedScope;
    }

    /**
     * @param bool $disjunctive
     */
    public function setDisjunctive($disjunctive)
    {
        $this->disjunctive = $disjunctive;
    }

    /**
     * @param Collection $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use Illuminate\Support\Collection;

class Product implements Serializeable
{
    /** @var  int */
    protected $id;

    /** @var  string */
    protected $bodyHtml;

    /** @var  string */
    protected $handle;

    /** @var  string */
    protected $productType;

    /** @var  string */
    protected $publishedScope;

    /** @var  string */
    protected $templateSuffix;

    /** @var  string */
    protected $title;

    /** @var  string */
    protected $vendor;

    /** @var  string */
    protected $tags;

    /** @var  Collection */
    protected $options;

    /** @var  Collection */
    protected $variants;

    /** @var  Collection */
    protected $images;

    /** @var  string */
    protected $createdAt;

    /** @var  string */
    protected $updatedAt;

    /** @var  string */
    protected $publishedAt;

    /** @var  Image */
    protected $image;

    /** @var Collection */
    protected $metafields;

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
     * @return string
     */
    public function getBodyHtml()
    {
        return $this->bodyHtml;
    }

    /**
     * @param string $bodyHtml
     */
    public function setBodyHtml($bodyHtml)
    {
        $this->bodyHtml = $bodyHtml;
    }

    /**
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * @param string $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return string
     */
    public function getPublishedScope()
    {
        return $this->publishedScope;
    }

    /**
     * @param string $publishedScope
     */
    public function setPublishedScope($publishedScope)
    {
        $this->publishedScope = $publishedScope;
    }

    /**
     * @return string
     */
    public function getTemplateSuffix()
    {
        return $this->templateSuffix;
    }

    /**
     * @param string $templateSuffix
     */
    public function setTemplateSuffix($templateSuffix)
    {
        $this->templateSuffix = $templateSuffix;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param string $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param Collection $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param Collection $variants
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     */
    public function setImages($images)
    {
        $this->images = $images;
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

    /**
     * @return string
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param string $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Collection
     */
    public function getMetafields()
    {
        return $this->metafields;
    }

    /**
     * @param Collection
     */
    public function setMetafields($metafields)
    {
        $this->metafields = $metafields;
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Theme implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $role;

    /** @var int */
    protected $themeStoreId;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /** @var bool */
    protected $previewable;

    /** @var bool */
    protected $processing;

    /** @var string */
    protected $src;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getThemeStoreId()
    {
        return $this->themeStoreId;
    }

    /**
     * @param int $themeStoreId
     */
    public function setThemeStoreId($themeStoreId)
    {
        $this->themeStoreId = $themeStoreId;
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
     * @return bool
     */
    public function isPreviewable()
    {
        return $this->previewable;
    }

    /**
     * @param bool $previewable
     */
    public function setPreviewable($previewable)
    {
        $this->previewable = $previewable;
    }

    /**
     * @return bool
     */
    public function getPreviewable()
    {
        return $this->previewable;
    }

    /**
     * @return bool
     */
    public function isProcessing()
    {
        return $this->processing;
    }

    /**
     * @param bool $processing
     */
    public function setProcessing($processing)
    {
        $this->processing = $processing;
    }

    /**
     * @return bool
     */
    public function getProcessing()
    {
        return $this->processing;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }
}

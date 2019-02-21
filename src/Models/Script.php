<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class Script implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $id;

    /** @var string */
    protected $src;

    /** @var string */
    protected $event;

    /** @var string */
    protected $createdAt;

    /** @var string */
    protected $updatedAt;

    /** @var string */
    protected $displayScope;

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
    public function getSrc()
    {
        return $this->src;
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
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getDisplayScope()
    {
        return $this->displayScope;
    }

    /**
     * @param string $displayScope
     */
    public function setDisplayScope($displayScope)
    {
        $this->displayScope = $displayScope;
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

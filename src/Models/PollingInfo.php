<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class PollingInfo implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var string */
    protected $location;

    /** @var string */
    protected $retryAfter;

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getRetryAfter()
    {
        return $this->retryAfter;
    }

    /**
     * @param string $retryAfter
     */
    public function setRetryAfter($retryAfter)
    {
        $this->retryAfter = $retryAfter;
    }
}

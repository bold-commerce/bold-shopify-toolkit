<?php

namespace BoldApps\ShopifyToolkit\Models;

class PageInfo
{
    /** @var int */
    protected $next = '';

    /** @var string */
    protected $prev = '';

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * @param string $next
     */
    public function setNext($next)
    {
        $this->next = $next;
    }

    /**
     * @return int
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * @param string $prev
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;
    }
}

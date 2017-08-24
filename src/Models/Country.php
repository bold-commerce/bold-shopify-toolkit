<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

class Country implements Serializeable
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $provinces;

    /**
     * @var float
     */
    protected $tax;


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
    public function getCode()
    {
        return $this->code;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return array
     */
    public function getProvinces()
    {
        return $this->provinces;
    }


    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

}
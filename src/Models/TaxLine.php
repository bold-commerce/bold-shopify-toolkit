<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

/**
 * Class TaxLine.
 */
class TaxLine implements Serializeable
{

    use HasAttributesTrait;

    /** @var  string */
    protected $title;

    /** @var  string */
    protected $price;

    /** @var  float */
    protected $rate;

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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

}

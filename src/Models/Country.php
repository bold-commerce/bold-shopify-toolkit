<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;

class Country implements Serializeable
{

    /**
     * @var string
     */
    protected $code;

    /**
     * @var int
     */
    protected $id;

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

}
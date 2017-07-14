<?php

namespace BoldApps\ShopifyToolkit\Models;


class OrderAdjustment
{
    /** @var  int */
    public $id;
    /** @var  int */
    public $orderId;
    /** @var  int */
    public $refundId;
    /** @var  float */
    public $amount;
    /** @var  float */
    public $taxAmount;
    /** @var  string */
    public $kind;
    /** @var  string */
    public $reason;
}
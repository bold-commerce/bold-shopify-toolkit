<?php


namespace BoldApps\ShopifyToolkit\Models;


/**
 * Class SmartCollectionRule
 * @package BoldApps\ShopifyToolkit\Models
 */
class SmartCollectionRule
{
    /** @var  string */
    protected $column;

    /** @var  string */
    protected $relation;

    /** @var  string */
    protected $condition;

    /**
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }



}
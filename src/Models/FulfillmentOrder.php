<?php

namespace BoldApps\ShopifyToolkit\Models;

use BoldApps\ShopifyToolkit\Contracts\Serializeable;
use BoldApps\ShopifyToolkit\Traits\HasAttributesTrait;

class FulfillmentOrder implements Serializeable, \JsonSerializable
{
    use HasAttributesTrait;

    /** @var int */
    protected $assigned_location_id;

    /** @var array */
    protected $destination;

    /** @var array */
    protected $delivery_method;

    /** @var string */
    protected $fulfill_at;

    /** @var string */
    protected $fulfill_by;

    /** @var array */
    protected $fulfillment_holds;

    /** @var int */
    protected $id;

    /** @var array */
    protected $international_duties;

    /** @var array */
    protected $line_items;

    /** @var int */
    protected $orderId;

    /** @var string */
    protected $request_status;

    /** @var int */
    protected $shop_id;

    /** @var string */
    protected $status;

    /** @var array */
    protected $supported_actions;

    /** @var array */
    protected $merchant_requests;

    /** @var array */
    protected $assigned_location;

    /** @var string */
    protected $created_at;

    /** @var array */
    protected $updated_at;

    public function getAssignedLocationId(): int
    {
        return $this->assigned_location_id;
    }

    public function setAssignedLocationId(int $assigned_location_id)
    {
        $this->assigned_location_id = $assigned_location_id;
    }

    public function getDestination(): array
    {
        return $this->destination;
    }

    public function setDestination(array $destination)
    {
        $this->destination = $destination;
    }

    public function getDeliveryMethod(): array
    {
        return $this->delivery_method;
    }

    public function setDeliveryMethod(array $delivery_method)
    {
        $this->delivery_method = $delivery_method;
    }

    public function getFulfillAt(): string
    {
        return $this->fulfill_at;
    }

    public function setFulfillAt(string $fulfill_at)
    {
        $this->fulfill_at = $fulfill_at;
    }

    public function getFulfillBy(): string
    {
        return $this->fulfill_by;
    }

    public function setFulfillBy(string $fulfill_by)
    {
        $this->fulfill_by = $fulfill_by;
    }

    public function getFulfillmentHolds(): array
    {
        return $this->fulfillment_holds;
    }

    public function setFulfillmentHolds(array $fulfillment_holds)
    {
        $this->fulfillment_holds = $fulfillment_holds;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getRequestStatus(): string
    {
        return $this->request_status;
    }

    public function setRequestStatus(string $request_status)
    {
        $this->request_status = $request_status;
    }

    public function getShopId(): int
    {
        return $this->shop_id;
    }

    public function setShopId(int $shop_id)
    {
        $this->shop_id = $shop_id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): array
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(array $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getInternationalDuties(): array
    {
        return $this->international_duties;
    }

    public function setInternationalDuties(array $international_duties)
    {
        $this->international_duties = $international_duties;
    }

    public function getLineItems(): array
    {
        return $this->line_items;
    }

    public function setLineItems(array $line_items)
    {
        $this->line_items = $line_items;
    }

    public function getOriginAddress(): array
    {
        return $this->originAddress ?? [];
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getSupportedActions(): array
    {
        return $this->supported_actions;
    }

    public function getMerchantRequests(): array
    {
        return $this->merchant_requests;
    }

    public function getAssignedLocation(): array
    {
        return $this->assigned_location;
    }
}

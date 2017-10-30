<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\CustomerAddress as ShopifyCustomerAddress;
use Illuminate\Support\Collection;

/**
 * Class CustomerAddress.
 */
class CustomerAddress extends Base
{
    /**
     * @param int   $customerId
     * @param int   $id
     *
     * @return ShopifyCustomerAddress|object
     */
    public function getById(int $customerId, int $id)
    {
        $raw = $this->client->get("admin/customers/$customerId/addresses/$id.json");

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }

    /**
     * @param int   $customerId
     * @param int   $page
     * @param int   $limit
     * @param array $filter
     *
     * @return Collection
     */
    public function getAll($customerId, $page = 1, $limit = 50, $filter = [])
    {
        $raw = $this->client->get("admin/customers/$customerId/addresses.json", array_merge(['page' => $page, 'limit' => $limit], $filter));

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomerAddress::class);
        }, $raw['addresses']);

        return new Collection($customers);
    }

    /**
     * @param int $customerId
     * @param ShopifyCustomerAddress $address
     *
     * @return ShopifyCustomerAddress | object
     */
    public function create(int $customerId, ShopifyCustomerAddress $address)
    {
        $serializedModel = ['address' => array_merge($this->serializeModel($address))];

        $raw = $this->client->post("admin/customers/$customerId/addresses.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }
}

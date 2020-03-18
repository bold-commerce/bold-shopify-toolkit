<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Customer as ShopifyCustomer;
use BoldApps\ShopifyToolkit\Models\CustomerAddress as ShopifyCustomerAddress;
use Illuminate\Support\Collection;

class CustomerAddress extends Base
{
    /**
     * @param ShopifyCustomer $customer
     * @param int             $id
     *
     * @return ShopifyCustomerAddress|object
     */
    public function getById($customer, $id)
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/$customerId/addresses/$id.json");

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }

    /**
     * @deprecated Use getByParams()
     * @see getByParams()
     *
     * @param ShopifyCustomer $customer
     * @param int             $page
     * @param int             $limit
     * @param array           $filter
     *
     * @return Collection
     */
    public function getAll($customer, $page = 1, $limit = 50, $filter = [])
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("admin/customers/$customerId/addresses.json", array_merge(['page' => $page, 'limit' => $limit], $filter));

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomerAddress::class);
        }, $raw['addresses']);

        return new Collection($customers);
    }

    /**
     * @param ShopifyCustomer $customer
     * @param array           $params
     *
     * @return Collection
     */
    public function getByParams($customer, $params = [])
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/$customerId/addresses.json", $params);

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomerAddress::class);
        }, $raw['addresses']);

        return new Collection($customers);
    }

    /**
     * @param ShopifyCustomer        $customer
     * @param ShopifyCustomerAddress $address
     *
     * @return ShopifyCustomerAddress | object
     */
    public function create($customer, ShopifyCustomerAddress $address)
    {
        $customerId = $customer->getId();
        $serializedModel = ['address' => array_merge($this->serializeModel($address))];

        $raw = $this->client->post("{$this->getApiBasePath()}/customers/$customerId/addresses.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Customer as ShopifyCustomer;
use BoldApps\ShopifyToolkit\Models\CustomerAddress as ShopifyCustomerAddress;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class CustomerAddress extends Base
{
    /**
     * @return ShopifyCustomerAddress|object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById(ShopifyCustomer $customer, int $id)
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/$customerId/addresses/$id.json");

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @see getByParams()
     * @deprecated Use getByParams()
     */
    public function getAll(ShopifyCustomer $customer, int $page = 1, int $limit = 50, array $filter = [])
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("admin/customers/$customerId/addresses.json", array_merge(['page' => $page, 'limit' => $limit], $filter));

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomerAddress::class);
        }, $raw['addresses']);

        return new Collection($customers);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams(ShopifyCustomer $customer, array $params = [])
    {
        $customerId = $customer->getId();
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/$customerId/addresses.json", $params);

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomerAddress::class);
        }, $raw['addresses']);

        return new Collection($customers);
    }

    /**
     * @return ShopifyCustomerAddress | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function create(ShopifyCustomer $customer, ShopifyCustomerAddress $address)
    {
        $customerId = $customer->getId();
        $serializedModel = ['address' => array_merge($this->serializeModel($address))];

        $raw = $this->client->post("{$this->getApiBasePath()}/customers/$customerId/addresses.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_address'], ShopifyCustomerAddress::class);
    }
}

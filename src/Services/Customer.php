<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Customer as ShopifyCustomer;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Customer extends CollectionEntity
{
    /**
     * @param $id
     *
     * @return ShopifyCustomer|object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/$id.json");

        return $this->unserializeModel($raw['customer'], ShopifyCustomer::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll(int $page = 1, int $limit = 50, array $filter = [])
    {
        $raw = $this->client->get('admin/customers.json', array_merge(['page' => $page, 'limit' => $limit], $filter));

        $customers = array_map(function ($product) {
            return $this->unserializeModel($product, ShopifyCustomer::class);
        }, $raw['customers']);

        return new Collection($customers);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customers.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, ShopifyCustomer::class);
        }, $raw['customers']);

        return new Collection($customers);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function searchByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/search.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, ShopifyCustomer::class);
        }, $raw['customers']);

        return new Collection($customers);
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return int
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function countByParams(array $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customers/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param $array
     *
     * @return ShopifyCustomer | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyCustomer::class);
    }

    /**
     * @return ShopifyCustomer | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function create(ShopifyCustomer $customer)
    {
        $serializedModel = ['customer' => array_merge($this->serializeModel($customer))];

        $raw = $this->client->post("{$this->getApiBasePath()}/customers.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer'], ShopifyCustomer::class);
    }

    /**
     * @return ShopifyCustomer | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyCustomer $customer)
    {
        $serializedModel = ['customer' => $this->serializeModel($customer)];

        $raw = $this->client->put("{$this->getApiBasePath()}/customers/{$customer->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer'], ShopifyCustomer::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyCustomer $customer)
    {
        return $this->client->delete("{$this->getApiBasePath()}/customers/{$customer->getId()}.json");
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function sendAccountCreationInvite(int $shopifyCustomerId, array $params = [], array $body = [])
    {
        return $this->client->post("{$this->getApiBasePath()}/customers/{$shopifyCustomerId}/send_invite.json", $params, $body);
    }
}

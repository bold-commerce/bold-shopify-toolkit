<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Customer as CustomerModel;
use BoldApps\ShopifyToolkit\Models\CustomerSavedSearch as CustomerSavedSearchModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class CustomerSavedSearch extends CollectionEntity
{
    /**
     * CustomerSavedSearch constructor.
     *
     * @param Client $client
     */
    public function __construct(ShopifyClient $client)
    {
        parent::__construct($client);
    }

    /**
     * @param $array
     *
     * @return CustomerSavedSearchModel | object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, CustomerSavedSearchModel::class);
    }

    /**
     * @return CustomerSavedSearchModel | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->post("{$this->getApiBasePath()}/customer_saved_searches.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @return CustomerSavedSearchModel | object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function edit(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->put("{$this->getApiBasePath()}/customer_saved_searches/{$customerSavedSearch->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(CustomerSavedSearchModel $customerSavedSearch): array
    {
        return $this->client->delete("{$this->getApiBasePath()}/customer_saved_searches/{$customerSavedSearch->getId()}.json");
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams(array $params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customer_saved_searches.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, CustomerSavedSearchModel::class);
        }, $raw['customer_saved_searches']);

        return new Collection($customers);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getAllCustomersById(int $customerSavedSearchId, array $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customer_saved_searches/$customerSavedSearchId/customers.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, CustomerModel::class);
        }, $raw['customers']);

        return new Collection($customers);
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Customer as CustomerModel;
use BoldApps\ShopifyToolkit\Models\CustomerSavedSearch as CustomerSavedSearchModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
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
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return CustomerSavedSearchModel | object
     */
    public function create(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->post("{$this->getApiBasePath()}/customer_saved_searches.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @param int $customerSavedSearchId
     *
     * @return CustomerSavedSearchModel | object
     */
    public function get($customerSavedSearchId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customer_saved_searches/$customerSavedSearchId.json");

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return CustomerSavedSearchModel | object
     */
    public function edit(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->put("{$this->getApiBasePath()}/customer_saved_searches/{$customerSavedSearch->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return array
     */
    public function delete(CustomerSavedSearchModel $customerSavedSearch)
    {
        return $this->client->delete("{$this->getApiBasePath()}/customer_saved_searches/{$customerSavedSearch->getId()}.json");
    }

    /**
     * @param $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customer_saved_searches.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, CustomerSavedSearchModel::class);
        }, $raw['customer_saved_searches']);

        return new Collection($customers);
    }

    /**
     * @param int   $customerSavedSearchId
     * @param array $params
     *
     * @return Collection
     */
    public function getAllCustomersById($customerSavedSearchId, $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/customer_saved_searches/$customerSavedSearchId/customers.json", $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, CustomerModel::class);
        }, $raw['customers']);

        return new Collection($customers);
    }
}

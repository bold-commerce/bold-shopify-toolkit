<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\CustomerSavedSearch as CustomerSavedSearchModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use Illuminate\Support\Collection;

/**
 * Class CustomerSavedSearch
 * @package BoldApps\ShopifyToolkit\Services
 */
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
     * @return CustomerSavedSearchModel
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, CustomerSavedSearchModel::class);
    }

    /**
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return CustomerSavedSearchModel
     */
    public function create(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->post('admin/customer_saved_searches.json', [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return CustomerSavedSearchModel
     */
    public function edit(CustomerSavedSearchModel $customerSavedSearch)
    {
        $serializedModel = ['customer_saved_search' => array_merge($this->serializeModel($customerSavedSearch))];

        $raw = $this->client->put("admin/customer_saved_searches/{$customerSavedSearch->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['customer_saved_search'], CustomerSavedSearchModel::class);
    }

    /**
     * @param CustomerSavedSearchModel $customerSavedSearch
     *
     * @return array
     */
    public function delete(CustomerSavedSearchModel $customerSavedSearch)
    {
        return $this->client->delete("admin/customer_saved_searches/{$customerSavedSearch->getId()}.json");
    }

    /**
     * @param $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get('admin/customer_saved_searches.json', $params);

        $customers = array_map(function ($customer) {
            return $this->unserializeModel($customer, CustomerSavedSearchModel::class);
        }, $raw['customers']);

        return new Collection($customers);
    }
}

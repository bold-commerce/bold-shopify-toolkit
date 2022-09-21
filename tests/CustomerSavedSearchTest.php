<?php

use BoldApps\ShopifyToolkit\Models\CustomerSavedSearch as ShopifyCustomerSavedSearch;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\CustomerSavedSearch as CustomerSavedSearchService;
use PHPUnit\Framework\TestCase;

class CustomerSavedSearchTest extends TestCase
{
    /** @var CustomerSavedSearchService */
    private $customerSavedSearchService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->customerSavedSearchService = new CustomerSavedSearchService($client);
    }

    /**
     * @test
     */
    public function shopifyCustomerSavedSearchSerializesProperly()
    {
        $customerSavedSearchEntity = $this->createCustomerSavedSearchEntity();

        $expected = $this->getCustomerSavedSearchArray();
        $actual = $this->customerSavedSearchService->serializeModel($customerSavedSearchEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shopifyCustomerSavedSearchDeserializesProperly()
    {
        $customerSavedSearchJson = $this->getCustomerSavedSearchJson();
        $jsonArray = (array) json_decode($customerSavedSearchJson, true);

        $expected = $this->createCustomerSavedSearchEntity();
        $actual = $this->customerSavedSearchService->unserializeModel($jsonArray, ShopifyCustomerSavedSearch::class);

        $this->assertEquals($expected, $actual);
    }

    private function createCustomerSavedSearchEntity()
    {
        /** @var ShopifyCustomerSavedSearch $customerSavedSearchEntity */
        $customerSavedSearchEntity = $this->customerSavedSearchService->createFromArray($this->getCustomerSavedSearchArray());

        return $customerSavedSearchEntity;
    }

    private function getCustomerSavedSearchJson()
    {
        return '{
            "id": 1862334091,
            "name": "Abandoned checkouts",
            "created_at": "2017-05-25T10:02:43-05:00",
            "updated_at": "2017-05-25T10:02:43-05:00",
            "query": "last_abandoned_order_date:last_month"
        }';
    }

    private function getCustomerSavedSearchArray()
    {
        return [
            'id' => 1862334091,
            'name' => 'Abandoned checkouts',
            'created_at' => '2017-05-25T10:02:43-05:00',
            'updated_at' => '2017-05-25T10:02:43-05:00',
            'query' => 'last_abandoned_order_date:last_month',
        ];
    }
}

<?php

namespace Tests\Services;

use BoldApps\ShopifyToolkit\Models\CustomerSavedSearch;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\CustomerSavedSearch as CustomerSavedSearchService;
use PHPUnit\Framework\TestCase;

class CustomerSavedSearchTest extends TestCase
{
    /** @var Client */
    private $clientMock;

    /** @var CustomerSavedSearchService */
    private $customerSavedSearchService;

    public function setUp()
    {
        parent::setUp();

        $this->clientMock = $this->createMock(Client::class);
        $this->customerSavedSearchService = new CustomerSavedSearchService($this->clientMock);
    }

    public function testGetCallsCorrectEndpointAndReturnsUnserializedModel()
    {
        $customerSavedSearchId = 123456789;
        $rawCustomerSavedSearch = [
            'customer_saved_search' => [
                'id' => 123456789,
                'name' => 'Accepts Marketing',
                'query' => 'accepts_marketing:1',
              ],
        ];

        $expectedUrl = 'admin/api/2020-04/customer_saved_searches/123456789.json';
        $expectedCustomerSavedSearch = new CustomerSavedSearch();
        $expectedCustomerSavedSearch->setId(123456789);
        $expectedCustomerSavedSearch->setName('Accepts Marketing');
        $expectedCustomerSavedSearch->setQuery('accepts_marketing:1');

        $this->clientMock->expects($this->at(0))
            ->method('get')
            ->with($expectedUrl, [], [], null, false)
            ->will($this->returnValue($rawCustomerSavedSearch));

        $actualCustomerSavedSearch = $this->customerSavedSearchService->get($customerSavedSearchId);

        $this->assertEquals($expectedCustomerSavedSearch, $actualCustomerSavedSearch);
    }
}

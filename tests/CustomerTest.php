<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Customer as ShopifyCustomer;
use BoldApps\ShopifyToolkit\Services\Customer as CustomerService;

class CustomerTest extends \PHPUnit\Framework\TestCase
{
    /** @var CustomerService */
    private $customerService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->customerService = new CustomerService($client);
    }

    /**
     * @test
     */
    public function ShopifyCustomerSerializesProperly()
    {
        $customerEntity = $this->createCustomerEntity();

        $expected = $this->getCustomerArray();
        $actual = $this->customerService->serializeModel($customerEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyCustomerDeserializesProperly()
    {
        $customerJson = $this->getCustomerJson();
        $jsonArray = (array) json_decode($customerJson, true);

        $expected = $this->createCustomerEntity();
        $actual = $this->customerService->unserializeModel($jsonArray, ShopifyCustomer::class);

        $this->assertEquals($expected, $actual);
    }

    private function createCustomerEntity()
    {
        /** @var ShopifyCustomer $customerEntity */
        $customerEntity = $this->customerService->createFromArray($this->getCustomerArray());

        return $customerEntity;
    }

    private function getCustomerJson()
    {
        return '{
            "id": 4391204235,
            "email": "test@email.com",
            "accepts_marketing": false,
            "created_at": "2017-05-25T14:18:37-05:00",
            "updated_at": "2018-01-31T18:07:21-06:00",
            "first_name": "First",
            "last_name": "Last",
            "orders_count": 102,
            "state": "enabled",
            "total_spent": "13243.97",
            "last_order_id": 148960968715,
            "note": "",
            "verified_email": true,
            "multipass_identifier": null,
            "tax_exempt": false,
            "phone": "+12040000000",
            "tags": "",
            "last_order_name": "#1102",
            "addresses": [{
                "id": 4797872459,
                "customer_id": 4391204235,
                "first_name": "First",
                "last_name": "Last",
                "company": "Bold",
                "address1": "50 Fultz Blvd",
                "address2": "",
                "city": "Winnipeg",
                "province": "Manitoba",
                "country": "Canada",
                "zip": "R3Y 0L6",
                "phone": "",
                "name": "First Last",
                "province_code": "MB",
                "country_code": "CA",
                "country_name": "Canada",
                "default": true
            }],
            "default_address": {
                "id": 4797872459,
                "customer_id": 4391204235,
                "first_name": "First",
                "last_name": "Last",
                "company": "Bold",
                "address1": "50 Fultz Blvd",
                "address2": "",
                "city": "Winnipeg",
                "province": "Manitoba",
                "country": "Canada",
                "zip": "R3Y 0L6",
                "phone": "",
                "name": "First Last",
                "province_code": "MB",
                "country_code": "CA",
                "country_name": "Canada",
                "default": true
            }
        }';
    }

    private function getCustomerArray()
    {
        return [
            'id' => 4391204235,
            'email' => 'test@email.com',
            'accepts_marketing' => false,
            'created_at' => '2017-05-25T14:18:37-05:00',
            'updated_at' => '2018-01-31T18:07:21-06:00',
            'first_name' => 'First',
            'last_name' => 'Last',
            'orders_count' => 102,
            'state' => 'enabled',
            'total_spent' => '13243.97',
            'last_order_id' => 148960968715,
            'note' => '',
            'verified_email' => true,
            'tax_exempt' => false,
            'phone' => '+12040000000',
            'tags' => '',
            'last_order_name' => '#1102',
            'addresses' => [[
                'id' => 4797872459,
                'customer_id' => 4391204235,
                'first_name' => 'First',
                'last_name' => 'Last',
                'company' => 'Bold',
                'address1' => '50 Fultz Blvd',
                'address2' => '',
                'city' => 'Winnipeg',
                'province' => 'Manitoba',
                'country' => 'Canada',
                'zip' => 'R3Y 0L6',
                'phone' => '',
                'name' => 'First Last',
                'province_code' => 'MB',
                'country_code' => 'CA',
                'country_name' => 'Canada',
                'default' => true,
            ]],
            'default_address' => [
                'id' => 4797872459,
                'customer_id' => 4391204235,
                'first_name' => 'First',
                'last_name' => 'Last',
                'company' => 'Bold',
                'address1' => '50 Fultz Blvd',
                'address2' => '',
                'city' => 'Winnipeg',
                'province' => 'Manitoba',
                'country' => 'Canada',
                'zip' => 'R3Y 0L6',
                'phone' => '',
                'name' => 'First Last',
                'province_code' => 'MB',
                'country_code' => 'CA',
                'country_name' => 'Canada',
                'default' => true,
            ],
        ];
    }
}

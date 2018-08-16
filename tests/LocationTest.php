<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Location as ShopifyLocation;
use BoldApps\ShopifyToolkit\Services\Location as LocationService;

class LocationTest extends \PHPUnit\Framework\TestCase
{
    /** @var LocationService */
    private $locationService;

    protected function setUp()
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->locationService = new LocationService($client);
    }

    /**
     * @test
     */
    public function ShopifyLocationSerializesProperly()
    {
        $locationEntity = $this->locationService->createFromArray($this->getLocationArray());

        $expected = $this->getLocationArray();
        $actual = $this->locationService->serializeModel($locationEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyLocationDeserializesProperly()
    {
        $locationJson = $this->getLocationJson();
        $jsonArray = (array)json_decode($locationJson, true);

        $expected = $this->locationService->createFromArray($this->getLocationArray());
        $actual = $this->locationService->unserializeModel($jsonArray, ShopifyLocation::class);

        $this->assertEquals($expected, $actual);
    }

    private function getLocationJson()
    {
        return '{
            "id": 487838322,
            "name": "Fifth Avenue AppleStore",
            "address1": "767 5th Ave",
            "address2": null,
            "city": "New York",
            "zip": "10153",
            "province": "New York",
            "country": "US",
            "phone": "12123361440",
            "created_at": "2018-07-05T12:41:00-04:00",
            "updated_at": "2018-07-05T12:41:00-04:00",
            "country_code": "US",
            "country_name": "United States",
            "province_code": "NY",
            "legacy": false,
            "admin_graphql_api_id": "gid://shopify/Location/487838322"
        }';
    }

    private function getLocationArray()
    {
        return [
            "id" => 487838322,
            "name" => "Fifth Avenue AppleStore",
            "address1" => "767 5th Ave",
            "city" => "New York",
            "zip" => "10153",
            "province" => "New York",
            "country" => "US",
            "phone" => "12123361440",
            "created_at" => "2018-07-05T12:41:00-04:00",
            "updated_at" => "2018-07-05T12:41:00-04:00",
            "country_code" => "US",
            "country_name" => "United States",
            "province_code" => "NY",
            "legacy" => false,
            "admin_graphql_api_id" => "gid://shopify/Location/487838322",
        ];
    }
}
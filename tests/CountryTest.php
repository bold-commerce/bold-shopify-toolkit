<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Models\Country as ShopifyCountry;
use BoldApps\ShopifyToolkit\Services\Country as CountryService;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    /** @var CountryService */
    private $countryService;

    protected function setUp(): void
    {
        /** @var Client $client */
        $client = $this->createMock(Client::class);
        $this->countryService = new CountryService($client);
    }

    /**
     * @test
     */
    public function ShopifyCountrySerializesProperly()
    {
        $countryEntity = $this->createCountryEntity();

        $expected = $this->getCountryArray();
        $actual = $this->countryService->serializeModel($countryEntity);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function ShopifyCountryDeserializesProperly()
    {
        $countryJson = $this->getCountryJson();
        $jsonArray = (array) json_decode($countryJson, true);

        $expected = $this->createCountryEntity();
        $actual = $this->countryService->unserializeModel($jsonArray, ShopifyCountry::class);

        $this->assertEquals($expected, $actual);
    }

    private function createCountryEntity()
    {
        /** @var ShopifyCountry $countryEntity */
        $countryEntity = $this->countryService->createFromArray($this->getCountryArray());

        return $countryEntity;
    }

    private function getCountryJson()
    {
        return '{
            "id": 2644869131,
            "name": "Australia",
            "tax": 0,
            "code": "AU",
            "tax_name": "GST",
            "provinces": [
                {
                    "id": 16168648715,
                    "country_id": 2644869131,
                    "name": "Australian Capital Territory",
                    "code": "ACT",
                    "tax": 0,
                    "tax_name": "VAT",
                    "tax_type": null,
                    "shipping_zone_id": 496074763,
                    "tax_percentage": 0
                },
                {
                    "id": 16168681483,
                    "country_id": 2644869131,
                    "name": "New South Wales",
                    "code": "NSW",
                    "tax": 0,
                    "tax_name": "VAT",
                    "tax_type": null,
                    "shipping_zone_id": 496074763,
                    "tax_percentage": 0
                }
            ]
        }';
    }

    private function getCountryArray()
    {
        return [
            'id' => 2644869131,
            'name' => 'Australia',
            'tax' => 0,
            'code' => 'AU',
            'tax_name' => 'GST',
            'provinces' => [
                [
                    'id' => 16168648715,
                    'country_id' => 2644869131,
                    'name' => 'Australian Capital Territory',
                    'code' => 'ACT',
                    'tax' => 0,
                    'tax_name' => 'VAT',
                    'tax_type' => null,
                    'shipping_zone_id' => 496074763,
                    'tax_percentage' => 0,
                ],
                [
                    'id' => 16168681483,
                    'country_id' => 2644869131,
                    'name' => 'New South Wales',
                    'code' => 'NSW',
                    'tax' => 0,
                    'tax_name' => 'VAT',
                    'tax_type' => null,
                    'shipping_zone_id' => 496074763,
                    'tax_percentage' => 0,
                ],
            ],
        ];
    }
}

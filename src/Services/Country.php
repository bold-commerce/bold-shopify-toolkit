<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Country as ShopifyCountry;

class Country extends Base
{
    /**
     * @param ShopifyCountry $country
     *
     * @return ShopifyCountry | object
     */
    public function create(ShopifyCountry $country)
    {
        $serializedModel = ['country' => $this->serializeModel($country)];

        $raw = $this->client->post("admin/countries.json", [], $serializedModel);

        return $this->unserializeModel($raw['country'], ShopifyCountry::class);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyCountry::class);
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get('admin/countries/count.json', $filter);

        return $raw['count'];
    }

    /**
     * @param array $filter
     *
     * @return ShopifyCountry | object
     */
    public function getAll($filter = [])
    {
        $raw = $this->client->get("admin/countries.json", $filter);

        return $this->unserializeModel($raw['countries'], ShopifyCountry::class);
    }

    /**
     * @param int   $countryId
     * @param array $filter
     *
     * @return ShopifyCountry | object
     */
    public function getById($countryId, $filter = [])
    {
        $raw = $this->client->get("admin/countries/$countryId.json", $filter);

        return $this->unserializeModel($raw['country'], ShopifyCountry::class);
    }

    /**
     * @param ShopifyCountry $country
     *
     * @return object
     */
    public function update(ShopifyCountry $country)
    {
        $serializedModel = ['country' => $this->serializeModel($country)];
        $raw = $this->client->put("admin/countries/{$country->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['country'], ShopifyCountry::class);
    }

    /**
     * @param ShopifyCountry $country
     *
     * @return array
     */
    public function delete(ShopifyCountry $country)
    {
        return $this->client->delete("admin/countries/{$country->getId()}.json");
    }
}
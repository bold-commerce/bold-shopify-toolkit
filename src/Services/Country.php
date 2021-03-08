<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Country as ShopifyCountry;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Country extends Base
{
    /**
     * @return ShopifyCountry | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function create(ShopifyCountry $country)
    {
        $serializedModel = ['country' => $this->serializeModel($country)];

        $raw = $this->client->post("{$this->getApiBasePath()}/countries.json", [], $serializedModel);

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
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/countries/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param array $filter
     *
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll($filter = [])
    {
        $raw = $this->client->get('admin/countries.json', $filter);

        $countries = array_map(function ($country) {
            return $this->unserializeModel($country, ShopifyCountry::class);
        }, $raw['countries']);

        return new Collection($countries);
    }

    /**
     * @param array $params
     *
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams($params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/countries.json", $params);

        $countries = array_map(function ($country) {
            return $this->unserializeModel($country, ShopifyCountry::class);
        }, $raw['countries']);

        return new Collection($countries);
    }

    /**
     * @param int   $countryId
     * @param array $filter
     *
     * @return ShopifyCountry | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($countryId, $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/countries/$countryId.json", $filter);

        return $this->unserializeModel($raw['country'], ShopifyCountry::class);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyCountry $country)
    {
        $serializedModel = ['country' => $this->serializeModel($country)];
        $raw = $this->client->put("{$this->getApiBasePath()}/countries/{$country->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['country'], ShopifyCountry::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyCountry $country)
    {
        return $this->client->delete("{$this->getApiBasePath()}/countries/{$country->getId()}.json");
    }
}

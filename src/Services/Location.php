<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\InventoryLevel as ShopifyInventoryLevel;
use BoldApps\ShopifyToolkit\Models\Location as ShopifyLocation;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Location extends Base
{
    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyLocation::class);
    }

    /**
     * @return Collection
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getAll()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/locations.json");

        $locations = array_map(function ($location) {
            return $this->unserializeModel($location, ShopifyLocation::class);
        }, $raw['locations']);

        return new Collection($locations);
    }

    /**
     * @param $id
     *
     * @return ShopifyLocation
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/locations/$id.json");

        return $this->unserializeModel($raw['location'], ShopifyLocation::class);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(): int
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/locations/count.json");

        return $raw['count'];
    }

    /**
     * @param $id
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getLocationInventoryLevels($id): Collection
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/locations/$id/inventory_levels.json");

        $inventoryLevels = array_map(function ($inventoryLevel) {
            return $this->unserializeModel($inventoryLevel, ShopifyInventoryLevel::class);
        }, $raw['inventory_levels']);

        return new Collection($inventoryLevels);
    }
}

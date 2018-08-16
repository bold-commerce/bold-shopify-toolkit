<?php

namespace BoldApps\ShopifyToolkit\Services;


use BoldApps\ShopifyToolkit\Models\Location as ShopifyLocation;
use BoldApps\ShopifyToolkit\Models\InventoryLevel as ShopifyInventoryLevel;
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
     */
    public function getAll()
    {
        $raw = $this->client->get('admin/locations.json');

        $locations = array_map(function ($location) {
            return $this->unserializeModel($location, ShopifyLocation::class);
        }, $raw['locations']);

        return new Collection($locations);

    }

    /**
     * @param $id
     *
     * @return ShopifyLocation
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/locations/$id.json");

        return $this->unserializeModel($raw['location'], ShopifyLocation::class);
    }

    /**
     * @return int
     */
    public function count()
    {
        $raw = $this->client->get('admin/locations/count.json');

        return $raw['count'];
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function getLocationInventoryLevels($id)
    {
        $raw = $this->client->get("admin/locations/$id/inventory_levels.json");

        $inventoryLevels = array_map(function ($inventoryLevel) {
            return $this->unserializeModel($inventoryLevel, ShopifyInventoryLevel::class);
        }, $raw['inventory_levels']);

        return new Collection($inventoryLevels);
    }
}
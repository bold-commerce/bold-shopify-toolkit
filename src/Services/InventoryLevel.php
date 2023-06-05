<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\InventoryLevel as ShopifyInventoryLevel;
use Illuminate\Support\Collection;

class InventoryLevel extends CollectionEntity
{
    /**
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyInventoryLevel::class);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/inventory_levels.json", $params);

        $inventoryLevels = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyInventoryLevel::class);
        }, $raw['inventory_levels']);

        return new Collection($inventoryLevels);
    }

    /**
     * @param int $locationId
     * @param int $inventoryItemId
     * @param int $availableAdjustment
     *
     * @return ShopifyInventoryLevel|object
     */
    public function adjust($locationId, $inventoryItemId, $availableAdjustment)
    {
        $raw = $this->client->post("{$this->getApiBasePath()}/inventory_levels/adjust.json", [], [
            'location_id' => $locationId,
            'inventory_item_id' => $inventoryItemId,
            'available_adjustment' => $availableAdjustment,
        ]);

        return $this->unserializeModel($raw['inventory_level'], ShopifyInventoryLevel::class);
    }

    /**
     * @param int  $locationId
     * @param int  $inventoryItemId
     * @param int  $available
     * @param bool $disconnectIfNecessary
     *
     * @return ShopifyInventoryLevel|object
     */
    public function set($locationId, $inventoryItemId, $available, $disconnectIfNecessary = false)
    {
        $raw = $this->client->post("{$this->getApiBasePath()}/inventory_levels/set.json", [], [
            'location_id' => $locationId,
            'inventory_item_id' => $inventoryItemId,
            'available' => $available,
            'disconnect_if_necessary' => $disconnectIfNecessary,
        ]);

        return $this->unserializeModel($raw['inventory_level'], ShopifyInventoryLevel::class);
    }

    /**
     * @param int  $locationId
     * @param int  $inventoryItemId
     * @param bool $relocateIfNecessary
     *
     * @return ShopifyInventoryLevel|object
     */
    public function connect($locationId, $inventoryItemId, $relocateIfNecessary = false)
    {
        $raw = $this->client->post("{$this->getApiBasePath()}/inventory_levels/connect.json", [], [
            'location_id' => $locationId,
            'inventory_item_id' => $inventoryItemId,
            'relocate_if_necessary' => $relocateIfNecessary,
        ]);

        return $this->unserializeModel($raw['inventory_level'], ShopifyInventoryLevel::class);
    }

    /**
     * @return ShopifyInventoryLevel|object
     */
    public function delete(ShopifyInventoryLevel $inventoryLevel)
    {
        return $this->client->delete("{$this->getApiBasePath()}/inventory_levels.json", [
            'inventory_item_id' => $inventoryLevel->getInventoryItemId(),
            'location_id' => $inventoryLevel->getLocationId(),
        ]);
    }
}

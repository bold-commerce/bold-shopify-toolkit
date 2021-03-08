<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\InventoryLevel as ShopifyInventoryLevel;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class InventoryLevel extends CollectionEntity
{
    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyInventoryLevel::class);
    }

    /**
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getByParams(array $params): Collection
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/inventory_levels.json", $params);

        $inventoryLevels = array_map(function ($priceRule) {
            return $this->unserializeModel($priceRule, ShopifyInventoryLevel::class);
        }, $raw['inventory_levels']);

        return new Collection($inventoryLevels);
    }

    /**
     * @return ShopifyInventoryLevel | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function adjust(int $locationId, int $inventoryItemId, int $availableAdjustment)
    {
        $raw = $this->client->post("{$this->getApiBasePath()}/inventory_levels/adjust.json", [], [
            'location_id' => $locationId,
            'inventory_item_id' => $inventoryItemId,
            'available_adjustment' => $availableAdjustment,
        ]);

        return $this->unserializeModel($raw['inventory_level'], ShopifyInventoryLevel::class);
    }

    /**
     * @return ShopifyInventoryLevel | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function set(int $locationId, int $inventoryItemId, int $available, bool $disconnectIfNecessary = false)
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
     * @param bool $relocateIfNecessary
     *
     * @return ShopifyInventoryLevel | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function connect(int $locationId, int $inventoryItemId, $relocateIfNecessary = false)
    {
        $raw = $this->client->post("{$this->getApiBasePath()}/inventory_levels/connect.json", [], [
            'location_id' => $locationId,
            'inventory_item_id' => $inventoryItemId,
            'relocate_if_necessary' => $relocateIfNecessary,
        ]);

        return $this->unserializeModel($raw['inventory_level'], ShopifyInventoryLevel::class);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyInventoryLevel $inventoryLevel): array
    {
        return $this->client->delete("{$this->getApiBasePath()}/inventory_levels.json", [
            'inventory_item_id' => $inventoryLevel->getInventoryItemId(),
            'location_id' => $inventoryLevel->getLocationId(),
        ]);
    }
}

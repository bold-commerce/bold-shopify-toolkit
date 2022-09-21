<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\InventoryItem as ShopifyInventoryItem;
use Illuminate\Support\Collection;

class InventoryItem extends CollectionEntity
{
    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, ShopifyInventoryItem::class);
    }

    /**
     * @param       $id
     * @param array $filter
     *
     * @return ShopifyInventoryItem|object
     */
    public function getById($id, $filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/inventory_items/$id.json", $filter);

        return $this->unserializeModel($raw['inventory_item'], ShopifyInventoryItem::class);
    }

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/inventory_items.json", $params);

        $inventoryItems = array_map(function ($inventoryItem) {
            return $this->unserializeModel($inventoryItem, ShopifyInventoryItem::class);
        }, $raw['inventory_items']);

        return new Collection($inventoryItems);
    }

    /**
     * @return ShopifyInventoryItem|object
     */
    public function update(ShopifyInventoryItem $inventoryItem)
    {
        $serializedModel = ['inventory_item' => $this->serializeModel($inventoryItem)];
        $raw = $this->client->put("{$this->getApiBasePath()}/inventory_items/{$inventoryItem->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['inventory_item'], ShopifyInventoryItem::class);
    }
}

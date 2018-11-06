<?php

namespace BoldApps\ShopifyToolkit\Services;

use Illuminate\Support\Collection;
use BoldApps\ShopifyToolkit\Models\Theme as ShopifyTheme;

class Theme extends Base
{
    /**
     * @param ShopifyTheme $shopifyTheme
     *
     * @return ShopifyTheme
     */
    public function create(ShopifyTheme $shopifyTheme)
    {
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->post('admin/themes.json', [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @param ShopifyTheme $shopifyTheme
     *
     * @return ShopifyTheme
     */
    public function update(ShopifyTheme $shopifyTheme)
    {
        $id = $shopifyTheme->getId();
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->put("admin/themes/$id.json", [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyTheme
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/themes/$id.json");

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     */
    public function getMain()
    {
        $filter = ['role' => 'main'];

        $raw = $this->client->get('admin/themes.json', $filter);

        return $this->unserializeModel($raw['themes'][0], ShopifyTheme::class);
    }

    /**
     * @param array $filter
     *
     * @return Collection
     */
    public function getAll($filter = [])
    {
        $raw = $this->client->get('admin/themes.json', $filter);

        $themes = array_map(function ($theme) {
            return $this->unserializeModel($theme, ShopifyTheme::class);
        }, $raw['themes']);

        return new Collection($themes);
    }
}

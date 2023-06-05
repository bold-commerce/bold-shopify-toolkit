<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Theme as ShopifyTheme;
use Illuminate\Support\Collection;

class Theme extends Base
{
    /**
     * @return ShopifyTheme
     */
    public function create(ShopifyTheme $shopifyTheme)
    {
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->post("{$this->getApiBasePath()}/themes.json", [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     */
    public function update(ShopifyTheme $shopifyTheme)
    {
        $id = $shopifyTheme->getId();
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->put("{$this->getApiBasePath()}/themes/$id.json", [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/themes/$id.json");

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     */
    public function getMain()
    {
        $filter = ['role' => 'main'];

        $raw = $this->client->get("{$this->getApiBasePath()}/themes.json", $filter);

        return $this->unserializeModel($raw['themes'][0], ShopifyTheme::class);
    }

    /**
     * @deprecated Use getByParams()
     * @see getByParams()
     *
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

    /**
     * @param array $params
     *
     * @return Collection
     */
    public function getByParams($params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/themes.json", $params);

        $themes = array_map(function ($theme) {
            return $this->unserializeModel($theme, ShopifyTheme::class);
        }, $raw['themes']);

        return new Collection($themes);
    }
}

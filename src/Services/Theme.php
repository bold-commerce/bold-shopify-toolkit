<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Theme as ShopifyTheme;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Theme extends Base
{
    /**
     * @return ShopifyTheme
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyTheme $shopifyTheme)
    {
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->post("{$this->getApiBasePath()}/themes.json", [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyTheme $shopifyTheme)
    {
        $id = $shopifyTheme->getId();
        $serializedModel = ['theme' => $this->serializeModel($shopifyTheme)];

        $raw = $this->client->put("{$this->getApiBasePath()}/themes/$id.json", [], $serializedModel);

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @param $id
     *
     * @return ShopifyTheme
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/themes/$id.json");

        return $this->unserializeModel($raw['theme'], ShopifyTheme::class);
    }

    /**
     * @return ShopifyTheme
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getMain()
    {
        $filter = ['role' => 'main'];

        $raw = $this->client->get("{$this->getApiBasePath()}/themes.json", $filter);

        return $this->unserializeModel($raw['themes'][0], ShopifyTheme::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     *
     * @deprecated Use getByParams()
     * @see getByParams()
     */
    public function getAll(array $filter = [])
    {
        $raw = $this->client->get('admin/themes.json', $filter);

        $themes = array_map(function ($theme) {
            return $this->unserializeModel($theme, ShopifyTheme::class);
        }, $raw['themes']);

        return new Collection($themes);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams(array $params = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/themes.json", $params);

        $themes = array_map(function ($theme) {
            return $this->unserializeModel($theme, ShopifyTheme::class);
        }, $raw['themes']);

        return new Collection($themes);
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Asset as AssetModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\Theme as ShopifyThemeService;
use BoldApps\ShopifyToolkit\Models\Theme as ShopifyTheme;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Asset.
 */
class Asset extends Base
{
    /**
     * @var ShopifyThemeService
     */
    protected $shopifyTheme;

    /**
     * @var ShopifyTheme
     */
    protected $currentTheme;

    /**
     * Asset constructor.
     *
     * @param Client $client
     * @param Theme  $theme
     */
    public function __construct(ShopifyClient $client, ShopifyThemeService $theme)
    {
        $this->shopifyTheme = $theme;
        parent::__construct($client);
    }

    /**
     * Loads the theme for use in asset requests. Defaults to the main theme.
     *
     * @param int $themeId (optional)
     */
    public function loadTheme($themeId = null)
    {
        if (null === $themeId) {
            $this->currentTheme = $this->shopifyTheme->getMain();
        } else {
            $this->currentTheme = $this->shopifyTheme->getById($themeId);
        }
    }

    /**
     * @param string $key
     *
     * @return null|object
     *
     * @throws \Exception
     */
    public function getByKey($key)
    {
        if (is_null($this->currentTheme)) {
            $this->loadTheme();
        }

        $themeId = $this->currentTheme->getId();

        try {
            $raw = $this->client->get("admin/themes/$themeId/assets.json", [
                'asset' => [
                    'key' => $key,
                ],
            ]);
            $asset = $this->unserializeModel($raw['asset'], AssetModel::class);
        } catch(RequestException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case 404:
                    $asset = null;
                    break;
                default:
                    throw $e;
            }
        }

        return $asset;
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        if (is_null($this->currentTheme)) {
            $this->loadTheme();
        }

        $themeId = $this->currentTheme->getId();

        $raw = $this->client->get("admin/themes/$themeId/assets.json");

        $assets = array_map(function ($asset) {
            return $this->unserializeModel($asset, AssetModel::class);
        }, $raw['assets']);

        return new Collection($assets);
    }

    /**
     * @return int
     */
    public function getThemeId()
    {
        return $this->currentTheme->getId();
    }

    /**
     * @return string
     */
    public function getThemeName()
    {
        return $this->currentTheme->getName();
    }

    /**
     * @param AssetModel $asset
     *
     * @return object
     */
    public function create(AssetModel $asset)
    {
        if (is_null($this->currentTheme)) {
            $this->loadTheme();
        }

        $themeId = $this->currentTheme->getId();

        $serializedModel = ['asset' => $this->serializeModel($asset)];

        $raw = $this->client->put("admin/themes/$themeId/assets.json", [], $serializedModel);

        return $this->unserializeModel($raw['asset'], AssetModel::class);
    }

    /**
     * @param AssetModel $asset
     *
     * @return object
     */
    public function update(AssetModel $asset)
    {
        return $this->create($asset);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function delete($key)
    {
        if (is_null($this->currentTheme)) {
            $this->loadTheme();
        }

        $themeId = $this->currentTheme->getId();

        return $this->client->delete("admin/themes/$themeId/assets.json", [
            'asset' => [
                'key' => $key,
            ],
        ]);
    }
}

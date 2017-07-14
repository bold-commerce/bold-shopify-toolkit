<?php

namespace BoldApps\ShopifyToolkit\Services;

use Illuminate\Support\Collection;

/**
 * Class Theme.
 */
class Theme extends Base
{
    /**
     * @param $id
     *
     * @return \BoldApps\ShopifyToolkit\Models\Theme
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/themes/$id.json");

        return $this->unserializeModel($raw['theme'], \BoldApps\ShopifyToolkit\Models\Theme::class);
    }

    /**
     * @return \BoldApps\ShopifyToolkit\Models\Theme
     */
    public function getMain()
    {
        $filter = ['role' => 'main'];

        $raw = $this->client->get('admin/themes.json', $filter);

        return $this->unserializeModel($raw['themes'][0], \BoldApps\ShopifyToolkit\Models\Theme::class);
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
            return $this->unserializeModel($theme, \BoldApps\ShopifyToolkit\Models\Theme::class);
        }, $raw['themes']);

        return new Collection($themes);
    }
}

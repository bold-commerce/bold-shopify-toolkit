<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Script as ShopifyScript;
use Illuminate\Support\Collection;

/**
 * Class Script.
 */
class Script extends Base
{

    /**
     * @param ShopifyScript $script
     * @return object
     */
    public function create(ShopifyScript $script)
    {
        $serializedModel = ['script_tag' => $this->serializeModel($script)];

        $raw = $this->client->post('admin/script_tags.json', [], $serializedModel);

        return $this->unserializeModel($raw['script_tag'], ShopifyScript::class);
    }

    /**
     * @return Collection
     */
    public function get()
    {
        $raw = $this->client->get('admin/script_tags.json');

        $scripts = array_map(function ($script) {
            return $this->unserializeModel($script, ShopifyScript::class);
        }, $raw['script_tags']);

        return new Collection($scripts);
    }

    /**
     * @param $url
     * @return Collection
     */
    public function getByUrl($url)
    {
        $raw = $this->client->get('admin/script_tags.json?src='.$url);

        $scripts = array_map(function ($script) {
            return $this->unserializeModel($script, ShopifyScript::class);
        }, $raw['script_tags']);

        return new Collection($scripts);
    }

    /**
     * @param ShopifyScript $script
     * @return object
     */
    public function update(ShopifyScript $script)
    {
        $serializedModel = ['script_tag' => $this->serializeModel($script)];

        $raw = $this->client->put("admin/script_tag/{$script->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['script_tag'], ShopifyScript::class);
    }


    /**
     * @param ShopifyScript $script
     * @return array
     */
    public function delete(ShopifyScript $script)
    {
        return $this->client->delete("admin/script_tags/{$script->getId()}.json");
    }
}

<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Script as ShopifyScript;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Script extends Base
{
    /**
     * @return object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function create(ShopifyScript $script)
    {
        $serializedModel = ['script_tag' => $this->serializeModel($script)];

        $raw = $this->client->post("{$this->getApiBasePath()}/script_tags.json", [], $serializedModel);

        return $this->unserializeModel($raw['script_tag'], ShopifyScript::class);
    }

    /**
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function get()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/script_tags.json");

        $scripts = array_map(function ($script) {
            return $this->unserializeModel($script, ShopifyScript::class);
        }, $raw['script_tags']);

        return new Collection($scripts);
    }

    /**
     * @param $url
     *
     * @return Collection
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByUrl($url)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/script_tags.json?src=$url");

        $scripts = array_map(function ($script) {
            return $this->unserializeModel($script, ShopifyScript::class);
        }, $raw['script_tags']);

        return new Collection($scripts);
    }

    /**
     * @return object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyScript $script)
    {
        $serializedModel = ['script_tag' => $this->serializeModel($script)];

        $raw = $this->client->put("{$this->getApiBasePath()}/script_tag/{$script->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['script_tag'], ShopifyScript::class);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function delete(ShopifyScript $script)
    {
        return $this->client->delete("{$this->getApiBasePath()}/script_tags/{$script->getId()}.json");
    }
}

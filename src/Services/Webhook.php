<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Webhook as ShopifyWebhook;
use Illuminate\Support\Collection;

class Webhook extends Base
{
    /**
     * @return object
     */
    public function create(ShopifyWebhook $webhook)
    {
        $serializedModel = ['webhook' => $this->serializeModel($webhook)];

        $raw = $this->client->post("{$this->getApiBasePath()}/webhooks.json", [], $serializedModel);

        return $this->unserializeModel($raw['webhook'], ShopifyWebhook::class);
    }

    /**
     * @return Collection
     */
    public function get()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/webhooks.json");

        $webhooks = array_map(function ($webhook) {
            return $this->unserializeModel($webhook, ShopifyWebhook::class);
        }, $raw['webhooks']);

        return new Collection($webhooks);
    }

    /**
     * @return object
     */
    public function update(ShopifyWebhook $webhook)
    {
        $serializedModel = ['webhook' => $this->serializeModel($webhook)];

        $raw = $this->client->put("{$this->getApiBasePath()}/webhooks/{$webhook->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['webhook'], ShopifyWebhook::class);
    }

    /**
     * @return object|null
     */
    public function delete(ShopifyWebhook $webhook)
    {
        return $this->client->delete("{$this->getApiBasePath()}/webhooks/{$webhook->getId()}.json");
    }
}

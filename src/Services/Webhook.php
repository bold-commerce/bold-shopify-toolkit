<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Webhook as ShopifyWebhook;
use Illuminate\Support\Collection;

/**
 * Class Variant.
 */
class Webhook extends Base
{
    /**
     * @param ShopifyWebhook $webhook
     *
     * @return object
     */
    public function create(ShopifyWebhook $webhook)
    {
        $serializedModel = ['webhook' => $this->serializeModel($webhook)];

        $raw = $this->client->post('admin/webhooks.json', [], $serializedModel);

        return $this->unserializeModel($raw['webhook'], ShopifyWebhook::class);
    }

    /**
     * @return Collection
     */
    public function get()
    {
        $raw = $this->client->get('admin/webhooks.json');

        $webhooks = array_map(function ($webhook) {
            return $this->unserializeModel($webhook, ShopifyWebhook::class);
        }, $raw['webhooks']);

        return new Collection($webhooks);
    }

    /**
     * @param ShopifyWebhook $webhook
     *
     * @return object
     */
    public function update(ShopifyWebhook $webhook)
    {
        $serializedModel = ['webhook' => $this->serializeModel($webhook)];

        $raw = $this->client->put("admin/webhooks/{$webhook->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['webhook'], ShopifyWebhook::class);
    }

    /**
     * @param ShopifyWebhook $webhook
     *
     * @return null|object
     */
    public function delete(ShopifyWebhook $webhook)
    {
        return $this->client->delete("admin/webhooks/{$webhook->getId()}.json");
    }
}

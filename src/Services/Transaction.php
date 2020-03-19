<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Transaction as ShopifyTransaction;
use Illuminate\Support\Collection;

class Transaction extends Base
{
    /**
     * @param int $orderId
     *
     * @return Collection of ShopifyTransaction
     */
    public function getByOrderId($orderId)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/$orderId/transactions.json");
        $transactions = array_map(function ($transaction) {
            return $this->unserializeModel($transaction, ShopifyTransaction::class);
        }, $raw['transactions']);

        return new Collection($transactions);
    }

    /**
     * @param ShopifyTransaction $shopifyTransaction
     *
     * @return ShopifyTransaction
     */
    public function create($shopifyTransaction)
    {
        $serializedModel = ['transaction' => $this->serializeModel($shopifyTransaction)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders/{$shopifyTransaction->getOrderId()}/transactions.json", [], $serializedModel);

        return $this->unserializeModel($raw['transaction'], ShopifyTransaction::class);
    }
}

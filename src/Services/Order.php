<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\CancelOrder;
use BoldApps\ShopifyToolkit\Models\Order as ShopifyOrder;
use BoldApps\ShopifyToolkit\Models\OrderLineItem as OrderLineItemModel;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\OrderLineItem as OrderLineItemService;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class Order extends CollectionEntity
{
    /** @var TaxLineService */
    protected $taxLineService;

    /** @var OrderLineItemModel */
    protected $lineItemService;

    /** @var array */
    protected $unserializationExceptions = [
        'tax_lines' => 'unserializeTaxLines',
        'line_items' => 'unserializeLineItems',
    ];

    /** @var array */
    protected $serializationExceptions = [
        'taxLines' => 'serializeTaxLines',
        'lineItems' => 'serializeLineItems',
    ];

    public function __construct(ShopifyClient $client, TaxLineService $taxLineService, OrderLineItemService $lineItemService)
    {
        $this->taxLineService = $taxLineService;
        $this->lineItemService = $lineItemService;
        parent::__construct($client);
    }

    /**
     * @param $id
     *
     * @return ShopifyOrder|object
     *
     * @throws ShopifyException
     * @throws GuzzleException
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/$id.json");

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
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
    public function getAll(int $page = 1, int $limit = 50, array $filter = [])
    {
        $raw = $this->client->get('admin/orders.json', array_merge(['page' => $page, 'limit' => $limit], $filter));
        $orders = array_map(function ($order) {
            return $this->unserializeModel($order, ShopifyOrder::class);
        }, $raw['orders']);

        return new Collection($orders);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function getByParams(array $params): Collection
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders.json", $params);

        $orders = array_map(function ($order) {
            return $this->unserializeModel($order, ShopifyOrder::class);
        }, $raw['orders']);

        return new Collection($orders);
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function count(array $filter = []): int
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function countByParams(array $filter = []): int
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @return ShopifyOrder | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function update(ShopifyOrder $order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->put("{$this->getApiBasePath()}/orders/{$order->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @return ShopifyOrder | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function create(ShopifyOrder $order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @return ShopifyOrder | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function createTest(ShopifyOrder $order)
    {
        $order->setTest(true);

        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders.json", [], $serializedModel, [], null, false, ['X-Shopify-Api-Features' => 'creates-test-orders']);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param CancelOrder | null $cancelOrder
     *
     * @return ShopifyOrder | object
     *
     * @throws GuzzleException
     * @throws ShopifyException
     */
    public function cancel(int $id, CancelOrder $cancelOrder = null)
    {
        $serializedModel = $this->serializeModel($cancelOrder);
        $raw = $this->client->post("{$this->getApiBasePath()}/orders/{$id}/cancel.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeTaxLines($entities)
    {
        if (null === $entities) {
            return;
        }

        $imageService = &$this->taxLineService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($imageService) {
                return $imageService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    protected function unserializeTaxLines(array $data): ?Collection
    {
        if (null === $data) {
            return null;
        }

        $taxLineService = &$this->taxLineService;
        $collection = array_map(function ($taxLine) use ($taxLineService) {
            return $taxLineService->unserializeModel($taxLine, TaxLineModel::class);
        }, $data);

        return new Collection($collection);
    }

    /**
     * @param $entities
     *
     * @return array|null
     */
    protected function serializeLineItems($entities)
    {
        if (null === $entities) {
            return null;
        }

        $service = &$this->lineItemService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($service) {
                return $service->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    protected function unserializeLineItems(array $data): Collection
    {
        if (null === $data) {
            return null;
        }

        $lineItemService = &$this->lineItemService;
        $collection = array_map(function ($taxLine) use ($lineItemService) {
            return $lineItemService->unserializeModel($taxLine, OrderLineItemModel::class);
        }, $data);

        return new Collection($collection);
    }
}

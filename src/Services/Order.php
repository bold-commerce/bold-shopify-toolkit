<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\CancelOrder;
use BoldApps\ShopifyToolkit\Models\Order as ShopifyOrder;
use BoldApps\ShopifyToolkit\Models\OrderLineItem as OrderLineItemModel;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\OrderLineItem as OrderLineItemService;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
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

    /**
     * Order constructor.
     *
     * @param Client $client
     */
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
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/$id.json");

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @deprecated Use getByParams()
     * @see getByParams()
     *
     * @param int   $page
     * @param int   $limit
     * @param array $filter
     *
     * @return Collection
     */
    public function getAll($page = 1, $limit = 50, $filter = [])
    {
        $raw = $this->client->get('admin/orders.json', array_merge(['page' => $page, 'limit' => $limit], $filter));
        $orders = array_map(function ($order) {
            return $this->unserializeModel($order, ShopifyOrder::class);
        }, $raw['orders']);

        return new Collection($orders);
    }

    /**
     * @param $params
     *
     * @return Collection
     */
    public function getByParams($params)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders.json", $params);

        $orders = array_map(function ($order) {
            return $this->unserializeModel($order, ShopifyOrder::class);
        }, $raw['orders']);

        return new Collection($orders);
    }

    /**
     * @param array $filter
     *
     * @return int
     */
    public function count($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param $filter
     *
     * @return int
     */
    public function countByParams($filter = [])
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/orders/count.json", $filter);

        return $raw['count'];
    }

    /**
     * @param ShopifyOrder $order
     *
     * @return ShopifyOrder|object
     */
    public function update($order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->put("{$this->getApiBasePath()}/orders/{$order->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param ShopifyOrder $order
     *
     * @return ShopifyOrder|object
     */
    public function create($order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param ShopifyOrder $order
     *
     * @return ShopifyOrder|object
     */
    public function createTest($order)
    {
        $order->setTest(true);

        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->post("{$this->getApiBasePath()}/orders.json", [], $serializedModel, [], null, false, ['X-Shopify-Api-Features' => 'creates-test-orders']);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param int              $id
     * @param CancelOrder|null $cancelOrder
     *
     * @return ShopifyOrder|object
     */
    public function cancel($id, $cancelOrder = null)
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

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeTaxLines($data)
    {
        if (null === $data) {
            return;
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
            return;
        }

        $service = &$this->lineItemService;

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) use ($service) {
                return $service->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeLineItems($data)
    {
        if (null === $data) {
            return;
        }

        $lineItemService = &$this->lineItemService;
        $collection = array_map(function ($taxLine) use ($lineItemService) {
            return $lineItemService->unserializeModel($taxLine, OrderLineItemModel::class);
        }, $data);

        return new Collection($collection);
    }
}

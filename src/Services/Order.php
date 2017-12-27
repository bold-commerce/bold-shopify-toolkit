<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Order as ShopifyOrder;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Models\OrderLineItem;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Services\OrderLineItem as OrderLineItemService;
use Illuminate\Support\Collection;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;

/**
 * Class Order.
 */
class Order extends CollectionEntity
{

    /**
     * @var TaxLineService
     */
    protected $taxLineService;

    /**
     * @var OrderLineItem
     */
    protected $lineItemService;

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'tax_lines' => 'unserializeTaxLines',
        'line_items' => 'unserializeLineItems',
    ];

    /**
     * @var array
     */
    protected $serializationExceptions = [
        'taxLines' => 'serializeTaxLines',
        'lineItems' => 'serializeLineItems',
    ];

    /**
     * Order constructor.
     * @param Client $client
     * @param TaxLineService $taxLineService
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
        $raw = $this->client->get("admin/orders/$id.json");

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param int $page
     * @param int $limit
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
     * @param $parms
     *
     * @return Collection
     */
    public function getByParams($parms)
    {
        $raw = $this->client->get('admin/orders.json', $parms);

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
        $raw = $this->client->get('admin/orders/count.json', $filter);

        return $raw['count'];
    }

    /**
     * @param $filter
     *
     * @return int
     */
    public function countByParams($filter = [])
    {
        $raw = $this->client->get('admin/orders/count.json', $filter);

        return $raw['count'];
    }

    /**
     * @param ShopifyOrder $order
     * @return ShopifyOrder | object
     */
    public function update($order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->put("admin/orders/{$order->getId()}.json", [], $serializedModel);

        return $this->unserializeModel($raw['order'], ShopifyOrder::class);
    }

    /**
     * @param ShopifyOrder $order
     * @return ShopifyOrder | object
     */
    public function create($order)
    {
        $serializedModel = ['order' => $this->serializeModel($order)];

        $raw = $this->client->post("admin/orders.json", [], $serializedModel);

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
            return $lineItemService->unserializeModel($taxLine, OrderLineItem::class);
        }, $data);

        return new Collection($collection);
    }


}

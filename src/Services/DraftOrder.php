<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DraftOrder as ShopifyDraftOrder;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use Illuminate\Support\Collection;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\DraftOrderLineItem as DraftOrderLineItemService;
use BoldApps\ShopifyToolkit\Models\DraftOrderLineItem as DraftOrderLineItemModel;
use BoldApps\ShopifyToolkit\Services\DraftOrderAppliedDiscount as AppliedDiscountService;
use BoldApps\ShopifyToolkit\Models\DraftOrderAppliedDiscount as AppliedDiscountModel;
use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;

/**
 * Class DraftOrder
 */
class DraftOrder extends Base
{
    /**
     * @var TaxLineService
     */
    protected $taxLineService;

    /**
     * @var DraftOrderLineItemService
     */
    protected $draftOrderLineItemService;

    /**
     * @var DraftOrderAppliedDiscount
     */
    protected $appliedDiscountService;

    /**
     * @var array
     */
    protected $unserializationExceptions = [
        'tax_lines' => 'unserializeTaxLines',
        'line_items' => 'unserializeLineItems',
        'applied_discount' => 'unserializeAppliedDiscount',
    ];

    /**
     * @var array
     */
    protected $serializationExceptions = [
        'taxLines' => 'serializeTaxLines',
        'lineItems' => 'serializeLineItems',
        'appliedDiscount' => 'serializeAppliedDiscount',
    ];


    /**
     * DraftOrder constructor.
     * @param Client $client
     * @param \BoldApps\ShopifyToolkit\Services\TaxLine $taxLineService
     * @param DraftOrderLineItemService $draftOrderLineItemService
     * @param DraftOrderAppliedDiscount $appliedDiscountService
     */
    public function __construct(ShopifyClient $client,
                                TaxLineService $taxLineService,
                                DraftOrderLineItemService $draftOrderLineItemService,
                                AppliedDiscountService $appliedDiscountService)
    {
        $this->taxLineService = $taxLineService;
        $this->draftOrderLineItemService = $draftOrderLineItemService;
        $this->appliedDiscountService = $appliedDiscountService;
        parent::__construct($client);
    }

    /**
     * @param $shopifyDraftOrder
     * @return object
     */
    public function create($shopifyDraftOrder)
    {
        $serializedModel = ['draft_order' => $this->serializeModel($shopifyDraftOrder)];
        $raw = $this->client->post("admin/draft_orders.json", [], $serializedModel);

        return $this->unserializeModel($raw['draft_order'], ShopifyDraftOrder::class);
    }

    /**
     * @param $id
     * @return ShopifyDraftOrder
     */
    public function getById($id)
    {
        $raw = $this->client->get("admin/draft_orders/$id.json");

        $result = $this->unserializeModel($raw['draft_order'], ShopifyDraftOrder::class);

        return $result;
    }

    /**
     * @param $data
     * @return ShopifyDraftOrder
     */
    public function createFromArray($data)
    {
        return $this->unserializeModel($data, ShopifyDraftOrder::class);
    }

    /**
     * @param $cart
     *
     * @return ShopifyDraftOrder
     */
    public function createDraftOrderFromCart(CartModel $cart)
    {
        $draftOrderModel = new ShopifyDraftOrder();

        $draftOrderLineItems = new Collection();
        foreach ($cart->getItems() as $cartItem) {
            $draftOrderLineItems->push($this->draftOrderLineItemService->createDraftOrderLineItemFromCartItem($cartItem));
        }

        $draftOrderModel->setLineItems($draftOrderLineItems);
        $draftOrderModel->setNote($cart->getNote());
        $draftOrderModel->setNoteAttributes($cart->getAttributes());

        return $draftOrderModel;
    }

    /**
     * @param $entities
     * @return array
     */
    protected function serializeTaxLines($entities)
    {
        if (null === $entities) {
            return;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->taxLineService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param $data
     * @return Collection
     */
    protected function unserializeTaxLines($data)
    {

        if (null === $data) {
            return;
        }

        $collection = array_map(function ($taxLine) {
            return $this->taxLineService->unserializeModel($taxLine, TaxLineModel::class);
        }, $data);

        return new Collection($collection);
    }

    /**
     * @param $entities
     * @return array
     */
    protected function serializeLineItems($entities)
    {
        if (null === $entities) {
            return;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->draftOrderLineItemService->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param $data
     * @return Collection
     */
    protected function unserializeLineItems($data)
    {
        if (null === $data) {
            return;
        }

        $collection = array_map(function ($lineItem) {
            return $this->draftOrderLineItemService->unserializeModel($lineItem, DraftOrderLineItemModel::class);
        }, $data);

        return new Collection($collection);
    }

    /**
     * @param $data
     * @return object
     */
    protected function unserializeAppliedDiscount($data)
    {
        if (null === $data) {
            return;
        }

        return $this->appliedDiscountService->unserializeModel($data, AppliedDiscountModel::class);
    }

    /**
     * @param $appliedDiscount
     * @return array
     */
    protected function serializeAppliedDiscount($appliedDiscount)
    {
        if (null === $appliedDiscount) {
            return;
        }

        return $this->appliedDiscountService->serializeModel($appliedDiscount);
    }
}

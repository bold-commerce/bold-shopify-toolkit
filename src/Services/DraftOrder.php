<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;
use BoldApps\ShopifyToolkit\Models\DraftOrder as ShopifyDraftOrder;
use BoldApps\ShopifyToolkit\Models\DraftOrderAppliedDiscount as AppliedDiscountModel;
use BoldApps\ShopifyToolkit\Models\DraftOrderLineItem as DraftOrderLineItemModel;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\DraftOrderAppliedDiscount as AppliedDiscountService;
use BoldApps\ShopifyToolkit\Services\DraftOrderLineItem as DraftOrderLineItemService;
use BoldApps\ShopifyToolkit\Services\PollingInfo as PollingInfoService;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Traits\TranslatePropertiesTrait;
use Illuminate\Support\Collection;

class DraftOrder extends Base
{
    use TranslatePropertiesTrait;

    /** @var TaxLineService */
    protected $taxLineService;

    /** @var DraftOrderLineItemService */
    protected $draftOrderLineItemService;

    /** @var DraftOrderAppliedDiscount */
    protected $appliedDiscountService;

    /** @var PollingInfoService */
    protected $pollingInfoService;

    /** @var array */
    protected $unserializationExceptions = [
        'tax_lines' => 'unserializeTaxLines',
        'line_items' => 'unserializeLineItems',
        'applied_discount' => 'unserializeAppliedDiscount',
    ];

    /** @var array */
    protected $serializationExceptions = [
        'taxLines' => 'serializeTaxLines',
        'lineItems' => 'serializeLineItems',
        'appliedDiscount' => 'serializeAppliedDiscount',
        'pollingInfo' => 'serializePollingInfo',
    ];

    /**
     * DraftOrder constructor.
     *
     * @param Client                    $client
     * @param TaxLine                   $taxLineService
     * @param DraftOrderAppliedDiscount $appliedDiscountService
     */
    public function __construct(
        ShopifyClient $client,
        TaxLineService $taxLineService,
        DraftOrderLineItemService $draftOrderLineItemService,
        AppliedDiscountService $appliedDiscountService,
        PollingInfoService $pollingInfoService
        ) {
        $this->taxLineService = $taxLineService;
        $this->draftOrderLineItemService = $draftOrderLineItemService;
        $this->appliedDiscountService = $appliedDiscountService;
        $this->pollingInfoService = $pollingInfoService;
        parent::__construct($client);
    }

    /**
     * @param $shopifyDraftOrder
     *
     * @return object
     */
    public function create($shopifyDraftOrder)
    {
        $serializedModel = ['draft_order' => $this->serializeModel($shopifyDraftOrder)];
        $raw = $this->client->post("{$this->getApiBasePath()}/draft_orders.json", [], $serializedModel);

        $result = $this->unserializeModel($raw['draft_order'], ShopifyDraftOrder::class);
        $result->setPollingInfo($this->client->getPollingInfo());

        return $result;
    }

    /**
     * @param $id
     *
     * @return ShopifyDraftOrder
     */
    public function getById($id)
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/draft_orders/$id.json");

        $result = $this->unserializeModel($raw['draft_order'], ShopifyDraftOrder::class);
        $result->setPollingInfo($this->client->getPollingInfo());

        return $result;
    }

    /**
     * @param $data
     *
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

        $cartAttributes = $cart->getAttributes();
        if (!empty($cartAttributes)) {
            $draftOrderModel->setNoteAttributes(self::translateProperties($cartAttributes));
        }

        return $draftOrderModel;
    }

    /**
     * @param $id
     *
     * @return object
     */
    public function delete($id)
    {
        return $this->client->delete("{$this->getApiBasePath()}/draft_orders/$id.json");
    }

    /**
     * @param $entities
     *
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
     *
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
     *
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
     *
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
     *
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
     *
     * @return array
     */
    protected function serializeAppliedDiscount($appliedDiscount)
    {
        if (null === $appliedDiscount) {
            return;
        }

        return $this->appliedDiscountService->serializeModel($appliedDiscount);
    }

    /**
     * @param $pollingInfo
     *
     * @return array
     */
    protected function serializePollingInfo($pollingInfo)
    {
        if (null === $pollingInfo) {
            return;
        }

        return $this->pollingInfoService->serializeModel($pollingInfo);
    }
}

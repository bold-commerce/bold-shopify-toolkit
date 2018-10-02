<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Models\DraftOrderLineItem as DraftOrderLineItemModel;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\DraftOrderAppliedDiscount as AppliedDiscountService;
use BoldApps\ShopifyToolkit\Models\DraftOrderAppliedDiscount as AppliedDiscountModel;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Models\TaxLine as TaxLineModel;
use BoldApps\ShopifyToolkit\Models\Cart\Item as CartItem;
use Illuminate\Support\Collection;
use BoldApps\ShopifyToolkit\Traits\TranslatePropertiesTrait;

class DraftOrderLineItem extends Base
{
    use TranslatePropertiesTrait;

    /** @var DraftOrderAppliedDiscount */
    protected $appliedDiscountService;

    /** @var TaxLineService */
    protected $taxLineService;

    /** @var array */
    protected $unserializationExceptions = [
        'applied_discount' => 'unserializeAppliedDiscount',
        'tax_lines' => 'unserializeTaxLines',
    ];

    /** @var array */
    protected $serializationExceptions = [
        'appliedDiscount' => 'serializeAppliedDiscount',
        'taxLines' => 'serializeTaxLines',
    ];

    /**
     * DraftOrderLineItem constructor.
     *
     * @param Client                    $client
     * @param DraftOrderAppliedDiscount $appliedDiscountService
     * @param TaxLineService            $taxlineService
     */
    public function __construct(ShopifyClient $client,
                                AppliedDiscountService $appliedDiscountService,
                                TaxLineService $taxlineService)
    {
        $this->appliedDiscountService = $appliedDiscountService;
        $this->taxLineService = $taxlineService;
        parent::__construct($client);
    }

    /**
     * @param $array
     *
     * @return object
     */
    public function createFromArray($array)
    {
        return $this->unserializeModel($array, DraftOrderLineItemModel::class);
    }

    /**
     * @param CartItem $cartItem
     *
     * @return DraftOrderLineItemModel
     */
    public function createDraftOrderLineItemFromCartItem(CartItem $cartItem)
    {
        $draftOrderLineItem = new DraftOrderLineItemModel();
        $draftOrderLineItemClass = new \ReflectionClass($draftOrderLineItem);
        $draftOrderLineItemProps = [];
        foreach ($draftOrderLineItemClass->getProperties() as $property) {
            array_push($draftOrderLineItemProps, $property->name);
        }

        $cartItemClass = new \ReflectionClass($cartItem);
        $cartItemProps = [];
        foreach ($cartItemClass->getProperties() as $property) {
            array_push($cartItemProps, $property->name);
        }

        foreach ($draftOrderLineItemProps as $draftOrderLineItemProp) {
            if (in_array($draftOrderLineItemProp, $cartItemProps)) {
                $cartItemValue = $cartItem->{'get'.ucfirst($draftOrderLineItemProp)}();
                if (false !== strpos($draftOrderLineItemProp, 'price')) {
                    $draftOrderLineItem->setPrice($cartItemValue / 100);
                } else {
                    $draftOrderLineItem->{'set'.ucfirst($draftOrderLineItemProp)}($cartItemValue);
                }
            }
        }

        $lineItemProperties = $draftOrderLineItem->getProperties();
        if (!empty($lineItemProperties)) {
            $draftOrderLineItem->setProperties(self::translateProperties($lineItemProperties));
        }

        return $draftOrderLineItem;
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
}

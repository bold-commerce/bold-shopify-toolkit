<?php

namespace BoldApps\Common\Test\Services\Shopify;

use PHPUnit\Framework\TestCase;
use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;
use BoldApps\ShopifyToolkit\Services\Cart as CartService;
use BoldApps\ShopifyToolkit\Services\DraftOrder as DraftOrderService;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Services\DraftOrderLineItem as DraftOrderLineItemService;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Services\DraftOrderAppliedDiscount as AppliedDiscountService;

/**
 * Class DraftOrderTest.
 */
class DraftOrderTest extends TestCase
{
    protected function setUp()
    {
        $mockShopifyClient = $this->createMock(ShopifyClient::class);

        $cartService = new CartService($mockShopifyClient);
        $this->cart = $cartService->unserializeModel([
            'items' => [],
            'attributes' => ['cool' => 'yes'],
        ], CartModel::class);

        $mockDraftOrderLineItemService = $this->createMock(DraftOrderLineItemService::class);
        $mockTaxLineService = $this->createMock(TaxLineService::class);
        $mockAppliedDiscountService = $this->createMock(AppliedDiscountService::class);

        $this->draftOrderService = new DraftOrderService(
            $mockShopifyClient,
            $mockTaxLineService,
            $mockDraftOrderLineItemService,
            $mockAppliedDiscountService
        );
    }

    public function testCreateDraftOrderFromCartCarriesOverCartAttributes()
    {
        $draftOrder = $this->draftOrderService->createDraftOrderFromCart($this->cart);
        $result = $draftOrder->getNoteAttributes();
        $expected = [['name' => 'cool', 'value' => 'yes']];
        $this->assertSame($expected, $result);
    }
}

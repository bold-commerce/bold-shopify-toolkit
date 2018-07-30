<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Contracts\RequestHookInterface;
use BoldApps\ShopifyToolkit\Contracts\ShopAccessInfo;
use BoldApps\ShopifyToolkit\Contracts\ShopBaseInfo;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\DraftOrder;
use BoldApps\ShopifyToolkit\Models\DraftOrder as DraftOrderModel;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockBuilder as Mock;
use BoldApps\ShopifyToolkit\Models\Variant as VariantModel;
use BoldApps\ShopifyToolkit\Models\DraftOrderLineItem as DraftOrderLineItemModel;
use BoldApps\ShopifyToolkit\Services\DraftOrderLineItem as DraftOrderLineItemService;
use BoldApps\ShopifyToolkit\Services\DraftOrderAppliedDiscount as AppliedDiscountService;
use Illuminate\Support\Collection;

/**
 * Class DraftOrderTest
 * @package BoldApps\Common\Test\Services\Shopify
 */
class DraftOrderTest extends TestCase
{
    /** @var Client */
    protected $client;

    /** @var Mock | ShopBaseInfo */
    protected $mockShopBaseInfo;

    /** @var Mock | ShopAccessInfo */
    protected $mockShopAccessInfo;

    /** @var Mock | RequestHookInterface */
    protected $mockRequestHookInterface;

    /** @var string */
    protected $myShopifyDomain;

    /**
     * @var AppliedDiscountService
     */
    protected $appliedDiscountService;

    /**
     * @var DraftOrderLineItemService
     */
    protected $draftOrderLineItemService;

    /**
     * @var TaxLineService
     */
    protected $taxLineService;

    /**
     * Tests set up
     */
    protected function setUp()
    {
        $this->myShopifyDomain = 'fight-club.myshopify.com';

        $this->mockShopBaseInfo = $this->getMockBuilder(ShopBaseInfo::class)->getMock();
        $this->mockShopAccessInfo = $this->getMockBuilder(ShopAccessInfo::class)->getMock();
        $this->mockRequestHookInterface = $this->getMockBuilder(RequestHookInterface::class)->getMock();

        // mock http client
        $mock = new MockHandler([new Response(200)]);
        $handler = HandlerStack::create($mock);
        $mockHttpClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->client = new Client($this->mockShopBaseInfo, $this->mockShopAccessInfo, $mockHttpClient,
            $this->mockRequestHookInterface);

        $this->taxLineService = new TaxLineService($this->client);
        $this->appliedDiscountService = new AppliedDiscountService($this->client);
        $this->draftOrderLineItemService = new DraftOrderLineItemService(
            $this->client,
            $this->appliedDiscountService,
            $this->taxLineService);
    }

    public function testCreateDraftOrderFromVariant()
    {
        $variant = new VariantModel();
        $variant->setPrice(50.0);
        $variant->setId(1);
        $variant->setProductId(1);
        $variant->setTitle("Prod title");
        $variant->setTaxable(true);

        $quantity = 1;

        $draftOrderService = new DraftOrder(
            $this->client,
            $this->taxLineService,
            $this->draftOrderLineItemService,
            $this->appliedDiscountService
        );

        $result = $draftOrderService->createDraftOrderFromVariant($variant, $quantity);

        $this->assertEquals(1, count($result->getLineItems()));
        $this->assertInstanceOf(DraftOrderModel::class, $result);
    }
}

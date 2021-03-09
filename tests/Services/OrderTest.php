<?php

namespace BoldApps\ShopifyToolkit\Test\Services;

use BoldApps\ShopifyToolkit\Models\CancelOrder;
use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\Order as OrderService;
use BoldApps\ShopifyToolkit\Services\TaxLine as TaxLineService;
use BoldApps\ShopifyToolkit\Services\OrderLineItem as OrderLineItemService;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /** @var OrderService */
    private $orderService;

    protected function setUp(): void
    {
        $client = $this->createMock(Client::class);
        $taxLineService = new TaxLineService($client);
        $orderLineItemService = new OrderLineItemService($client, $taxLineService);
        $this->orderService = new OrderService($client, $taxLineService, $orderLineItemService);
    }

    public function testSerializeCancelOrder()
    {
        $cancelOrder = new CancelOrder();
        $cancelOrder->setAmount(10.52);
        $cancelOrder->setCurrency('CAD');
        $cancelOrder->setReason('customer');
        $cancelOrder->setEmail(true);

        $expected = [
            'amount' => 10.52,
            'currency' => 'CAD',
            'reason' => 'customer',
            'email' => true,
        ];

        $actual = $this->orderService->serializeModel($cancelOrder);

        $this->assertEquals($expected, $actual);
    }
}

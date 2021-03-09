<?php

namespace BoldApps\Common\Test\Services\Shopify;

use BoldApps\ShopifyToolkit\Services\Cart;
use BoldApps\ShopifyToolkit\Services\Client as ShopifyClient;
use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;
use GuzzleHttp\Client as HttpClient;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /** @var HttpClient */
    private $client;

    protected function setUp(): void
    {
        $this->client = $this->getMockBuilder(HttpClient::class)->getMock();
    }

    public function testClearCartWillClearAttributes()
    {
        $cart = $this->createCart();
        $emptiedCart = $this->createCart(true);

        $mockClient = $this->getMockBuilder(ShopifyClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cartService = new Cart($mockClient);

        // Expect cart clear to be sent
        $serializedCart = $cartService->serializeModel($cart);
        $mockClient
            ->expects($this->at(0))
            ->method('post')
            ->with('cart/clear.json', [], [], $this->anything(), null, true)
            ->will($this->returnValue($serializedCart));

        // Expect cart update to be sent with empty notes and empty attributes
        $serializedEmptyCart = $cartService->serializeModel($emptiedCart);
        $expectedCartData = [
            'note' => '',
            'attributes' => $emptiedCart->getAttributes(),
        ];
        $mockClient
            ->expects($this->at(1))
            ->method('post')
            ->with('cart/update.json', [], $expectedCartData, $this->anything(), null, true)
            ->will($this->returnValue($serializedEmptyCart));

        $cartToken = 'nice-cart-token';
        $clearedCart = $cartService->clear($cartToken);
    }

    public function testClearCartWithPassword()
    {
        $cart = $this->createCart();
        $emptiedCart = $this->createCart(true);

        $mockClient = $this->getMockBuilder(ShopifyClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cartService = new Cart($mockClient);

        // Expect cart clear to be sent with password
        $serializedCart = $cartService->serializeModel($cart);
        $mockClient
            ->expects($this->at(0))
            ->method('post')
            ->with('cart/clear.json', [], [], $this->anything(), 'password', true)
            ->will($this->returnValue($serializedCart));

        $serializedEmptyCart = $cartService->serializeModel($emptiedCart);
        $mockClient
            ->expects($this->at(1))
            ->method('post')
            ->will($this->returnValue($serializedEmptyCart));

        $cartToken = 'nice-cart-token';
        $clearedCart = $cartService->clear($cartToken, 'password');
    }

    private function createCart($setValuesToEmpty = false)
    {
        $cart = new CartModel();

        if ($setValuesToEmpty) {
            $cart->setNote('');
            $cart->setAttributes(['attribute1' => '']);
        } else {
            $cart->setNote('note');
            $cart->setAttributes(['attribute1' => 'value1']);
        }

        $cart->setTotalDiscount(3);
        $cart->setTotalWeight(4);
        $cart->setItemCount(0);
        $cart->setTotalPrice(8);
        $cart->setOriginalTotalPrice(5);
        $cart->setToken('token');
        $cart->setRequiresShipping(true);

        return $cart;
    }
}

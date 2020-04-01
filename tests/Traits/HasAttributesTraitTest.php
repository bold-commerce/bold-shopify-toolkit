<?php

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\Cart as CartService;
use BoldApps\ShopifyToolkit\Models\Cart\Cart;
use BoldApps\ShopifyToolkit\Models\Cart\Item as CartItem;

class HasAttributesTraitTest extends \PHPUnit\Framework\TestCase
{
    /** @var \BoldApps\ShopifyToolkit\Models\Customer */
    private $customerObject;

    protected function setUp()
    {
        $client = $this->createMock(Client::class);
        $this->cartService = new CartService($client);
        $this->customerObject = new \BoldApps\ShopifyToolkit\Models\Customer();
    }

    public function testHasAttribute()
    {
        $firstName = 'cool first name';
        $this->customerObject->setFirstName($firstName);
        $this->assertEquals($firstName, $this->customerObject->first_name);
        $this->assertEquals($firstName, $this->customerObject->firstName);
        $this->assertEquals($this->customerObject->getFirstName(), $this->customerObject->first_name);
        $this->assertEquals($this->customerObject->getFirstName(), $this->customerObject->firstName);
    }

    public function testHasAttributeFails()
    {
        $this->assertNull($this->customerObject->yesnt_exists);
        $this->assertNull($this->customerObject->yesntExists);
    }

    public function testHasMutator()
    {
        $this->assertTrue($this->customerObject->hasGetMutator('first_name'));
        $this->assertTrue($this->customerObject->hasGetMutator('firstName'));
    }

    public function testHasMutatorFails()
    {
        $this->assertFalse($this->customerObject->hasGetMutator('yesnt_exists'));
        $this->assertFalse($this->customerObject->hasGetMutator('yesntExists'));
    }

    public function testIsset()
    {
        $firstName = 'cool first name';
        $this->customerObject->setFirstName($firstName);
        $this->assertTrue(isset($this->customerObject->first_name));
    }

    public function testIssetFails()
    {
        $this->assertFalse(isset($this->customerObject->first_name));
    }

    public function testToArray()
    {
        $cart = new Cart();
        $cart->setToken('cheesewhiz');

        $arrayCart = $cart->toArray();
        $reModeledCart = $this->cartService->unserializeModel($arrayCart, Cart::class);

        $this->assertEquals('cheesewhiz', $reModeledCart->getToken());
    }

    public function testJsonSerialize()
    {
        $cart = new Cart();
        $cart->setToken('cheesewhizard');
        $cartItem = new CartItem();
        $cartItem->setPrice(500);
        $cart->setItems([$cartItem]);

        $jsonCart = json_encode($cart);
        $arrayCart = json_decode($jsonCart, true);

        $reModeledCart = $this->cartService->unserializeModel($arrayCart, Cart::class);
        $reModeledCartItem = $reModeledCart->getItems()[0];

        $this->assertEquals(500, $reModeledCartItem->getPrice());
        $this->assertEquals('cheesewhizard', $reModeledCart->getToken());
    }
}

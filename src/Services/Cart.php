<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Exceptions\ShopifyException;
use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;
use BoldApps\ShopifyToolkit\Models\Cart\Item as CartItemModel;
use BoldApps\ShopifyToolkit\Models\Option as OptionModel;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Collection;

class Cart extends Base
{
    protected $unserializationExceptions = [
        'items' => 'unserializeItems',
        'variant_options' => 'unserializeOptions',
    ];

    protected $serializationExceptions = [
        'items' => 'serializeItems',
        'variantOptions' => 'serializeOptions',
    ];

    /**
     * @return CartModel
     */
    public function get($cartToken, $password = null)
    {
        $raw = $this->client->get('cart.json', [], $this->getCartCookie($cartToken), $password, true);

        $cart = $this->unserializeModel($raw, CartModel::class);

        return $cart;
    }

    /**
     * @param string      $cartToken
     * @param string|null $password
     *
     * @return CartModel|object
     */
    public function clear($cartToken, $password = null)
    {
        $cookies = $this->getCartCookie($cartToken);

        $raw = $this->client->post('cart/clear.json', [], [], $cookies, $password, true);

        if (empty($raw)) {
            // The request to clear cart has failed, we are unable to take any further action on the cart
            throw new ShopifyException('Received empty result while trying to clear cart');
        }

        /** @var CartModel */
        $cart = $this->unserializeModel($raw, CartModel::class);

        $needToUpdateCart = false;
        $cartUpdateData = [];

        if (!empty($cart->getNote())) {
            $needToUpdateCart = true;
            $cartUpdateData['note'] = '';
        }

        if (count($cart->getAttributes())) {
            // can't just set attributes to an empty array, gotta set the values to blank
            $clearedAttributes = $cart->getAttributes();
            foreach ($clearedAttributes as &$attribute) {
                $attribute = '';
            }
            $needToUpdateCart = true;
            $cart->setAttributes($clearedAttributes);
            $cartUpdateData['attributes'] = $clearedAttributes;
        }

        if ($needToUpdateCart) {
            $raw = $this->client->post('cart/update.json', [], $cartUpdateData, $this->getCartCookie($cartToken), $password, true);

            return $this->unserializeModel($raw, CartModel::class);
        }

        return $cart;
    }

    /**
     * @param string      $cartToken
     * @param string|null $password
     *
     * @return object
     */
    public function update(CartModel $cart, $cartToken, $password = null)
    {
        $raw = $this->client->post('cart/update.json', [], $this->serializeModel($cart), $this->getCartCookie($cartToken), $password, true);

        return $this->unserializeModel($raw, CartModel::class);
    }

    /**
     * @param null $password
     */
    public function switchCartCurrency($cartToken, $currency, $password = null)
    {
        $this->client->get('cart', ['currency' => $currency], $this->getCartCookie($cartToken), $password, true);
    }

    /**
     * Builds the cookie needed for you to get a cart.
     *
     * @return array
     */
    private function getCartCookie($cartToken)
    {
        $cartCookie = new SetCookie();
        $cartCookie->setName('cart');
        $cartCookie->setValue($cartToken);

        return [$cartCookie];
    }

    /**
     * @return array|null
     */
    protected function serializeItems($entities)
    {
        if (null === $entities) {
            return;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeItems($data)
    {
        if (null === $data) {
            return;
        }

        $items = array_map(function ($item) {
            return $this->unserializeModel($item, CartItemModel::class);
        }, $data);

        return new Collection($items);
    }

    /**
     * @return array|null
     */
    protected function serializeOptions($entities)
    {
        if (null === $entities) {
            return;
        }

        if ($entities instanceof Collection) {
            return $entities->map(function ($entity) {
                return $this->serializeModel($entity);
            })->toArray();
        }

        return $entities;
    }

    /**
     * @param array $data
     *
     * @return Collection
     */
    protected function unserializeOptions($data)
    {
        if (null === $data) {
            return;
        }

        $options = array_map(function ($option, $key) {
            return $this->unserializeModel(['id' => $key, 'name' => $option], OptionModel::class);
        }, $data, array_keys($data));

        return new Collection($options);
    }
}

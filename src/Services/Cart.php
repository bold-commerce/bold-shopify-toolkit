<?php

namespace BoldApps\ShopifyToolkit\Services;
use BoldApps\ShopifyToolkit\Models\Cart\Item as CartItemModel;
use BoldApps\ShopifyToolkit\Models\Cart\Cart as CartModel;
use BoldApps\ShopifyToolkit\Models\Option as OptionModel;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Collection;

class Cart extends Base
{

    /**
     * @return CartModel
     */
    public function get($cartToken, $password = null)
    {

        $raw = $this->client->get('cart.json',[], $this->getCartCookie($cartToken), $password, true);

        $raw['items'] = $this->unserializeItems($raw['items']);
        $cart = $this->unserializeModel($raw, CartModel::class);

        return $cart;
    }


    /**
     * @param string $cartToken
     * @param string|null $password
     * @return CartModel|object
     */
    public function clear($cartToken, $password = null) {

        $cookies = $this->getCartCookie($cartToken);

        $raw = $this->client->post('cart/clear.json', [], [], $cookies , $password, true);

        /**
         * @var CartModel $cart
         */
        $cart = $this->unserializeModel($raw, CartModel::class);

        $needToUpdateCart = false;


        if ($cart->getNote() !== '') {
            $needToUpdateCart = true;
        }

        if(count($cart->getAttributes())) {
            //can't just set attributes to an empty array, gotta set the values to blank
            $clearedAttributes = $cart->getAttributes();
            foreach($clearedAttributes as &$attribute) {
                $attribute = '';
            }
            $needToUpdateCart = true;
            $cart->setAttributes($clearedAttributes);
        }

        if($needToUpdateCart){
            $raw = $this->client->post("cart/update.json", [], ['note' => '','attributes' => $cart->getAttributes()], $this->getCartCookie($cartToken), $password, true);

            return $this->unserializeModel($raw, CartModel::class);
        }

        return $cart;
    }

    /**
     * @param CartModel $cart
     * @param string $cartToken
     * @param string | null $password
     * @return object
     */
    public function update(CartModel $cart, $cartToken, $password = null)
    {
        $serializedModel = ['cart' => $this->serializeModel($cart)];

        $raw = $this->client->post("cart/update.json", [], $serializedModel, $this->getCartCookie($cartToken), $password, true);

        return $this->unserializeModel($raw, CartModel::class);
    }

    /**
     * Builds the cookie needed for you to get a cart
     *
     * @param $cartToken
     * @return array
     */
    private function getCartCookie($cartToken) {
        $cartCookie = new SetCookie();
        $cartCookie->setName('cart');
        $cartCookie->setValue($cartToken);

        return [$cartCookie];
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

        $items = array_map(function ($item){
            $item['variant_options'] = $this->unserializeOptions($item['variant_options']);
            return $this->unserializeModel($item, CartItemModel::class);
        }, $data);

        return new Collection($items);
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
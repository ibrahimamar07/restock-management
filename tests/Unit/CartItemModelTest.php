<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartItem;

class CartItemModelTest extends TestCase
{
    public function test_cart_item_casts_and_relations()
    {
        $user = User::create([
            'email' => 'ci_user@example.test',
            'username' => 'ci_user',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'CIStore',
            'storeAddress' => 'Addr',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'BoltX',
            'itemPrice' => 2.5,
        ]);

        $cart = Cart::create([
            'idUser' => $user->idUser,
            'idStore' => $store->idStore,
        ]);

        $ci = CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 3,
            'subTotal' => 7.5,
        ]);

        $this->assertEquals('7.50', (string) $ci->subTotal);
        $this->assertEquals($cart->idCart, $ci->cart->idCart);
        $this->assertEquals($item->idItem, $ci->item->idItem);
    }
}

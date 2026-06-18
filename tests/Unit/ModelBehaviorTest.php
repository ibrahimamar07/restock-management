<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Store;
use App\Models\User;
use App\Models\UserPaymentType;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ModelBehaviorTest extends TestCase
{
    public function test_cascade_delete_store_removes_items_and_cart_items()
    {
        $user = User::create([
            'email' => 'c1@example.test',
            'username' => 'c1',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'DelStore',
            'storeAddress' => 'Addr',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Bolt',
            'itemPrice' => '2.00',
        ]);

        $cart = Cart::create([
            'idUser' => $user->idUser,
            'idStore' => $store->idStore,
        ]);

        $cartItem = CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 1,
            'subTotal' => 2.00,
        ]);

        $this->assertDatabaseHas('items', ['idItem' => $item->idItem]);
        $this->assertDatabaseHas('cart_items', ['idCartItem' => $cartItem->idCartItem]);

        $store->delete();

        $this->assertDatabaseMissing('stores', ['idStore' => $store->idStore]);
        $this->assertDatabaseMissing('items', ['idItem' => $item->idItem]);
        $this->assertDatabaseMissing('cart_items', ['idCartItem' => $cartItem->idCartItem]);
    }

    public function test_user_hidden_password()
    {
        $user = User::create([
            'email' => 'hidden@example.test',
            'username' => 'hidden1',
            'password' => 'pw',
        ]);

        $array = $user->toArray();
        $this->assertArrayNotHasKey('password', $array);
    }

    public function test_cart_cartdate_cast_is_datetime()
    {
        $user = User::create([
            'email' => 'dt@example.test',
            'username' => 'dt1',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'DateStore',
            'storeAddress' => 'Addr',
        ]);

        $cart = Cart::create([
            'idUser' => $user->idUser,
            'idStore' => $store->idStore,
        ]);

        $cart = $cart->fresh();

        $this->assertInstanceOf(Carbon::class, $cart->cartDate);
    }

    public function test_invoice_and_payment_default_statuses()
    {
        $restocker = User::create([
            'email' => 'inv@example.test',
            'username' => 'inv1',
            'password' => 'pw',
        ]);

        $owner = User::create([
            'email' => 'own@example.test',
            'username' => 'own1',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'InvStore',
            'storeAddress' => 'Addr',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Tape',
            'itemPrice' => '5.00',
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
        ]);

        $cartItem = CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 1,
            'subTotal' => 5.00,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $owner->idUser,
            'totalAmount' => 5.00,
        ]);

        $invoice = $invoice->fresh();

        $this->assertEquals('unpaid', $invoice->status);

        $pt = PaymentType::create(['paymentName' => 'Cash']);
        $upt = UserPaymentType::create([
            'idUser' => $restocker->idUser,
            'idPaymentType' => $pt->idPaymentType,
            'paymentDetails' => 'detail',
        ]);

        $payment = Payment::create([
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $upt->idUserPaymentType,
            'amount' => 5.00,
        ]);

        $payment = $payment->fresh();

        $this->assertEquals('pending', $payment->status);
    }
}

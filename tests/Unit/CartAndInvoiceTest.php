<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Item;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\PaymentType;
use App\Models\UserPaymentType;
use App\Models\Payment;

class CartAndInvoiceTest extends TestCase
{
    public function test_cart_and_invoice_workflow()
    {
        $restocker = User::create([
            'email' => 'r@example.test',
            'username' => 'restock',
            'password' => 'pw',
        ]);

        $owner = User::create([
            'email' => 'o@example.test',
            'username' => 'owner',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'Owner Store',
            'storeAddress' => 'Addr',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Glue',
            'itemPrice' => '3.00',
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
        ]);

        $cartItem = CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 2,
            'subTotal' => 6.00,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $owner->idUser,
            'totalAmount' => 6.00,
        ]);

        $pt = PaymentType::create(['paymentName' => 'Bank Transfer']);
        $upt = UserPaymentType::create([
            'idUser' => $restocker->idUser,
            'idPaymentType' => $pt->idPaymentType,
            'paymentDetails' => 'acc 123',
        ]);

        $payment = Payment::create([
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $upt->idUserPaymentType,
            'amount' => 6.00,
        ]);

        $this->assertEquals(6.00, (float) $invoice->totalAmount);
        $this->assertEquals(1, $invoice->payments()->count());
        $this->assertEquals(1, $cart->cartItems()->count());
    }
}

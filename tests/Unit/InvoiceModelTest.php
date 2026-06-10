<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Payment;

class InvoiceModelTest extends TestCase
{
    public function test_invoice_casts_and_payments_relation()
    {
        $owner = User::create([
            'email' => 'inv_owner@example.test',
            'username' => 'inv_owner',
            'password' => 'pw',
        ]);

        $restocker = User::create([
            'email' => 'inv_restocker@example.test',
            'username' => 'inv_restocker',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'InvStoreX',
            'storeAddress' => 'Addr',
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $owner->idUser,
            'totalAmount' => 12.5,
        ]);

        $this->assertEquals('12.50', (string) $invoice->totalAmount);
        $invoice = $invoice->fresh();
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $invoice->invoiceDate);

        $pt = \App\Models\PaymentType::create(['paymentName' => 'PTX']);
        $upt = \App\Models\UserPaymentType::create([
            'idUser' => $restocker->idUser,
            'idPaymentType' => $pt->idPaymentType,
            'paymentDetails' => 'd',
        ]);

        Payment::create([
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $upt->idUserPaymentType,
            'amount' => 12.5,
        ]);

        $this->assertEquals(1, $invoice->payments()->count());
    }
}

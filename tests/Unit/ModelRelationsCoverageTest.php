<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Store;
use App\Models\User;
use App\Models\UserPaymentType;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class ModelRelationsCoverageTest extends TestCase
{
    public function test_payment_model_relations_link_invoice_and_payment_type()
    {
        $storeOwner = User::create([
            'email' => 'paymentowner@example.com',
            'username' => 'paymentowner',
            'password' => Hash::make('secret'),
        ]);

        $restocker = User::create([
            'email' => 'paymentrestocker@example.com',
            'username' => 'paymentrestocker',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Payment Store',
            'storeAddress' => 'Payment Address',
            'storePic' => null,
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 1000,
            'status' => 'unpaid',
        ]);

        $paymentType = PaymentType::create([
            'paymentName' => 'Test Payment',
        ]);

        $userPaymentType = UserPaymentType::create([
            'idUser' => $storeOwner->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '123',
        ]);

        $payment = Payment::create([
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $userPaymentType->idUserPaymentType,
            'amount' => 1000,
            'paymentDate' => now(),
            'status' => 'confirmed',
        ]);

        $this->assertEquals($invoice->idInvoice, $payment->invoice->idInvoice);
        $this->assertEquals($userPaymentType->idUserPaymentType, $payment->userPaymentType->idUserPaymentType);
    }

    public function test_store_model_has_items_and_carts_relations()
    {
        $user = User::create([
            'email' => 'storerel@example.com',
            'username' => 'storerel',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Rel Store',
            'storeAddress' => 'Rel Address',
            'storePic' => null,
        ]);

        $this->assertEquals(0, $store->items()->count());
        $this->assertEquals(0, $store->carts()->count());
    }

    public function test_user_model_relations_return_collections()
    {
        $user = User::create([
            'email' => 'userrel@example.com',
            'username' => 'userrel',
            'password' => Hash::make('secret'),
        ]);

        $this->assertNotNull($user->stores());
        $this->assertNotNull($user->carts());
        $this->assertNotNull($user->userPaymentTypes());
        $this->assertNotNull($user->restockerInvoices());
        $this->assertNotNull($user->storeOwnerInvoices());
    }
}

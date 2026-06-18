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

class UserPaymentTypeTest extends TestCase
{
    public function test_user_payment_type_relations_and_payments()
    {
        $user = User::create([
            'email' => 'upt_user@example.test',
            'username' => 'upt_user',
            'password' => 'pw',
        ]);

        $pt = PaymentType::create(['paymentName' => 'PT1']);

        $upt = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => $pt->idPaymentType,
            'paymentDetails' => 'det',
        ]);

        // create a minimal invoice to satisfy FK
        $restocker = User::create([
            'email' => 'r2@example.test',
            'username' => 'r2',
            'password' => 'pw',
        ]);

        $owner = User::create([
            'email' => 'o2@example.test',
            'username' => 'o2',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'S2',
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
            'totalAmount' => 1.00,
        ]);

        $payment = Payment::create([
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $upt->idUserPaymentType,
            'amount' => 1.00,
        ]);

        $this->assertEquals($user->idUser, $upt->user->idUser);
        $this->assertEquals($pt->idPaymentType, $upt->paymentType->idPaymentType);
        $this->assertEquals(1, $upt->payments()->count());
    }
}

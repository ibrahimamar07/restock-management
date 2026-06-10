<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PaymentType;
use App\Models\User;
use App\Models\UserPaymentType;

class PaymentTypeTest extends TestCase
{
    public function test_payment_type_has_user_payment_types()
    {
        $pt = PaymentType::create(['paymentName' => 'TestPT']);

        $user = User::create([
            'email' => 'pt_user@example.test',
            'username' => 'pt_user',
            'password' => 'pw',
        ]);

        $upt = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => $pt->idPaymentType,
            'paymentDetails' => 'detail',
        ]);

        $this->assertEquals(1, $pt->userPaymentTypes()->count());
        $this->assertEquals($upt->idUserPaymentType, $pt->userPaymentTypes->first()->idUserPaymentType);
    }
}

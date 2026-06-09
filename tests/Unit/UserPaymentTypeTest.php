<?php

// namespace Tests\Unit;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Tests\TestCase;
// use App\Models\User;
// use App\Models\UserPaymentType;

// class UserPaymentTypeTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_user_payment_type_relationship()
//     {
//         $user = User::factory()->create([
//             'username' => 'pay_user',
//             'email' => 'pay_user@example.com',
//             'password' => bcrypt('password'),
//         ]);

//         $upt = UserPaymentType::create([
//             'idUser' => $user->idUser,
//             'idPaymentType' => 1,
//             'paymentDetails' => '123456'
//         ]);

//         $this->assertEquals($user->idUser, $upt->idUser);
//         $this->assertEquals(1, $upt->idPaymentType);
//         $this->assertEquals('123456', $upt->paymentDetails);
//     }
// }

<?php

// namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
// use Tests\TestCase;
// use App\Models\PaymentType;
// use App\Models\User;
// use App\Models\UserPaymentType;

// class RegistrationFlowTest extends TestCase
// {
//     use RefreshDatabase;

//     public function test_full_registration_flow_creates_user_and_payment()
//     {
//         Storage::fake('public');

//         // Step 1: register (stores in session)
//         $this->post('/register', [
//             'email' => 'flow@example.com',
//             'username' => 'flowuser',
//             'password' => 'secret123',
//         ])->assertRedirect('/new-profile');

//         // Step 2: save profile with image
//         $file = UploadedFile::fake()->image('avatar.jpg');
//         $this->post('/new-profile', [
//             'nickname' => 'Flow',
//             'description' => 'Testing flow',
//             'profilepic' => $file,
//         ])->assertRedirect('/new-method');

//         // Step 3: select payment method
//         $this->post('/new-method', [
//             'payment_type' => 3,
//         ])->assertRedirect('/payment-number');

//         // Step 4: finalize registration
//         $this->post('/finalize-registration', [
//             'payment_number' => 12345678,
//         ])->assertRedirect('/onboarding');

//         // Assert user created and authenticated
//         $this->assertDatabaseHas('users', ['username' => 'flowuser']);
//         $user = User::where('username', 'flowuser')->first();
//         $this->assertAuthenticatedAs($user);

//         // Assert payment method created for user
//         $this->assertDatabaseHas('user_payment_types', ['idUser' => $user->idUser]);
//     }

//     public function test_set_default_payment_method()
//     {
//         // Prepare payment type and user
//         $ptype = PaymentType::create(['paymentName' => 'Bank Test']);
//         $user = User::factory()->create();

//         $upt1 = UserPaymentType::create([
//             'idUser' => $user->idUser,
//             'idPaymentType' => $ptype->idPaymentType,
//             'paymentDetails' => '111',
//             'is_default' => 0,
//         ]);
//         $upt2 = UserPaymentType::create([
//             'idUser' => $user->idUser,
//             'idPaymentType' => $ptype->idPaymentType,
//             'paymentDetails' => '222',
//             'is_default' => 0,
//         ]);

//         $this->actingAs($user)->post('/profile/paymentmethods/default', [
//             'idUserPaymentType' => $upt2->idUserPaymentType,
//         ])->assertRedirect();

//         $this->assertDatabaseHas('user_payment_types', [
//             'idUserPaymentType' => $upt2->idUserPaymentType,
//             'is_default' => 1,
//         ]);
//     }
// }

<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Store;
use App\Models\User;
use App\Models\UserPaymentType;
use App\Services\StoreImageService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class RestockManagementTest extends TestCase
{
    use WithFaker;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_new_user_stores_registration_session_and_redirects()
    {
        $response = $this->post('/register', [
            'email' => 'alice@example.com',
            'username' => 'alice',
            'password' => 'securepass',
        ]);

        $response->assertRedirect('/new-profile');
        $response->assertSessionHas('reg_email', 'alice@example.com');
        $response->assertSessionHas('reg_username', 'alice');
        $response->assertSessionHas('reg_password');
    }

    public function test_new_user_fails_when_email_is_duplicate()
    {
        User::create([
            'email' => 'bob@example.com',
            'username' => 'bob',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->from('/register')->post('/register', [
            'email' => 'bob@example.com',
            'username' => 'bob2',
            'password' => 'secret2',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHas('error', 'Email already registered.');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_save_profile_stores_data_in_session()
    {
        $response = $this->withSession([])->post('/new-profile', [
            'nickname' => 'Alice',
            'description' => 'Testing profile',
        ]);

        $response->assertRedirect('/new-method');
        $response->assertSessionHas('reg_nickname', 'Alice');
        $response->assertSessionHas('reg_description', 'Testing profile');
    }

    public function test_finalize_registration_creates_user_and_payment_method()
    {
        // Payment type 3 harus ada agar transaksinya dapat dibuat.
        DB::table('payment_types')->insert([
            'idPaymentType' => 3,
            'paymentName' => 'E-Wallet - GoPay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->withoutExceptionHandling();

        $this->withSession([
            'reg_email' => 'charlie@example.com',
            'reg_username' => 'charlie',
            'reg_password' => Hash::make('securepass'),
            'reg_nickname' => 'Charlie',
            'reg_description' => 'New user',
            'reg_profilepic' => null,
            'reg_payment_type' => 3,
        ])
            ->post('/finalize-registration', [
                'payment_number' => 12345678,
            ])
            ->assertRedirect('/onboarding');

        $this->assertDatabaseHas('users', [
            'email' => 'charlie@example.com',
            'username' => 'charlie',
            'nickname' => 'Charlie',
        ]);

        $user = User::where('email', 'charlie@example.com')->first();
        $this->assertNotNull($user);
        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('user_payment_types', [
            'idUser' => $user->idUser,
            'idPaymentType' => 3,
        ]);
    }

    public function test_login_with_valid_credentials_redirects_home()
    {
        User::create([
            'email' => 'dan@example.com',
            'username' => 'dan',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'dan',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticated();
    }

    public function test_store_creation_uses_image_service_and_saves_record()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'owner@example.com',
            'username' => 'owner',
            'password' => Hash::make('ownerpass'),
        ]);

        $mock = Mockery::mock(StoreImageService::class);
        $mock->shouldReceive('saveImage')->once()->andReturn('saved-store.jpg');
        $this->app->instance(StoreImageService::class, $mock);

        $this->actingAs($user)
            ->post('/stores', [
                'storeName' => 'Test Store',
                'storeAddress' => 'Jl Test 123',
                'storeDesc' => 'Desc',
                'storePic' => UploadedFile::fake()->image('store.jpg'),
            ])
            ->assertRedirect(route('stores.listStore'));

        $this->assertDatabaseHas('stores', [
            'storeName' => 'Test Store',
            'idUser' => $user->idUser,
        ]);
    }

    public function test_add_item_to_store_creates_item_record()
    {
        $user = User::create([
            'email' => 'seller@example.com',
            'username' => 'seller',
            'password' => Hash::make('sellerpass'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Seller Store',
            'storeAddress' => 'Jl Seller',
            'storePic' => null,
        ]);

        $this->actingAs($user)
            ->post("/stores/{$store->idStore}/items", [
                'itemName' => 'Kopi',
                'itemPrice' => 15000,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('items', [
            'itemName' => 'Kopi',
            'idStore' => $store->idStore,
        ]);
    }

    public function test_create_invoice_from_cart_computes_total_and_updates_cart_status()
    {
        $storeOwner = User::create([
            'email' => 'owner2@example.com',
            'username' => 'owner2',
            'password' => Hash::make('ownerpass'),
        ]);

        $restocker = User::create([
            'email' => 'restocker@example.com',
            'username' => 'restocker',
            'password' => Hash::make('restockpass'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Invoice Store',
            'storeAddress' => 'Jl Invoice',
            'storePic' => null,
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Pasta',
            'itemPrice' => 20000,
        ]);

        CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 2,
            'subTotal' => 40000,
        ]);

        $this->actingAs($restocker)
            ->post("/carts/{$cart->idCart}/create-invoice")
            ->assertRedirect();

        $this->assertDatabaseHas('invoices', [
            'idCart' => $cart->idCart,
            'totalAmount' => 40000.00,
            'status' => 'unpaid',
        ]);

        $this->assertDatabaseHas('carts', [
            'idCart' => $cart->idCart,
            'status' => 'converted_to_invoice',
        ]);
    }

    public function test_process_payment_marks_invoice_as_paid()
    {
        $storeOwner = User::create([
            'email' => 'owner3@example.com',
            'username' => 'owner3',
            'password' => Hash::make('ownerpass'),
        ]);

        $restocker = User::create([
            'email' => 'restocker2@example.com',
            'username' => 'restocker2',
            'password' => Hash::make('restockpass'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Payment Store',
            'storeAddress' => 'Jl Payment',
            'storePic' => null,
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'converted_to_invoice',
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 50000,
            'status' => 'unpaid',
        ]);

        $paymentType = PaymentType::create(['paymentName' => 'E-Wallet Test']);
        $userPaymentType = UserPaymentType::create([
            'idUser' => $storeOwner->idUser,
            'idPaymentType' => $paymentType->idPaymentType,
            'paymentDetails' => '08123456789',
        ]);

        $this->actingAs($storeOwner)
            ->post("/invoices/{$invoice->idInvoice}/pay", [
                'idUserPaymentType' => $userPaymentType->idUserPaymentType,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('invoices', [
            'idInvoice' => $invoice->idInvoice,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('payments', [
            'idInvoice' => $invoice->idInvoice,
            'idUserPaymentType' => $userPaymentType->idUserPaymentType,
            'status' => 'comfirmed',
        ]);
    }
}

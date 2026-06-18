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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class CoverageBoostTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_duplicate_username_fails_registration()
    {
        User::create([
            'email' => 'john@example.com',
            'username' => 'john',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->from('/register')->post('/register', [
            'email' => 'john2@example.com',
            'username' => 'john',
            'password' => 'secret2',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHas('error', 'Username already taken.');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_save_profile_with_uploaded_picture_stores_session()
    {
        Storage::fake('public');

        $response = $this->post('/new-profile', [
            'nickname' => 'Test User',
            'description' => 'Profile description',
            'profilepic' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect('/new-method');
        $response->assertSessionHas('reg_nickname', 'Test User');
        $response->assertSessionHas('reg_description', 'Profile description');
        $response->assertSessionHas('reg_profilepic');
    }

    public function test_new_user_payment_selection_redirects_to_payment_number()
    {
        $response = $this->post('/new-method', [
            'payment_type' => 3,
        ]);

        $response->assertRedirect('/payment-number');
        $response->assertSessionHas('reg_payment_type', 3);
    }

    // public function test_update_profile_with_new_picture_replaces_existing_file()
    // {
    //     Storage::fake('public');

    //     $user = User::create([
    //         'email' => 'profile@example.com',
    //         'username' => 'profileuser',
    //         'password' => Hash::make('secret'),
    //         'profilepic' => 'profile_pics/old.jpg',
    //     ]);

    //     Storage::disk('public')->put('profile_pics/old.jpg', 'old-content');

    //     $response = $this->actingAs($user)->post('/profile/update', [
    //         'nickname' => 'Updated Name',
    //         'description' => 'Updated description',
    //         'profilepic' => UploadedFile::fake()->image('newpic.jpg'),
    //     ]);

    //     $response->assertRedirect('/profile');
    //     $response->assertSessionHas('success', 'Profil berhasil diperbarui!');

    //     $user->refresh();
    //     $this->assertSame('Updated Name', $user->nickname);
    //     $this->assertSame('Updated description', $user->description);
    //     $this->assertStringStartsWith('profile_pics/', $user->profilepic);
    //     $this->assertFalse(Storage::disk('public')->exists('profile_pics/old.jpg'));
    //     $this->assertTrue(Storage::disk('public')->exists($user->profilepic));
    // }

    public function test_update_password_with_correct_old_password_updates_password()
    {
        $user = User::create([
            'email' => 'password@example.com',
            'username' => 'passworduser',
            'password' => Hash::make('oldpass'),
        ]);

        $response = $this->actingAs($user)->post('/profile/updatepassword', [
            'oldPassword' => 'oldpass',
            'newPassword' => 'newpass123',
            'confirmPassword' => 'newpass123',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('success', 'Password berhasil diperbarui!');

        $user->refresh();
        $this->assertTrue(Hash::check('newpass123', $user->password));
    }

    public function test_user_payment_methods_view_and_default_selection_work()
    {
        $user = User::create([
            'email' => 'payments@example.com',
            'username' => 'paymentsuser',
            'password' => Hash::make('secret'),
        ]);

        DB::table('payment_types')->insert([
            ['idPaymentType' => 1, 'paymentName' => 'Credit Card', 'created_at' => now(), 'updated_at' => now()],
            ['idPaymentType' => 2, 'paymentName' => 'E-Wallet', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $first = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => 1,
            'paymentDetails' => '1111',
        ]);

        $second = UserPaymentType::create([
            'idUser' => $user->idUser,
            'idPaymentType' => 2,
            'paymentDetails' => '2222',
        ]);

        $response = $this->actingAs($user)->get('/profile/paymentmethods');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post('/profile/paymentmethods/default', [
            'idUserPaymentType' => $second->idUserPaymentType,
        ]);

        $response->assertRedirect(route('paymentMethodsView'));
        $this->assertDatabaseHas('user_payment_types', [
            'idUserPaymentType' => $first->idUserPaymentType,
            'is_default' => 0,
        ]);
        $this->assertDatabaseHas('user_payment_types', [
            'idUserPaymentType' => $second->idUserPaymentType,
            'is_default' => 1,
        ]);
    }

    public function test_store_payment_method_adds_payment_method()
    {
        $user = User::create([
            'email' => 'newpayment@example.com',
            'username' => 'newpaymentuser',
            'password' => Hash::make('secret'),
        ]);

        DB::table('payment_types')->insert([
            'idPaymentType' => 5,
            'paymentName' => 'Bank Transfer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/profile/paymentmethods/store', [
            'idPaymentType' => 5,
            'paymentDetails' => '1234567890',
        ]);

        $response->assertRedirect(route('paymentMethodsView'));
        $this->assertDatabaseHas('user_payment_types', [
            'idUser' => $user->idUser,
            'idPaymentType' => 5,
            'paymentDetails' => '1234567890',
        ]);
    }

    public function test_logout_redirects_to_login()
    {
        $user = User::create([
            'email' => 'logout@example.com',
            'username' => 'logoutuser',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_store_owner_can_update_and_delete_store()
    {
        $user = User::create([
            'email' => 'ownerupdate@example.com',
            'username' => 'ownerupdate',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Original Store',
            'storeAddress' => 'Original Address',
            'storePic' => 'old_store.jpg',
        ]);

        $updateResponse = $this->actingAs($user)->put("/stores/{$store->idStore}", [
            'storeName' => 'Updated Store',
            'storeAddress' => 'Updated Address',
            'storeDesc' => 'Updated Description',
        ]);

        $updateResponse->assertRedirect(route('stores.showStore', $store->idStore));
        $this->assertDatabaseHas('stores', [
            'idStore' => $store->idStore,
            'storeName' => 'Updated Store',
            'storeAddress' => 'Updated Address',
        ]);

        $mock = Mockery::mock(StoreImageService::class);
        $mock->shouldReceive('deleteImage')->once()->with('old_store.jpg')->andReturn(true);
        $this->app->instance(StoreImageService::class, $mock);

        $deleteResponse = $this->actingAs($user)->delete("/stores/{$store->idStore}");
        $deleteResponse->assertRedirect(route('stores.listStore'));
        $this->assertDatabaseMissing('stores', [
            'idStore' => $store->idStore,
        ]);
    }

    public function test_item_owner_can_update_and_delete_item()
    {
        $user = User::create([
            'email' => 'itemowner@example.com',
            'username' => 'itemowner',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Item Store',
            'storeAddress' => 'Item Address',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Item One',
            'itemPrice' => 1000,
        ]);

        $updateResponse = $this->actingAs($user)->put("/items/{$item->idItem}", [
            'itemName' => 'Item One Updated',
            'itemPrice' => 2000,
        ]);

        $updateResponse->assertRedirect(route('stores.showStore', $store->idStore));
        $this->assertDatabaseHas('items', [
            'idItem' => $item->idItem,
            'itemName' => 'Item One Updated',
            'itemPrice' => 2000,
        ]);

        $deleteResponse = $this->actingAs($user)->delete("/items/{$item->idItem}");
        $deleteResponse->assertRedirect(route('stores.showStore', $store->idStore));
        $this->assertDatabaseMissing('items', [
            'idItem' => $item->idItem,
        ]);
    }

    public function test_browse_store_routes_return_pages()
    {
        $user = User::create([
            'email' => 'browse@example.com',
            'username' => 'browseuser',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Browse Store',
            'storeAddress' => 'Browse Address',
        ]);

        Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Browse Item',
            'itemPrice' => 500,
        ]);

        $listResponse = $this->actingAs($user)->get('/stores/browse');
        $listResponse->assertStatus(200);

        $detailResponse = $this->actingAs($user)->get("/stores/detail/{$store->idStore}");
        $detailResponse->assertStatus(200);
    }

    public function test_invoice_flow_routes_show_pay_and_cancel()
    {
        $storeOwner = User::create([
            'email' => 'ownerinvoice@example.com',
            'username' => 'ownerinvoice',
            'password' => Hash::make('secret'),
        ]);

        $restocker = User::create([
            'email' => 'restockerinvoice@example.com',
            'username' => 'restockerinvoice',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Invoice Store',
            'storeAddress' => 'Invoice Address',
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Invoice Item',
            'itemPrice' => 1000,
        ]);

        CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 2,
            'subTotal' => 2000,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 2000,
            'status' => 'unpaid',
        ]);

        DB::table('payment_types')->insert([
            'idPaymentType' => 10,
            'paymentName' => 'Cash',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $paymentMethod = UserPaymentType::create([
            'idUser' => $storeOwner->idUser,
            'idPaymentType' => 10,
            'paymentDetails' => 'CASH',
        ]);

        $showResponse = $this->actingAs($restocker)->get("/invoices/{$invoice->idInvoice}");
        $showResponse->assertStatus(200);

        $createdConfirmationResponse = $this->actingAs($restocker)->get("/invoices/{$invoice->idInvoice}/created");
        $createdConfirmationResponse->assertStatus(200);

        $payViewResponse = $this->actingAs($storeOwner)->get("/invoices/{$invoice->idInvoice}/pay");
        $payViewResponse->assertStatus(200);

        $payResponse = $this->actingAs($storeOwner)->post("/invoices/{$invoice->idInvoice}/pay", [
            'idUserPaymentType' => $paymentMethod->idUserPaymentType,
        ]);

        $payResponse->assertRedirect(route('invoices.paymentConfirmation', $invoice->idInvoice));
        $this->assertDatabaseHas('invoices', [
            'idInvoice' => $invoice->idInvoice,
            'status' => 'paid',
        ]);
        $this->assertDatabaseHas('payments', [
            'idInvoice' => $invoice->idInvoice,
            'amount' => 2000.00,
        ]);

        $cancelInvoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 1000,
            'status' => 'unpaid',
        ]);

        $cancelResponse = $this->actingAs($restocker)->delete("/invoices/{$cancelInvoice->idInvoice}");
        $cancelResponse->assertRedirect(route('invoices.index'));
        $this->assertDatabaseHas('invoices', [
            'idInvoice' => $cancelInvoice->idInvoice,
            'status' => 'cancelled',
        ]);
    }

    public function test_store_and_item_routes_render_views()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'storeview@example.com',
            'username' => 'storeview',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($user)
            ->get('/stores/create')
            ->assertStatus(200);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'View Store',
            'storeAddress' => 'View Address',
            'storePic' => null,
        ]);

        $this->actingAs($user)
            ->get('/stores')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get("/stores/{$store->idStore}")
            ->assertStatus(200);

        $this->actingAs($user)
            ->get("/stores/{$store->idStore}/edit")
            ->assertStatus(200);

        $this->actingAs($user)
            ->get("/stores/{$store->idStore}/items/create")
            ->assertStatus(200);
    }

    public function test_profile_and_payment_views_render_for_authenticated_user()
    {
        $user = User::create([
            'email' => 'profileview@example.com',
            'username' => 'profileview',
            'password' => Hash::make('secret'),
        ]);

        DB::table('payment_types')->insert([
            'idPaymentType' => 20,
            'paymentName' => 'Deposit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/profile')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/profile/edit')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/profile/changepassword')
            ->assertStatus(200);

        $this->actingAs($user)
            ->get('/profile/paymentmethods/new')
            ->assertStatus(200);
    }

    public function test_invoice_pages_render_for_authorized_users()
    {
        $storeOwner = User::create([
            'email' => 'invoiceviewowner@example.com',
            'username' => 'invoiceowner',
            'password' => Hash::make('secret'),
        ]);

        $restocker = User::create([
            'email' => 'invoiceviewrestocker@example.com',
            'username' => 'invoicerestocker',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Invoice View Store',
            'storeAddress' => 'Invoice Address',
            'storePic' => null,
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Invoice View Item',
            'itemPrice' => 500,
        ]);

        CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 3,
            'subTotal' => 1500,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 1500,
            'status' => 'unpaid',
        ]);

        DB::table('payment_types')->insert([
            'idPaymentType' => 30,
            'paymentName' => 'Invoice Pay',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $paymentMethod = UserPaymentType::create([
            'idUser' => $storeOwner->idUser,
            'idPaymentType' => 30,
            'paymentDetails' => 'INV-123',
        ]);

        $this->actingAs($restocker)
            ->get('/invoices')
            ->assertStatus(200);

        $this->actingAs($restocker)
            ->get("/invoices/{$invoice->idInvoice}")
            ->assertStatus(200);

        $this->actingAs($restocker)
            ->get("/invoices/{$invoice->idInvoice}/created")
            ->assertStatus(200);

        $this->actingAs($storeOwner)
            ->get("/invoices/{$invoice->idInvoice}/pay")
            ->assertStatus(200);

        $payResponse = $this->actingAs($storeOwner)->post("/invoices/{$invoice->idInvoice}/pay", [
            'idUserPaymentType' => $paymentMethod->idUserPaymentType,
        ]);

        $payResponse->assertRedirect(route('invoices.paymentConfirmation', $invoice->idInvoice));

        $this->actingAs($storeOwner)
            ->get("/invoices/{$invoice->idInvoice}/confirmation")
            ->assertStatus(200);

        $newCart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $this->actingAs($restocker)
            ->get("/carts/{$newCart->idCart}/create-invoice")
            ->assertStatus(200);
    }
}

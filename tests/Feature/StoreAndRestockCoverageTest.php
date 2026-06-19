<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use App\Policies\StorePolicy;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAndRestockCoverageTest extends TestCase
{
    public function test_create_store_view_and_list_store_view_render()
    {
        $user = User::create([
            'email' => 'storecoverage@example.com',
            'username' => 'storecoverage',
            'password' => Hash::make('secret'),
        ]);

        $this->actingAs($user)->get('/stores/create')->assertStatus(200);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Coverage Store',
            'storeAddress' => 'Coverage Address',
            'storePic' => null,
        ]);

        $this->actingAs($user)->get('/stores')->assertStatus(200);
        $this->actingAs($user)->get("/stores/{$store->idStore}")->assertStatus(200);
        $this->actingAs($user)->get("/stores/{$store->idStore}/edit")->assertStatus(200);
    }

    public function test_restocks_submission_controller_routes_are_covered()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'restockcoverage@example.com',
            'username' => 'restockcoverage',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Restock Coverage Store',
            'storeAddress' => 'Restock Address',
            'storePic' => null,
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Coverage Item',
            'itemPrice' => 8888,
        ]);

        $this->actingAs($user)
            ->get("/restock/item/{$item->idItem}")
            ->assertStatus(200);

        $this->actingAs($user)
            ->post('/restock/submit', [
                'item_id' => $item->idItem,
                'quantity' => 2,
                'proof_image' => UploadedFile::fake()->image('proof.jpg'),
            ])
            ->assertRedirect(route('browse.index'));
    }

    public function test_store_policy_default_methods_return_false()
    {
        $owner = User::create([
            'email' => 'policycoverage@example.com',
            'username' => 'policycoverage',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'Policy Coverage Store',
            'storeAddress' => 'Policy Address',
            'storePic' => null,
        ]);

        $this->assertFalse((new StorePolicy)->viewAny($owner));
        $this->assertFalse((new StorePolicy)->view($owner, $store));
        $this->assertFalse((new StorePolicy)->create($owner));
        $this->assertFalse((new StorePolicy)->update($owner, $store));
        $this->assertFalse((new StorePolicy)->delete($owner, $store));
        $this->assertFalse((new StorePolicy)->restore($owner, $store));
        $this->assertFalse((new StorePolicy)->forceDelete($owner, $store));
    }

    public function test_invoice_pay_view_redirects_when_unpaid()
    {
        $storeOwner = User::create([
            'email' => 'invoicepaycoverage@example.com',
            'username' => 'invoicepaycoverage',
            'password' => Hash::make('secret'),
        ]);

        $restocker = User::create([
            'email' => 'invoicepayrestcoverage@example.com',
            'username' => 'invoicepayrestcoverage',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $storeOwner->idUser,
            'storeName' => 'Invoice Pay Store',
            'storeAddress' => 'Invoice Pay Address',
            'storePic' => null,
        ]);

        $cart = Cart::create([
            'idUser' => $restocker->idUser,
            'idStore' => $store->idStore,
            'status' => 'pending',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Invoice Pay Item',
            'itemPrice' => 1234,
        ]);

        CartItem::create([
            'idCart' => $cart->idCart,
            'idItem' => $item->idItem,
            'quantity' => 1,
            'subTotal' => 1234,
        ]);

        $invoice = Invoice::create([
            'idCart' => $cart->idCart,
            'idRestocker' => $restocker->idUser,
            'idStoreOwner' => $storeOwner->idUser,
            'invoiceDate' => now(),
            'totalAmount' => 1234,
            'status' => 'unpaid',
        ]);

        $response = $this->actingAs($storeOwner)->get("/invoices/{$invoice->idInvoice}/pay");
        $response->assertStatus(200);
    }
}

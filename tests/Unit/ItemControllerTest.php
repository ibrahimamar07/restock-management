<?php

namespace Tests\Unit;

use App\Http\Controllers\ItemController;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    public function test_create_item_view_returns_view_for_store_owner()
    {
        $user = User::create([
            'email' => 'itemowner@example.test',
            'username' => 'itemowner',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Item Store',
            'storeAddress' => 'Address',
        ]);

        Auth::login($user);

        $controller = new ItemController();
        $response = $controller->createItemView($store);

        $this->assertSame('managemystore.additemstoreview', $response->getName());
    }

    public function test_add_item_creates_new_item_for_store()
    {
        $user = User::create([
            'email' => 'itemadd@example.test',
            'username' => 'itemadd',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Item Add Store',
            'storeAddress' => 'Address',
        ]);

        Auth::login($user);

        $request = new class extends ItemStoreRequest {
            public function validated($key = null, $default = null)
            {
                return [
                    'itemName' => 'Screwdriver',
                    'itemPrice' => '7.50',
                ];
            }
        };

        $controller = new ItemController();
        $response = $controller->addItem($request, $store);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('items', ['itemName' => 'Screwdriver']);
    }

    public function test_update_item_updates_item_data()
    {
        $user = User::create([
            'email' => 'itemupdate@example.test',
            'username' => 'itemupdate',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Item Update Store',
            'storeAddress' => 'Address',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Old Item',
            'itemPrice' => '9.00',
        ]);

        Auth::login($user);

        $request = new class extends ItemUpdateRequest {
            public function validated($key = null, $default = null)
            {
                return [
                    'itemName' => 'New Item',
                    'itemPrice' => '9.99',
                ];
            }
        };

        $controller = new ItemController();
        $response = $controller->updateItem($request, $item);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('items', ['itemName' => 'New Item']);
    }

    public function test_delete_item_removes_item_and_redirects()
    {
        $user = User::create([
            'email' => 'itemdelete@example.test',
            'username' => 'itemdelete',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Item Delete Store',
            'storeAddress' => 'Address',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Delete Me',
            'itemPrice' => '3.50',
        ]);

        Auth::login($user);

        $controller = new ItemController();
        $response = $controller->deleteItem($item);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseMissing('items', ['idItem' => $item->idItem]);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use App\Models\Item;

class StoreModelTest extends TestCase
{
    public function test_store_has_items()
    {
        $user = User::create([
            'email' => 'seller@example.test',
            'username' => 'seller1',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Corner Store',
            'storeAddress' => 'Corner st',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Nails',
            'itemPrice' => '1.50',
        ]);

        $this->assertCount(1, $store->items);
        $this->assertEquals('Nails', $store->items->first()->itemName);
    }
}

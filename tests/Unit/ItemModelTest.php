<?php

namespace Tests\Unit;

use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Tests\TestCase;

class ItemModelTest extends TestCase
{
    public function test_fillable_and_casts()
    {
        $item = new Item;

        $expectedFillable = ['idStore', 'itemName', 'itemPrice'];
        $this->assertEqualsCanonicalizing($expectedFillable, $item->getFillable());

        $casts = $item->getCasts();
        $this->assertArrayHasKey('itemPrice', $casts);
        $this->assertEquals('decimal:2', $casts['itemPrice']);
    }

    public function test_relationship_with_store_and_price_casting()
    {
        $user = User::create([
            'email' => 'u@example.test',
            'username' => 'u1',
            'password' => 'secret',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Toko A',
            'storeAddress' => 'Address',
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Screwdriver',
            'itemPrice' => '12.345',
        ]);

        $this->assertEquals('12.35', (string) $item->itemPrice);
        $this->assertEquals($store->idStore, $item->store->idStore);
    }
}

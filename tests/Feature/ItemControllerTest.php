<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;

class ItemControllerTest extends TestCase
{
    public function test_owner_can_add_item_successfully()
    {
        $user = User::create([
            'email' => 'owner_test@example.test',
            'username' => 'owner_test',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Owner Test Store',
            'storeAddress' => 'Addr',
        ]);

        $this->actingAs($user)
            ->post("/stores/{$store->idStore}/items", [
                'itemName' => 'TestItem',
                'itemPrice' => 100,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('items', [
            'itemName' => 'TestItem',
            'idStore' => $store->idStore,
        ]);
    }

    public function test_non_owner_cannot_add_item_for_store()
    {
        $owner = User::create([
            'email' => 'owner2_test@example.test',
            'username' => 'owner2_test',
            'password' => 'pw',
        ]);

        $other = User::create([
            'email' => 'other_test@example.test',
            'username' => 'other_test',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $owner->idUser,
            'storeName' => 'Owner2 Store',
            'storeAddress' => 'Addr',
        ]);

        $this->actingAs($other)
            ->post("/stores/{$store->idStore}/items", [
                'itemName' => 'ShouldFail',
                'itemPrice' => 100,
            ])
            ->assertStatus(403);
    }

    public function test_add_item_validation_fails_when_price_missing()
    {
        $user = User::create([
            'email' => 'owner3_test@example.test',
            'username' => 'owner3_test',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Owner3 Store',
            'storeAddress' => 'Addr',
        ]);

        $this->actingAs($user)
            ->from("/stores/{$store->idStore}/items/create")
            ->post("/stores/{$store->idStore}/items", [
                'itemName' => 'NoPriceItem',
            ])
            ->assertRedirect();

        $this->assertDatabaseMissing('items', [
            'itemName' => 'NoPriceItem',
        ]);
    }
}

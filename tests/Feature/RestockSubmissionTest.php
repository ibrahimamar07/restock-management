<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RestockSubmissionTest extends TestCase
{
    public function test_restocks_item_form_view_requires_authenticated_user()
    {
        $user = User::create([
            'email' => 'restockform@example.com',
            'username' => 'restockform',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Restock Store',
            'storeAddress' => 'Restock Address',
            'storePic' => null,
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Restock Item',
            'itemPrice' => 7500,
        ]);

        $response = $this->actingAs($user)->get("/restock/item/{$item->idItem}");
        $response->assertStatus(200);
    }

    public function test_restocks_submission_redirects_to_browse()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'submitrestock@example.com',
            'username' => 'submitrestock',
            'password' => Hash::make('secret'),
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Proof Store',
            'storeAddress' => 'Proof Address',
            'storePic' => null,
        ]);

        $item = Item::create([
            'idStore' => $store->idStore,
            'itemName' => 'Proof Item',
            'itemPrice' => 5000,
        ]);

        $response = $this->actingAs($user)->post('/restock/submit', [
            'item_id' => $item->idItem,
            'quantity' => 1,
            'proof_image' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response->assertRedirect(route('browse.index'));
    }
}

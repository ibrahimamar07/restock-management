<?php

// namespace Tests\Unit;

// use App\Models\Item;
// use App\Models\Store;
// use App\Models\User;
// use Illuminate\Support\Facades\Storage;
// use Tests\TestCase;

// class StoreModelTest extends TestCase
// {
//     public function test_store_has_items()
//     {
//         $user = User::create([
//             'email' => 'seller@example.test',
//             'username' => 'seller1',
//             'password' => 'pw',
//         ]);

//         $store = Store::create([
//             'idUser' => $user->idUser,
//             'storeName' => 'Corner Store',
//             'storeAddress' => 'Corner st',
//         ]);

//         $item = Item::create([
//             'idStore' => $store->idStore,
//             'itemName' => 'Nails',
//             'itemPrice' => '1.50',
//         ]);

//         $this->assertCount(1, $store->items);
//         $this->assertEquals('Nails', $store->items->first()->itemName);
//     }

//     public function test_store_pic_url_attribute_returns_local_storage_url()
//     {
//         Storage::fake('public');

//         $user = User::create([
//             'email' => 'storepic@example.test',
//             'username' => 'storepic1',
//             'password' => 'pw',
//         ]);

//         $store = Store::create([
//             'idUser' => $user->idUser,
//             'storeName' => 'Pic Store',
//             'storeAddress' => 'Pic Address',
//             'storePic' => 'example.jpg',
//         ]);

//         $this->assertStringContainsString('example.jpg', $store->storePicUrl);
//     }

//     public function test_store_pic_url_attribute_returns_supabase_url_when_bucket_is_set()
//     {
//         putenv('SUPABASE_URL=https://example.supabase.co');
//         putenv('SUPABASE_ANON_KEY=testkey');
//         putenv('SUPABASE_PROJECT_REF=testref');
//         putenv('SUPABASE_BUCKET=my-bucket');

//         $user = User::create([
//             'email' => 'storepic2@example.test',
//             'username' => 'storepic2',
//             'password' => 'pw',
//         ]);

//         $store = Store::create([
//             'idUser' => $user->idUser,
//             'storeName' => 'Supabase Store',
//             'storeAddress' => 'Supabase Address',
//             'storePic' => 'example.jpg',
//         ]);

//         $this->assertStringContainsString('my-bucket/storepic/example.jpg', $store->storePicUrl);
//         $this->assertStringStartsWith('https://', $store->storePicUrl);
//     }
// }

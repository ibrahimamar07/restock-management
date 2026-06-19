<?php

namespace Tests\Unit;

use App\Http\Controllers\StoreController;
use App\Http\Requests\Store\StoreRequest;
use App\Http\Requests\Store\UpdateRequest;
use App\Models\Store;
use App\Models\User;
use App\Services\StoreImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    public function test_list_store_returns_view_for_authenticated_user()
    {
        $user = User::create([
            'email' => 'owner1@example.test',
            'username' => 'owner1',
            'password' => 'pw',
        ]);

        Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Store One',
            'storeAddress' => 'Address 1',
        ]);

        Auth::login($user);

        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}
        });

        $response = $controller->listStore();

        $this->assertSame('managemystore.mystoreview', $response->getName());
        $this->assertArrayHasKey('stores', $response->getData());
    }

    public function test_create_store_view_returns_view()
    {
        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}
        });

        $response = $controller->createStoreView();

        $this->assertSame('managemystore.setupstoreview', $response->getName());
    }

    public function test_add_store_calls_image_service_and_creates_store()
    {
        Storage::fake('public');

        $user = User::create([
            'email' => 'owner2@example.test',
            'username' => 'owner2',
            'password' => 'pw',
        ]);

        Auth::login($user);

        $file = UploadedFile::fake()->image('store.jpg');
        $request = new class($file) extends StoreRequest
        {
            public function __construct(private UploadedFile $file) {}

            public function validated($key = null, $default = null)
            {
                return [
                    'storeName' => 'My Store',
                    'storeAddress' => 'My Address',
                ];
            }

            public function hasFile($key): bool
            {
                return $key === 'storePic';
            }

            public function file($key = null, $default = null)
            {
                return $this->file;
            }
        };

        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}

            public function saveImage(UploadedFile $file): string
            {
                return 'saved.jpg';
            }
        });

        $response = $controller->addStore($request);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('stores', [
            'storeName' => 'My Store',
            'storePic' => 'saved.jpg',
        ]);
    }

    public function test_edit_store_view_and_show_store_return_views()
    {
        $user = User::create([
            'email' => 'owner3@example.test',
            'username' => 'owner3',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Store Three',
            'storeAddress' => 'Address 3',
        ]);

        Auth::login($user);

        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}
        });

        $showResponse = $controller->showStore($store);
        $this->assertSame('managemystore.storedetailview', $showResponse->getName());

        $editResponse = $controller->editStoreView($store);
        $this->assertSame('managemystore.editstoreview', $editResponse->getName());
    }

    public function test_update_store_updates_record_without_new_image()
    {
        $user = User::create([
            'email' => 'owner4@example.test',
            'username' => 'owner4',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Store Four',
            'storeAddress' => 'Address 4',
            'storePic' => 'old.jpg',
        ]);

        Auth::login($user);

        $request = new class extends UpdateRequest
        {
            public function validated($key = null, $default = null)
            {
                return [
                    'storeName' => 'Updated Name',
                    'storeAddress' => 'Updated Address',
                ];
            }

            public function hasFile($key): bool
            {
                return false;
            }
        };

        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}
        });

        $response = $controller->updateStore($request, $store);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseHas('stores', ['idStore' => $store->idStore, 'storeName' => 'Updated Name']);
    }

    public function test_delete_store_removes_store()
    {
        $user = User::create([
            'email' => 'owner5@example.test',
            'username' => 'owner5',
            'password' => 'pw',
        ]);

        $store = Store::create([
            'idUser' => $user->idUser,
            'storeName' => 'Delete Store',
            'storeAddress' => 'Address 5',
            'storePic' => 'old.jpg',
        ]);

        Auth::login($user);

        $controller = new StoreController(new class extends StoreImageService
        {
            public function __construct() {}

            public function deleteImage(?string $imageName): bool
            {
                return true;
            }
        });

        $response = $controller->deleteStore($store);

        $this->assertSame(302, $response->getStatusCode());
        $this->assertDatabaseMissing('stores', ['idStore' => $store->idStore]);
    }
}

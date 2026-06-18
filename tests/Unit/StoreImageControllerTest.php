<?php

namespace Tests\Unit;

use App\Http\Controllers\StoreImageController;
use App\Services\StoreImageService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StoreImageControllerTest extends TestCase
{
    public function test_store_returns_json_with_name_and_url()
    {
        $file = UploadedFile::fake()->image('store.jpg');
        $request = Request::create('/store-image', 'POST');
        $request->files->set('image', $file);
        $request->setLaravelSession(session());

        $service = new class extends StoreImageService
        {
            public function __construct() {}

            public function saveImage(UploadedFile $file): string
            {
                return 'store.jpg';
            }

            public function getImageUrl(?string $imageName): ?string
            {
                return 'https://example.com/store.jpg';
            }
        };

        $controller = new StoreImageController;
        $response = $controller->store($request, $service);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('store.jpg', $response->getData(true)['name']);
        $this->assertSame('https://example.com/store.jpg', $response->getData(true)['url']);
    }

    public function test_destroy_returns_no_content()
    {
        $service = new class extends StoreImageService
        {
            public function __construct() {}

            public function deleteImage(?string $imageName): bool
            {
                return true;
            }
        };

        $controller = new StoreImageController;
        $response = $controller->destroy('store.jpg', $service);

        $this->assertSame(204, $response->getStatusCode());
    }
}

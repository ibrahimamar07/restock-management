<?php

namespace Tests\Unit;

use App\Services\StoreImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreImageServiceTest extends TestCase
{
    public function test_save_image_stores_file_and_returns_filename()
    {
        Storage::fake('public');

        $service = new StoreImageService();
        $file = UploadedFile::fake()->image('store.jpg');

        $fileName = $service->saveImage($file);

        $this->assertStringEndsWith('.jpg', $fileName);
        Storage::disk('public')->assertExists('storepic/'.$fileName);
    }

    public function test_delete_image_removes_existing_file_and_returns_true()
    {
        Storage::fake('public');

        $filename = 'existing.jpg';
        Storage::disk('public')->put('storepic/'.$filename, 'data');

        $service = new StoreImageService();
        $result = $service->deleteImage($filename);

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing('storepic/'.$filename);
    }

    public function test_delete_image_returns_false_when_file_missing()
    {
        Storage::fake('public');

        $service = new StoreImageService();
        $result = $service->deleteImage('missing.jpg');

        $this->assertFalse($result);
    }
}

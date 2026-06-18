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

        $service = new StoreImageService;
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

        $service = new StoreImageService;
        $result = $service->deleteImage($filename);

        $this->assertTrue($result);
        Storage::disk('public')->assertMissing('storepic/'.$filename);
    }

    public function test_delete_image_returns_false_when_file_missing()
    {
        Storage::fake('public');

        $service = new StoreImageService;
        $result = $service->deleteImage('missing.jpg');

        $this->assertFalse($result);
    }

    public function test_upload_contents_saves_file_and_returns_true()
    {
        Storage::fake('public');

        $service = new StoreImageService;
        $result = $service->uploadContents('hello world', 'storepic', 'upload-test.txt', 'text/plain');

        $this->assertTrue($result);
        Storage::disk('public')->assertExists('storepic/upload-test.txt');
    }

    public function test_move_from_storage_path_moves_temp_file_to_destination()
    {
        Storage::fake('public');
        Storage::disk('public')->put('temp/temp-file.txt', 'content');

        $service = new StoreImageService;
        $storedPath = $service->moveFromStoragePath('temp/temp-file.txt', 'storepic', true);

        $this->assertStringContainsString('temp-file.txt', $storedPath);
        $this->assertStringEndsWith('temp-file.txt', $storedPath);
        Storage::disk('public')->assertMissing('temp/temp-file.txt');
        Storage::disk('public')->assertExists('storepic/'.$storedPath);
    }
}

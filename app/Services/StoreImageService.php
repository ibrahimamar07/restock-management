<?php
// ibrahim amar alfanani 5026231195
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImageService
{
    protected $disk = 'public';
    protected $folder = 'storepic';

    /**
     * Menyimpan file gambar baru dan mengembalikan nama file unik.
     * @param UploadedFile $file
     * @return string Nama file yang tersimpan
     */
    public function saveImage(UploadedFile $file): string
    {
        // 1. Buat nama file unik
        $imageName = time() . '_' . uniqid() . '.' . $file->extension(); 
        
        // 2. Simpan file ke storage/app/public/storepic/
        $file->storeAs($this->folder, $imageName, $this->disk);

        return $imageName;
    }

    /**
     * Menghapus file gambar lama dari storage.
     * @param string|null $imageName Nama file yang akan dihapus
     * @return bool
     */
    public function deleteImage(?string $imageName): bool
    {
        if ($imageName) {
            $path = $this->folder . '/' . $imageName;
            
            // Cek apakah file ada sebelum menghapus untuk menghindari error
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->delete($path);
            }
        }
        return false;
    }
}
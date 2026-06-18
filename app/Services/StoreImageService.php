<?php

// ibrahim amar alfanani 5026231195

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreImageService
{
    protected $disk = 'public';

    protected $folder = 'storepic';

    protected ?SupabaseService $supabase = null;

    public function __construct(?SupabaseService $supabase = null)
    {
        $this->supabase = $supabase;
    }

    /**
     * Return public URL for an image.
     */
    public function getImageUrl(?string $imageName): ?string
    {
        if (! $imageName) {
            return null;
        }

        $path = $this->folder.'/'.$imageName;
        $bucket = env('SUPABASE_BUCKET');

        if ($bucket && $this->supabase) {
            return $this->supabase->getPublicUrl($bucket, $path);
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Menyimpan file gambar baru dan mengembalikan nama file unik.
     * Jika `SUPABASE_BUCKET` diset, file akan diupload ke Supabase Storage.
     *
     * @return string Nama file yang tersimpan
     */
    public function saveImage(UploadedFile $file): string
    {
        return $this->saveImageToFolder($file, $this->folder);
    }

    /**
     * Save uploaded file to a given folder (Supabase if configured, otherwise local public storage).
     * Returns the basename of the saved file.
     */
    public function saveImageToFolder(UploadedFile $file, string $folder): string
    {
        $imageName = time().'_'.uniqid().'.'.$file->extension();
        $bucket = env('SUPABASE_BUCKET');

        $path = trim($folder, '/').'/'.$imageName;

        $contents = file_get_contents($file->getRealPath());
        $contentType = $file->getClientMimeType() ?? 'application/octet-stream';

        if ($bucket && $this->supabase) {
            $ok = $this->supabase->uploadFile($bucket, $path, $contents, $contentType);
            if ($ok) {
                return $imageName;
            }
            // fallback to local if upload fails
        }

        // Save locally
        $file->storeAs($folder, $imageName, $this->disk);

        return $imageName;
    }

    /**
     * Upload raw contents to a folder with a given filename. Returns true on success.
     */
    public function uploadContents(string $contents, string $folder, string $filename, string $contentType = 'application/octet-stream'): bool
    {
        $bucket = env('SUPABASE_BUCKET');
        $path = trim($folder, '/').'/'.ltrim($filename, '/');

        if ($bucket && $this->supabase) {
            return $this->supabase->uploadFile($bucket, $path, $contents, $contentType);
        }

        // Save to local storage
        Storage::disk($this->disk)->put($path, $contents);

        return true;
    }

    /**
     * Move a file currently in public disk (storage/app/public) into final folder (upload to Supabase or keep local).
     * Returns the stored path to save into DB (for stores we keep basename, for other folders we return folder/filename).
     */
    public function moveFromStoragePath(string $storagePath, string $folder, bool $returnBasename = false): string
    {
        if (! Storage::disk($this->disk)->exists($storagePath)) {
            return '';
        }

        $contents = Storage::disk($this->disk)->get($storagePath);
        $contentType = Storage::disk($this->disk)->mimeType($storagePath) ?? 'application/octet-stream';
        $basename = uniqid().'_'.basename($storagePath);
        $targetFilename = $basename;
        $targetPath = trim($folder, '/').'/'.$targetFilename;

        $ok = $this->uploadContents($contents, $folder, $targetFilename, $contentType);

        // remove temp file
        Storage::disk($this->disk)->delete($storagePath);

        if ($ok) {
            return $returnBasename ? $basename : $targetPath;
        }

        return '';
    }

    /**
     * Menghapus file gambar lama dari storage.
     * Jika menggunakan Supabase, akan menghapus dari bucket.
     *
     * @param  string|null  $imageName  Nama file yang akan dihapus
     */
    public function deleteImage(?string $imageName): bool
    {
        if ($imageName) {
            $path = $this->folder.'/'.$imageName;

            $bucket = env('SUPABASE_BUCKET');
            if ($bucket && $this->supabase) {
                return $this->supabase->deleteFile($bucket, $path);
            }

            // Cek apakah file ada sebelum menghapus untuk menghindari error
            if (Storage::disk($this->disk)->exists($path)) {
                return Storage::disk($this->disk)->delete($path);
            }
        }

        return false;
    }
}

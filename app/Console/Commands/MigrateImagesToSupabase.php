<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use App\Models\User;
use App\Services\SupabaseService;
use App\Services\StoreImageService;
use GuzzleHttp\Client as HttpClient;

class MigrateImagesToSupabase extends Command
{
    protected $signature = 'migrate:images-to-supabase {--dry-run}';
    protected $description = 'Migrate existing images (store & user) to Supabase Storage and update DB paths.';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $bucket = env('SUPABASE_BUCKET');

        if (! $bucket) {
            $this->error('SUPABASE_BUCKET not configured in environment.');
            return 1;
        }

        $this->info('Starting migration to Supabase bucket: ' . $bucket);

        $supabase = app(SupabaseService::class);
        $imageService = app(StoreImageService::class);
        $http = new HttpClient(['http_errors' => false]);

        // Migrate stores
        $this->info('Migrating store images...');
        $stores = Store::whereNotNull('storePic')->get();
        foreach ($stores as $store) {
            $val = $store->storePic;
            // skip if already in supabase (we can't detect, but we will re-upload only if it's a URL or local path)
            if (preg_match('#^https?://#i', $val) || strpos($val, 'storage/') !== false || strpos($val, '/storage/') !== false) {
                $this->line("Processing store {$store->idStore}: {$val}");

                // get contents
                $contents = null;
                $mime = 'application/octet-stream';

                if (preg_match('#^https?://#i', $val)) {
                    $res = $http->get($val);
                    if ($res->getStatusCode() === 200) {
                        $contents = (string) $res->getBody();
                        $mime = $res->getHeaderLine('Content-Type') ?: $mime;
                    }
                } else {
                    // local storage path
                    $localPath = ltrim(preg_replace('#^/|^storage/#', '', $val), '/');
                    if (\Storage::disk('public')->exists($localPath)) {
                        $contents = \Storage::disk('public')->get($localPath);
                        $mime = \Storage::disk('public')->mimeType($localPath) ?: $mime;
                    }
                }

                if (! $contents) {
                    $this->warn("Could not read contents for store {$store->idStore}: {$val}");
                    continue;
                }

                $basename = uniqid().'_'.basename($val);
                $targetPath = 'storepic/' . $basename;

                $this->info("Uploading to {$targetPath}...");
                if (! $dry) {
                    $ok = $supabase->uploadFile($bucket, $targetPath, $contents, $mime);
                    if ($ok) {
                        // store only basename so existing code continues to work
                        $store->storePic = $basename;
                        $store->save();
                        $this->info("Updated store {$store->idStore} -> {$basename}");
                    } else {
                        $this->error("Upload failed for store {$store->idStore}");
                    }
                }
            }
        }

        // Migrate users
        $this->info('Migrating user profile images...');
        $users = User::whereNotNull('profilepic')->get();
        foreach ($users as $user) {
            $val = $user->profilepic;
            if (preg_match('#^https?://#i', $val) || strpos($val, 'storage/') !== false || strpos($val, '/storage/') !== false) {
                $this->line("Processing user {$user->idUser}: {$val}");
                $contents = null;
                $mime = 'application/octet-stream';

                if (preg_match('#^https?://#i', $val)) {
                    $res = $http->get($val);
                    if ($res->getStatusCode() === 200) {
                        $contents = (string) $res->getBody();
                        $mime = $res->getHeaderLine('Content-Type') ?: $mime;
                    }
                } else {
                    $localPath = ltrim(preg_replace('#^/|^storage/#', '', $val), '/');
                    if (\Storage::disk('public')->exists($localPath)) {
                        $contents = \Storage::disk('public')->get($localPath);
                        $mime = \Storage::disk('public')->mimeType($localPath) ?: $mime;
                    }
                }

                if (! $contents) {
                    $this->warn("Could not read contents for user {$user->idUser}: {$val}");
                    continue;
                }

                $basename = uniqid().'_'.basename($val);
                $targetPath = 'profile_pics/' . date('Y/m/d') . '/' . $basename;

                $this->info("Uploading to {$targetPath}...");
                if (! $dry) {
                    $ok = $supabase->uploadFile($bucket, $targetPath, $contents, $mime);
                    if ($ok) {
                        // store path 'profile_pics/...' so accessor will use it directly
                        $user->profilepic = $targetPath;
                        $user->save();
                        $this->info("Updated user {$user->idUser} -> {$targetPath}");
                    } else {
                        $this->error("Upload failed for user {$user->idUser}");
                    }
                }
            }
        }

        $this->info('Migration completed.');
        return 0;
    }
}

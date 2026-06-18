<?php

// ibrahim amar alfanani 5026231195

namespace App\Models;

use App\Services\SupabaseService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $primaryKey = 'idStore';

    protected $fillable = [
        'idUser',
        'storeName',
        'storeAddress',
        'storePic',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    // PERHATIKAN: Fungsi items cukup satu saja
    public function items()
    {
        return $this->hasMany(Item::class, 'idStore', 'idStore');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'idStore', 'idStore');
    }

    public function getStorePicUrlAttribute()
    {
        if (! $this->storePic) {
            return null;
        }

        // If the stored value is already a full URL (e.g., Azure blob URL), return it directly
        if (preg_match('#^https?://#i', $this->storePic)) {
            return $this->storePic;
        }

        // If the stored value already contains a path, use it as-is, otherwise prefix with storepic/
        $path = strpos($this->storePic, '/') !== false ? ltrim($this->storePic, '/') : 'storepic/'.ltrim($this->storePic, '/');
        $bucket = env('SUPABASE_BUCKET');

        if ($bucket) {
            $supabase = app(SupabaseService::class);

            return $supabase->getPublicUrl($bucket, $path);
        }

        return Storage::disk('public')->url($path);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
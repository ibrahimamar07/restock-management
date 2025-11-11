<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $primaryKey = 'idItem';

    protected $fillable = [
        'idStore',
        'itemName',
        'itemPrice',
    ];

    protected $casts = [
        'itemPrice' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'idStore', 'idStore');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'idItem', 'idItem');
    }
}


<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = 'idCartItem';

    protected $fillable = [
        'idCart',
        'idItem',
        'quantity',
        'subTotal',
    ];

    protected $casts = [
        'subTotal' => 'decimal:2',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'idCart', 'idCart');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'idItem', 'idItem');
    }
}
<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'idCart';

    protected $fillable = [
        'idUser',
        'idStore',
        'cartDate',
        'status',
        'restockProof',
    ];

    protected $casts = [
        'cartDate' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'idStore', 'idStore');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'idCart', 'idCart');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'idCart', 'idCart');
    }
}

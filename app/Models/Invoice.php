<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $primaryKey = 'idInvoice';

    protected $fillable = [
        'idCart',
        'idRestocker',
        'idStoreOwner',
        'invoiceDate',
        'totalAmount',
        'status',
    ];

    protected $casts = [
        'totalAmount' => 'decimal:2',
        'invoiceDate' => 'datetime',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'idCart', 'idCart');
    }

    public function restocker()
    {
        return $this->belongsTo(User::class, 'idRestocker', 'idUser');
    }

    public function storeOwner()
    {
        return $this->belongsTo(User::class, 'idStoreOwner', 'idUser');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'idInvoice', 'idInvoice');
    }
}
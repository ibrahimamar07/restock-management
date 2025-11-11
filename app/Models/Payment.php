<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'idPayment';

    protected $fillable = [
        'idInvoice',
        'idUserPaymentType',
        'amount',
        'paymentDate',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paymentDate' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'idInvoice', 'idInvoice');
    }

    public function userPaymentType()
    {
        return $this->belongsTo(UserPaymentType::class, 'idUserPaymentType', 'idUserPaymentType');
    }
}
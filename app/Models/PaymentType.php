<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'payment_types';
    protected $primaryKey = 'idPaymentType';

    protected $fillable = [
        'paymentName',
    ];

    public function userPaymentTypes()
    {
        return $this->hasMany(UserPaymentType::class, 'idPaymentType', 'idPaymentType');
    }
}
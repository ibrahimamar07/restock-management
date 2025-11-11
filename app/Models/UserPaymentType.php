<?php
// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentType extends Model
{
    use HasFactory;

    protected $table = 'user_payment_types';
    protected $primaryKey = 'idUserPaymentType';

    protected $fillable = [
        'idUser',
        'idPaymentType',
        'paymentDetails',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'idPaymentType', 'idPaymentType');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'idUserPaymentType', 'idUserPaymentType');
    }
}

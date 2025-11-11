<?php

// ibrahim amar alfanani 5026231195
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'idUser';

    protected $fillable = [
        'email',
        'username',
        'password',
        'nickname',
        'description',
        'profilepic',
    ];

    protected $hidden = [
        'password',
    ];

    public function stores()
    {
        return $this->hasMany(Store::class, 'idUser', 'idUser');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'idUser', 'idUser');
    }

    public function userPaymentTypes()
    {
        return $this->hasMany(UserPaymentType::class, 'idUser', 'idUser');
    }

    public function restockerInvoices()
    {
        return $this->hasMany(Invoice::class, 'idRestocker', 'idUser');
    }

    public function storeOwnerInvoices()
    {
        return $this->hasMany(Invoice::class, 'idStoreOwner', 'idUser');
    }
}
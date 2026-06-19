<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'item_id',
        'user_id',
        'content',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'idItem');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'idUser');
}
}

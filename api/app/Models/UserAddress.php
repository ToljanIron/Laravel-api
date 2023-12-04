<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'address_line_1',
        'state',
        'city',
        'zip',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

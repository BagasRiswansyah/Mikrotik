<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressListHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'domain_ip',
        'comment',
        'status',
        'user_id',
        'user_role'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'token', 'name'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

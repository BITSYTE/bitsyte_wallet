<?php

namespace App\Models;

use BlockCypher\Api\WalletGenerateAddressResponse;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'private', 'public', 'address', 'wif'
    ];

}

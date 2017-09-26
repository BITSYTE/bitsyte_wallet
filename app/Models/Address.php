<?php

namespace App\Models;

use BlockCypher\Api\WalletGenerateAddressResponse;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'private', 'public', 'address', 'wif'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

}

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

    /** @var array  */
    protected $hidden = [
        'id', 'user_id', 'wallet_id', 'updated_at', 'created_at'
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

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

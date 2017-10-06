<?php

namespace App\Models;

use BlockCypher\Api\WalletGenerateAddressResponse;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 *
 * @package App\Models
 */
class Address extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'private', 'public', 'address', 'wif'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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

    /**
     * Get related wallet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get related Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

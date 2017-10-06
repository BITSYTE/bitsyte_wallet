<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 *
 * @package App\Models
 */
class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'name'
    ];

    /** @var array  */
    protected $hidden = [
        'id', 'user_id', 'updated_at', 'created_at'
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
     * Relationship with Addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Add Address to Wallet
     *
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $this->addresses()->save($address);
    }

    /**
     * Get the related user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

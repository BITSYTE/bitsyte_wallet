<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     *
     * @var array
     */
    protected $fillable = [
        'token', 'name'
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

}

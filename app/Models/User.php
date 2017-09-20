<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token', 'confirmed',
        'confirmation_token',
        'id'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'confirmed' => 'boolean',
    ];

    /**
     * Set crypt version of password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Semantic relationship with devices
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    /**
     * verify if user have a email confirmation
     *
     * @return bool|mixed
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Relationship with wallets
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Relationship with Address
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Add wallet to User
     *
     * @param Wallet $wallet
     */
    public function addWallet(Wallet $wallet)
    {
        $this->wallets()->save($wallet);
    }

    /**
     * Add Address to User
     *
     * @param Address $address
     */
    public function addAddress(Address $address)
    {
        $this->addresses()->save($address);
    }
}

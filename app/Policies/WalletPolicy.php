<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the wallet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wallet  $wallet
     * @return mixed
     */
    public function view(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id;
    }

    /**
     * Determine whether the user can create wallets.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the wallet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wallet  $wallet
     * @return mixed
     */
    public function update(User $user, Wallet $wallet)
    {
        //
    }

    /**
     * Determine whether the user can delete the wallet.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wallet  $wallet
     * @return mixed
     */
    public function delete(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id;
    }

    /**
     * Determine whether the user can add address to the wallet.
     *
     * @param User $user
     * @param Wallet $wallet
     * @return bool
     */
    public function addAddress(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id;
    }
}

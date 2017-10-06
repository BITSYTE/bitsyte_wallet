<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 04/09/2017
 * Time: 19:48
 */

namespace App\Observers;


use App\Models\User;
use Keygen\Keygen;

class ConfirmationTokenObserver
{
    /**
     * generate token, This is used by new user notifications
     *
     * @param User $user
     */
    public function creating(User $user)
    {
        if (empty($user->confirmation_token)) {
            $user->confirmation_token = Keygen::token(20)->generate();
        }
    }
}
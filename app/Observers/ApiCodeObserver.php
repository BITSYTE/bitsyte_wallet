<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 04/09/2017
 * Time: 17:54
 */

namespace App\Observers;


use App\Models\User;
use Keygen\Keygen;

class ApiCodeObserver
{
    public function creating(User $user)
    {
        if(empty($user->api_token)) {
            $user->api_token = Keygen::token(60)->generate();
        }
    }
}
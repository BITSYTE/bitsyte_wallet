<?php

namespace App\Listeners;

use App\Notifications\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class RegisteredListener
 *
 * @package App\Listeners
 */
class RegisteredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        /** @var \App\Models\User $event */
        //$event->user->notify(new EmailVerification($event->user));
    }
}

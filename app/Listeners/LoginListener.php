<?php

namespace App\Listeners;

use App\Models\Device;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListener
{
    /**
     * @var Request
     */
    private $request;

    /**
     * Create the event listener.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $device = User::whereHas('devices',function($query) {
            $query->whereDeviceId($this->request);
        })->first();

        if (!$device) {

            $event->user->devices()->create($this->request->device);
        }

    }
}

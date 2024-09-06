<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // Log login details
        Log::info('User Logged In:', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'time' => now(),
        ]);
    }
}

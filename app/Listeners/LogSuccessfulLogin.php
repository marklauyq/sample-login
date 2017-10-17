<?php

namespace App\Listeners;

use App\RedisLog;
use App\RedisLogEntry;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        //
        $user = $event->user;
        $entry = new RedisLogEntry(Carbon::now(),RedisLogEntry::$ACTIVITY_LOGIN, RedisLogEntry::$STATUS_PASS);
        $redis = new RedisLog($user->id);
        $redis->push($entry->toArray());
        $redis->store();
    }
}

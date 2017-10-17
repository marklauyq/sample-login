<?php

namespace App\Listeners;

use App\RedisLog;
use App\RedisLogEntry;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;
        $entry = new RedisLogEntry(Carbon::now(),RedisLogEntry::$ACTIVITY_LOGOUT, RedisLogEntry::$STATUS_PASS);
        $redis = new RedisLog($user->id);
        $redis->push($entry->toArray());
        $redis->store();
    }
}

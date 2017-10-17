<?php

namespace App\Listeners;

use App\RedisLog;
use App\RedisLogEntry;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogRegisteredUser
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
        //
        $user = $event->user;
        $entry = new RedisLogEntry(Carbon::now(),RedisLogEntry::$ACTIVITY_REGISTER, RedisLogEntry::$STATUS_PASS);
        $redis = new RedisLog($user->id);
        $redis->push($entry->toArray());
        $redis->store();
    }
}

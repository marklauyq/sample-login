<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\RedisLog;
use App\RedisLogEntry;
use Carbon\Carbon;

class LogFailedLogin
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
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        if($user = $event->user){ // log failed event if the email is correct
            $entry = new RedisLogEntry(Carbon::now(),RedisLogEntry::$ACTIVITY_LOGIN, RedisLogEntry::$STATUS_FAIL);
            $redis = new RedisLog($user->id);
            $redis->push($entry->toArray());
            $redis->store();
        }
    }
}

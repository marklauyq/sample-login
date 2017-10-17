<?php

namespace App\Http\Controllers;

use App\RedisLog;
use Illuminate\Http\Request;
use App\RedisLogEntry;
use Carbon\Carbon;

use Auth;

class ApiController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        $entry = new RedisLogEntry(Carbon::now(),RedisLogEntry::$ACTIVITY_API_REQUEST, RedisLogEntry::$STATUS_PASS);
        $redis = new RedisLog($user->id);
        $redis->push($entry->toArray());
        $redis->store();

        $logs = new RedisLog($user->id);

        return response()->json($logs->getLogs());
    }
}

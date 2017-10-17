<?php

namespace App\Http\Controllers;

use App\RedisLog;
use Illuminate\Http\Request;
use Redis;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $logs = new RedisLog($user->id);

        return view('home', [
            'logs' => $logs->getLogs()
        ]);
    }
}

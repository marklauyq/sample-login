<?php

namespace App\Http\Controllers;

use App\RedisLog;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RedisLogEntry;
use Carbon\Carbon;
use App\User;

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


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function register(Request $request){
        $validation = $this->validator($request->all());

        if($validation->fails()) {
            return response()->json($validation->errors());
        }else{
            $data = $request->all();
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            event(new Registered($user));

            return response()->json($user);
        }
    }
}

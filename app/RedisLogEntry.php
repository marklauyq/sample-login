<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17/10/2017
 * Time: 9:13 PM
 */

namespace App;


use Carbon\Carbon;

class RedisLogEntry
{
    public static $ACTIVITY_REGISTER = 'Register';
    public static $ACTIVITY_LOGIN = 'Login';
    public static $ACTIVITY_API_REQUEST = 'API-Request';
    public static $ACTIVITY_LOGOUT = 'Logout';
    public static $ACTIVITY_LOGIN_FAIL = 'Logout';

    public static $STATUS_PASS = 'Pass';
    public static $STATUS_FAIL = 'Fail';

    private $datetime;
    private $activity;
    private $status;

    /**
     * RedisLogEntry constructor.
     * @param Carbon $datetime
     * @param String $activity
     * @param String $status
     */
    public function __construct(Carbon $datetime, $activity, $status)
    {
        $this->datetime = $datetime;
        $this->activity = $activity;
        $this->status   = $status;
    }

    /**
     * @return mixed
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param Carbon $datetime
     */
    public function setDatetime(Carbon $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return mixed
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param mixed $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function toArray(){
        return [
          'datetime'=> $this->datetime->toDateTimeString(),
          'activity'=> $this->activity,
          'status'=> $this->status,
        ];
    }
}
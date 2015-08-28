<?php //-->

namespace Modules;

use Resources\User;

class Auth
{
    /* Constants
    --------------------------------------------*/
    const AUTH_USER = 'PHP_AUTH_USER';
    const AUTH_PW = 'PHP_AUTH_PW';
    const AUTH_FIELD = 'username';

    /* Public Properties
    --------------------------------------------*/
    /* Protected Properties
    --------------------------------------------*/
    public static $errors = array(
        'AUTH_NO_CREDENTIALS' => 'no credentials found',
        'AUTH_INVALID_CREDENTIALS' => 'invalid credentials',
        'AUTH_NO_USER' => 'user not found',
        'ACTION_FORBIDDEN' => 'forbidden action'
    );

    /* Private Properties
    --------------------------------------------*/
    private static $user = null;

    /* Public Methods
    --------------------------------------------*/
    public static function setUser($user) {
        self::$user = $user;
    }

    public static function getUser() {
        return self::$user;
    }

    public static function check()
    {
        $server = Helper::getServer();

        // check required
        if(!isset($server[self::AUTH_USER]) || !isset($server[self::AUTH_PW])) {
            self::errorCode('AUTH_NO_CREDENTIALS');
        }

        $key = $server[self::AUTH_USER];
        $pass = $server[self::AUTH_PW];

        // validate and get id
        if(!self::validate($key, $pass)) {
            self::errorCode('AUTH_INVALID_CREDENTIALS');
        }

        // check if user exists
        $user = User::get(array(
            'filters' => array(
                self::AUTH_FIELD => $key)));

        // if deleted or not exists
        if(!$user) {
            self::errorCode('AUTH_NO_USER');
        }

        return $user;
    }

    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
    private static function errorCode($code)
    {   
        if(array_key_exists($code, self::$errors)) {
            // kill it!
            Helper::error($code, self::$errors[$code], true);
        }
    }

    private static function validate($key, $pass)
    {
        // pass is just a sha1 of key
        if(sha1($key) !== $pass) {
            return false;
        }

        return true;
    }
}
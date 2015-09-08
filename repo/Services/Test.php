<?php //-->

namespace Services;

use Resources\Test as T;
use Exception;
use Modules\Helper;
use Modules\Auth;
use Modules\JWT;
use Services\User;

class Test
{
    /* Constants
    --------------------------------------------*/
    /* Public Properties
    --------------------------------------------*/
    /* Protected Properties
    --------------------------------------------*/
    /* Private Properties
    --------------------------------------------*/
    /* Public Methods
    --------------------------------------------*/
    public static function __callStatic($name, $args)
    {   
        return T::$name(current($args), end($args));
    }

    // customed find
    public static function get($options) {
        $row = T::get($options);
        $row['NOTE'] = 'THIS IS A CUSTOM GET';

        return $row;
    }

    public static function sample()
    {
        $auth = Auth::getUser();

        $simple = User::get(26);

        $single = User::get(array(
            'filters' => array(
                'id' => 31)));

        $multi = User::find(array( 
            'filters' => array(
                'type' => 'publisher'),
            'fields' => ['id', 'email', 'name'],
            'sorts' => array('id' => 'desc'),
            'limits' => [0, 3]));

        $create = User::create(Helper::getJson());
        $update = User::update(
            Helper::getJson(),
            Helper::getSegment(0));

        $remove = User::remove(26);

        return array(
            'auth' => $auth,
            'create' => $create,
            'update' => $update,
            'remove' => $remove,
            'simple' => $simple,
            'single' => $single,
            'multi' => $multi,
            'param' => Helper::getParam('sample'),
            // 'json' => Helper::getJson(),
            'segment' => Helper::getSegment(1),
            'error' => false);
    }

    public static function jwt($options)
    {
        $token = Helper::getServer('HTTP_APPLICATION_AUTHORIZATION');

        $jwt = JWT::encode(array(
            "user" => array(
                'id' => '1', 
                'username' => 'admin')));

        try {   
            JWT::setLeeway(60);
            return $payload = JWT::decode($token);
        } catch (Exception $e) {  
            return $e->getMessage();        
        }
    }

    /* Protected Methods
    --------------------------------------------*/
    /* Private Methods
    --------------------------------------------*/
}
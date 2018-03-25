<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 22/03/18
 * Time: 10:02 AM
 */

namespace app\core\helpers;
use app\core\librarys\Session;

class Xtoken {
    public static function create () {
        $token = '';
        $token =  md5(uniqid(mt_rand(),true));
        Session::set('token',$token);
        return $token;
    }
    public static function validate (string $input_token): bool {
        return (Session::get('token') === $input_token);
    }
}
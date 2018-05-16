<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 23/04/18
 * Time: 11:28 AM
 */
declare(strict_types = 1);
namespace app\core\libs;

final class Cookie {
    private static $security;

    public function construct () {
        self::$security = (PROTOCOL=='http') ? false : true;
    }
    /**
     * @param string $name
     * @param $value
     * @param int $expiration
     */
    public final static function set (string $name, $value, int $expiration): void {
        setcookie($name, $value, time() + $expiration, '/','',false,true);
    }
    /**
     * @param string $name
     * @return mixed
     */
    public final static function get (string $name){
        if (isset($_COOKIE[$name])) return $_COOKIE[$name];
        return false;
    }
    /**
     * @param string $name
     * @return bool
     */
    public final static function exits (string $name): bool {
        return isset($_COOKIE[$name]);
    }
    /**
     * @param string $name
     * @return bool
     */
    public final static function destroy (string $name):bool {
        self::$security = (PROTOCOL=='http') ? false : true;
        return setcookie($name, '', 0, '/','',self::$security);
    }
}
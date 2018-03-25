<?php
/**
 * Created by PhpStorm.
 * Admin: chris
 * Date: 15/03/18
 * Time: 10:50 PM
 */

declare(strict_types = 1);
namespace app\core\librarys;

final class Session {
    // Inicia una sesión
    public static function start() {
        session_start();
    }
    // Obtiene los datos almacenados en una sesión
    public static function get (string $name) {
        if (!isset($_SESSION)) self::start(); return $_SESSION[$name];
    }
    // Crea una nueva sesión
    public static function set (string $name, $value) {
        if (!isset($_SESSION)) self::start(); $_SESSION[$name] = $value;
    }
    // Comprueba si existe la sesión indicada
    public static function exists (string $name):bool {
        if (!isset($_SESSION)) self::start(); return isset($_SESSION[$name]);
    }
    // Destruye una sesión
    public static function destroy () {
        if (!isset($_SESSION)) self::start(); session_destroy(); return self::class;
    }
    // Redirecciona a la ruta establecida (Usar como método encadenado en "destroy()")
    public static function redirect (string $path) {
        redirect($path);
    }
}
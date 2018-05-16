<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:05 PM
 */

declare(strict_types=1);
namespace app\core\libs;

final class Route {
    private static $controllers = array();
    /**
     * @param array $controllers
     */
    final public static function setRoutes(array $controllers) {
        self::$controllers = $controllers;
        self::processAddress();
    }
    // Procesado de la dirección
    private static function processAddress() {
        $url        = [];
        $url        = ( isset($_GET['url']) ) ? explode('/', clear_url(strtolower($_GET['url'])) ) : ['/'];
        $status     = false;
        $method     = null;
        foreach (self::$controllers as $route => $controller){
            $route = ($route == '/') ? $route : trim($route, '/');
            if ($route == $url[0]) {
                $status     = true;
                $method     = (count($url) > 1) ? $url[1] : '';
                self::loadMethod($method, $controller);
                break;
            }
        }
        if (!$status) View::create('errors.page-error-404');
    }
    // Método encargado de cargar el método del controlador especificado
    private static function loadMethod(string $method, string $controller) {
        $classController    = '';
        $classMethod        = '';
        $classCalled        = null;
        // Método por default o el enviado por el usuario
        $classMethod        = ($method == 'index' || $method == '') ? 'index' : $method;
        // Se le agrega el namespace correspondiente
        $classController    = '\app\controllers\\'.$controller;
        // Se instancia la clase dependiendo la petición
        $classCalled        = new $classController();
        // Verificar la existencia del método, si existe se llama
        if (method_exists($classCalled, $classMethod))
            $classCalled->$classMethod();
        else
            View::create('errors.page-error-404');
    }
}
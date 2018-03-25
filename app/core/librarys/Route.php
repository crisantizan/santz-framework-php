<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:05 PM
 */

declare(strict_types=1);
namespace app\core\librarys;

final class Route {
    private static $controllers = array();
    /**
     * @param array $controllers
     */
    final public static function setControllers(array $controllers) {
        self::$controllers = $controllers;
        self::submit();
    }

    private static function submit(){
        $url = isset($_GET['url']) ? clear_url(strtolower($_GET['url'])) : '/';
        $path = explode('/',$url);
        $controller=null;
        // Se verifica si el usuario no pidió ningún controlador
        if ($url == 'index.twig' || $url == '/' || $url == 'index.php'){
            // Se verifica si la llave del controlador principal "/" existe
            $path_exist = array_key_exists('/',self::$controllers);
            // Si existe se le asigna su valor a la variable $controller
            if ($path_exist == 1){
                $controller = self::$controllers['/'];
                // Se manda la informacion para ser verificada e incluir el controlador si existe
                self::getController('index', $controller);
            }else{
                die('No se ha pasado el controlador index, favor diríjase al archivo app/core/Routes.php');
            }
        }else{
            // Controladores | métodos específicos
            $status = false;
            $method=null;
            foreach (self::$controllers as $route => $nameController){
                if (trim($route,'/') == $path[0]){
                    $status = true;
                    $controller = $nameController;
                    $method = (count($path) > 1) ? $path[1] : null;
                    self::getController($method, $controller);
                }
            }
            if (!$status){
                die('Controlador no encontrado');
            }
        }
    }
    // Método encargado de obtener el controlador y su método
    private static function getController(string $method=null, string $controller){
        $ClassController = null;
        $methodController = null;
        $ClassTmp=null;
        // Método por default o el enviado por el usuario
        if ($method == 'index' || $method == null){
            $methodController = 'index';
        }else{
            $methodController = $method;
        }
        // Se le agrega el namespace correspondiente
        $ClassController = '\app\controllers\\'.$controller;
        // Se instancia la clase dependiendo la petición
        $ClassTmp = new $ClassController();
        // Verificar la existencia del método, si existe se llama
        if (method_exists($ClassTmp,$methodController)){
            $ClassTmp->$methodController();
        }else{
            echo 'Método no existe';
        }
    }
}
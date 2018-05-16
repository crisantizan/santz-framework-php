<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 11:21 PM
 */

use app\core\libs\Route;
// Añdir la ruta y el controlador que la procesará
Route::setRoutes([
    '/'         => 'MainController',
    '/index'    => 'MainController',
    '/user'     => 'UserController',
]);

<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 11:21 PM
 */

use app\core\librarys\Route;
Route::setControllers(array(
    '/'=>'MainController',
    '/user'=> 'UserController',
));

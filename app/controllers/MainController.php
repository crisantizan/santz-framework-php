<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 13/02/18
 * Time: 08:51 PM
 */

declare(strict_types = 1);
namespace app\controllers;
use app\core\librarys\View;
use app\core\helpers;

class MainController {
    public function index(){
        View::create('index',[
            'title' => 'Bienvenido',
            'message' => 'Bienvenido a la página principal <santz/framework>',
            //Descomentar para crear un token
            //'token' => helpers\Xtoken::create()
        ]);
    }
}

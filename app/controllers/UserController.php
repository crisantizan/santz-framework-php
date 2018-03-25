<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 13/02/18
 * Time: 10:06 PM
 */

declare(strict_types = 1);
namespace app\controllers;
use app\core\librarys\Session;
use app\core\librarys\View;
use app\models\User as UserModel;
use app\core\helpers\Xtoken;

class UserController extends UserModel {

    public function index(){
        View::create('user.index',[
            'title' => 'Página usuarios',
            'message' => 'Bienvenido a la página usuarios'
        ]);
    }

    public  function show () {
        View::create('user.show',[
            'title' => 'Página show',
            'message' => '¡Método "show" del contrador "UserController" cargado con éxito!'
        ]);
    }

}
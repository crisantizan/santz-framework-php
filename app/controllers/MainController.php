<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 13/02/18
 * Time: 08:51 PM
 */

declare(strict_types = 1);
namespace app\controllers;
use app\core\database\Jovi;
use app\core\libs\View;
use app\core\helpers;

class MainController extends Jovi {
    public function index() {
        $param = [
            'tipos_documentos' => ['nombre']
        ];
        $data = [];
//        $this->table = 'administradores';
//        $this->id = '1';
//        $this->direccion = 'VillaCoral';
//        $data = $this->create(UPDATE)->exec();
//        if ($data)
//            echo 'Datos modificados';
//        else
//            echo 'Error';
//        $this->close();
        $data = $this->select($param, JOIN_TYPE)
                     ->from('administradores')
                     ->join('tipos_documentos',['administradores.tipo_documento','tipos_documentos.id'])
                     ->where('administradores.tipo_documento','=','1')
                     ->get();
        dd($data);
//        View::create('index',[
//            'title' => 'Bienvenido',
//            'message' => 'Bienvenido a la página principal <santz/framework>',
//            //Descomentar para crear un token
//            //'token' => helpers\Xtoken::create()
//        ]);
    }
}

<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 15/02/18
 * Time: 03:39 PM
 */

namespace app\models;
use app\core\orm\Model;

class User extends Model {
    /*El nombre de la tabla al cual se harán las consultas, debe coincidir
    con el que se colocó en la base de datos*/
    protected static $table = 'matricula';
}
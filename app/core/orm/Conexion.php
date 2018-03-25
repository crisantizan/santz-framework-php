<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:07 PM
 */

namespace app\core\orm;

class Conexion {

    private static $db_data=array();

    protected static function connect(){
        // Método que retornará la conexión a la base de datos
        self::$db_data = require_once (CONFIG_PATH.'db_data.php');
        try{
            $dsn = 'mysql:host='.self::$db_data['db_host'].'; dbname='.self::$db_data['db_name'].'; charset='.self::$db_data['db_charset'];
            $conn = new \PDO($dsn,self::$db_data['db_user'],self::$db_data['db_pass'],self::$db_data['db_options']);
            $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
}

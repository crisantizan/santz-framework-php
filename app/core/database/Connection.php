<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:07 PM
 */

namespace app\core\database;

class Connection {
    // Método que retornará la conexión a la base de datos
    protected static function connect(){
        $db = require_once (CONFIG_PATH.'db_data.php');
        try{
            $dsn    = 'mysql:host='.$db::$host.'; dbname='.$db::$name.'; charset='.$db::$charset;
            $conn   = new \PDO($dsn,$db::$user,$db::$pass,$db::$options);
            $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e){
            return $e->getMessage();
        }
    }
}
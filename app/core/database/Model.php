<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:09 PM
 */

namespace app\core\database;

class Model extends Connection {
    protected static $conn;
    private $data = array();
    // Recibe las propiedades creadas y las almacena
    public function __construct() {
        try {
            self::$conn = parent::connect();
        } catch (\PDOException $PDOException) {
            echo $PDOException;
        }
    }
    // Método mágico para obtener propiedades (No necesita ser llamado)
    public function __get($name) {
        return $this->data[$name];
    }
    // Método mágico para crear propiedades (No necesita ser llamado)
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    // Retorna la información recibida para ser usada en el ORM
    protected function getColumns() {
        return $this->data;
    }
    // Método mágico que destruye la información del arreglo
    public function __destruct() {
        unset($this->data);
    }
}
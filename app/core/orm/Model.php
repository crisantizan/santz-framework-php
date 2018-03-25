<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:09 PM
 */

namespace app\core\orm;
use app\core\orm\Espectre;

class Model extends Espectre {
    private $data = array();
    protected static $table;
    // Recibe las propiedades creadas y las almacena
    public function __construct($data = null) {
        parent::__construct();
        $this->data = $data;
    }
    // Retorna la información recibida para ser usada en el ORM
    public function getColumns() {
        return $this->data;
    }
    // Método mágico para obtener propiedades (No necesita ser llamado)
    public function __get($name) {
        return $this->data[$name];
    }
    // Método mágico para crear propiedades (No necesita ser llamado)
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    // Método mágico que destruye la información del arreglo
    public function __destruct() {
        unset($this->data);
    }
}
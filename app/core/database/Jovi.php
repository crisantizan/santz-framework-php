<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:08 PM
 */

declare(strict_types = 1);
namespace app\core\database;
use Couchbase\Exception;

error_reporting(E_ALL ^ E_NOTICE);
class Jovi extends Model {
    private $stmt;
    private $query;
    private $parameters  = array();

    /**
     * @param array $data
     * @param bool $joinType
     * @return object
     */
    public function select(array $data, bool $joinType = false):object {
        $this->query ="SELECT ";
        if (!$joinType) {
            foreach ($data as $column)
                $this->query.="$column, ";
        } else {
            foreach ($data as $table => $columns){
                foreach ($columns as $column)
                    $this->query.="{$table}.{$column} as {$column}_{$table}, ";
            }
        }
        $this->query = substr($this->query,0,-2);
        return $this;
    }
    /**
     * @param string $table
     * @return object
     */
    public function from (string $table):object {
        $this->query.=" FROM {$table}"; return $this;
    }
    /**
     * @param string $table
     * @param array $rowId
     * @return $this
     */
    public function join(string $table, array $rowId):object {
        $this->query.=" INNER JOIN {$table} ON {$rowId[0]} = {$rowId[1]}";
        return $this;
    }
    public function where(string $column, string $operator, string $value) {
        $this->condition('WHERE', $column, $operator, $value);
        return $this;
    }
    public function and (string $column, string $operator, string $value) {
        $this->condition('AND', $column, $operator, $value);
        return $this;
    }
    public function or (string $column, string $operator, string $value) {
        $this->condition('OR', $column, $operator, $value);
        return $this;
    }
    private function condition (string $typeCondition,string $column, string $operator, string $value) {
        $marker = '';
        $marker = $this->marker($column);
        $value = ($operator == 'like') ? '%'.$value.'%' : $value;
        $this->addParam($marker, $value);
        $this->query.=" {$typeCondition} {$column} {$operator} {$marker}";
    }
    public function limit (int $limit) {
        $this->query.=" LIMIT {$limit};";
        return $this;
    }
    // Prepara la query que en el momento se quiere ejecutar
    private function prepare () {
        $this->stmt=self::$conn->prepare($this->query);
        $this->each();
    }
    public function exec () {
        $this->prepare();
        return $this->stmt->execute();
    }
    private function fetchAll () {
        return $this->stmt->fetchAll();
    }
    public function get () {
        if ($this->exec())
            return $this->fetchAll();
        else
            return null;
    }
    // Método para agregar los valores correspondiente a las llaves del query
    private function each(){
        foreach ($this->parameters as $marker => $value)
            $this->bind($marker, $value);
    }
    // Agrega los respectivos valores a los marcadores pasados
    /**
     * @param string $marker
     * @param $value
     */
    private function bind (string $marker, $value) {
        $this->stmt->bindParam($marker, $value);
    }
    // Va agregando los parámetros a un arreglo común
    /**
     * @param string $marker
     * @param string $value
     */
    private function addParam(string $marker, $value){
        $this->parameters[$marker] = $value;
    }
    private function marker (string $column) {
        $tmp = str_replace('.','',$column);
        return ":{$tmp}";
    }
    /* Método para insertar o editar segun lo pida el usuario (true para actualizar;
     false, o sin parámetros para crear */
    /**
     * @param int|null $type
     * @return $this
     */
    public function create(int $type = 0):object {
        $values = $this->getColumns();
        $params=null; $columns=null;
        foreach ($values as $key => $value) {
            if ($value !== null && !is_integer($key) && $value !== '' && strpos($key, 'obj_') === false && $key !== 'id' && $key !== 'table') {
                $this->addParam($key, $value);
            }
        }
        $columns = array_keys($this->parameters);
        if ($type === 0){
            $params = join(', :', $columns);
            $params = $this->marker($params);
            $columns = join(', ', $columns);
            $this->query = "INSERT INTO ".$this->table." ({$columns}) VALUES ({$params});";
        }else if($type === 1){
            foreach ($columns as $column){
                $params.= $column.' = '. $this->marker($column).', ';
            }
            $params = trim($params,', ');
            $this->query = "UPDATE ".$this->table." SET {$params} WHERE id = {$this->id};";
        }
        return $this;
    }
    // Método para crear una autenticación tipo login
    /**
     * @param string $column_unique
     * @param string $value
     * @param array $password
     * @return array|null
     */
    public function loginAuth(string $column_unique, string $value, array $password) {
        $data                   = array();
        $column_name_password   = $password[0];
        $password_user          = $password[1];
        $password_db            = null;
        $this->query = "SELECT * FROM ".$this->table. " WHERE {$column_unique} = :{$column_unique} LIMIT 1;";
        $this->prepare();
        $this->bind($column_unique, $value);
        $this->stmt->execute();
        $data = $this->stmt->fetch();
        if ($data){
            $password_db = $data->$column_name_password;
            return ['entry' => password_verify($password_user,$password_db), 'data' => $data];
        }else{
            return null;
        }
    }
    /**
     * @param string $column_unique
     * @param string $value
     * @return bool
     * @throws \Exception
     */
    public function rowExists(string $column_unique, string $value){
        $this->query = "SELECT {$column_unique} FROM ".$this->table." WHERE {$column_unique} = :{$column_unique};";
        $this->prepare();
        $this->bind($column_unique, $value);
        if ($this->stmt->execute()) {
            if ($this->stmt->fetch()) return true; else return false;
        }else{
            throw new \Exception();
        }
    }
    // Busca toda la información de cierta columna por su id
    /**
     * @param int $id
     * @return object
     */
    public function findId(int $id=0):object {
        $id = ($id == 0) ? $this->id : $id;
        $this->query = "SELECT * FROM ".$this->table." WHERE id = :id LIMIT 1;";
        $this->prepare();
        $this->bind('id',$id,\PDO::PARAM_INT);
        $this->execute();
        return $this->stmt->fetch();
    }
    // Busca todos los datos de una tabla
    /**
     * @return array
     */
    public function findAll():array {
        $this->query = 'SELECT * FROM '.$this->table. ';';
        $this->stmt = self::$conn->query($this->query);
        return $this->stmt->fetchAll();
    }
    // Metodo para eliminar registros
    /**
     * @return bool
     */
    public function destroy():bool {
        $this->query="DELETE FROM ".$this->table ." WHERE id = :id;";
        $this->prepare();
        $this->bind('id', $this->id, \PDO::PARAM_INT);
        return $this->stmt->execute();
    }
    // Liberar memoria
    public function close() {
        $this->stmt->closeCursor();
        $this->query    = null;
        self::$conn     = null;
        $this->parameters = [];
    }
}
<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:08 PM
 */

declare(strict_types = 1);
namespace app\core\orm;
use app\core\orm\Conexion;
use Couchbase\Exception;

error_reporting(E_ALL ^ E_NOTICE);
class Espectre extends Conexion {
    private static $conn;
    private static $table;
    private $stmt = null;
    private $query = null;
    private $count = 0;
    private $paramJoin = array();
    // Se obtiene la conexión al momento de instanciar la clase
    public function __construct() {
        self::$conn = Conexion::connect();
    }
    /**
     * @param array $data
     * @return object
     */
    public function select(array $data):object {
        $this->query ="SELECT ";
        foreach ($data as $key => $value){
            foreach ($value as $llave){
                $this->query.="{$key}.{$llave} as {$llave}_{$key}, ";
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
     * @return object
     */
    public function join(string $table, array $rowId):object {
        $this->query.=" INNER JOIN {$table} ON {$rowId[0]} = {$rowId[1]}";
        return $this;
    }

    /**
     * @param string $param
     * @param string $value
     * @param bool $condition
     * @return $this
     */
    public function whereJoin(string $param, string $value, bool $condition=false) {
        $this->array_add($this->quit($param), $value);
        $paramP = $this->quit($param);
        $this->query.=" WHERE {$param} = {$paramP}";
        if (!$condition) {
            $this->stmt = self::$conn->prepare($this->query);
            $this->stmt->bindParam($paramP,$value);
        }
        return $this;
    }

    /**
     * @param string $type
     * @param string $param
     * @param string $value
     * @return object
     */
    public function conditionJoin(string $type, string $param, string $value):object {
        $this->query.=" {$type} {$param} = {$this->quit($param)}";
        $this->array_add($this->quit($param), $value);
        $this->stmt = self::$conn->prepare($this->query);
        foreach ($this->paramJoin as $param){
            echo $param['column'] .' '. $param['value'] . '<br>';
            $this->stmt->bindParam($param['column'],$param['value']);
        }
        $this->stmt->execute();return $this->stmt->fetch();
        return $this;
    }
    /* Método para insertar o editar segun lo pida el usuario (true para actualizar;
     false, o sin parámetros para crear */
    /**
     * @param int|null $type
     * @return $this
     */
    public function create(int $type=null):object {
        $values = $this->getColumns();
        $filtered = null; $params=null; $columns=null;
        foreach ($values as $key => $value) {
            if ($value !== null && !is_integer($key) && $value !== '' && strpos($key, 'obj_') === false && $key !== 'id') {
                if ($value === false) {
                    $value = 0;
                }
                $filtered[$key] = $value;
            }
        }
        $columns = array_keys($filtered);
        if ($type === null || $type === 0){
            $params = join(', :', $columns);
            $params =':'.$params;
            $columns = join(', ', $columns);
            $this->query = "INSERT INTO ".static::$table." ({$columns}) VALUES ({$params});";
        }else if($type === 1){
            foreach ($columns as $column){
                $params.= $column.' = :'.$column.', ';
            }
            $params = trim($params,', ');
            $this->query = "UPDATE ".static::$table." SET {$params} WHERE id = :id;";
        }
        $this->prepare();
        if($type == 1) $this->bind('id', $this->id, \PDO::PARAM_INT);
        $this->each($filtered);
        return $this;
    }

    // Método para crear una autenticación tipo login
    /**
     * @param string $column_unique
     * @param string $value
     * @param array $password
     * @return bool
     */
    public function loginAuth(string $column_unique, string $value, array $password) {
        $data = array();
        $column_name_password = $password[0];
        $password_user = $password[1];
        $password_db = null;
        $this->query = "SELECT * FROM ".static::$table. " WHERE {$column_unique} = :{$column_unique} LIMIT 1;";
        $this->prepare();
        $this->bind($column_unique, $value);
        $this->stmt->execute();
        $data = $this->stmt->fetch();
        if ($data){
            $password_db = $data->$column_name_password;
            return password_verify($password_user,$password_db);
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
        $this->query = "SELECT {$column_unique} FROM ".static::$table." WHERE {$column_unique} = :{$column_unique};";
        $this->prepare();
        $this->bind($column_unique, $value);
        if ($this->stmt->execute()){
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
        $this->query = "SELECT * FROM ".static::$table. " WHERE id = :id LIMIT 1;";
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
        $this->query = 'SELECT * FROM '.static::$table. ';';
        $this->stmt = self::$conn->query($this->query);
        return $this->stmt->fetchAll();
    }

    // Metodo para eliminar registros
    /**
     * @return bool
     */
    public function destroy():bool {
        $this->query="DELETE FROM ".static::$table ." WHERE id = :id;";
        $this->prepare();
        $this->bind('id', $this->id, \PDO::PARAM_INT);
        return $this->stmt->execute();
    }

    // Método para agregar una cláusla WHERE al query
    /**
     * @param string $column
     * @param string $value
     * @param string $operator
     * @param bool $continue
     * @return object
     */
    public function where(string  $column, string $operator, $value, bool $continue=false):object {
        $operator = strtolower($operator);
            $this->query = "SELECT * FROM ". static ::$table ." WHERE ".$column." {$operator} :".$column;
            if (!$continue){
                $this->prepare();
                if ($operator === '=')
                    $this->bind($column, $value);
                else if ($operator === 'like')
                    $value = '%'.$value.'%';
                    $this->bind($column, $value);
            }else{
                if ($operator === 'like') $this->array_add($column,'%'.$value.'%');
                else $this->array_add($column,$value);
            }
        return $this;
    }

    // Método para agregar cláusulas AND, OR etcétera
    /**
     * @param string $clausule
     * @param string $column
     * @param string $operator
     * @param $value
     * @param int $limit
     * @return object
     */
    public function clausule (string $clausule, string $column, string $operator, $value, int $limit=0): object{
        $operator = strtolower($operator);
        $limitStr = ($limit != 0) ? "LIMIT {$limit}" : '';
        switch ($operator){
            case '=':
                $this->array_add($column,$value);
                $this->query .= " {$clausule} {$column} {$operator} :{$column} {$limitStr}";
                $this->prepare();
                $this->each($this->paramJoin,true);
                break;
            case 'like':
                $this->array_add($column,'%'.$value.'%');
                $this->query .= " {$clausule} {$column} {$operator} :{$column} {$limitStr}";
                $this->prepare();
                $this->each($this->paramJoin,true);
                break;
        }
        return $this;
    }

    // Método para agregar los valores correspondiente a las llaves del query
    /**
     * @param array $array
     * @param bool $orState
     */
    private function each(array $array, bool $orState=false){
        switch ($orState) {
            case true:
                foreach ($array as $key)
                    $this->bind($key['column'],$key['value']);
                break;
            case false:
                foreach ($array as $key => &$value)
                    $this->bind($key,$value);
                break;
        }
    }

    // Prepara la query que en el momento se quiere ejecutar
    private function prepare () {
        $this->stmt=self::$conn->prepare($this->query);
    }

    // Agrega los respectivos valores a los marcadores pasados
    /**
     * @param string $mark
     * @param $value
     * @param int $type
     */
    private function bind (string $mark, $value, int $type=0) {
        $mark = $this->quit($mark);
        if ($type ==0) $this->stmt->bindParam($mark, $value);
        else $this->stmt->bindParam($mark, $value,$type);
    }

    // Ejecuta la consulta que en el momento se requiera
    private function execute () {
        $this->stmt->execute();
    }

    // Retorna verdadero, falso; o una instancia de la clase según sea el caso
    /**
     * @param bool $execute
     * @return $this
     */
    public function save (bool $execute = false) {
        switch ($execute){
            case true:
                if ($this->stmt->execute()) return $this;
                break;
            case false:
                return $this->stmt->execute();
                break;
        }
    }

    // Método para obtener todas las columnas de la consulta
    /**
     * @return array
     */
    protected function getAll (): array {
        if ($this->save()) return $this->stmt->fetchAll(); else return [null];
    }

    // Método para obtener una columna de la consulta
    /**
     * @return array
     */
    public function get() {
        if ($this->save()) return $this->stmt->fetch(); else return [null];
    }

    /* --------------------------Metodos de ayuda-------------------------- */
    // Quita el punto, agrega dos al inicio y retornar un string
    /**
     * @param string $value
     * @return string
     */
    private function quit (string $value): string {
        $var = explode('.',$value);
        return ':'.$var[0].$var[1];
    }

    // Va agregando los parámetros a un arreglo común
    /**
     * @param string $column
     * @param string $value
     */
    private function array_add(string $column, $value){
        array_push($this->paramJoin, ['column'=>$column,'value'=>$value]);
    }

    // Liberar memoria
    public function close() {
        $this->stmt->closeCursor();
        $this->query=null;
        self::$conn=null;
    }
}
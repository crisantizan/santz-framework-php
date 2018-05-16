<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 15/02/18
 * Time: 03:59 PM
 */

declare(strict_types = 1);
use app\core\libs\Session;
/* ----------Función que permite encriptar datos---------- */
/**
 * @param string $password cadena a encriptar
 * @return string
 */
function encrypt_pass (string $password):string {
    return password_hash($password,PASSWORD_DEFAULT);
}
/* ----------Limpia url de carácteres extraños---------- */
/**
 * @param string $string cadena a limpiar
 * @return mixed
 */
function clear_url (string $string):string {
    return str_replace(
        ['á','é','í','ó','ú','Á','É','Í','Ó','Ú','ä','ë','ï','ö','ü','Ä','Ë','Ï','Ö','Ü',' ',',',';',':','','^','(',')','%','#','!','¿','¡','°','|','"','\'','<','>','=','´','¨','*','~','+','{','}','[',']','_','-'],
        ['a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u'],
        $string
    );
}
/* ----------Función que retornará la ruta completa de la clase---------- */
/**
 * @param object $class
 * @return string
 */
function get_path_class (object $class): string {
    return URL_BASE . str_replace('\\','/', get_class($class)) . '/';
    //return array_pop(explode('\\',get_class($class)));
}

/* ----------Función para escapar carácteres introducidos por el usuario---------- */
/**
 * @param $name
 * @return string
 */
function input ($name):string {
    $name = $_REQUEST[$name];
    $name = trim($name);
    $name = stripcslashes($name);
    $name = htmlspecialchars($name);
    return $name;
}
/* Función para redireccionar a una página en específico */
/**
 * @param string $path
 */
function redirect (string $path) {
    header('Location:'.$path);
}
/* Verifica si algún parámetro es vacío */
/**
 * @param string ...$inputs
 * @return bool
 */
function anyIsEmpty (string ...$inputs):bool {
    foreach ($inputs as $input) {
        if ( empty($input) ) return true;
    }
    return false;
}
// Devuelve el nombre de tipo de usuario de acuerdo al id del mismo
/**
 * @param int $idUserType
 * @return string
 */
function userType (int $idUserType): string {
    $userType = '';
    switch ($idUserType) {
        case 1:
            $userType   = 'Administrator';
            break;
        case 2:
            $userType   = 'Secretary';
            break;
        case 3:
            $userType   = 'Teacher';
            break;
        case 4:
            $userType   = 'Student';
            break;
    }
    return $userType;
}
// Función para subir imágenes
/**
 * @param string $input
 * @return string
 */
function uploader (string $input): string {
    $message = [
        'status'    => false,
        'error'     => []
    ];
    if (isset($_FILES[$input])) {
        $file               = $_FILES[$input]['tmp_name'];
        $type               = strtolower(pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION));
        $acceptedFormats    = ['jpg','png','jpeg'];
        $size               = $_FILES[$input]['size'];
        $userType           = userType(intval(Session::get('user')->rango));
        $folder             = RESOURCES_PATH.'images/users/'.$userType.'/id_'.Session::get('user')->id;
        $route              = $folder.'/profile-image.'.$type;

        foreach ($acceptedFormats as $format) {
            if ($format == $type){
                $message['status'] = true;
                break;
            }
        }

        if (!$message['status']){
            $message['error']['title']          = '¡Archivo no soportado!';
            $message['error']['description']    = 'Solo se admiten imágenes en formatos JPG, PNG, JPEG';
            return json_encode($message);
        }

        if ($size > 2000000){
            $message['status'] = false;
            $message['error']['title']          = '¡Archivo muy grande!';
            $message['error']['description']    = 'Su imagen no debe pesar más de 2MB';
            return json_encode($message);
        }

        if ( !file_exists($folder) )
            $message['status'] = mkdir($folder,0777,true);

        if ($message['status'])
            $status = move_uploaded_file($file, $route);

        if (!$message['status']){
            $message['error']['title']          = '¡Error al subir imagen!';
            $message['error']['description']    = 'No se ha podido subir su imagen, por favor inténtelo de nuevo';
            return json_encode($message);
        }
    }
    return json_encode($message);
}
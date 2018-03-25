<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 15/02/18
 * Time: 03:59 PM
 */

/* ----------Función que permite encriptar datos---------- */
/**
 * @param string $password cadena a encriptar
 * @return void
 */
function encrypt_pass (string $password) {
    return password_hash($password,PASSWORD_DEFAULT);
}
/* ----------Limpia url de carácteres extraños---------- */
/**
 * @param string $string cadena a limpiar
 * @return mixed
 */
function clear_url (string $string) {
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
function input ($name) {
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
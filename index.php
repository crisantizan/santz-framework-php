<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:12 PM
 */

// Path base de aplicación
define('BASE_PATH', dirname( realpath(__FILE__) ).'/');
// Escribir aquí los componentes de la ruta de tu aplicación (sin /)
define('PROTOCOL','http');
define('HOSTNAME','santz.co');
define('URL_BASE', PROTOCOL.'://'.HOSTNAME.'/');
// Se encarga de incluir los archivos de toda la aplicación
require_once('app/core/core.php');
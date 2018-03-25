<?php
/**
 * Created by PhpStorm.
 * core: chris
 * Date: 12/02/18
 * Time: 09:06 PM
 */

/*
    Todos los archivos del proyecto se encuentran aquí, el Autoload se encarga
    de incluir las clases.
 */

// Constantes globales para rutas del proyecto
require_once(BASE_PATH.'app/config/const_paths.php');
// Constantes globales para pasar por parámetros en métodos de persistencia de datos.
require_once(BASE_PATH.'app/config/const_db_params.php');
// Funciones globales de ayuda.
require_once (HELPERS_PATH.'func_helpers.php');
// Autoload para carga automática de clases.
require_once (VENDOR_PATH.'autoload.php');
// Rutas existentes en la aplicación
require_once (CORE_PATH.'Routes.php');

<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:24 PM
 */

/*
 * Digita aquí las credenciales de tu base de datos
 * Por defecto las consultas retornarán la información en objectos
 * Cambiar el atributo ATTR_DEFAULT_FETCH_MODE FETCH_ASSOC o FETCH_BOTH para obtener arrays
 */

return [
    'db_host'=>'127.0.0.1',
    'db_name'=>'',
    'db_user'=>'root',
    'db_pass'=>'',
    'db_charset'=>'utf8',
    'db_options'=>
        [\PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ]
];
<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 1/03/18
 * Time: 08:08 PM
 */

declare(strict_types = 1);
namespace app\core\helpers;

final class FunctionsTwig extends \Twig_Extension {
    //Imprime la ruta completa de las librerias externas
    final public static function assets (string $path) {
        echo URL_BASE."public/assets/{$path}";
    }
    // Cargar archivos desde la raíz del proyecto (Ej: bundle.js) desde cualquier ruta
    final public static function home (string $file): void {
        echo URL_BASE."{$file}";
    }
    //Convertiremos el método en una función ejecutable por Twig
    public function getFunctions() : array {
        return array(
            new \Twig_Function('assets',    array($this,'assets')),
            new \Twig_Function('home',      array($this,'home'))
        );
    }
    public function getName() : string {
        return 'Santz_Func_Twig';
    }
}
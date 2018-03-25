<?php
/**
 * Created by PhpStorm.
 * UserController: chris
 * Date: 12/02/18
 * Time: 09:07 PM
 */

declare(strict_types = 1);
namespace app\core\librarys;
use app\core\helpers\FunctionsTwig;

class View {
    public static function create(string $path,  array $params=null){
        // Convertir el string recibido en array
        $path = explode('.',$path);
        $route = null;
        // Crear, mediante ciclo, el formato ruta del archivo requerido
        for ($i=0; $i < count($path); $i++){
            if ($i == count($path)-1){
                // Si es el último se le anexa la extención del archivo
                $route.=$path[$i].'.twig';
            }else{
                // Mientras se sigue formando la ruta
                $route.=$path[$i].'/';
            }
        }
        // Comprobar si el archivo obtenido en la ruta existe
        if (file_exists(VIEWS_PATH.'templates/'.$route)){
            // Se le establece donde estarán las vistas
            $loader = new \Twig_Loader_Filesystem(VIEWS_PATH.'templates/');
            // Se le configuran opciones
            $twig = new \Twig_Environment($loader,[
                // Carpeta donde se guardará la cache, poner en "false" si no se quiere almacenar
                'cache'=> false // VIEWS_PATH.'cache/'
            ]);
            // Extensión para poder crear funciones personalizadas
            $twig->addExtension(new FunctionsTwig());
            // Agregar variables globales (Uso exclusivo de Twig)
            $twig->addGlobal('URL_BASE',URL_BASE);
            // Renderizar con o sin parámetros
            if (is_null($params))echo $twig->render($route);else echo $twig->render($route, $params);
        }else{
            die('El archivo solicitado no existe, por favor compruebe su ruta.');
        }
    }
}
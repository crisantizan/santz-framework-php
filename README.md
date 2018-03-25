# Espectre/Miniframework
Miniframework para desarrollo de aplicaciones en PHP y JS (TypeScript)<br><br>
 <i>Antes de proceder con la instalación del framework, es recomendable crear un virtualhost para trabajar con más comodidad, omitiendo configuraciones adicionales.</i> 
<br><br>
>### Requerimientos mínimos <br>
- PHP >= 7.0.0
- Nodejs para poder el gestor de paquetes 'npm'
- Composer, gestor de dependencias PHP
- TypeScript
- Browserify, aunque puedes utilizar la herramienta similar de tu preferencia
>### Preparación previa
#### Instalación NodeJS
>Descargar <a href="https://nodejs.org/es/" target="_blank">NodeJs</a> paquete  <br>
Otras formas de <a href="https://nodejs.org/es/download/package-manager/" target="_blank">descarga</a>
#### Instalación global de TypeScript:
<pre>$ npm i -g typescript </pre>
#### Instalación composer:
>Descargar e instalar <a href="https://getcomposer.org/download/" target="_blank">Composer</a> desde la página oficial
#### Instalación global Browserify:
<pre>$ npm install -g browserify </pre>
>### Descarga e instalación del framework
- Ubicarse en la carpeta de destino y clonar el proyecto con el siguiente comando:
- <pre>$ git clone https://github.com/chrisantiz/Espectre_Miniframework</pre>
> *Si no se tiene <a href="https://git-scm.com/" target="_blank">git</a> instalado, descargar el comprimido directamente.*
- Acceder a la carpeta raíz del proyecto. Instalar las dependecias:<br>

    - npm, ejecutar:
    <pre>$ npm install</pre>
    - composer, ejecutar:
    <pre>$ composer install</pre>
- Ir al archivo principal "index.php", en la raíz del proyecto, y modificar la ruta base de la aplicación: <br>
    <pre>
    11  //Url base
    12  define('URL_BASE','http://tu_ruta_base.co/');</pre>

Si todos los pasos anteriores se han realizado satisfactoriamente se podrá levantar un servidor local y correr la aplicación. <br>
*Se verá una pantalla así:* <br>
<img src="https://lh3.googleusercontent.com/ZhBTOiKb-Uxi_590ozfjRsT9WWPySO6TIGr-Q6ZzPxKQw-F2H3XKeJABWaeNO6PJbdOaDu4cizFaaw=w1366-h705-no"/>
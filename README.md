# Santz/Framework
Miniframework para desarrollo de aplicaciones en PHP y TypeScript<br><br>
 <i>Antes de proceder con la instalación del framework, es recomendable crear un virtualhost para trabajar con más comodidad, omitiendo configuraciones adicionales.</i> 
<br><br>
>### Requerimientos mínimos <br>
- PHP >= 7.0.0
- Nodejs para poder el gestor de paquetes 'npm'
- Composer, gestor de dependencias PHP

#### Instalación NodeJS
>Descargar <a href="https://nodejs.org/es/" target="_blank">NodeJs</a> paquete  <br>
Otras formas de <a href="https://nodejs.org/es/download/package-manager/" target="_blank">descarga</a>

#### Instalación composer:
>Descargar e instalar <a href="https://getcomposer.org/download/" target="_blank">Composer</a> desde la página oficial

>### Descarga e instalación del framework
- Ubicarse en la carpeta de destino y clonar el proyecto con el siguiente comando:
- <pre>$ git clone https://github.com/chrisantiz/santz</pre>
 *Si no se tiene <a href="https://git-scm.com/" target="_blank">git</a> instalado, descargar el comprimido directamente.*
 
 ####Instalando dependencias
   Al instalar el framework se necesitará instalar las dependencias de desarrollo para su uso ideal:<br>
- > Dependencias frontend
    ```bash
    $ npm install
    ```
- > Dependencias backend
    ```bash
    $ composer install
    ```
- Ir al archivo principal "index.php", en la raíz del proyecto, y modificar la ruta base de la aplicación: <br>

    <pre>
    11  //Url base
    12  define('URL_BASE','http://tu_ruta_base.co/');</pre>

Si todos los pasos anteriores se han realizado satisfactoriamente se podrá levantar un servidor local y correr la aplicación. <br>
*Se verá una pantalla así:* <br>
<img src="https://lh3.googleusercontent.com/ZhBTOiKb-Uxi_590ozfjRsT9WWPySO6TIGr-Q6ZzPxKQw-F2H3XKeJABWaeNO6PJbdOaDu4cizFaaw=w1366-h705-no"/>
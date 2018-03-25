//<reference path="../../../node_modules/@types/jquery/index.d.ts" />
import {classAutoload} from "./libs/helpers";
let controller:string;
let method:string;
var route:string[] = [];
// Se captura toda la url
var tempPath:any = window.location.pathname;
// Se divide en un arreglo
tempPath = tempPath.split('/');
// Se guadará de forma permanente el controlador y el método
var route:string[] = [];
// Contador que regula la cantidad de índices a agregar al array. Máximo dos.
var cont:number = 0;

for (let i in tempPath) {
    if (tempPath[i] !== '') route.push(tempPath[i]), cont++;
    if (cont > 1) break;
}
// La posición 0 será el controlador. Si viene vacía o indefinida por defecto será "main"
controller = (route[0] == '' || route[0] == undefined) ? 'main' : route[0].toLowerCase();
// La posición 1 será el método. Si está vació o indefinido por defecto será "index"
method = (route[1] == '' || route[1] == undefined) ?  'index' : route[1].toLowerCase() ;
// Mandamos a evaluar los datos recogidos y si son correctos nos carga lo solicitado
classAutoload(controller, method);
//console.log(`Controller: ${controller}`); console.log(`Method: ${method}`);
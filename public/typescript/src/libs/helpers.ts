import * as Controller from "../Controllers";
import htmlString = JQuery.htmlString;
Controller;
// Retorna una instancia del controlador especificado por parámetro
const getController = (controller: string) => {
    controller = `Controller.${controller}`;
    return eval(controller)();
};
// Autocarga la clase y método pasado por parámetros
const classAutoload = (controller:string, method:string) => {
    // Se crea una instancia para comprobar si el método existe
    var inst = getController(controller);
    // Si existe se llama
    if (inst.methodExist(method)) return eval(`Controller.${controller}().${method}()`);
};
// Se pasan x parámetros y devolverá true si alguno está vació
const anyIsEmpty = (...inputs:htmlString[]):boolean => {
    for (let input in inputs) {
        if (inputs[input] === '') return true;
    }
    return false;
};
// Retorna la ruta completa de la carpeta «assets»
const assets = (patch: string): string => {
    return `${window.location.origin}/public/assets/${patch}`;
};
// Monta el loader al elemento HTML indicado
const mountLoaderHTML = (htmlElement: string): void => {
    const loader: string = `
        <div class="loader d-none">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10" /> </svg>
        </div>
    `;
    ( document.querySelector(htmlElement) as HTMLElement ).innerHTML = loader;
};
// Muestra o quita el loader
const toggleLoader = (): void => {
    $('.loader').toggleClass('d-block');
};
// Selectores de elementos del Doom
const __ = (element: string):HTMLInputElement => {
    return <HTMLInputElement>document.querySelector(element);
};
const __e = (element: string):HTMLElement => {
    return <HTMLElement>document.querySelector(element);
};
// conversor de unidades
const convert = (size:number) => {
    if (size < 1000000)
        return `${(size/1000).toFixed(1)} KB`;
    else
        return `${(size/1000000).toFixed(1)} MB`;
};
// Exportando las funciones
export {
    classAutoload,
    anyIsEmpty,
    assets,
    mountLoaderHTML,
    toggleLoader,
    __,
    __e,
    convert
};
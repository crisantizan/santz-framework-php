import * as Controller from "../Controllers";
Controller;
// Retorna una instancia del controlador especificado por parámetro
var getController = (controller: string) => {
    controller = `Controller.${controller}`;
    return eval(controller)();
};
// Autocarga la clase y método pasado por parámetros
var classAutoload = (controller:string, method:string) => {
    // Se crea una instancia para comprobar si el método existe
    var inst = getController(controller);
    // Si existe se llama
    if (inst.methodExist(method)) return eval(`Controller.${controller}().${method}()`);
};

// Exportando las funciones
export {classAutoload};
import {MainController} from './controllers/MainController';
import {UserController} from "./controllers/UserController";

/* ----------FUNCIONES QUE RETORNARÁN LOS CONTROLADORES---------- */
export var main = () => { return new MainController(); };
export var user = () => { return new UserController(); };
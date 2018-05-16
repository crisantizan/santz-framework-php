///<reference path="../libs/MethodValidate.ts"/>
import {MethodValidate} from "../libs/MethodValidate";

export class UserController extends MethodValidate{
    public index () {
        console.log('Method index from UserController is working!');
    }

    public show () {
        console.log('Method show from UserController is working!');
    }
}
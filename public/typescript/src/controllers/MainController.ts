///<reference path="../../../../node_modules/@types/jquery/index.d.ts" />
import {MethodValidate} from "../libs/MethodValidate";

export class MainController extends MethodValidate {
    public index () {
        let msg = 'Hello world from MainController';
        console.log(msg);

        $('#btnTest').on('click', () => {
            this.message(msg);
        });
    }

    private message (msg:string): void {
        alert(msg);
    }
}

///<reference path="../../../../node_modules/@types/jquery/index.d.ts" />
///<reference path="../../../../node_modules/@types/axios/index" />
import {MethodValidate} from "../libs/MethodValidate";
// import axios from 'axios';
var axios:any;
export class MainController extends MethodValidate {
    public index () {
        console.log('Hello word from MainController');
        var btn:any = document.querySelector('#btnTest');
        var otra:any = btn.getAttribute('id');
        var token:any = $('#token').val();
        $('#btnTest').on('click', () => {
            this.auth(token.toString());
        });
/*        $('#btnTest').on('click', () => {
            this.auth();
        });*/
        //alert('¡BIEN HECHO! instalación satisfactoria');
    }

    private auth (token:string) {

        $.ajax({
            url:"/user/auth",
            method: "POST",
            dataType:"JSON",
            data:{
                token:token
            }
        })
        .done((res) => {
            console.log( res );
        });
    }
}

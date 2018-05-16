// Clase que debe ser usada por todos los controladores,
// permite llamar un método específico cuando este existe
export class MethodValidate {
    public methodExist (method:string) {
        let self = 'this.';
        method = `${self}${method}`;
        return (eval(method));
    }
}
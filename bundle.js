(function(){function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s}return e})()({1:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var MainController_1 = require("./controllers/MainController");
var UserController_1 = require("./controllers/UserController");
exports.main = function () { return new MainController_1.MainController(); };
exports.user = function () { return new UserController_1.UserController(); };

},{"./controllers/MainController":2,"./controllers/UserController":3}],2:[function(require,module,exports){
"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
var MethodValidate_1 = require("../libs/MethodValidate");
var axios;
var MainController = (function (_super) {
    __extends(MainController, _super);
    function MainController() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    MainController.prototype.index = function () {
        var _this = this;
        console.log('Hello word from MainController');
        var btn = document.querySelector('#btnTest');
        var otra = btn.getAttribute('id');
        var token = $('#token').val();
        $('#btnTest').on('click', function () {
            _this.auth(token.toString());
        });
    };
    MainController.prototype.auth = function (token) {
        $.ajax({
            url: "/user/auth",
            method: "POST",
            dataType: "JSON",
            data: {
                token: token
            }
        })
            .done(function (res) {
            console.log(res);
        });
    };
    return MainController;
}(MethodValidate_1.MethodValidate));
exports.MainController = MainController;

},{"../libs/MethodValidate":4}],3:[function(require,module,exports){
"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
var MethodValidate_1 = require("../libs/MethodValidate");
var UserController = (function (_super) {
    __extends(UserController, _super);
    function UserController() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    UserController.prototype.index = function () {
        console.log('Method index from UserController is working!');
    };
    UserController.prototype.show = function () {
        console.log('Method show from UserController is working!');
    };
    return UserController;
}(MethodValidate_1.MethodValidate));
exports.UserController = UserController;

},{"../libs/MethodValidate":4}],4:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var MethodValidate = (function () {
    function MethodValidate() {
    }
    MethodValidate.prototype.methodExist = function (method) {
        var self = 'this.';
        method = "" + self + method;
        return (eval(method));
    };
    return MethodValidate;
}());
exports.MethodValidate = MethodValidate;

},{}],5:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Controller = require("../Controllers");
Controller;
var getController = function (controller) {
    controller = "Controller." + controller;
    return eval(controller)();
};
var classAutoload = function (controller, method) {
    var inst = getController(controller);
    if (inst.methodExist(method))
        return eval("Controller." + controller + "()." + method + "()");
};
exports.classAutoload = classAutoload;

},{"../Controllers":1}],6:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var helpers_1 = require("./libs/helpers");
var controller;
var method;
var route = [];
var tempPath = window.location.pathname;
tempPath = tempPath.split('/');
var route = [];
var cont = 0;
for (var i in tempPath) {
    if (tempPath[i] !== '')
        route.push(tempPath[i]), cont++;
    if (cont > 1)
        break;
}
controller = (route[0] == '' || route[0] == undefined) ? 'main' : route[0].toLowerCase();
method = (route[1] == '' || route[1] == undefined) ? 'index' : route[1].toLowerCase();
helpers_1.classAutoload(controller, method);
console.log('Prueba');

},{"./libs/helpers":5}]},{},[6]);

(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
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
var MainController = (function (_super) {
    __extends(MainController, _super);
    function MainController() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    MainController.prototype.index = function () {
        var msg = 'Hello world from MainController';
        console.log(msg);
        document.querySelector('#btnTest').addEventListener('click', function () {
            alert(msg);
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
var anyIsEmpty = function () {
    var inputs = [];
    for (var _i = 0; _i < arguments.length; _i++) {
        inputs[_i] = arguments[_i];
    }
    for (var input in inputs) {
        if (inputs[input] === '')
            return true;
    }
    return false;
};
exports.anyIsEmpty = anyIsEmpty;
var assets = function (patch) {
    return window.location.origin + "/public/assets/" + patch;
};
exports.assets = assets;
var mountLoaderHTML = function (htmlElement) {
    var loader = "\n        <div class=\"loader d-none\">\n            <svg class=\"circular\" viewBox=\"25 25 50 50\">\n                <circle class=\"path\" cx=\"50\" cy=\"50\" r=\"20\" fill=\"none\" stroke-width=\"4\" stroke-miterlimit=\"10\" /> </svg>\n        </div>\n    ";
    document.querySelector(htmlElement).innerHTML = loader;
};
exports.mountLoaderHTML = mountLoaderHTML;
var toggleLoader = function () {
    $('.loader').toggleClass('d-block');
};
exports.toggleLoader = toggleLoader;
var __ = function (element) {
    return document.querySelector(element);
};
exports.__ = __;
var __e = function (element) {
    return document.querySelector(element);
};
exports.__e = __e;
var convert = function (size) {
    if (size < 1000000)
        return (size / 1000).toFixed(1) + " KB";
    else
        return (size / 1000000).toFixed(1) + " MB";
};
exports.convert = convert;

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
controller = (route[0] == '' || route[0] == 'index' || route[0] == undefined) ? 'main' : route[0].toLowerCase();
method = (route[1] == '' || route[1] == undefined) ? 'index' : route[1].toLowerCase();
helpers_1.classAutoload(controller, method);

},{"./libs/helpers":5}]},{},[6]);

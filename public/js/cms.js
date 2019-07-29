/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/cms.js":
/*!*****************************!*\
  !*** ./resources/js/cms.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./cms/alerts */ "./resources/js/cms/alerts.js");

__webpack_require__(/*! ./cms/functions */ "./resources/js/cms/functions.js");

/***/ }),

/***/ "./resources/js/cms/alerts.js":
/*!************************************!*\
  !*** ./resources/js/cms/alerts.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$.fn.overhang = function (e) {
  function o(e, o) {
    r.fadeOut(100), a.slideUp(c.speed, function () {
      e && c.callback(null !== o ? n.data(o) : "");
    });
  }

  var n = $(this),
      a = $("<div class='overhang'></div>"),
      r = $("<div class='overhang-overlay'></div>");
  $(".overhang").remove(), $(".overhang-overlay").remove();
  var t = {
    success: ["#2ECC71", "#27AE60"],
    error: ["#E74C3C", "#C0392B"],
    warn: ["#E67E22", "#D35400"],
    info: ["#3498DB", "#2980B9"],
    prompt: ["#9B59B6", "#8E44AD"],
    confirm: ["#1ABC9C", "#16A085"],
    "default": ["#95A5A6", "#7F8C8D"]
  },
      s = {
    type: "success",
    custom: !1,
    message: "This is an overhang.js message!",
    textColor: "#FFFFFF",
    yesMessage: "Yes",
    noMessage: "No",
    yesColor: "#2ECC71",
    noColor: "#E74C3C",
    duration: 1.5,
    speed: 500,
    closeConfirm: !1,
    upper: !1,
    easing: "easeOutBounce",
    html: !1,
    overlay: !1,
    callback: function callback() {}
  },
      c = $.extend(s, e);
  c.type = c.type.toLowerCase();
  var l = ["success", "error", "warn", "info", "prompt", "confirm"];
  -1 === $.inArray(c.type, l) && (c.type = "default", console.log("You have entered invalid type name for an overhang message. Overhang resorted to the default theme.")), c.custom ? (c.primary = e.primary || t["default"][0], c.accent = e.accent || t["default"][1]) : (c.primary = t[c.type][0] || t["default"][0], c.accent = t[c.type][1] || t["default"][1]), ("prompt" === c.type || "confirm" === c.type) && (c.primary = e.primary || t[c.type][0], c.accent = e.accent || t[c.type][1], c.closeConfirm = !0), a.css("background-color", c.primary), a.css("border-bottom", "6px solid " + c.accent);
  var p = $("<span class='overhang-message'></span>");
  p.css("color", c.textColor), c.html ? p.html(c.message) : p.text(c.upper ? c.message.toUpperCase() : c.message), a.append(p);
  var i = $("<input class='overhang-prompt-field' />"),
      u = $("<button class='overhang-yes-option'>" + c.yesMessage + "</button>"),
      d = $("<button class='overhang-no-option'>" + c.noMessage + "</button>");

  if (u.css("background-color", c.yesColor), d.css("background-color", c.noColor), c.closeConfirm) {
    var m = $("<span class='overhang-close'></span>");
    m.css("color", c.accent), "confirm" !== c.type && a.append(m);
  }

  if ("prompt" === c.type ? (a.append(i), n.data("overhangPrompt", null), i.keydown(function (e) {
    13 == e.keyCode && (n.data("overhangPrompt", i.val()), o(!0, "overhangPrompt"));
  })) : "confirm" === c.type && (a.append(u), a.append(d), a.append(m), n.data("overhangConfirm", null), u.click(function () {
    n.data("overhangConfirm", !0), o(!0, "overhangConfirm");
  }), d.click(function () {
    n.data("overhangConfirm", !1), o(!0, "overhangConfirm");
  })), n.append(a), a.slideDown(c.speed, c.easing), c.overlay && (c.overlayColor && r.css("background-color", c.overlayColor), n.append(r)), c.closeConfirm && !e.duration) m.click(function () {
    "prompt" !== c.type && "confirm" !== c.type ? o(!0, null) : o(!1, null);
  });else if (c.closeConfirm && e.duration) {
    var f = setTimeout(function () {
      a.slideUp(c.speed, function () {
        o(!0, null);
      });
    }, 1e3 * c.duration);
    m.click(function () {
      clearTimeout(f), "prompt" !== c.type && "confirm" !== c.type ? o(!0, null) : o(!1, null);
    });
  } else a.delay(1e3 * c.duration).slideUp(c.speed, function () {
    o(!0, null);
  });
};

window.alertError = function (errorMessage) {
  $('#modal-error-alert #error-message').text(errorMessage);
  $('#modal-error-alert').modal('show');
};

window.alertConfirmDelete = function (title, message) {
  var confirmEndpoint = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
  var callBack = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
  $.confirm({
    title: title,
    content: message,
    buttons: {
      confirm: {
        text: 'Confirm Delete',
        btnClass: 'btn-danger',
        action: function action() {
          if (confirmEndpoint) {
            window.location.replace(confirmEndpoint);
            return $('.modal').modal('hide');
          }

          return callBack(true);
        }
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-blue',
        action: function action() {
          return callBack(false);
        }
      }
    }
  });
};

/***/ }),

/***/ "./resources/js/cms/functions.js":
/*!***************************************!*\
  !*** ./resources/js/cms/functions.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.removeInputErrors = function () {
  $('input').removeClass('is-invalid');
  $('.invalid-feedback').remove();
};

window.addInputErrors = function (formId, data) {
  $.each(data, function (key, value) {
    $(formId + ' input[name="' + key + '"]').addClass('is-invalid').after('<div class="invalid-feedback">' + value + '</div>');
  });
};

window.addExtraCustomerToTable = function (customer, id) {
  $('#extra-customers-modal tbody').append('<tr>' + '<td>' + customer + '</td>' + '<td class="text-right"><button id="delete-extra-customer" class="btn btn-sm btn-danger" value="' + id + '">Remove</button></td>' + '</tr>');
};

/***/ }),

/***/ 2:
/*!***********************************!*\
  !*** multi ./resources/js/cms.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/samuel/Code/shop/resources/js/cms.js */"./resources/js/cms.js");


/***/ })

/******/ });
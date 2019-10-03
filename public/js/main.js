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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./modules/basket */ "./resources/js/modules/basket.js");

__webpack_require__(/*! ./modules/categories */ "./resources/js/modules/categories.js");

__webpack_require__(/*! ./modules/products */ "./resources/js/modules/products.js");

__webpack_require__(/*! ./modules/inputs */ "./resources/js/modules/inputs.js");

__webpack_require__(/*! ./modules/checkout */ "./resources/js/modules/checkout.js");

$('input[type="file"]').change(function (file) {
  $('.custom-file-label').html(file.target.files[0].name);
});
$('button[id="upload-order"]').on('click', function () {
  $('#loader .loader-txt').html('Uploading your order, please wait');
  $('#loader').modal('show');
});
$(".sidebar-dropdown > a").click(function () {
  $(".sidebar-submenu").slideUp(200);

  if ($(this).parent().hasClass("active")) {
    $(".sidebar-dropdown").removeClass("active");
    $(this).parent().removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this).next(".sidebar-submenu").slideDown(200);
    $(this).parent().addClass("active");
  }
});
$("#close-sidebar").click(function () {
  $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function () {
  $(".page-wrapper").addClass("toggled");
}); // Get the modal

var modal = document.getElementById('img-modal'); // Get the image and insert it inside the modal - use its "alt" text as a caption

var img = document.getElementById('enlarge-image');
var modalImg = document.getElementById("product-image");
var captionText = document.getElementById("caption");
$('img[id="enlarge-image"]').on('click', function () {
  $('#img-modal').show();
  modalImg.src = $(this).attr('src');
  captionText.innerHTML = $(this).closest('.product-list').find('#product-code').text();
  console.log($(this).closest('#product-code').text());
});
$('#img-modal').on('click', function () {
  $(this).hide();
}); // Get the <span> element that closes the modal

var span = document.getElementsByClassName("close")[0]; // When the user clicks on <span> (x), close the modal

if (span) {
  span.onclick = function () {
    modal.style.display = "none";
  };
}

/***/ }),

/***/ "./resources/js/modules/basket.js":
/*!****************************************!*\
  !*** ./resources/js/modules/basket.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var basketDropdown = $('.basket-dropdown'),
    basketDropdownContent = $('.basket-dropdown-content');
$("#header-basket").mouseenter(function () {
  basketDropdownContent.html('');
  $.get('/basket/dropdown').done(function (response) {
    if (response.lines.length > 0) {
      $.each(response.lines, function (key, item) {
        basketDropdownContent.append("<div class=\"row\"><div class=\"col-auto\"><img src=\"".concat(item.image, "\"></div><div class=\"col details\"><h3>").concat(item.product, "</h3><span>").concat(item.name, "</span><span>Qty: ").concat(item.quantity, "</span><span>Price: ").concat(item.price, "</span></div></div>"));
      });
    } else {
      basketDropdownContent.html('<h4 class="text-center mt-2">You have no items in your basket.</h4>');
    }

    basketDropdown.fadeToggle('fast');
  }).fail(function () {
    basketDropdownContent.html('<h4 class="text-center mt-2">Unable to get basket details.</h4>');
  });
});
basketDropdown.mouseleave(function () {
  $(".basket-dropdown").fadeToggle('fast');
});
$('form[id="product-add-basket-quickbuy"]').on('submit', function (e) {
  e.preventDefault();
  var product = $(this).find('input[name="product"]'),
      quantity = $(this).find('input[name="quantity"]');
  addProductToBasket(product.val(), quantity.val(), true, false);
  product.val('');
  quantity.val(1);
});
$('form[id="product-add-basket-checkout"]').on('submit', function (e) {
  e.preventDefault();
  var product = $(this).find('input[name="product"]'),
      quantity = $(this).find('input[name="quantity"]');
  addProductToBasket(product.val(), quantity.val(), false, true);
  product.val('');
  quantity.val(1);
  product.focus();
});
$('form[id="product-add-basket-products"]').on('submit', function (e) {
  e.preventDefault();
  var product = $(this).find('input[name="product"]'),
      quantity = $(this).find('input[name="quantity"]');
  addProductToBasket(product.val(), quantity.val(), true);
});
$(document).on('click', '#basket-line__remove', function () {
  var line = $(this).closest('tr'),
      product = line.find('#basket__product').text();
  $.post('/basket/delete-product', {
    product: product
  }).done(function (response) {
    line.remove();
    basketSummary(true);
  }).fail(function (response) {
    return Swal.fire('Error', 'Unable to remove product, please try again.', 'error');
  });
});
$(document).on('click', '#basket_line__update', function () {
  var line = $(this).closest('tr'),
      product = line.find('#basket__product').text(),
      newQty = line.find('input').val();

  if (!$.isNumeric(newQty)) {
    return Swal.fire({
      title: 'Error',
      text: 'You must enter a number to update a quantity',
      type: 'error',
      allowOutsideClick: false
    }).then(function (result) {
      if (result) {
        location.reload();
      }
    });
  }

  $.post('/basket/update-product', {
    product: product,
    qty: newQty
  }).done(function (response) {
    location.reload();
  }).fail(function (response) {
    return Swal.fire({
      title: 'Error',
      text: 'Unable to update product quantity, please try again',
      type: 'error',
      allowOutsideClick: false
    }).then(function (result) {
      if (result) {
        location.reload();
      }
    });
  });
});

function addProductToBasket(product, quantity, displayDropdown, inBasket) {
  $.post('/basket/add-product', {
    product: product.trim().toUpperCase(),
    quantity: quantity
  }).done(function (response) {
    if (response.error) {
      return Swal.fire('Error', response.message, 'error');
    }

    if (inBasket) {
      appendBasketTable(response);
    }

    $('#header-checkout').removeClass('d-none');
    basketSummary(inBasket);

    if (displayDropdown) {
      basketAddedDropdown(response.product);
    }

    if (response.message) {
      return Swal.fire('Warning', response.message, 'warning');
    }

    return true;
  }).fail(function () {
    return swal('Error', 'The request could not be completed, please try again', 'error');
  });
}

function basketAddedDropdown(productDetails) {
  var dropdownTimer = setTimeout(function () {
    basketDropdown.fadeOut(100);
  }, 3000);

  if (basketDropdown.is(':visible')) {
    clearTimeout(dropdownTimer);
    basketDropdown.hide();
  }

  basketDropdownContent.html("<div class=\"row\"><div class=\"col-auto\"><img src=\"".concat(productDetails.image, "\"></div><div class=\"col details\"><h3>").concat(productDetails.product, "</h3><span>").concat(productDetails.name, "</span><span>Qty: ").concat(productDetails.quantity, "</span><span>Price: ").concat(productDetails.price, "</span></div></div><div class=\"basket-dropdown-message\">Has been added to your basket.</div>"));
  basketDropdown.fadeIn(100);
}

function basketSummary() {
  var isBasket = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
  $.get('/basket/summary').done(function (response) {
    $('.basket-info .order-lines').html(response.line_count);
    $('.basket-info .order-total').html(response.summary.goods_total);

    if (response.line_count === 0) {
      $('#header-checkout').hide();
    } else {
      $('#header-checkout').show();
    }

    if (isBasket) {
      if (response.line_count === 0) {
        $('#basket-message').show();
        $('#basket-checkout__buttons').hide();
      } else {
        $('#basket-message').hide();
        $('#basket-checkout__buttons').show();
      }

      $('#basket__goods-total').text(response.summary.goods_total);
      $('#basket__shipping').text(response.summary.shipping);
      $('#basket__sub-total').text(response.summary.sub_total);
      $('#basket__small-order-charge').text(response.summary.small_order_charge);
      $('#basket__vat').text(response.summary.vat);
      $('#basket__total').text(response.summary.total);
    }
  });
}

function appendBasketTable(details) {
  if (details.product.stock < details.product.quantity) {
    var backOrder = 'class="bg-warning"';
  } else {
    var backOrder = '';
  }

  if (details.basket) {
    var row = $('.table-basket tbody #' + details.product.product),
        qtyField = row.find('input[name="line_qty"]'),
        currentQty = qtyField.val(),
        newQty = parseInt(currentQty) + parseInt(details.product.quantity);
    qtyField.val(newQty);

    if (newQty > details.product.stock) {
      row.addClass('bg-warning');
    }
  } else {
    $('.table-basket tbody').append('' + '<tr ' + backOrder + ' id="' + details.product.product + '">' + '<td>' + '<div class="basket-image__container d-inline-block"><img class="basket-image" src="' + details.product.image + '" alt="' + details.product.product + '"></div>' + '<h2 class="section-title d-inline-block"><a href="' + details.product.link + '">' + details.product.name + '</a></h2>' + '</td>' + '<td id="basket__product">' + details.product.product + '</td>' + '<td>' + details.product.unit + '</td>' + '<td class="text-right">' + details.product.stock + '</td>' + '<td class="text-right">' + details.product.net_price + '</td>' + '<td class="quantity-column"><input name="line_qty" class="form-control form-quantity" value="' + details.product.quantity + '" autocomplete="off">' + '<span class="quantity-options"><span id="basket_line__update" class="quantity-update">Update</span> <span id="basket-line__remove" class="quantity-remove">Remove</span></span>' + '</td>' + '<td class="text-right">' + details.product.price + '</td>' + '</tr>');
  }
}

/***/ }),

/***/ "./resources/js/modules/categories.js":
/*!********************************************!*\
  !*** ./resources/js/modules/categories.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('.sub-category-image[data-products]').each(function (index, item) {
    var products = $(item).data('products');
    $.get('/category/image/' + products).done(function (response) {
      $(item).find('.spinner').remove();
      $(item).append('<img src="' + response.image + '" alt="' + response.image + '">');
    });
  });
});

/***/ }),

/***/ "./resources/js/modules/checkout.js":
/*!******************************************!*\
  !*** ./resources/js/modules/checkout.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$('select[name="shipping"]').on('change', function () {
  var shippingValue = $(this).find(':selected').data('cost').toFixed(2);
  basketSummaryCheckout(shippingValue);
});

function basketSummaryCheckout(shippingValue) {
  $.get('/basket/summary/' + shippingValue).done(function (response) {
    $.each(response.summary, function (key, value) {
      $('#' + key).text(value);
    });
  });
}

/***/ }),

/***/ "./resources/js/modules/inputs.js":
/*!****************************************!*\
  !*** ./resources/js/modules/inputs.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('input[name="date_from"]').datepicker({
    dateFormat: 'dd/mm/yy'
  });
  $('input[name="date_to"]').datepicker({
    dateFormat: 'dd/mm/yy'
  });
});

/***/ }),

/***/ "./resources/js/modules/products.js":
/*!******************************************!*\
  !*** ./resources/js/modules/products.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $('input[id="quick-buy"]').autocomplete({
    minLength: 2,
    // autoFocus: true,
    // select: function( event, ui ) {
    //     $(this).val( ui.item.id );
    //     $(this).closest('form').submit();
    // },
    source: function source(request, response) {
      $.ajax({
        url: '/products/autocomplete/' + $('input[id="quick-buy"]').val().toUpperCase(),
        type: 'GET',
        success: function success(data) {
          response($.map(data, function (value) {
            return {
              label: value.product.trim(),
              value: value.product.trim()
            };
          }));
        }
      });
    }
  });
  $('input[id="customer-admin"]').autocomplete({
    minLength: 2,
    source: function source(request, response) {
      $.post('/customer/autocomplete', {
        customer: $('input[id="customer-admin"]').val().toUpperCase()
      }).done(function (data) {
        response($.map(data, function (value) {
          return {
            label: value.customer_code.trim() + ' - ' + value.customer_name.trim(),
            value: value.customer_code.trim()
          };
        }));
      }); // $.ajax({
      //     url: '/customer/autocomplete',
      //     type: 'POST',
      //     dataType: 'json',
      //     data: {
      //         customer: $('input[id="customer-admin"]').val().toUpperCase()
      //     },
      //     success: function (data) {
      //         response($.map(data, function (value) {
      //             return {
      //                 label: value.customer_code.trim() + ' - ' + value.customer_name.trim(),
      //                 value: value.customer_code.trim()
      //             };
      //         }));
      //     }
      // });
    }
  });
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/samuel/Code/shop/resources/js/main.js */"./resources/js/main.js");


/***/ })

/******/ });
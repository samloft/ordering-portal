let basketDropdown = $('.basket-dropdown'),
    basketDropdownContent = $('.basket-dropdown-content');

$("#header-basket").mouseenter(function () {
    basketDropdownContent.html('');

    $.get('/basket/dropdown').done(function (response) {
        if (response.lines.length > 0) {
            $.each(response.lines, function (key, item) {
                basketDropdownContent.append(`<div class="row"><div class="col-auto"><img src="${item.image}"></div><div class="col details"><h3>${item.product}</h3><span>${item.name}</span><span>Qty: ${item.quantity}</span><span>Price: ${item.price}</span></div></div>`);
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

    let product = $(this).find('input[name="product"]'),
        quantity = $(this).find('input[name="quantity"]');

    addProductToBasket(product.val(), quantity.val(), true, false);

    product.val('');
    quantity.val(1);
});

$('form[id="product-add-basket-checkout"]').on('submit', function (e) {
    e.preventDefault();

    let product = $(this).find('input[name="product"]'),
        quantity = $(this).find('input[name="quantity"]');

    addProductToBasket(product.val(), quantity.val(), false, true);

    product.val('');
    quantity.val(1);

    product.focus();
});

$('form[id="product-add-basket-products"]').on('submit', function (e) {
    e.preventDefault();

    let product = $(this).find('input[name="product"]'),
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

$(document).on('click', '#basket_line__update', function() {
    var line = $(this).closest('tr'),
        product = line.find('#basket__product').text(),
        newQty = line.find('input').val();

    if (!$.isNumeric(newQty)) {
        return Swal.fire({
            title: 'Error',
            text: 'You must enter a number to update a quantity',
            type: 'error',
            allowOutsideClick: false
        }).then((result) => {
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
        }).then((result) => {
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
    let dropdownTimer = setTimeout(function () {
        basketDropdown.fadeOut(100);
    }, 3000);

    if (basketDropdown.is(':visible')) {
        clearTimeout(dropdownTimer);
        basketDropdown.hide();
    }

    basketDropdownContent.html(`<div class="row"><div class="col-auto"><img src="${productDetails.image}"></div><div class="col details"><h3>${productDetails.product}</h3><span>${productDetails.name}</span><span>Qty: ${productDetails.quantity}</span><span>Price: ${productDetails.price}</span></div></div><div class="basket-dropdown-message">Has been added to your basket.</div>`);
    basketDropdown.fadeIn(100);
}

function basketSummary(isBasket = false) {
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
        $('.table-basket tbody').append('' +
            '<tr ' + backOrder + ' id="' + details.product.product + '">' +
            '<td>' +
            '<div class="basket-image__container d-inline-block"><img class="basket-image" src="' + details.product.image + '" alt="' + details.product.product + '"></div>' +
            '<h2 class="section-title d-inline-block"><a href="' + details.product.link + '">' + details.product.name + '</a></h2>' +
            '</td>' +
            '<td id="basket__product">' + details.product.product + '</td>' +
            '<td>' + details.product.unit + '</td>' +
            '<td class="text-right">' + details.product.stock + '</td>' +
            '<td class="text-right">' + details.product.net_price + '</td>' +
            '<td class="quantity-column"><input name="line_qty" class="form-control form-quantity" value="' + details.product.quantity + '" autocomplete="off">' +
            '<span class="quantity-options"><span id="basket_line__update" class="quantity-update">Update</span> <span id="basket-line__remove" class="quantity-remove">Remove</span></span>' +
            '</td>' +
            '<td class="text-right">' + details.product.price + '</td>' +
            '</tr>'
        );
    }
}
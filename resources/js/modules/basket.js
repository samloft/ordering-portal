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

    addProductToBasket(product.val(), quantity.val(), true);

    product.val('');
    quantity.val(1);
});

$('form[id="product-add-basket-checkout"]').on('submit', function (e) {
    e.preventDefault();

    let product = $(this).find('input[name="product"]'),
        quantity = $(this).find('input[name="quantity"]');

    addProductToBasket(product.val(), quantity.val(), false);

    product.val('');
    quantity.val(1);
});

$('form[id="product-add-basket-products"]').on('submit', function (e) {
    e.preventDefault();

    let product = $(this).find('input[name="product"]'),
        quantity = $(this).find('input[name="quantity"]');

    addProductToBasket(product.val(), quantity.val(), true);
});

function addProductToBasket(product, quantity, displayDropdown = false) {
    $.post('/basket/add-product', {
        product: product,
        quantity: quantity
    }).done(function (response) {
        if (response.error) {
            return swal('Error', response.message, 'error');
        }

        basketSummary();

        if (displayDropdown) {
            basketAddedDropdown(response.product);
        }

        if (response.message) {
            return swal('Warning', response.message, 'warning');
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

function basketSummary() {
    $.get('/basket/summary').done(function (response) {
        $('.basket-info .order-lines').html(response.lines);
        $('.basket-info .order-total').html(response.goods_total);
    });
}
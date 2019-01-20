let basketDropdown = $('.basket-dropdown');

$("#header-basket").mouseenter(function () {
    basketDropdown.html('Hi');

    basketDropdown.fadeToggle('fast');
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

    basketDropdown.html(`<div class="row"><div class="col-auto"><img src="${productDetails.image}"></div><div class="col details"><h3>${productDetails.product}</h3><span>${productDetails.name}</span><span>Qty: ${productDetails.quantity}</span><span>Price: ${productDetails.price}</span></div></div><div class="basket-dropdown-message">Has been added to your basket.</div>`)
        .fadeIn(100);
}

function basketSummary() {
    $.get('/basket/summary').done(function (response) {
        $('.basket-info .order-lines').html(response.lines);
        $('.basket-info .order-total').html(response.goods_total);
    });
}
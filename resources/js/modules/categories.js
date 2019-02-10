$(function () {
    $('.sub-category-image[data-products]').each(function (index, item) {
        let products = $(item).data('products');

        $.get('/category/image/' + products, {}).done(function (response) {
            $(item).find('.spinner').remove();
            $(item).append('<img src="' + response + '">');
        });
    });
});
$(function () {
    $('input[id="quick-buy"]').autocomplete({
        minLength: 2,
        // autoFocus: true,
        // select: function( event, ui ) {
        //     $(this).val( ui.item.id );
        //     $(this).closest('form').submit();
        // },
        source: function (request, response) {
            $.ajax({
                url: '/products/autocomplete/' + $('input[id="quick-buy"]').val().toUpperCase(),
                type: 'GET',
                success: function (data) {
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
});
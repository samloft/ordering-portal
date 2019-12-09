$(function () {
    $('input[id="customer-admin"]').autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.post('/customer/autocomplete', {
                customer: $('input[id="customer-admin"]').val().toUpperCase()
            }).done(function (data) {
                response($.map(data, function (value) {
                    return {
                        label: value.customer_code.trim() + ' - ' + value.customer_name.trim(),
                        value: value.customer_code.trim()
                    };
                }));
            });
        }
    });
});

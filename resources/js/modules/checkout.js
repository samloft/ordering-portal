$('select[name="shipping"]').on('change', function () {
    var shippingValue = $(this).find(':selected').data('cost').toFixed(2);

    basketSummaryCheckout(shippingValue);
});

function basketSummaryCheckout(shippingValue) {
    $.get('/basket/summary/' + shippingValue).done(function (response) {
        $.each(response.summary, function(key, value) {
            $('#' + key).text(value);
        });
    });
}
$(function () {
    // $('input[id="quick-buy"]').autocomplete({
    //     minLength: 2,
    //     // autoFocus: true,
    //     // select: function( event, ui ) {
    //     //     $(this).val( ui.item.id );
    //     //     $(this).closest('form').submit();
    //     // },
    //     source: function (request, response) {
    //         $.ajax({
    //             url: '/products/autocomplete/' + $('input[id="quick-buy"]').val().toUpperCase(),
    //             type: 'GET',
    //             success: function (data) {
    //                 response($.map(data, function (value) {
    //                     return {
    //                         label: value.product.trim(),
    //                         value: value.product.trim()
    //                     };
    //                 }));
    //             }
    //         });
    //     }
    // });

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

            // $.ajax({
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

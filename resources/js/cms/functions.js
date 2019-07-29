window.removeInputErrors = function () {
    $('input').removeClass('is-invalid');
    $('.invalid-feedback').remove();
};

window.addInputErrors = function (formId, data) {
    $.each(data, function (key, value) {
        $(formId + ' input[name="' + key + '"]')
            .addClass('is-invalid')
            .after('<div class="invalid-feedback">' + value + '</div>');
    });
};

window.addExtraCustomerToTable = function (customer, id) {
    $('#extra-customers-modal tbody').append('<tr>' +
        '<td>' + customer + '</td>' +
        '<td class="text-right"><button id="delete-extra-customer" class="btn btn-sm btn-danger" value="' + id + '">Remove</button></td>' +
        '</tr>');
};
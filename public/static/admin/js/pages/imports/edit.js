$(document).ready(function () {
    $(".employee-id").select2({
        placeholder: "Select Employee",
        allowClear: true
    }).val(Boilerplate.employeeId).trigger("change");

    $('select[name="modal_product_name"]').on('change', function () {
        generateOptions();
        generateUnit();
    });

    $('select[name="modal_product_option"]').on('change', function () {
        $('#modal-import-price').val($('#modal-product-option option:selected').attr('p'));
        $('#modal-current-quantity').text($('#modal-product-option option:selected').attr('q') + ' +');
    });

    var index = 0;
    $('#modal-save').on('click', function () {
        productId   = $('#modal-product-name').val();
        option      = $('#modal-product-option').val();
        price       = $('#modal-import-price').val();
        quantity    = $('#modal-quantity').val();
        unit        = $('#modal-unit').attr('uid');

        if( productId && option && quantity > 0 ) {
            var content = '';
            content += '' +
                '<tr>' +
                    '<td>' +
                        $('#modal-product-name :selected').text() +
                        '<input type="hidden" name="products[' + index + '][id]" value=' + "'" + productId + "'" + '>' +
                    '</td>' +

                    '<td>' +
                        $('#modal-product-option :selected').text() +
                        '<input type="hidden" name="products[' + index + '][option_id]" value=' + "'" + option + "'" + '>' +
                    '</td>' +

                    '<td>' +
                        $('#modal-import-price').val() +
                        '<input type="hidden" name="products[' + index + '][import_price]" value=' + "'" + price + "'" + '>' +
                    '</td>' +

                    '<td>' +
                        quantity +
                        '<input type="hidden" name="products[' + index + '][quantity]" value=' + "'" + quantity + "'" + '>' +
                    '</td>' +

                    '<td>' +
                        $('#modal-unit').val() +
                        '<input type="hidden" name="products[' + index + '][unit_id]" value=' + "'" + unit + "'" + '>' +
                    '</td>' +

                    '<td>' +
                        quantity * price +
                    '</td>' +

                    '<td style="text-align: center">' +
                        '<span onclick="deleteProduct(this);" style="cursor: pointer; color: #ca2424;"> Delete</span>' +
                    '</td>' +
                '</tr>';
            $('#import-products').append(content);
        }

        index++;
        $('.close').click();
    });

});

function generateOptions() {
    optionUrl = $('#modal-product-name option:selected').attr('option-url');

    $('select[name="modal_product_option"]').html('');

    $.ajax({
        type: 'GET',
        url: optionUrl,
        data: {
        },
        success: function (response) {
            if( response.code == 100 ) {
                response.data.forEach(function (option, index) {
                    $('select[name="modal_product_option"]').append('<option value="' + option.id + '" p="' + option.import_price + '" q="' + option.quantity + '">' + option.name + '</option>');
                });

                $('#modal-import-price').val($('#modal-product-option option:selected').attr('p'));
                $('#modal-current-quantity').text($('#modal-product-option option:selected').attr('q') + ' +');
            } else {
                alert(response.message);
            }
        },
        error: function () {

        }
    });

}

function generateUnit() {
    productId = $('#modal-product-name').val();

    Boilerplate.products.forEach(function (product) {
        if (product.id == productId) {
            $('#modal-unit').val(product.unit_name);
            $('#modal-unit').attr('uid', product.unit_id);
        }
    });
}

function resetModalImport() {
    $('#modal-product-name').val('');
    $('#modal-product-option').html('');
    $('#modal-product-option').append('<option value="">Select a Option</option>');
    $('#modal-import-price').val(0);
    $('#modal-quantity').val(0);
    $('#modal-current-quantity').text('0 +');
}

function deleteProduct(span) {
    if (confirm('Are You Sure ?')) {
        $(span).parent().parent().remove();
    }
}


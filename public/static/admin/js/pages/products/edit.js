$(function () {

    $('select[name="category_id"]').on('change', function () {
        generateSubcategories();
    });

    //--------------- when click save new product options ----------------
    var index = 0;
    $('#save-properties').on('click', function () {
        importPrice = parseInt($('#option-import-price').val());
        exportPrice = parseInt($('#option-export-price').val());
        quantity = parseInt($('#option-quantity').val());

        propertiesName = '';
        propertiesCode = '{';
        $('input[name="property_name[]"]').each(function (index, value) {
            property = value.value;
            values = $('input[name="property_values[]')[index].value;
            if (property != '' && values != '') {
                propertiesName += index ? (' | ' + property + ': ' + values) : (property + ': ' + values);
                propertiesCode += index ? (', "' + property + '": "' + values + '"') : ('"' + property + '": "' + values + '"');
            }
        });
        propertiesCode += '}';

        if (propertiesName == '') {
            alert('Chưa nhập thuộc tính cho sản phẩm!');
            return false;
        }
        newRow =    '<tr>' +
                        '<td>' +
                            importPrice +
                            '<input type="hidden" name="options[' + index + '][import_price]" value="' + importPrice + '">' +
                        '</td>' +
                        '<td>' +
                            exportPrice +
                            '<input type="hidden" name="options[' + index + '][export_price]" value="' + exportPrice + '">' +
                        '</td>' +
                        '<td>' +
                            quantity +
                            '<input type="hidden" name="options[' + index + '][quantity]" value="' + quantity + '">' +
                        '</td>' +
                        '<td>' +
                            propertiesName +
                            '<input type="hidden" name="options[' + index + '][properties]" value=' + "'" + propertiesCode + "'" + '>' +
                        '</td>' +
                        '<td>' +
                            '<span onclick="deleteProductOption(this);" style="cursor: pointer; color: #ca2424;"> Delete</span>' +
                        '</td>' +
                    '</tr>';
        $('.create-product-options').append(newRow);

        index++;
        resetModalProductOption();
        $('.close').click();
    });
    //-------------------------------

    // upload images
    $('#product-images').filer({
        limit: 5,
        maxSize: 30, // Maximal file size in MB's.
        extensions: ['jpg', 'jpeg', 'png'],
        showThumbs: true,
        addMore: true,
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                                </div>\
                            </div>\
                        </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
    });
});

function generateSubcategories() {
    $('select[name="subcategory_id"]').html('');
    Boilerplate.subcategories.forEach(function (subcategory) {
        if (subcategory.category_id == $('select[name="category_id"]').val()) {
            $('select[name="subcategory_id"]').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
        }
    });
}

function deleteProductOption(span) {
    if (confirm('Are You Sure ?')) {
        $(span).parent().parent().remove();
    }
}

// Make default Modal create new Options
function resetModalProductOption() {
    $('.rowDelete').click();
    $('#option-import-price').val(0);
    $('#option-export-price').val(0);
    $('#option-quantity').val(0);
}

//--------------- auto init row in modal create option ----------------
var initRow = $('#initRow'), section = initRow.parent('section');

initRow.on('focus', 'input', function () {
    addRow(section, initRow);
});
function addRow(section, initRow) {
    var newRow = initRow.clone().removeAttr('id').addClass('new').insertBefore(initRow),
        deleteRow = $('<a class="rowDelete"><img src="http://i.imgur.com/ZSoHl.png"></a>');

    newRow
        .append(deleteRow)
        .on('click', 'a.rowDelete', function () {
            removeRow(newRow);
        })
        .slideDown(300, function () {
            $(this)
                .find('input:first-child').focus();
        })
}

function removeRow(newRow) {
    newRow
        .slideUp(200, function () {
            $(this)
                .next('div:not(#initRow)')
                .find('input').focus()
                .end()
                .end()
                .remove();
        });
}
//-------------------------------
$(document).ready(function () {

    $(document).on('change', '.serv-renewal-select', function () {


        var selectedValue = $(this).val();
        var dateInput = $(this).closest('td').find('.date_picker.serv_other_renewal_date_input');


        if (selectedValue == 5) {
            dateInput.show();
        } else {
            dateInput.hide();
        }
    });

    $(document).on('change', '.pro-renewal-select', function () {
        var selectedValue = $(this).val();
        var dateInput = $(this).closest('td').find('.date_picker.pro_other_renewal_date_input');

        if (selectedValue == 5) {
            dateInput.show();
        } else {
            dateInput.hide();
        }

    });
    new DataTable('#product_table');
    new DataTable('#service_table');
    // new DataTable('#invoice_table');
    new DataTable('#client_table');
    // Initialize DataTable for the main table
    // Initialize DataTable for the main table
    flatpickr('.date_picker', {
        // "minDate": new Date().fp_incr(1)
    });



});

let serviceRowCount = 1;

function addNewServiceRow() {
    serviceRowCount++;
    let newSelect = $('#serviceSelect-1').clone();
    newSelect.attr('id', `serviceSelect-${serviceRowCount}`);
    newSelect.val('');
    var service_html=$('#services_select').html();
    select=`<select type="text"
    class="form-control bg-light border-0 service-select"
    id="serviceSelect-${serviceRowCount}" placeholder="Service Name"
    name="service_name[]">
    ${service_html}
    </select>`;
    let newRow = `<tr id="serviceRow-${serviceRowCount}" class="service">
            <td></td>
            <td class="text-start">
                <div class="mb-2">
                    ${select}
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 service-line-price" id="servicePrice-${serviceRowCount}" placeholder="$0.00" name="service_amount[]"/>
                </div>
            </td>

            <td class="text-end">
            <input type="text"
            class="form-control bg-light border-0 service_quantity"
            id="service_quantity-${serviceRowCount}" placeholder=""
            name="service_quantity[]" />
        </td>
        <td class="text-end">
            <div>
                <input type="text"
                    class="form-control bg-light border-0 total_service"
                    id="total_service-${serviceRowCount}" placeholder="OMR 0.00"
                    name="total_service[]" />
            </div>
        </td>

        <td class="text-end">
            <div>
                <input type="text"
                    class="form-control bg-light border-0 service_warranty"
                    id="service_warranty-${serviceRowCount}"
                    name="service_warranty[]" />
            </div>
        </td>

            <td>
                <textarea class="form-control bg-light border-0" name="service_detail[]"
                id="serviceDetails-${serviceRowCount}" rows="2" placeholder="Service Details"></textarea>
            </td>
            <td class="service-removal">
                <a href="javascript:void(0)" class="btn btn-success"
                 onclick="deleteRow(${serviceRowCount})"><i class="ri-delete-bin-3-line"></i></a>
            </td>
        </tr>`;






    $('#serviceRows tr:last').before(newRow);

    flatpickr(`#serviceRow-${serviceRowCount} .date_picker`, {
        // Your date picker options
        // "minDate": new Date().fp_incr(1)
    });
    updateTotal();
}

let rowCount = 1;

function addNewRow() {
    rowCount++;
    let newSelect = $('#productName-1').clone();
    newSelect.attr('id', `productName-${rowCount}`);
    newSelect.val('');
    var product_html=$('#products_select').html();
    var select_product=`<select  type="text" class="form-control bg-light border-0 product-select" id="productName-${rowCount}" name="product_name[]">
    ${product_html}
    </select>`;
    let newRow = `<tr id="${rowCount}" class="product">
            <td></td>
            <td class="text-start">
                <div class="mb-2">
                    ${select_product}
                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control bg-light border-0 product-line-price" id="productPrice-${rowCount}" placeholder="$0.00" name="product_amount[]"/>
                </div>
            </td>
            <td class="text-end">
            <input type="text"
            class="form-control bg-light border-0 quantity"
            id="quantity-${rowCount}" placeholder=""
            name="quantity[]" />
        </td>
        <td class="text-end">
            <div>
                <input type="text"
                    class="form-control bg-light border-0 total_price"
                    id="total_price-${rowCount}" placeholder="OMR 0.00"
                    name="total_price[]" />
            </div>
        </td>
        <td class="text-end">
        <div>
            <input type="text"
                class="form-control bg-light border-0 product_warranty"
                id="product_warranty-${rowCount}"
                name="product_warranty[]" />
        </div>
         </td>
            <td>
                <textarea class="form-control bg-light border-0" name="product_detail[]"
                 id="productDetails-${rowCount}" rows="2" placeholder="Product Details"></textarea>
            </td>
            <td class="product-removal">
                <a href="javascript:void(0)" class="btn btn-success"
                onclick="deleteRow1(${rowCount})"><i class="ri-delete-bin-3-line"></i></a>
            </td>
        </tr>`;

    $('#newlink tr:last').before(newRow);

    flatpickr(` #${rowCount} .date_picker`);

    updateTotal();
}

function deleteRow(rowId) {
    $(`#serviceRow-${rowId}`).remove();
    updateTotal();
}

function deleteRow1(rowId1) {
    $(`#${rowId1}`).remove();
    updateTotal();
}

function updateTotal() {
    let total = 0;

    $('.product-line-price').each(function () {
        total += parseFloat($(this).val()) || 0;
    });

    $('.service-line-price').each(function () {
        total += parseFloat($(this).val()) || 0;
    });

    $('#cart-subtotal').val(total.toFixed(2));
    updateRemainingAmount();
}

function updateRemainingAmount() {
    let totalAmount = parseFloat($('#cart-subtotal').val()) || 0;
    let paidAmount = parseFloat($('#cart-paid').val()) || 0;
    let remainingAmount = totalAmount - paidAmount;
    $('#cart-total').val(remainingAmount.toFixed(2));
}

$(document).on('input', '.product-line-price, .service-line-price', function () {
    updateTotal();
});

$(document).on('input', '#cart-paid', function () {
    updateRemainingAmount();
});


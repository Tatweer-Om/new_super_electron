 // Function to calculate and update the total amount
 function updateTotal() {
    var total = 0;

    // Iterate over product amounts
    $('.product-line-price').each(function () {
        var productAmount = parseFloat($(this).val()) || 0;
        total += productAmount;
    });

    // Iterate over service amounts
    $('.service-line-price').each(function () {
        var serviceAmount = parseFloat($(this).val()) || 0;
        total += serviceAmount;
    });

    // Display the total in the total input field
    $('#cart-subtotal').val(total.toFixed(2));

    // Update the remaining amount
    updateRemainingAmount();
}

// Function to update the remaining amount
function updateRemainingAmount() {
    var totalAmount = parseFloat($('#cart-subtotal').val()) || 0;
    var paidAmount = parseFloat($('#cart-paid').val()) || 0;
    var remainingAmount = totalAmount - paidAmount;

    // Display the remaining amount
    $('#cart-total').val(remainingAmount.toFixed(2));
}

// Add event listeners for product and service amounts
$(document).on('input', '.product-line-price, .service-line-price', function () {
    updateTotal();
});

// Add event listener for paid amount
$(document).on('input', '#cart-paid', function () {
    updateRemainingAmount();
});

// Function to add a new product row
function addNewRow() {
    var newRow = $('#newlink tr:last').clone();
    var currentId = parseInt(newRow.attr('id')) + 1;

    newRow.attr('id', currentId);

    // Reset values in the new row
    newRow.find('.product-line-price').val('');
    newRow.find('input[type="date"]').val('');
    newRow.find('textarea').val('');

    $('#newlink').append(newRow);
    updateTotal();
}

// Function to add a new service row
function addNewServiceRow() {
    var newRow = $('#serviceRows tr:last').clone();
    var currentId = parseInt(newRow.attr('id').split('-')[1]) + 1;

    newRow.attr('id', 'serviceRow-' + currentId);

    // Reset values in the new row
    newRow.find('.service-line-price').val('');
    newRow.find('input[type="date"]').val('');
    newRow.find('textarea').val('');

    $('#serviceRows').append(newRow);
    updateTotal();
}

// Function to delete a row
function deleteRow(row) {
    $(row).closest('tr').remove();
    updateTotal();
}

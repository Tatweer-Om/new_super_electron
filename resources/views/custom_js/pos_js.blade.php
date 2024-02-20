<script>
    $(document).ready(function() {
        cat_products('all');
        $('#clear_list').click(function() {
            $('#order_list').empty();
        });

        $('#order_list').on('click', '#delete-item', function() {
            var $productItem = $(this).closest('.product-list');
            $productItem.remove();
        });

        $(document).on('click', '.inc', function() {
        var $qtyInput = $(this).siblings('.qty-input');
        var count = parseInt($qtyInput.val());
        count++;
        $qtyInput.val(count);
    });

    // Event delegation for minus button
        $(document).on('click', '.dec', function() {
            var $qtyInput = $(this).siblings('.qty-input');
            var count = parseInt($qtyInput.val());
            if (count > 1) {
                count--;
                $qtyInput.val(count);
        }
    });
});

    function cat_products(cat_id)
    {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: "{{ url('cat_products') }}",
            data: {
                cat_id: cat_id,
                _token: csrfToken
            },
            success: function(response) {
                // Clear existing products
                $('#cat_products').html("");

                // Iterate over each product in the response
                var productHtml="";
                response.products.forEach(function(product) {
                    // Append product HTML to the container
                    productHtml=productHtml+ `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 pe-2">
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg" onclick="order_list(${product.barcode})">
                                    <img src="{{ asset('images/product_images/') }}/${product.stock_image}" alt="Products">
                                     <span ><i data-feather="check" class="feather-16"></i></span>
                                </a>
                                <h6 class="cat-name"><a href="javascript:void(0);">${response.category_name}</a></h6>
                                <h6 class="product-name"><a href="javascript:void(0);">${product.product_name}</a></h6>
                                <div class="d-flex align-items-center justify-content-between price">
                                    <span>${product.quantity} PCs</span>
                                    <p> OMR ${product.sale_price}</p>
                                </div>
                            </div>
                        </div>
                    `;

                });
                $('#cat_products').html(productHtml);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function order_list(product_barcode) {

        var quantity =1;
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "POST",
            url: "{{ url('order_list') }}",
            data: {
                product_barcode: product_barcode,
                _token: csrfToken
            },
            success: function(response) {
                if ($('#order_list').find('div.list_' + product_barcode).length > 0) {
                    var $existingProduct = $('#order_list').find('div.list_' + product_barcode);
                    var $qtyInput = $existingProduct.find('.qty-input');
                    var count = parseInt($qtyInput.val());
                    count++;
                    $qtyInput.val(count);

                }
                else
                {
                    var orderHtml = `
                        <div class="product-list d-flex align-items-center justify-content-between list_${product_barcode}">
                            <div class="d-flex align-items-center product-info" data-bs-toggle="modal" data-bs-target="#products">
                                <a href="javascript:void(0);" class="img-bg">
                                    <img src="{{ asset('images/product_images/') }}/${response.product_image}" alt="${response.product_name}">
                                </a>
                                <div class="info">
                                    <span>${response.product_barcode}</span>
                                    <h6><a href="javascript:void(0);">${response.product_name}</a></h6>
                                    <p>OMR ${response.product_price}</p>
                                </div>
                            </div>
                            <div class="qty-item text-center">
                                <a href="javascript:void(0);" class="dec d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="minus"><i class="fas fa-minus"></i></a>
                                <input type="text" class="form-control text-center qty-input" name="qty" value="1">
                                <a href="javascript:void(0);" class="inc d-flex justify-content-center align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" title="plus"><i class="fas fa-plus"></i></a>
                            </div>
                            <div class="d-flex align-items-center action">
                                <a class="btn-icon edit-icon me-2 "  href="${response.product_id}" data-bs-toggle="modal" data-bs-target="#edit-product"><i class="fas fa-edit"></i></a>
                                <a class="btn-icon delete-icon confirm-text " id ="delete-item" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    `;

                    $('#order_list').append(orderHtml);

                }
            },
            error: function(xhr, status, error)
            {

                console.error(xhr.responseText);
            }
        });
    }







</script>

@extends('layouts.app')

@section('content')
<style>
.autocomplete-items {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ddd;
    max-height: 150px;
    overflow-y: auto;
    z-index: 1000;
    width: 96%;
}

.autocomplete-item {
    padding: 10px;
    cursor: pointer;
}

.autocomplete-item:hover {
    background-color: #f0f0f0;
}
</style>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Edit Invoice</h5>
                                <div class="float-right">
                                    <a href="{{ route('invoices.index') }}" class="btn btn-primary btn-md primary-btn">
                                        <i class="feather icon-arrow-left"></i>
                                        Go Back
                                    </a>
                                </div>
                            </div>

                            <div class="card-block">
                                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoiceForm">
                                    @csrf
                                    @method('PUT') {{-- Use PUT method for update --}}
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="job">Jobs</label>
                                            <select name="job_id" id="job_id" class="form-control">
                                                <option value="" selected disabled>Select Job</option>
                                                @foreach($jobs as $job)
                                                    <option value="{{ $job->id }}" {{ $job->id == $invoice->job_id ? 'selected' : '' }}>{{ $job->name .' '. $job->vehicle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 products-list">
                                            <label for="products">Products</label>
                                            <div id="product-fields">
                                                <?php
                                                   $data = json_decode($invoice->product_details);
                                                ?>
                                                @foreach($data->products as $key => $invoiceProduct)
                                                <div class="form-row product-row">
                                                        <div class="col-md-3">
                                                            <input name="product[]" type="text" class="form-control product-autocomplete" placeholder="Product" value="{{ optional($invoiceProduct)->product }}">
                                                            <div class="autocomplete-items"></div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input name="price[]" type="text" class="form-control cost-price" placeholder="Cost Price" value="{{ optional($invoiceProduct)->price }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input name="discount[]" type="text" class="form-control discount" placeholder="Discount" value="{{ optional($invoiceProduct)->discount }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button class="btn btn-danger removeButton remove-button" type="button">
                                                                <i class="bi bi-trash"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div id="newinput"></div>
                                            <button id="rowAdder" type="button" class="btn btn-add btn-sm">
                                                <i class="fa fa-plus"></i> Add More
                                            </button>
                                            <br><br>
                                            <div id="totalAmountDisplay" class="mt-3">
                                                Total Amount: <span id="totalAmount">{{ $data->totalAmount }}</span>
                                            </div><br>
                                            <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generateProductRow() {
        var html = '<div class="form-row product-row">' +
            '<div class="col-md-3">' +
            '<input name="product[]" type="text" class="form-control product-autocomplete" placeholder="Product">' +
            '<div class="autocomplete-items"></div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<input name="price[]" type="text" class="form-control cost-price" placeholder="Cost Price">' +
            '</div>' +
            '<div class="col-md-3">' +
            '<input name="discount[]" type="text" class="form-control discount" placeholder="Discount">' +
            '</div>' +
            '<div class="col-md-3">' +
            '<button class="btn btn-danger removeButton remove-button" type="button">' +
            '<i class="bi bi-trash"></i> Remove' +
            '</button>' +
            '</div>' +
            '</div>';
        return html;
    }

    $(document).ready(function() {
        // Initialize products list visibility based on job selection
        $('#job_id').on('change', function() {
            var job_id = $(this).val();
            if (job_id) {
                $(".products-list").removeAttr('hidden');
            } else {
                $(".products-list").attr('hidden', 'hidden');
            }
        });

        // Add row functionality
        $('#rowAdder').click(function() {
            $('#product-fields').append(generateProductRow());
            $('.remove-button').removeClass('d-none');
        });

        // Remove row functionality
        $('body').on('click', '.remove-button', function() {
            var productRows = $('.product-row');
            if (productRows.length > 1) {
                $(this).closest('.product-row').remove();
            } else {
                $(this).closest('.product-row').find('input').val('');
            }
            if ($('#product-fields .product-row').length === 1) {
                $('.remove-button').addClass('d-none');
            }
            calculateTotalAmount();
        });

        // Product autocomplete functionality
        $('body').on('input', '.product-autocomplete', function() {
            var input = $(this).val().trim();
            var autocompleteContainer = $(this).siblings('.autocomplete-items');

            $.ajax({
                type: 'GET',
                url: '{{ route('autocomplete') }}',
                data: { input: input },
                success: function(response) {
                    autocompleteContainer.empty();
                    if (response.length > 0) {
                        $.each(response, function(key, value) {
                            var autocompleteItem = '<div class="autocomplete-item" data-id="' + value.id + '">' + value.name + '</div>';
                            autocompleteContainer.append(autocompleteItem);
                        });
                    }
                }
            });
        });

        // Selecting autocomplete item functionality
        $('body').on('click', '.autocomplete-item', function() {
            var productName = $(this).text();
            console.log(productName);
            var productId = $(this).data('id');
            var productRow = $(this).closest('.product-row');
            var inputField = productRow.find('.product-autocomplete');
            inputField.val(productName);
            $.ajax({
                type: 'GET',
                url: '{{ route('getProductDetails') }}',
                data: { productName: productName },
                success: function(response) {
                    if (response.success) {
                        productRow.find('.cost-price').val(response.product.price);
                        productRow.find('.discount').val(response.product.discount);
                        calculateTotalAmount();
                    } else {
                        console.error('Failed to fetch product details.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Get Product Details AJAX error:', status, error);
                }
            });

            $(this).parent('.autocomplete-items').empty().hide();
        });

        function calculateTotalAmount() {
            var totalAmount = 0;

            $('.product-row').each(function() {
                var price = $(this).find('.cost-price').val();
                var discount = $(this).find('.discount').val();

                price = parseFloat(price) || 0;
                discount = parseFloat(discount) || 0;

                var totalPrice = price - (price * discount / 100);
                totalAmount += totalPrice;
            });

            $('#totalAmount').text('$' + totalAmount.toFixed(2));
        }

        $('#invoiceForm').submit(function(e) {
            if (!validateInputs()) {
                e.preventDefault();
            }
        });

        function validateInputs() {
            var isValid = true;

            $('.product-row').each(function() {
                var productInput = $(this).find('.product-autocomplete');
                var priceInput = $(this).find('.cost-price');
                var discountInput = $(this).find('.discount');

                if (productInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a product name.');
                    return false;
                }

                if (priceInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a cost price.');
                    return false;
                }

                if (discountInput.val().trim() === '') {
                    isValid = false;
                    alert('Please enter a discount.');
                    return false;
                }
            });

            return isValid;
        }

        $('body').on('input', '.cost-price, .discount', function() {
            calculateTotalAmount();
        });
    });
</script>

@endsection

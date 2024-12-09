@extends('masteradmin.layouts.app')
<title>Profityo | Edit Bills</title>
@if(isset($access['update_bills']) && $access['update_bills'] == 1) 
@section('content')
<link rel="stylesheet" href="{{ url('public/vendor/flatpickr/css/flatpickr.css') }}">


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __('Edit Bill') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __('Edit Bill') }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br">cancel</button></a>
              <a href="#"><button class="add_btn">Save</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        @if(Session::has('bill-edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('bill-edit') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
            @php
            Session::forget('bill-edit');
        @endphp
        @endif
        <!-- card -->   
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit Bill</h3>
          </div>
          <!-- /.card-header -->
          <form id="items-form" action="{{ route('business.bill.update', ['id' => $bill->sale_bill_id]) }}" method="POST">
          @csrf
          @method('Patch')
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Vendor <span class="text-danger">*</span></label>
                  <?php //dd($bill->sale_vendor_id); ?>
                  <select class="form-control select2" name="sale_vendor_id" id="sale_vendor_id" style="width: 100%;" required>
                    <option>Select a Vendor...</option>
                    @foreach($salevendor as $vendor)
                        <option value="{{ $vendor->purchases_vendor_id }}" {{ $bill->sale_vendor_id == $vendor->purchases_vendor_id ? 'selected' : '' }}>
                        {{ $vendor->purchases_vendor_name }}
                        </option>
                    @endforeach
                  </select>
                  <p class="mb-0">{{ $bill->vendor->purchases_vendor_name }}</p>
                  <p class="mb-0">{{ $bill->vendor->purchases_vendor_address1 }}</p>
                  <p class="mb-0">{{ $bill->vendor->purchases_vendor_address2 }}</p>
                  <p class="mb-0">{{ $bill->vendor->purchases_vendor_city_name }}, {{ $bill->vendor->state->name }} {{ $bill->vendor->purchases_vendor_zipcode }}</p>
                  <p class="mb-0">{{ $bill->vendor->country->name }}</p>
                  <p class="mb-0">{{ $bill->vendor->purchases_vendor_email }}</p>
                  <span class="error-message" id="error_sale_vendor_id" style="color: red;"></span> 

                </div>

              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Bill Date</label>
                  <div class="input-group date" id="billdate" data-target-input="nearest">
                    <!-- <input type="text" class="form-control datetimepicker-input" placeholder="" data-target="#billdate">
                    <div class="input-group-append" data-target="#billdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div> -->
                    <input type="hidden" id="from-datepicker-hidden" value="{{ $bill->sale_bill_date }}" /> 
                    @php
                        $saleBillDate = \Carbon\Carbon::parse($bill->sale_bill_date)->format('m/d/Y');
                    @endphp

                    <x-flatpickr id="from-datepicker" class="form-control" name="sale_bill_date" placeholder="Select a date" :value="$saleBillDate"  />
                    <div class="input-group-append">
                        <div class="input-group-text" id="from-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="billnumber">Bill #</label>
                  <input type="number" name="sale_bill_number" id="sale_bill_number" class="form-control" id="billnumber" placeholder="Enter Bill #" value="{{ $bill->sale_bill_number }}">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Currency <span class="text-danger">*</span></label>
                  <select class="form-control select2" id="sale_currency_id" name="sale_currency_id"style="width: 100%;" required>
                    <option>Select a Currency...</option>
                    @foreach($currencys as $curr)
                        <option value="{{ $curr->id }}" data-symbol="{{ $curr->currency_symbol }}" {{ $curr->id == $bill->sale_currency_id ? 'selected' : '' }}>
                        {{ $curr->currency }} ({{ $curr->currency_symbol }}) - {{ $curr->currency_name }}
                        </option>
                    @endforeach
                  </select>
                  <span class="error-message" id="error_sale_currency_id" style="color: red;"></span> 
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Due Date</label>
                  <div class="input-group date" id="duedate" data-target-input="nearest">
                  <input type="hidden" id="to-datepicker-hidden" value="{{ $bill->sale_bill_valid_date }}" />
                  @php
                        $saleBillDueDate = \Carbon\Carbon::parse($bill->sale_bill_valid_date)->format('m/d/Y');
                    @endphp
                  <x-flatpickr id="to-datepicker" class="form-control" name="sale_bill_valid_date" placeholder="Select a date" :value="$saleBillDueDate"/>
                    <div class="input-group-append">
                        <div class="input-group-text" id="to-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sale_bill_customer_ref">P.O./S.O.</label>
                  <input type="text" class="form-control" id="sale_bill_customer_ref" name="sale_bill_customer_ref" placeholder="Enter P.O./S.O." value="{{ $bill->sale_bill_customer_ref }}">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="sale_bill_note">Notes</label>
                  <textarea id="sale_bill_note" name="sale_bill_note" class="form-control" rows="3" placeholder="">{{ $bill->sale_bill_note }}</textarea>
                </div>
              </div>
            </div>
            <div class="row px-10">
              <div class="col-md-12 text-right">
                <a id="add" class="additem_btn"><i class="fas fa-plus add_plus_icon"></i>Add A Line</a>
              </div>
              <div class="col-md-12 table-responsive ">
                <table class="table table-hover text-nowrap dashboard_table item_table" id="dynamic_field">
                  <thead>
                  <tr>
                    <th style="width: 22%;">Items<span class="text-danger">*</span></th>
                    <th style="width: 22%;">Expense Category<span class="text-danger">*</span></th>
                    <th style="width: 15%;">Quantity<span class="text-danger">*</span></th>
                    <th style="width: 15%;">Price<span class="text-danger">*</span></th>
                    <th>Tax</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($billsItems as $item)
                  <tr class="item-row" id="item-row-template">
                    <td>
                    <div>
                      <select class="form-control select2" name="items[][sale_product_id]" style="width: 100%;">
                      <option>Select Items</option>
                      @foreach($products as $product)
                  <option value="{{ $product->purchases_product_id }}" {{ $product->purchases_product_id == $item->sale_product_id ? 'selected' : '' }}>
                  {{ $product->purchases_product_name }}
                  </option>
                @endforeach
                      </select>
                      <span class="error-message" id="error_items_0_sale_product_id" style="color: red;"></span>

                      <input type="text" class="form-control px-10" name="items[][sale_bill_item_desc]"
                      placeholder="Enter item description" value="{{ $item->sale_bill_item_desc }}">
                      <span class="error-message" id="error_items_0_sale_bill_item_desc" style="color: red;"></span>
                    </div>
                    </td>
                    <td>
                    <select class="form-control select2" name="items[][sale_expense_id]" style="width: 100%;">
                      <option>Select Category</option>
                      @foreach($ExpenseAccounts as $accounts)
                        <option value="{{ $accounts->chart_acc_id }}" {{ $accounts->chart_acc_id == $item->sale_expense_id ? 'selected' : '' }}>
                        {{ $accounts->chart_acc_name }}
                        </option>
                      @endforeach
                      </select>
                      <span class="error-message" id="error_items_0_sale_expense_id" style="color: red;"></span>
                    </td>
                    <td><input type="number" class="form-control" name="items[][sale_bill_item_qty]"
                      placeholder="Enter item Quantity" min="1" value="{{ $item->sale_bill_item_qty }}">
                    <span class="error-message" id="error_items_0_sale_bill_item_qty" style="color: red;"></span>
                    </td>
                    <td>
                    <div class="d-flex">
                      <input type="text" name="items[][sale_bill_item_price]" class="form-control"
                      aria-describedby="inputGroupPrepend" placeholder="Enter item Price" value="{{ $item->sale_bill_item_price }}">

                    </div>
                    <span class="error-message" id="error_items_0_sale_bill_item_price" style="color: red;"></span>
                    </td>

                    <td>
                    <select class="form-control select2" name="items[][sale_bill_item_tax]" style="width: 100%;">
                      @foreach($salestax as $salesTax)
                        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}"
                        {{ $salesTax->tax_id == $item->sale_bill_item_tax ? 'selected' : '' }} >
                        {{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%
                        </option>
                      @endforeach
                    </select>
                    <div class="px-10"></div>
                    <select class="form-control select2" name="items[][sale_bill_item_tax]" style="width: 100%;">
                      @foreach($salestax as $salesTax)
                        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}"
                        {{ $salesTax->tax_id == $item->sale_bill_item_tax ? 'selected' : '' }} >
                        {{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%
                        </option>
                      @endforeach
                    </select>
                    </td>
                    <td class="text-right item-price">{{ number_format( $item->sale_bill_item_price * $item->sale_bill_item_qty, 2) }}</td>
                    <td class="text-right"><i class="fa fa-trash delete_icon_grid delete-item"></i></td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <input type="hidden" name="sale_bill_sub_total" value="{{ $bill->sale_bill_sub_total }}">
            <input type="hidden" name="sale_bill_tax_amount" value="{{ $bill->sale_bill_tax_amount }}">
            <input type="hidden" name="sale_bill_final_amount" value="{{ $bill->sale_bill_final_amount }}">
            <div class="row justify-content-end">
              <div class="col-md-4 subtotal_box">
                <div class="table-responsive">
                  <table class="table total_table">
                    <tr>
                      <td style="width:50%">Sub Total :</td>
                      <td id="sub-total">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_sub_total }}</td>
                    </tr>
                    <tr>
                      <td>Tax :</td>
                      <td id="tax">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_tax_amount }}</td>
                    </tr>
                    <tr>
                      <td>Total :</td>
                      <td id="total">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_final_amount }}</td>
                    </tr>
                    <tr>
                      <td>Total Paid :</td>
                      <td id="total-paid">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_paid_amount }}</td>
                    </tr>
                    <tr>
                      <td>Amount Due :</td>
                      <td id="amount-due">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_due_amount }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="col-md-12 text-center py-20">
              <a href="{{ route('business.bill.index') }}" class="add_btn_br px-10">Cancel</a>
              <button class="add_btn px-10">Save</button>
            </div>
            <!-- /.row -->
          </div>
          </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here --> 
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>

<script>
$(document).ready(function () {
      // Function to calculate my items amount
      function calculateTotals() {
      const currencySymbol = $('#sale_currency_id option:selected').data('symbol') || '$'; // 
      let subTotal = 0;
      let totalDiscount = 0;
      let totalTax = 0;
      let total = 0;

      // Calculate item totals
      $('.item-row').each(function () {
      const qty = parseFloat($(this).find('input[name="items[][sale_bill_item_qty]"]').val()) || 0;
      const price = parseFloat($(this).find('input[name="items[][sale_bill_item_price]"]').val()) || 0;
      const itemTotal = qty * price;
      const taxableAmount = itemTotal;

      subTotal += itemTotal;

      // Tax rate from the 
      const itemTaxRate = parseFloat($(this).find('select[name="items[][sale_bill_item_tax]"] option:selected').data('tax-rate')) || 0;
      const itemTax = taxableAmount * (itemTaxRate / 100);
      totalTax += itemTax;

      // Update the price for the current item
      const itemTotalPrice = itemTotal;
      $(this).find('.item-price').text(`${itemTotalPrice.toFixed(2)}`);
      });


      total = subTotal + totalTax;

      // Update calculated values
      $('#sub-total').text(`${currencySymbol}${subTotal.toFixed(2)}`);
      $('#tax').text(`${currencySymbol}${totalTax.toFixed(2)}`);
      $('#total').text(`${currencySymbol}${total.toFixed(2)}`);
      $('#total-paid').text(`${currencySymbol}${0}`);
      $('#amount-due').text(`${currencySymbol}${total.toFixed(2)}`);

      $('input[name="sale_bill_sub_total"]').val(subTotal.toFixed(2));
      $('input[name="sale_bill_tax_amount"]').val(totalTax.toFixed(2));
      $('input[name="sale_bill_final_amount"]').val(total.toFixed(2));

    }

    // Handle changes in product select
    $(document).on('change', 'select[name="items[][sale_product_id]"]', function () {
      // alert('hii');
      var selectedProductId = $(this).val();
      var $row = $(this).closest('.item-row');
      // alert(selectedProductId);
      if (selectedProductId) {
      $.ajax({
        url: '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/bill/get-product-details/' + selectedProductId,
        method: 'GET',
        success: function (response) {
        $row.find('input[name="items[][sale_bill_item_price]"]').val(response.purchases_product_price);
        $row.find('input[name="items[][sale_bill_item_desc]"]').val(response.purchases_product_desc);
        $row.find('input[name="items[][sale_bill_item_qty]"]').val(1);
        // $row.find('select[name="items[][sale_currency_id]"]').val(response.sale_product_currency_id).trigger('change');
        $row.find('select[name="items[][sale_bill_item_tax]"]').val(response.purchases_product_tax).trigger('change');

        $row.find('select[name="items[][sale_expense_id]"]').val(response.purchases_product_expense_account).trigger('change');

        $row.find('.item-price').text('$' + parseFloat(response.purchases_product_price).toFixed(2));

        calculateTotals();
        }
      });
      }
    });

    //changes in quantity, price, discount, and tax inputs
    $(document).on('input', 'input[name="items[][sale_bill_item_qty]"], input[name="items[][sale_bill_item_price]"], input[name="sale_bill_item_discount"], select[name="items[][sale_bill_item_tax]"]', function () {
      calculateTotals();
    });

    //item removal
    $(document).on('click', '.delete-item', function () {
      $(this).closest('.item-row').remove();
      calculateTotals();
    });

    $('#sale_currency_id').on('change', function () {
      calculateTotals(); // Recalculate totals when currency changes
    });
    
  });

    $(document).ready(function () {
    let rowCount = 1;

    $('#add').click(function () {
      rowCount++;
      $('#dynamic_field').append(`
      <tr class="item-row" id="row${rowCount}">
      <td>
      <div>
      <select class="form-control select2" name="items[][sale_product_id]" style="width: 100%;">
      <option>Select Items</option>
      @foreach($products as $product)
      <option value="{{ $product->purchases_product_id }}">{{ $product->purchases_product_name }}</option>
      @endforeach
      </select>
      <input type="text" class="form-control px-10" name="items[][sale_bill_item_desc]" placeholder="Enter item description">
      </div>
      <td>
      <select class="form-control select2" name="items[][sale_expense_id]" style="width: 100%;">
      <option>Select Category</option>
      @foreach($ExpenseAccounts as $accounts)
      <option value="{{ $accounts->chart_acc_id }}">{{ $accounts->chart_acc_name }}</option>
      @endforeach
      </select>
      </td>
      </td>
      <td><input type="number" class="form-control" name="items[][sale_bill_item_qty]" min="1" placeholder="Enter item Quantity" ></td>
      <td>
      <div class="d-flex">
      <input type="text" name="items[][sale_bill_item_price]" class="form-control" aria-describedby="inputGroupPrepend" placeholder="Enter item Price">
      </div>
      </td>
      <td>
        <select class="form-control select2" name="items[][sale_bill_item_tax]" style="width: 100%;">
        @foreach($salestax as $salesTax)
        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}">{{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%</option>
      @endforeach
        </select>
        <div class="px-10"></div>
        <select class="form-control select2" name="items[][sale_bill_item_tax]" style="width: 100%;">
        @foreach($salestax as $salesTax)
        <option data-tax-rate="{{ $salesTax->tax_rate }}" value="{{ $salesTax->tax_id }}">{{ $salesTax->tax_name }} {{ $salesTax->tax_rate }}%</option>
      @endforeach
        </select>
      </td>
      <td class="text-right item-price">0.00</td>
      <td class="text-right"><i class="fa fa-trash delete_icon_grid delete-item" id="${rowCount}"></i></td>
      </tr>
      `);

      $('.select2').select2();
    });

    $(document).on('click', '.delete-item', function () {
      var rowId = $(this).attr("id");
      $('#row' + rowId).remove();
    });




    });
    //insert estimate data
    $(document).ready(function () {
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#items-form').on('submit', function (e) {
      e.preventDefault();

      let formData = {};


      $('.item-row').each(function (index) {
      const rowIndex = index;
      formData[`items[${rowIndex}][sale_product_id]`] = $(this).find('select[name="items[][sale_product_id]"]').val();
      formData[`items[${rowIndex}][sale_bill_item_desc]`] = $(this).find('input[name="items[][sale_bill_item_desc]"]').val();
      formData[`items[${rowIndex}][sale_bill_item_qty]`] = $(this).find('input[name="items[][sale_bill_item_qty]"]').val();
      formData[`items[${rowIndex}][sale_bill_item_price]`] = $(this).find('input[name="items[][sale_bill_item_price]"]').val();
      formData[`items[${rowIndex}][sale_expense_id]`] = $(this).find('select[name="items[][sale_expense_id]"]').val();
      formData[`items[${rowIndex}][sale_bill_item_tax]`] = $(this).find('select[name="items[][sale_bill_item_tax]"]').val();
      formData[`items[${rowIndex}][sale_bill_item_price]`] = $(this).find('input[name="items[][sale_bill_item_price]"]').val();
     

      formData['sale_vendor_id'] = $('select[name="sale_vendor_id"]').val();
      formData['sale_bill_number'] = $('input[name="sale_bill_number"]').val();
      formData['sale_bill_customer_ref'] = $('input[name="sale_bill_customer_ref"]').val();
      formData['sale_bill_date'] = $('input[name="sale_bill_date"]').val();
      formData['sale_bill_valid_date'] = $('input[name="sale_bill_valid_date"]').val();
      formData['sale_bill_sub_total'] = $('input[name="sale_bill_sub_total"]').val();
      formData['sale_bill_tax_amount'] = $('input[name="sale_bill_tax_amount"]').val();
      formData['sale_bill_final_amount'] = $('input[name="sale_bill_final_amount"]').val();
      formData['sale_bill_note'] = $('#sale_bill_note[name="sale_bill_note"]').val();
      formData['sale_bill_status'] = 1;
      formData['sale_status'] = 0;
      formData['sale_currency_id'] = $('select[name="sale_currency_id"]').val();

    //   console.log(formData);

      $.ajax({
      url: "{{ route('business.bill.update', ['id' => $bill->sale_bill_id]) }}",
      method: 'PATCH',
      data: formData,
      success: function (response) {
        window.location.href = response.redirect_url;
      },
      error: function (xhr) {
        if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        // console.log(errors); 

        $('.error-message').html('');
        $('input, select').removeClass('is-invalid');

        var firstErrorField = null;

        $.each(errors, function (field, messages) {
          // console.log(messages); 


          var fieldId = field.replace(/\./g, '_').replace(/\[\]/g, '_');
          var errorMessageContainerId = 'error_' + fieldId;
          var errorMessageContainer = $('#' + errorMessageContainerId);

          if (errorMessageContainer.length) {
          errorMessageContainer.html(messages.join('<br>'));

          var $field = $('[name="' + field + '"]');

          if ($field.length > 0) {
            $field.addClass('is-invalid');

            if (!firstErrorField) {
            // console.log(firstErrorField); 
            firstErrorField = $field;
            }
            scrollToCenter($field);
          } else {
            // console.log('Field not found for:', field);
          }
          } else {
          // console.log('Error container not found for:', errorMessageContainerId);
          }
        });


        } else {
        // console.log('An error occurred: ' + xhr.statusText);
        }
      }
      });
    });
    });
  });

    function scrollToCenter($element) {
    // console.log('hiii');
    if ($element.length) {
      var elementOffset = $element.offset(); // Get element's offset
      var elementTop = elementOffset.top; // Get element's top position
      var elementHeight = $element.outerHeight(); // Get element's height
      var windowHeight = $(window).height(); // Get window height

      // Calculate the scroll position to center the element
      var scrollTop = elementTop - (windowHeight / 2) + (elementHeight / 2);

      // Scroll to the calculated position
      $('html, body').scrollTop(scrollTop);
    } else {
      // console.log('Element not found or has zero length.');
    }
    }

  </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var fromInput = document.getElementById('from-datepicker-hidden');
        var toInput = document.getElementById('to-datepicker-hidden');


    var fromdatepicker = flatpickr("#from-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "m/d/Y",
      altFormat: "d/m/Y",
      allowInput: true,
      defaultDate: fromInput.value || null,
    });

    var todatepicker = flatpickr("#to-datepicker", {
      locale: 'en',
      altInput: true,
      dateFormat: "m/d/Y",
      altFormat: "d/m/Y",
      allowInput: true,
      defaultDate: toInput.value || null,
    });

    document.getElementById('from-calendar-icon').addEventListener('click', function () {
      fromdatepicker.open();
    });

    document.getElementById('to-calendar-icon').addEventListener('click', function () {
      todatepicker.open();
    });

    });

  </script>
@endsection
@endif
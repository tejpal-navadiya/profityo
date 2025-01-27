<div id="preview-edit-container">
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
      <div class="col-auto">
        <h1 class="m-0">{{ __('New Recurring Invoice') }}</h1>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ __('New Recurring Invoice') }}</li>
        </ol>
      </div><!-- /.col -->
      <div class="col-auto">
        <ol class="breadcrumb float-sm-right">
        <!-- <a href="#"><button class="add_btn_br">Edit</button></a> -->
        <button type="button" value="true" id="back_to_edit" class="add_btn_br">Edit</button>

        <button type="button" form="items-form" id="save-btn" value="false" class="add_btn">Save & Continue</button>

        </ol>
      </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </div>
        <!-- Main content -->
    
    <section class="content px-10">
        <div class="container-fluid">
            <!-- Estimates Card -->
            @php
    $previewData = session('previewData');
   //dd($previewData);
@endphp
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice</h3>
                    <h3 class="card-title float-sm-right">#{{ $previewData['sale_estim_number'] ?? 'N/A' }}</h3>
                </div>
                <div class="card-body2">
                    <div class="row justify-content-between pad-3">
                        <div class="col-md-3">
                        @if($businessDetails && $businessDetails->bus_image)
                                <img src="{{ url(env('IMAGE_URL') . '/masteradmin/business_profile/' . $businessDetails->bus_image) }}" />                       
                                @else
                                <img src="{{url('public/dist/img/upload_icon.png')}}" class="upload_icon_img" />
                                @endif
                            </div>
                        <div class="col-md-6 text-right">
                             <h2>{{ $previewData['sale_estim_title'] ?? '' }}</h2>
                            <p class="company_details_text">{{ $previewData['sale_estim_summary'] ?? '' }}</p>
                            <p class="estimate_view_title">Invoice</p>
                            <?php //dd($businessDetails); ?>
                            <!-- <p class="company_details_text">{{ $previewData['sale_estim_summary'] ?? 'Summary' }}</p> -->
                            <p class="company_business_name text-right">{{ $businessDetails->bus_company_name ?? '' }}</p>
                            <p class="company_details_text text-right">{{  $businessDetails->bus_address1 ?? '' }}</p>
                            <p class="company_details_text text-right">{{  $businessDetails->bus_address2 ?? '' }}</p>
                            <p class="company_details_text text-right">{{ $businessDetails->state->name ?? '' }},
                            {{  $businessDetails->city_name ?? '' }} {{ $businessDetails->zipcode ?? '' }}
                            </p>
                            <p class="company_details_text text-right">{{  $businessDetails->country->name ?? '' }}</p>
                            <p class="company_details_text text-right">Phone: {{  $businessDetails->bus_phone ?? ''}}</p>
                            <p class="company_details_text text-right">Mobile: {{  $businessDetails->bus_mobile ?? ''}}</p>
                            <p class="company_details_text text-right">{{  $businessDetails->bus_website ?? '' }}</p>
                            <!-- Add more dynamic fields here if necessary -->
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row justify-content-between pad-2">

                    <div class="col-auto px-10" id="sale_customer">
                        <?php //dd($salecustomer); ?>
                        <p class="company_business_name" style="text-decoration: underline;">Bill To</p>

                        <p class="company_details_text">{{ $salecustomer->sale_cus_first_name ?? ''  }} {{ $estimates->sale_cus_last_name ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_cus_business_name ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_cus_phone ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_cus_email ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_bill_address1 ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_bill_address2 ?? ''  }}</p>

                        <p class="company_details_text"> {{ $salecustomer->state->name ?? '' }}, {{ $estimates->sale_bill_city_name ?? ''  }} {{ $estimates->sale_bill_zipcode ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->bill_country->name ?? '' }}</p>

                        </div>

                        <!-- /.col -->

                        <div class="col-auto px-10" id="ship_customer">

                        <p class="company_business_name" style="text-decoration: underline;">Shipped To</p>

                        <p class="company_details_text">{{ $salecustomer->sale_ship_shipto ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_ship_phone ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_cus_email ?? ''  }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_ship_address1 ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->sale_ship_address2 ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->ship_state->name ?? '' }}, {{ $salecustomer->sale_ship_city_name ?? ''  }} {{ $salecustomer->sale_ship_zipcode ?? '' }}</p>

                        <p class="company_details_text">{{ $salecustomer->country->name ?? '' }}</p>

                        </div>

                        <div class="col-auto">
                            <table class="table estimate_detail_table">
                                <tr>
                                    <td><strong>Invoice Number:</strong></td>
                                    <td>{{ $previewData['sale_estim_number'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>P.O./S.O. Number:</strong></td>
                                    <td>{{ $previewData['sale_estim_customer_ref'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Invoice Date:</strong></td>
                                    
                                    <td>{{ now()->format('m/d/Y') ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Due:</strong></td>
                                    <td>{{ now()->addDays($previewData['sale_re_inv_payment_due_id'])->format('m/d/Y') ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total ({{ $currencys->find($previewData['sale_currency_id'])->currency }}):</strong></td>
                                    <td><strong>${{ number_format($previewData['sale_estim_final_amount'] ?? 0, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row px-10">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-hover text-nowrap dashboard_table item_table">
                                <thead>
                                    <tr>
                                        <th>Items</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <!-- <th>Discount</th> -->
                                        <th>Tax</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @forelse ($previewData['items'] as $item)
                                
                                        <tr>
                                        <td id="product-name-{{ $loop->index }}">{{ $item['product_name'] ?? 'N/A' }}</td>

                                            <!-- <td>{{ $item['product_name'] ?? 'N/A' }}</td> -->
                                            <td>{{ $item['sale_estim_item_qty'] ?? 'N/A' }}</td>
                                            <td>{{ number_format($item['sale_estim_item_price'] ?? 0, 2) }}</td>
                                            <!-- <td>{{ $item['sale_estim_item_discount'] ?? '0' }}</td> -->
                                            <td>{{ $item['sale_estim_item_tax'] ?? 'N/A' }}</td>
                                            <td>
                                                {{ number_format(
                                                    (($item['sale_estim_item_price'] ?? 0) * ($item['sale_estim_item_qty'] ?? 0)) 
                                                    - ($item['sale_estim_item_discount'] ?? 0) 
                                                    + ($item['sale_estim_item_tax'] ?? 0), 
                                                    2
                                                ) }}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2">No items available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Add more sections as necessary -->

                    <div class="row justify-content-end">
                        <div class="col-md-4 subtotal_box">
                            <div class="table-responsive">
                                <table class="table total_table">
                                    <tr>
                                        <td style="width:50%">Sub Total :</td>
                                        <td>{{ $currencys->currency_symbol }}{{ $previewData['sale_estim_sub_total'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount:</td>
                                        <td>{{ $currencys->currency_symbol }}{{ $previewData['sale_estim_discount_total'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tax :</td>
                                        <td>{{ $currencys->currency_symbol }}{{ $previewData['sale_estim_tax_amount'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total:</strong></td>
                                        <td><strong>{{ $currencys->currency_symbol }}{{ $previewData['sale_estim_final_amount'] }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
    </div>
   <script>
    $(document).ready(function () {
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#back_to_edit').on('click', function(e) {
        e.preventDefault();  // Prevent form submission
        //alert('hii');
        // Add the preview flag to the form data
        let formData = getFormData();
        formData['back_to'] = 'true';  // Set preview flag to true
        // console.log(formData);
        // Trigger the AJAX request with the preview flag
        submitFormViaAjax(formData);
        
    });

    // Handle the click event for the Save & Continue button
    $('#save-btn').on('click', function(e) {
        e.preventDefault();  // Prevent form submission

        // Add the preview flag to the form data
        let formData = getFormData();
        formData['preview'] = 'false';  // Set preview flag to false (Save & Continue)
        // console.log('FormData (with preview flag):', formData);
        // Trigger the AJAX request for saving data
        submitFormViaAjax(formData);
    });

    // Function to collect form data into an object
    function getFormData() {
  
        let formData = {
        sale_estim_number: '{{ $previewData['sale_estim_number'] ?? '' }}',
        sale_estim_customer_ref: '{{ $previewData['sale_estim_customer_ref'] ?? '' }}',
        sale_estim_date: '{{ $previewData['sale_estim_date'] ?? '' }}',
        sale_estim_title: '{{ $previewData['sale_estim_title'] ?? '' }}',
        sale_estim_summary: '{{ $previewData['sale_estim_summary'] ?? '' }}',
        sale_cus_id: '{{ $previewData['sale_cus_id'] ?? '' }}',
        sale_estim_valid_date: '{{ $previewData['sale_estim_valid_date'] ?? '' }}',
        sale_estim_discount_desc: '{{ $previewData['sale_estim_discount_desc'] ?? '' }}',
        sale_estim_sub_total: '{{ $previewData['sale_estim_sub_total'] ?? '' }}',
        sale_estim_discount_total: '{{ $previewData['sale_estim_discount_total'] ?? '' }}',
        sale_estim_tax_amount: '{{ $previewData['sale_estim_tax_amount'] ?? '' }}',
        sale_estim_final_amount: '{{ $previewData['sale_estim_final_amount'] ?? '' }}',
        sale_estim_notes: '{{ $previewData['sale_estim_notes'] ?? '' }}',
        sale_estim_footer_note: '{{ $previewData['sale_estim_footer_note'] ?? '' }}',
        sale_estim_item_discount: '{{ $previewData['sale_estim_item_discount'] ?? '' }}',
        sale_total_days: '{{ $previewData['sale_total_days'] ?? '' }}',
        sale_re_inv_payment_due_id: '{{ $previewData['sale_re_inv_payment_due_id'] ?? '' }}',
        sale_estim_status: 1,
        sale_status: 0,
        sale_currency_id: '{{ $previewData['sale_currency_id'] ?? '' }}',
        items: @json($previewData['items'] ?? []).map((item, index) => ({
            sale_product_id: item.sale_product_id ?? '',
            sale_estim_item_desc: item.sale_estim_item_desc ?? '',
            sale_estim_item_qty: item.sale_estim_item_qty ?? '',
            sale_estim_item_price: item.sale_estim_item_price ?? '',
            sale_estim_item_tax: item.sale_estim_item_tax ?? '',
            // sale_estim_item_discount: item.sale_estim_item_discount ?? ''
        }))
    };



        return formData;
    }

    // Function to send the form data via AJAX
    function submitFormViaAjax(formData) {
        var url;
        var method;
    <?php if (isset($previewData['reinvoices_id'])): ?>
        url = "{{ route('business.recurring_invoices.update', ['reinvoices_id' => $previewData['invoices_id']]) }}";
        method = 'PATCH';
    <?php else: ?>
        url = "{{ route('business.recurring_invoices.store') }}";
        method = 'POST';
    <?php endif; ?>

        $.ajax({
            
            url: url,
            method: method,
            data: formData,
            success: function(response) {
              if (response.preview_view) {
                  // Inject the preview HTML into the container
               // alert('success');
               console.log(response);

                  $('#preview-edit-container').html(response.preview_view).fadeIn();
                //   $('.select2').select2();
                  initializeFlatpickr();
                  $('.select2').select2();
                  // Optionally, scroll to the preview container if needed
                //   $('html, body').animate({ scrollTop: $('#preview-container').offset().top }, 500);
              } else if (response.redirect_url) {
                  // Redirect for save success
                  window.location.href = response.redirect_url;
              }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-message').html('');
                    $('input, select').removeClass('is-invalid');

                    var firstErrorField = null;
                    $.each(errors, function(field, messages) {
                        var fieldId = field.replace(/\./g, '_').replace(/\[\]/g, '_');
                        var errorMessageContainerId = 'error_' + fieldId;
                        var errorMessageContainer = $('#' + errorMessageContainerId);

                        if (errorMessageContainer.length) {
                            errorMessageContainer.html(messages.join('<br>'));
                            var $field = $('[name="' + field + '"]');
                            if ($field.length > 0) {
                                $field.addClass('is-invalid');
                                if (!firstErrorField) {
                                    firstErrorField = $field;
                                }
                                scrollToCenter($field);
                            }
                        }
                    });
                }
            }
        });
    }
    
    function initializeFlatpickr() {

       // alert('hiii');
        
    var fromInput = document.getElementById('from-datepicker-hidden');
    var toInput = document.getElementById('to-datepicker-hidden');
    let fromdatepicker1, todatepicker1;

    // Initialize the "from" date picker
    if (document.getElementById('from-datepicker')) {
        fromdatepicker1 = flatpickr("#from-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            defaultDate: fromInput.value || null,
            onChange: calculateDays
        });

        document.getElementById('from-calendar-icon')?.addEventListener('click', function () {
            fromdatepicker1.open();
        });
    }

    // Initialize the "to" date picker
    if (document.getElementById('to-datepicker')) {
        todatepicker1 = flatpickr("#to-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            defaultDate: toInput.value || null,
            onChange: calculateDays
        });

        document.getElementById('to-calendar-icon')?.addEventListener('click', function () {
            todatepicker1.open();
        });
    }

    // Update the calculateDays function to use the correct variable names
    function calculateDays() {
        const sdate = fromdatepicker1?.input.value;
        const edate = todatepicker1?.input.value;

        if (sdate && edate) {
            const startDate = new Date(sdate);
            const endDate = new Date(edate);

            const timeDifference = endDate.getTime() - startDate.getTime();
            const totalDays = timeDifference / (1000 * 3600 * 24);

            if (totalDays < 0) {
                document.getElementById("total-days").innerText = "Invalid date range";
                document.getElementById("hidden-total-days").value = '';
            } else {
                document.getElementById("total-days").innerText = totalDays;
                document.getElementById("hidden-total-days").value = totalDays;
            }
        }
    }
}

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
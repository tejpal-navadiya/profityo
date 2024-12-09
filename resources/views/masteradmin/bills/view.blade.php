@extends('masteradmin.layouts.app')
<title>Profityo | View Bills</title>
@if(isset($access['view_bills']) && $access['view_bills'] == 1) 
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto>
            <h1 class="m-0">{{ __('Bill Detail') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Bill</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#" data-toggle="modal" data-target="#deletebill_{{ $bill->sale_bill_id }}"><button class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Send Statement</button></a>
              <a href="{{ route('business.estimates.create') }}"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Create Estimate</button></a>
              <a href="{{ route('business.invoices.create') }}"><button class="add_btn_br"><i class="fas fa-solid fa-file-invoice mr-2"></i>Create Invoice</button></a>
              <a href="{{ route('business.bill.edit',$bill->sale_bill_id) }}"><button class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
              <a  href="{{ route('business.bill.create') }}" ><button class="add_btn">Create Another Bill</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Vendor Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 
                <p class="company_business_name">{{ $bill->vendor->purchases_vendor_name }}</p>
                <p class="company_details_text">{{ $bill->vendor->purchases_vendor_address1 }}</p>
                <p class="company_details_text">{{ $bill->vendor->purchases_vendor_address2 }}</p>
                <p class="company_details_text">{{ $bill->vendor->purchases_vendor_city_name }}, {{ $bill->vendor->state->name }} {{ $bill->vendor->purchases_vendor_zipcode }}</p>
                <p class="company_details_text">{{ $bill->vendor->country->name }}</p>
                <p class="company_details_text">{{ $bill->vendor->purchases_vendor_email }}</p>
                <p class="company_details_text">{{ $bill->vendor->purchases_vendor_phone }}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Billing Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                    <table class="table estimate_detail_table">
                    <tbody>
                        <tr>
                        <td><strong>Bill Date :</strong></td>
                        <td>{{ \Carbon\Carbon::parse($bill->sale_bill_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                        <td><strong>Due Date :</strong></td>
                        <td>{{ \Carbon\Carbon::parse($bill->sale_bill_valid_date)->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                        <td><strong>Currency :</strong></td>
                        <td>{{ $currency->iso2 }} - {{ $currency->currency_name }}</td>
                        </tr>
                        <tr>
                        <td><strong>P.O./S.O :</strong></td>
                        <td>{{ $bill->sale_bill_customer_ref }}</td>
                        </tr>
                        <tr>
                        <td><strong>Notes :</strong></td>
                        <td>{{ $bill->sale_bill_note }}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
         
        </div>
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">item View</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body2">
            <div class="table-responsive">
              <table class="table table-hover text-nowrap dashboard_table item_table">
                <thead>
                <tr>
                  <th style="width: 300px;">Items</th>
                  <th style="width: 300px;">Expense Category</th>
                  <th>Description</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Tax</th>
                  <th class="text-right">Amount</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($billsItems as $item)
                  <tr>
                    <td>{{ $item->bill_product->purchases_product_name ?? 'No Name' }}</td>
                    <td>{{ $item->expense_category->chart_acc_name ?? 'No Name' }}</td>
                    <td>{{ $item->sale_bill_item_desc }}</td>
                    <td class="text-center">{{ $item->sale_bill_item_qty }}</td>
                    <td class="text-center">{{ $item->sale_bill_item_price }}</td>
                    <td class="text-center">{{ $item->item_tax->tax_name ?? 'No Tax Name' }} {{ $item->item_tax->tax_rate ?? 'No Tax Name' }}%</td>
                    <td class="text-right">{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $item->sale_bill_item_qty * $item->sale_bill_item_price ?? '0'}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="row justify-content-end">
              <div class="col-md-4 subtotal_box">
                <div class="table-responsive">
                  <table class="table total_table">
                    <tr>
                      <td style="width:50%">Sub Total :</td>
                      <td>{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_sub_total }}</td>
                    </tr>
                    <tr>
                      <td>Tax1 :</td>
                      <td>{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_tax_amount }}</td>
                    </tr>
                    <tr>
                      <td>Total :</td>
                      <td>{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_final_amount }}</td>
                    </tr>
                    <tr>
                      <td>Total Paid :</td>
                      <td>{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_paid_amount }}</td>
                    </tr>
                    <tr>
                      <td>Amount Due :</td>
                      <td>{{ $currencys->find($bill->sale_currency_id)->currency_symbol }}{{ $bill->sale_bill_due_amount }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="deletebill_{{ $bill->sale_bill_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <form id="delete-form-{{ $bill->sale_bill_id }}" data-id="{{ $bill->sale_bill_id }}">
            @csrf
            @method('DELETE')
            <div class="modal-body pad-1 text-center">
                <i class="fas fa-solid fa-trash delete_icon"></i>
                <p class="company_business_name px-10"><b>Delete Bill</b></p>
                <p class="company_details_text px-10">Delete Bill {{ $bill->sale_bill_id }}</p>
                <p class="company_details_text">Are You Sure You Want to Delete This Bill?</p>
                <button type="button" class="add_btn" data-dismiss="modal">Cancel</button>
                <button type="button" class="delete_btn"  data-id="{{ $bill->sale_bill_id }}">Delete</button>
            </div>
            </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
  $(document).on('click', '.delete_btn', function() {
    var invoiceId = $(this).data('id'); // Get the bill ID
    var form = $('#delete-form-' + invoiceId);
    var url = "{{ route('business.bill.destroy', ':id') }}"; // Use the named route
    url = url.replace(':id', invoiceId); // Replace with the actual ID

    // Send DELETE request using AJAX
    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(), // Serialize form data
        success: function(response) {
            if (response.success) {
                // Redirect or update the UI dynamically
                window.location.href = "{{ route('business.bill.index') }}";
            } else {
                alert('An error occurred: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while deleting the record.');
        }
    });
});
</script>
@endsection
@endif
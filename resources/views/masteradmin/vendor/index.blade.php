@extends('masteradmin.layouts.app')
<title>Profityo | Vendors & Services (Purchases)</title>
@if(isset($access['view_vendors']) && $access['view_vendors'])
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Vendors</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Vendors</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br"><i class="fas fa-download add_plus_icon"></i>Import From Google Contact</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-download add_plus_icon"></i>Import From CSV</button></a>
              @if(isset($access['add_vendors']) && $access['add_vendors'])
              <a href="{{ route('business.purchasvendor.create') }}"><button class="add_btn"><i
                  class="fas fa-plus add_plus_icon"></i>Add A Vendor</button></a>
              @endif
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row --> 
      </div><!-- /.container-fluid -->
    </div>
  <section class="content px-10">
    <div class="container-fluid">
      <!-- Main row -->
      @if(Session::has('purchases-vendor-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-vendor-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-vendor-add');
            @endphp
          @endif
          @if(Session::has('purchases-vendor-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-vendor-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-vendor-delete');
            @endphp
          @endif

          @if(Session::has('purchases-vendor-bankdetail'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-vendor-bankdetail') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-vendor-bankdetail');
            @endphp
          @endif
          @if(Session::has('purchases-vendor-edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('purchases-vendor-edit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('purchases-vendor-edit');
    @endphp
    @endif
      <div class="card px-20">
        <div class="card-body1">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example1" class="table table-hover text-nowrap">
              <thead>
                 <tr>
                      <th>Type</th>
                      <th>Vendor Name</th>
                      <!-- <th>Name</th> -->
                      <th>Email</th>
                      <th>Direct Deposit</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
              </thead>
              <tbody>
                @if (count($PurchasVendor) > 0)
                @foreach ($PurchasVendor as $value)
              <tr>
              <td>{{ $value->purchases_vendor_type }}</td>
              <td>{{ $value->purchases_vendor_name }}</td>
              <!-- <td>{{ $value->purchases_vendor_email }}</td> -->
              <td>{{ $value->purchases_vendor_email }}</td>
              <td>
                <!-- <a href="javascript:void(0);" class="invoice_underline" data-toggle="modal" data-target="#add_bank_account" data-vendor-id="{{ $value->purchases_vendor_id }}">Add Bank Details</a></td> -->
                @if ($value->purchases_vendor_type == '1099-NEC Contractor')
                            @if($value->bankDetails) <!-- Check if bank details exist -->
                                <a href="{{ route('business.purchasvendor.viewBankDetails', $value->purchases_vendor_id) }}" class="invoice_underline">View Bank Details</a>
                            @else
                                <a href="javascript:void(0);" class="invoice_underline" data-toggle="modal" data-target="#add_bank_account{{ $value->purchases_vendor_id }}" data-vendor-id="{{ $value->purchases_vendor_id }}">Add Bank Details</a>
                            @endif
                        @else
                            <span class="text-muted">Not Available</span>
                        @endif
              <!-- <td><span class="overdue_text">$75.00 Overdue</span></td> -->
              <td class="text-right">
            
                <ul class="navbar-nav ml-auto float-sm-right">
                          <li class="nav-item dropdown d-flex align-items-center">
                            <span class="d-block"><a href="{{ route('business.bill.add',$value->purchases_vendor_id) }}" class="invoice_underline">Create Bill</a></span>
                            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                              <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                            @if(isset($access['view_vendors']) && $access['view_vendors'])
                              <a href="{{ route('business.vendordetails.show', $value->purchases_vendor_id) }}" class="dropdown-item">
                                <i class="fas fa-regular fa-eye mr-2"></i> View
                              </a>
                              @endif
                              @if(isset($access['update_vendors']) && $access['update_vendors'])
                              <a href="{{ route('business.purchasvendor.edit',$value->purchases_vendor_id) }}" class="dropdown-item">
                                <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                              </a>
                              @endif
                              <a href="{{ route('business.bill.create') }}" class="dropdown-item">
                                <i class="fas fa-regular fa-copy mr-2"></i> Create Bill
                              </a>
                              @if(isset($access['delete_vendors']) && $access['delete_vendors'])
                              <a data-toggle="modal" class="dropdown-item" data-target="#delete-vendor-modal-{{ $value->purchases_vendor_id }}">
                                <i class="fas fa-solid fa-trash mr-2"></i> Delete
                              </a>
                              @endif
                            </div>
                          </li>
                        </ul>
                      </td>
                      </tr>

              <div class="modal fade" id="delete-vendor-modal-{{ $value->purchases_vendor_id }}" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <form id="delete-plan-form" action="{{ route('business.purchasvendor.destroy', ['PurchasesVendor' => $value->purchases_vendor_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body pad-1 text-center">
                <i class="fas fa-solid fa-trash delete_icon"></i>
                <p class="company_business_name px-10"><b>Delete Vendor</b></p>
                <!-- <p class="company_details_text px-10">Delete Vendor </p> -->
                <p class="company_details_text">Are You Sure You Want to Delete This Vendor?</p>
                <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                @csrf
                @method('DELETE')
                <button type="submit" class="delete_btn px-15">Delete</button>
                </div>
                </form>
              </div>
              </div>
              </div>

              <div class="modal fade" id="add_bank_account{{ $value->purchases_vendor_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Add Bank Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                          <form id="bankDetailsForm" action="{{ route('business.purchasvendor.addBankDetails', ['PurchasesVendor' => $value->purchases_vendor_id]) }}" method="POST">
                                  <input type="hidden" name="purchases_vendor_id" value="{{$value->purchases_vendor_id}}" id="purchases_vendor_id">
                                  @csrf
                                  <div class="row pxy-15 px-10">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="purchases_routing_number">Routing Number <span class="text-danger">*</span></label>
                                              <input type="number" class="form-control @error('purchases_routing_number') is-invalid @enderror" name="purchases_routing_number" id="routingnumber"> 
                                              @error('purchases_routing_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                              @enderror
                                            </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="purchases_account_number">Account Number <span class="text-danger">*</span></label>
                                              <input type="number" class="form-control @error('purchases_account_number') is-invalid @enderror" name="purchases_account_number" id="accountnumber"> 
                                              @error('purchases_account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                              @enderror
                                            </div>
                                      </div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="bank_account_type">Bank Account Type <span class="text-danger">*</span></label>
                                              <div class="form-check">
                                                  <input class="form-check-input mr-2" type="radio" name="bank_account_type" value="checking" {{ old('bank_account_type') == 'checking' ? 'checked' : '' }}>
                                                  <label class="form-check-label">Checking</label>
                                              </div>
                                              <div class="form-check">
                                                  <input class="form-check-input mr-2" type="radio" name="bank_account_type" value="savings" {{ old('bank_account_type') == 'savings' ? 'checked' : '' }}>
                                                  <label class="form-check-label">Savings</label>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="add_btn_br" data-dismiss="modal">Back To Vendors List</button>
                                      <button type="submit" class="add_btn">Save</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
              
              @endforeach            
                @else
                  
                @endif
              </tbody>
            </table>
          </div>
        </div><!-- /.card-body -->
      </div><!-- /.card-->
      <!-- /.row (main row) -->
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

<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#add_bank_account').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var vendorId = button.data('vendor-id'); // Extract info from data-* attributes
            
            var modal = $(this);
            modal.find('#purchases_vendor_id').val(vendorId); // Set the vendor ID in the hidden input
        });
    });
</script>

@endsection
@endif
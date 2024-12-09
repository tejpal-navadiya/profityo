@extends('masteradmin.layouts.app')
<title>Profityo | Sales Taxes</title>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Sales Taxes</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Sales Taxes</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            @if(isset($access['add_salestax']) && $access['add_salestax'])
              <a href="{{ route('business.salestax.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Create a Sales Tax</button></a>
              @endif
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
      @if(Session::has('salestax-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('salestax-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('salestax-add');
            @endphp
          @endif
          @if(Session::has('salestax-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('salestax-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('salestax-delete');
            @endphp
          @endif
        <!-- Main row -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="col-md-12 table-responsive pad_table">
                <table id="example4" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php //dd($SalesTax); ?>
                    @if (count($SalesTax) > 0)
                        @foreach ($SalesTax as $value)
                          <tr>
                          <td><strong>{{ $value->tax_abbreviation }} ({{ $value->tax_rate }}%)</strong> - {{ $value->tax_name }}</td>
                            <!-- <td>{{ $value->sp_desc }}</td>
                            <td>{{ $value->sp_amount }}</td>
                            <td>{{ $value->sp_month }}</td> -->
                            <td class="text-right">
                            @if(isset($access['update_salestax']) && $access['update_salestax'])
                            <a href="{{ route('business.salestax.edit',$value->tax_id) }}"><i
                            class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                            @endif
                            @if(isset($access['delete_salestax']) && $access['delete_salestax'])
                            <a data-toggle="modal" data-target="#delete-role-modal-{{ $value->tax_id }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                            @endif
                          </td>
                          </tr>
                          <!-- <div class="modal fade" id="delete-SalesTaxs" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <form id="delete-SalesTax-form" action="{{ route('business.salestax.destroy', ['salestax' => $value->tax_id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-body pad-1 text-center">
                                    <i class="fas fa-solid fa-trash delete_icon"></i>
                                    <p class="company_business_name px-10"><b>Delete SalesTaxs</b></p>
                                    <p class="company_details_text px-10">Are You Sure You Want to Delete This SalesTax?</p>
                                    <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete_btn px-15">Delete</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div> -->
                          <div class="modal fade" id="delete-role-modal-{{ $value->tax_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <form id="delete-plan-form" action="{{ route('business.salestax.destroy', ['salestax' => $value->tax_id]) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <div class="modal-body pad-1 text-center">
                                        <i class="fas fa-solid fa-trash delete_icon"></i>
                                        <p class="company_business_name px-10"><b>Delete Sale Tax</b></p>
                                        <p class="company_details_text px-10">Are You Sure You Want to Delete This Sale Tax?</p>
                                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete_btn px-15">Delete</button>
                                      </div>
                                    </form>
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
  <!-- <div class="modal fade" id="deletesalestaxes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Sales Tax</b></p>
          <p class="company_details_text px-10">Are You Sure You Want to Delete This Sales Tax?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- ./wrapper -->


@endsection


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profityo | View All Business</title>
  @include('layouts.headerlink')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('layouts.navigation')
    @include('layouts.sidebar')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
              <h1 class="m-0">Subscription Plans</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Subscription Plans</li>
              </ol>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <a href="{{ route('plans.create') }}"><button class="add_btn"><i
                      class="fas fa-plus add_plus_icon"></i>Add Subscription Plans</button></a>
              </ol>
            </div>
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
      <!-- Main content -->
      <section class="content px-10">
        <div class="container-fluid">
          @if(Session::has('plan-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('plan-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('plan-add');
            @endphp
          @endif
          @if(Session::has('plan-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('plan-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('plan-delete');
            @endphp
          @endif

          <!-- Main row -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="col-md-12 table-responsive pad_table">
                <table id="example1" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Amount</th>
                      <!-- <th>Validity (In Months)</th> -->
                      <th>Create User</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php //dd($plan); ?>
                    @if (count($plan) > 0)
                        @foreach ($plan as $value)
                          <tr>
                            <td>{{ $value->sp_name }}</td>
                            <td>{{ $value->sp_desc }}</td>
                            <td>{{ $value->sp_amount }}</td>
                            <!-- <td>{{ $value->sp_month }}</td> -->
                            <td>{{ $value->sp_user }}</td>
                            <td class="text-right">
                            <a href="{{ route('plans.planrole',$value->sp_id) }}"><i class="fas ffa-solid fa-key view_icon_grid"></i></a>
                            <a href="{{ route('plans.edit',$value->sp_id) }}"><i
                            class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                            <a data-toggle="modal" data-target="#deletesubscription-plans"><i
                            class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                            </td>
                          </tr>
                          <div class="modal fade" id="deletesubscription-plans" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <form id="delete-plan-form" action="{{ route('plans.destroy', ['plan' => $value->sp_id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-body pad-1 text-center">
                                    <i class="fas fa-solid fa-trash delete_icon"></i>
                                    <p class="company_business_name px-10"><b>Delete Subscription Plans</b></p>
                                    <p class="company_details_text px-10">Are You Sure You Want to Delete This plan?</p>
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
    
  </div>
  <!-- ./wrapper -->

  @include('layouts.footerlink')

</body>

</html>
@extends('masteradmin.layouts.app')
<title>User Role | Profityo</title>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __("User Role") }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __("User Role") }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('business.role.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Add User Role</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
        <div class="container-fluid">
          
          <!-- Main row -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="col-md-12 table-responsive pad_table">
                <table id="example1" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($roles) > 0)
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->role_name }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('plans.planrole',$role->role_id) }}"><i class="fas ffa-solid fa-key view_icon_grid"></i></a>
                                        <a href="{{ route('plans.edit',$role->role_name) }}"><i
                                        class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                        <a data-toggle="modal" data-target="#deletesubscription-plans"><i
                                        class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                                        </td>
                                </tr>
                            @endforeach    
                        @else
                            <tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No records found</td></tr>
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


@endsection

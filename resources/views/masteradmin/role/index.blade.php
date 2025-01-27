@extends('masteradmin.layouts.app')
<title>User Role | Profityo</title>
@if(isset($access['view_roles']) && $access['view_roles']) 
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
            @if(isset($access['add_roles']) && $access['add_roles']) 
              <a href="{{ route('business.role.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Add User Role</button></a>
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
          @if(Session::has('role-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('role-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('role-add');
            @endphp
          @endif
          @if(Session::has('role-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('role-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('role-delete');
            @endphp
          @endif
          @if(Session::has('role-edit'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('role-edit') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            @php
            Session::forget('role-edit');
            @endphp
        @endif
          <!-- Main row -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="col-md-12 table-responsive pad_table">
              <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th width="300">Description</th>
                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($roles) > 0)
                            @foreach ($roles as $role)
                                <tr>
                                  <td>{{ $role->role_name }}</td>
                                  <td>{{ $role->description }}</td>
                                  <td class="text-right">
                                    <a href="{{ route('business.role.userrole',$role->role_id) }}"><i class="fas ffa-solid fa-key view_icon_grid"></i></a>
                                    @if(isset($access['update_roles']) && $access['update_roles']) 
                                    <a href="{{ route('business.role.edit',$role->role_id) }}"><i
                                    class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                                    @endif
                                    @if(isset($access['delete_roles']) && $access['delete_roles']) 
                                    <a data-toggle="modal" data-target="#delete-role-modal-{{ $role->role_id }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                                    @endif
                                  </td>
                                </tr>
                                
                                <div class="modal fade" id="delete-role-modal-{{ $role->role_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <form id="delete-plan-form" action="{{ route('business.role.destroy', ['role' => $role->role_id]) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <div class="modal-body pad-1 text-center">
                                        <i class="fas fa-solid fa-trash delete_icon"></i>
                                        <p class="company_business_name px-10"><b>Delete Role</b></p>
                                        <p class="company_details_text px-10">Are You Sure You Want to Delete This Role?</p>
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


@endsection
@endif

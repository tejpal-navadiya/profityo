@extends('masteradmin.layouts.app')
<title>Edit User Role | Profityo</title>
@if(isset($access['update_roles']) && $access['update_roles']) 
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __("Edit User Role") }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __("Edit User Role") }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            <a href="{{ route('business.role.index') }}"><button class="add_btn_br">Cancel</button></a>
            <button type="submit" form="items-form" class="add_btn">Save</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
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

        <!-- card -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit User Role</h3>
          </div>
          <!-- /.card-header -->
          <form id="items-form" method="POST" action="{{ route('business.role.update', ['role' => $role->role_id]) }}">
          @csrf
          @method('patch')
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="role_name">Role Name</label>
                  <input type="text" class="form-control @error('role_name') is-invalid @enderror"
                        id="role_name" name="role_name" placeholder="Enter Role Name"
                        value="{{ old('role_name', $role->role_name) }}" />
                    @error('role_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
              </div>
            </div>
            <div class="row py-20 px-10">
              <div class="col-md-12 text-center">
                <a href="{{route('business.role.index')}}"  class="add_btn_br px-10">Cancel</a>
                <button type="submit" class="add_btn px-10">Save</button>
              </div>
            </div>
          </div>
          </form>
        </div>
        <!-- /.card -->
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

@extends('masteradmin.layouts.app')
<title>Profityo | Employees</title>

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">Employees</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ol>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('business.employee.create') }}">
                            <button class="add_btn">
                                <i class="fas fa-plus add_plus_icon"></i>Add an Employee
                            </button>
                        </a>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
   
    <section class="content px-10">
        <div class="container-fluid">
        @if(Session::has('employee-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('employee-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('employee-add');
            @endphp
          @endif
          @if(Session::has('delete_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('delete_success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('delete_success');
            @endphp
          @endif
          @if(Session::has('employee-edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('employee-edit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('employee-edit');
    @endphp
    @endif

            <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
                <ul class="nav nav-pills p-2 tab_box">
                    <li class="nav-item">
                        <a class="nav-link active" href="#activeemployee" data-toggle="tab">
                            Active <span class="badge badge-toes">{{ $employees->where('emp_status', 1)->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#onleaveemployee" data-toggle="tab">
                            On Leave <span class="badge badge-toes">{{ $employees->where('emp_status', 2)->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dismissedemployee" data-toggle="tab">
                            Dismissed <span class="badge badge-toes">{{ $employees->where('emp_status', 3)->count() }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card px-20">
                <div class="card-body1">
                    <div class="tab-content">
                        <!-- Active Employees Tab -->
                        <div class="tab-pane active" id="activeemployee">
                            <div class="col-md-12 table-responsive pad_table">
                                <table id="example1" class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees->where('emp_status', 1) as $employee)
                                            <tr>
                                                <td>{{ $employee->emp_first_name }} {{ $employee->emp_last_name }}</td>
                                                <td>{{ $employee->emp_status == 1 ? 'Active' : '' }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.employee.edit', $employee->emp_id) }}">
                                                        <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- On Leave Employees Tab -->
                        <div class="tab-pane" id="onleaveemployee">
                            @if($employees->where('emp_status', 2)->isEmpty())
                                <p class="mb-0 text-center">You Presently have no Employees on Leave</p>
                            @else
                                <table id="example1" class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees->where('emp_status', 2) as $employee)
                                            <tr>
                                                <td>{{ $employee->emp_first_name }} {{ $employee->emp_last_name }}</td>
                                                <td>On Leave</td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.employee.edit', $employee->id) }}">
                                                        <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- Dismissed Employees Tab -->
                        <div class="tab-pane" id="dismissedemployee">
                            @if($employees->where('emp_status', 3)->isEmpty())
                                <p class="mb-0 text-center">You Presently have no Dismissed Employees</p>
                            @else
                                <table id="example1" class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees->where('emp_status', 3) as $employee)
                                            <tr>
                                                <td>{{ $employee->emp_first_name }} {{ $employee->emp_last_name }}</td>
                                                <td>Dismissed</td>
                                                <td class="text-right">
                                                    <a href="{{ route('business.employee.edit', $employee->id) }}">
                                                        <i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('masteradmin.layouts.app')
<title>Profityo | New User</title>
@if(isset($access['add_users']) && $access['add_users']) 
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">New User</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">New User</li>
                    </ol>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('business.userdetail.index') }}"><button class="add_btn_br">Cancel</button></a>
                        <button type="submit" form="items-form" class="add_btn">Save</button>
                        </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content px-10">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New User</h3>
                </div>
                <form id="items-form" method="POST" action="{{ route('business.userdetail.store') }}">
                    @csrf
                    <div class="card-body2">
                        <div class="row pad-5">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="users_name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('users_name') is-invalid @enderror" id="taxname"
                                           name="users_name" placeholder="Name" value="{{ old('users_name') }}">
                                    @error('users_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="users_email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('users_email') is-invalid @enderror"
                                           id="users_email" name="users_email" placeholder="Email"
                                           value="{{ old('users_email') }}">
                                    @error('users_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="users_phone">Phone<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('users_phone') is-invalid @enderror" id="taxnumber"
                                           name="users_phone" placeholder="Phone" value="{{ old('users_phone') }}">
                                    @error('users_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Role<span class="text-danger">*</span></label>
                                    <select class="form-control from-select select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}" name="role_id" style="width: 100%;">
                                        <option>Select User Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="users_password">Password</label>
                                    <input type="Password" name="users_password" class="form-control @error('users_password') is-invalid @enderror"
                                           id="textrate" placeholder="Password" value="{{ old('users_password') }}">
                                     @error('users_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row py-20 px-10">
                            <div class="col-md-12 text-center">
                                <a href="{{ route('business.userdetail.index') }}" class="add_btn_br">Cancel</a>
                                <button type="submit" class="add_btn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection
@endif
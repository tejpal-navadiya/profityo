@if(isset($access['view_users']) && $access['view_users']) 
@extends('masteradmin.layouts.app')
<title>Profityo | Users</title>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Users</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            @if(isset($access['add_users']) && $access['add_users'])
              <a href="{{ route('business.userdetail.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>Add User</button></a>
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
        <!-- Handle messages -->
        @if(Session::has('link-success'))
          <p class="text-success" > {{ Session::get('link-success') }}</p>
        @endif
        @if(Session::has('link-error'))
          <p class="text-danger" > {{ Session::get('link-error') }}</p>
        @endif
              
        @if(Session::has('user-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('user-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('user-add');
            @endphp
          @endif
          @if(Session::has('user-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('user-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('user-delete');
            @endphp
          @endif
          @if(Session::has('user-edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('user-edit') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('user-edit');
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
                    <th>Email</th>
                    <th>Phone</th>
                    <th>User Role</th>
                    <th>Status</th>
                    <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($userdetail) > 0)
                    @foreach ($userdetail as $value)
                      <tr>
                        <td>{{ $value->users_name }}</td>
                        <td>{{ $value->users_email  }}</td>
                        <td>{{ $value->users_phone  }}</td>
                        <td>{{ $value->userRole->role_name ?? config('global.default_user_role') }}</td>
                        <td>
                        <span class="status-text status_btn" data-id="{{ $value->users_id }}" style="cursor: pointer;">
                          @if ($value->users_status == 1)
                            <span class="converted_status">Active</span>
                          @else
                            <span class="overdue_status">Inactive</span>
                          @endif
                        </span>
                      </td>

                    
                        <td class="text-right">
                          @if(isset($access['update_users']) && $access['update_users']) 
                          <a href="{{ route('business.userdetail.edit',$value->users_id ) }}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                          @endif
                          @if(isset($access['delete_users']) && $access['delete_users']) 
                          <a data-toggle="modal" data-target="#delete-role-modal-{{ $value->users_id  }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                          @endif
                        </td>
                      
                      </tr>
                     
                      <div class="modal fade" id="delete-role-modal-{{ $value->users_id  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <form id="delete-userdetail-form" action="{{ route('business.userdetail.destroy', ['userdetail' => $value->users_id ]) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <div class="modal-body pad-1 text-center">
                                <i class="fas fa-solid fa-trash delete_icon"></i>
                                <p class="company_business_name px-10"><b>Delete User</b></p>
                                
                                  @if($value->userRole->role_name ?? '')
                                    <p class="company_details_text px-10"> Are You Sure You Want to Delete This User? </p>
                                  @else 
                                      {{ config('global.default_user_role_alert_msg') }}
                                  @endif
                                  @if($value->userRole->role_name ?? '')
                                <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="delete_btn px-15">Delete</button>
                                @endif 
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
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 
  </div>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
$(document).on('click', '.toggle-status', function() {
    var button = $(this);
    var id = $( this ).data( 'id' );
// alert(id);
    $.ajax({
        url: '/business/userrole/' + id + '/update-status', // Adjust the URL based on your routes
        method: 'POST',
        success: function(response) {
            if (response.status === 'success') {
                // Update button text and class based on new status
                if (response.new_status == 1) {
                    button.text('Deactivate').removeClass('btn-danger').addClass('btn-success');
                } else {
                    button.text('Activate').removeClass('btn-success').addClass('btn-danger');
                }
            }
        },
        error: function() {
            alert('Failed to update status.');
        }
    });
});
</script> -->
<!-- <script>
    document.getElementById('status-text').addEventListener('click', function () {
      const userId = this.getAttribute('data-id');
alert(userId);
      fetch(`{{ url('/business/userrole') }}/${userId}/update-status`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Content-Type': 'application/json'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            const statusText = document.getElementById('status-text');

            // Update the status text and class based on the new status
            if (data.new_status == 1) {
              statusText.innerHTML = '<span class="converted_status">Active</span>';
            } else {
              statusText.innerHTML = '<span class="overdue_status">Inactive</span>';
            }
          }
        });
    });
  </script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).on('click', '.status-text', function () {
      var userId = $(this).data('id'); // Get user ID from data attribute

      $.ajax({
        url: 'userrole/' + userId + '/update-status',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          if (response.status === 'success') {
            var statusText = $('span[data-id="' + userId + '"]');

            // Update the status text and class based on the new status
            if (response.new_status == 1) {
              statusText.html('<span class="converted_status">Active</span>');
            } else {
              statusText.html('<span class="overdue_status">Inactive</span>');
            }
          } else {
            alert('Failed to update status.');
          }
        },
        error: function() {
          alert('Error updating status.');
        }
      });
    });
  </script>
  <!-- /.content-wrapper -->
@endsection
@endif
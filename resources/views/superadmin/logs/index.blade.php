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
              <h1 class="m-0">Log Activity</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Log Activity</li>
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
                <table id="example1" class="table table-hover">
                <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Url</th>
                                <th>Method</th>
                                <th>Ip</th>
                                <th>Browser</th>
                                <th>User Name</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($logs) > 0)
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->subject }}</td>
                                        <td>{{ $log->url }}</td>
                                        <td>{{ $log->method }}</td>
                                        <td>{{ $log->ip }}</td>
                                        <td>{{ $log->agent }}</td>
                                        <td>{{ $log->user_name }}</td>
                                        <td>{{ $log->created_at }}</td>
                                    </tr>
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
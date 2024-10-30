@php($busadminRoute = config('global.businessAdminURL'))
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" data-toggle="dropdown"><i class="fas fa-plus"></i></a>
        <div class="dropdown-menu">
          <a href="transactions-list.html" class="dropdown-item">Transaction</a>
          <a href="new-estimate.html" class="dropdown-item">Estimate</a>
          <a href="new-invoice.html" class="dropdown-item">Invoice</a>
          <a href="new-recurringinvoice.html" class="dropdown-item">Recurring Invoice</a>
          <a href="new-bill.html" class="dropdown-item">Bill</a>
          <a href="new-customer.html" class="dropdown-item">Customer</a>
          <a href="new-vendor.html" class="dropdown-item">Vendor</a>
          <a href="new-product-services.html" class="dropdown-item">Product Or Services</a>
        </div>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link user_nav" data-toggle="dropdown" href="#">
          <!-- <img src="{{url('public/dist/img/user2-160x160.jpg')}}" class="elevation-2 user_img" alt="User Image"> -->
           <?php //dd(Auth::guard('masteradmins')->user()); ?>
           @if(Auth::guard('masteradmins')->check() && Auth::guard('masteradmins')->user()->users_image)
    <img src="{{ url(env('IMAGE_URL').'masteradmin/profile_image/' . Auth::guard('masteradmins')->user()->users_image) }}" class="elevation-2 user_img" target="_blank" alt="Profile Image">
@else
    <img src="{{url('public/dist/img/user2-160x160.jpg')}}" class="elevation-2 user_img" alt="User Image">
@endif

@if(Auth::guard('masteradmins')->check() && Auth::guard('masteradmins')->user()->users_name)
    <span class="d-block dropdown-toggle">{{ Auth::guard('masteradmins')->user()->users_name }}</span>
@endif
          <!-- <span class="d-block dropdown-toggle" >{{ Auth::guard('masteradmins')->user()->users_name}} </span> -->
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <x-dropdown-link :href="route('business.profile.edit')">
                <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
            </x-dropdown-link>
          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('business.logout') }}">
            @csrf
            <x-dropdown-link :href="route('business.logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                <i class="nav-icon fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
            </x-dropdown-link>
          </form>
          <!-- <a href="login.html" class="dropdown-item">
            <i class="nav-icon fas fa-sign-out-alt mr-2"></i> Log Out
          </a> -->
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
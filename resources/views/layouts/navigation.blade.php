
  <!-- Preloader -->
  @php($adminRoute = config('global.superAdminURL'))
  <!--  -->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link user_nav" data-toggle="dropdown" href="#">
          @if(Auth::user()->image)
            <img src="{{ url(env('IMAGE_URL').'/superadmin/profile_image/' . Auth::user()->image) }} " class="elevation-2 user_img" target="_blank">
          @else
            <img src="{{url('public/dist/img/user2-160x160.jpg')}}" class="elevation-2 user_img" alt="User Image">
          @endif
          <span class="d-block dropdown-toggle" >{{ Auth::user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <x-dropdown-link :href="route('profile.edit')">
                <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
            </x-dropdown-link>

          <div class="dropdown-divider"></div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                <i class="nav-icon fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
            </x-dropdown-link>
          </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<html lang="en">
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">



  <title>{{ 'jobes@jobes.com' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="/css/app.css">


 <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico">











</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" to="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    <div class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>


    <ul class="navbar-nav ml-auto">
      <li class="nav-item mr-3">

          <router-link class="nav-link" to="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off text-danger"></i>
                                        {{ __('Logout') }}
                                    </router-link>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
      </li>
   </ul>

    <!-- Right navbar links -->
    {{-- <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-th-large"></i></a>
      </li>
    </ul> --}}
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="index3.html" class="brand-link">
        @php($company=\App\Company::all())
        @foreach($company as $company)
      <img src="{{ asset('img/logo') . '/' . $company->companylogo }}" alt="logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
           @endforeach

            <span class="brand-text font-weight-heavy small">{{ $company->companyname }}</span>


    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/profile') . '/' . Auth::user()->photo }} " class="img-circle elevation-2" alt="profile">
        </div>
        <div class="info">
          <router-link to="#" class="d-block">{{ Auth::user()->name }}</router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               @if(Gate::check('isAdmin') || Gate::check('isManager'))
               <li class="nav-item">
                <router-link  to="/profile" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    {{ 'Dashboard' }}

                  </p>
                </router-link>
              </li>
              @endif


              @if(Gate::check('isAdmin') || Gate::check('isManager') || Gate::check('isAgent'))
             <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ 'Management' }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @if(Gate::check('isAdmin') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/staff" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    {{ 'Staff Management' }}

                  </p>
                </router-link>
              </li>
              @endif
              @if(Gate::check('isAdmin') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/viewcustomers" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    {{ 'Customer Management' }}

                  </p>
                </router-link>
              </li>
              @endif
              @if(Gate::check('isAgent') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/manageitem" class="nav-link">
                  <i class="nav-icon fas fa-shipping-fast"></i>
                  <p>
                    {{ 'Manage Items' }}

                  </p>
                </router-link>
              </li>
              @endif
              @if(Gate::check('isAgent') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/packagemanage" class="nav-link">
                  <i class="nav-icon fas fa-shopping-cart"></i>
                  <p>
                    {{ 'Order Management' }}

                  </p>
                </router-link>
              </li>
              @endif
              @if(Gate::check('isAdmin') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/branch" class="nav-link">
                  <i class="nav-icon fas fa-building"></i>
                  <p>
                    {{ 'Branch Management' }}

                  </p>
                </router-link>
              </li>
              @endif
              @can('isAdmin')
              <li class="nav-item">
                <router-link to="/company" class="nav-link">
                  <i class="nav-icon fas  fa-building"></i>
                  <p>
                    {{ 'Company Management' }}

                  </p>
                </router-link>
              </li>
              @endcan
            </ul>
          </li>
          @endif

          <li class="nav-item">
                <router-link to="/package" class="nav-link">
                  <i class="nav-icon fas fa-box"></i>
                  <p>
                    {{ 'Request Sending  Package' }}

                  </p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/packageorder" class="nav-link">
                  <i class="nav-icon fas fa-eye"></i>
                  <p>
                    {{ 'View Orders' }}

                  </p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="#" class="nav-link">
                  <i class="nav-icon fas fa-map-marker-alt"></i>
                  <p>
                    {{ 'Track the Parcel' }}

                  </p>
                </router-link>
              </li>





              @can('isAdmin')
             <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                {{ 'Home Page Settings' }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <router-link to="/contactus" class="nav-link">
                  <i class="nav-icon fas  fa-building"></i>
                  <p>
                    {{ 'Fill Contact Info' }}

                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/aboutus" class="nav-link">
                  <i class="nav-icon fas  fa-building"></i>
                  <p>
                    {{ 'Fill About info' }}

                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/services" class="nav-link">
                  <i class="nav-icon fas  fa-building"></i>
                  <p>
                    {{ 'Fill Company Services' }}

                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/blog" class="nav-link">
                  <i class="nav-icon fas fa-blog"></i>
                  <p>
                    {{ 'Blog' }}

                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          @endcan

          @if(Gate::check('isAdmin') || Gate::check('isManager'))
              <li class="nav-item">
                <router-link to="/report" class="nav-link">
                  <i class="nav-icon fas fa-file"></i>
                  <p>
                    {{ 'Print Package Reports' }}

                  </p>
                </router-link>
              </li>
              @endif


              <li class="nav-item">
                <router-link to="/profile" class="nav-link">
                  <i class="nav-icon fas fa-id-badge"></i>
                  <p>
                    {{ 'Profile' }}

                  </p>
                </router-link>
              </li>


          {{-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas "></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li> --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <router-view></router-view>

         <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    {{-- <div class="float-right d-none d-sm-inline">
      Anything you want
    </div> --}}
    <!-- Default to the left -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <i class="fa fa-heart" aria-hidden="true"></i> by <a href="goddymj@gmail.com" target="_blank">GoBRIGHT</a>
  </footer>
</div>
<!-- ./wrapper -->
<script src="/js/app.js"></script>

</body>

</html>


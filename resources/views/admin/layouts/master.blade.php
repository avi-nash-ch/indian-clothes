<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Indian Clothes</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="shortcut icon" type="image/png" href="{{asset('images/logo.png')}}" />
  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}"> --}}

  <link rel='stylesheet' id='fontawesome-css' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <!-- style css -->
  <link rel="stylesheet" href="{{asset('admin/assets/css/app.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- owl carousel css -->
  <link rel="stylesheet" href="{{asset('css/owl.carousel-2/assets/owl.carousel.css')}}">
  <link rel="stylesheet" href="{{asset('css/owl.carousel-2/assets/owl.theme.default.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> --}}

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #0737c1;
    }
    /* Custom sidebar styling */
    .main-sidebar {
      background-color: #2C3E50; /* Deep blue color */
    }
    .sidebar-dark-primary .nav-sidebar .nav-link {
      color: #ECF0F1; /* Light text color for contrast */
    }
    .sidebar-dark-primary .nav-sidebar .nav-link:hover {
      background-color: #34495E; /* Slightly lighter shade for hover effect */
    }
    .sidebar-dark-primary .brand-link {
      background-color: #223240; /* Slightly darker shade for the logo area */
      color: #ECF0F1;
    }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Preloader -->
    {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('images/oji-logo.png')}}" alt="Logo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand" style="background-color: #2C3E50;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: #C0C0C0;">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
  
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="dropdown user user-menu mt-2 mr-2">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #C0C0C0;">
          <span class="hidden-xs">{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu mt-3" style="background-color: #343A40;">
          <!-- User image -->
          <li class="user-header">
            <h4 style="padding-top: 20px; color: #C0C0C0; padding-bottom: 20px; font-weight: 800; font-size: 20px;">
              Admin
            </h4>
          </li>
          <!-- Menu Footer -->
          <li class="user-footer">
            <div class="row">
              <div class="pull-left col-md-8">
                <a href="{{ route('logout') }}" class="btn btn-flat" style="background-color: #A9A9A9; color: #2C3E50;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
                </a>
              </div>
              <div class="pull-right">
                <a href="{{ route('profile') }}" class="btn btn-flat" style="background-color: #A9A9A9; color: #2C3E50;">
                  Profile
                </a>
              </div>
            </div>
          </li>
        </ul>
      </li>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </ul>
  </nav>
  <!-- /.navbar -->

  @if(session()->has('error'))
  <div class="row mt-1">
    <div class="col-md-7">
    </div>
    <div class="col-md-5">
      <div id="error-alert" class="alert alert-dismissible bg-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ session('error') }}
      </div>
    </div>
  </div>
  @endif
  @if(session()->has('success'))
  <div class="row mt-1">
    <div class="col-md-7">
    </div>
    <div class="col-md-5">
      <div id="success-alert" class="alert alert-dismissible bg-success">
        <button type="button" class="close close-btn" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
      </div>
    </div>
  </div>
  @endif

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="{{asset('images/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Indian Clothes</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-th-large" aria-hidden="true"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          {{-- admin --}}
          {{-- order --}}
          <li class="nav-item">
            <a href="{{route('order.index')}}" class="nav-link {{ request()->is('admin/order*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-shopping-bag" aria-hidden="true"></i>
              <p>
                Order
              </p>
            </a>
          </li>

          {{-- User --}}
          <li class="nav-item">
            <a href="{{route('user.index')}}" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-user" aria-hidden="true"></i>
              <p>
                Customer
              </p>
            </a>
          </li>

          {{-- Sponsored Banner --}}
          <li class="nav-item">
            <a href="{{route('sponsored-banner.index')}}" class="nav-link {{ request()->is('/admin/sponsored-banner*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-tags" aria-hidden="true"></i>
              <p>
                Sponsored Banner
              </p>
            </a>
          </li>


          {{-- Promotional Banner --}}
          <li class="nav-item">
            <a href="{{route('promotionalBanner.index')}}" class="nav-link {{ request()->is('admin/promotionalBanner*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-tags" aria-hidden="true"></i>
              <p>
                Banner 1
              </p>
            </a>
          </li>

          {{-- Offer Banner --}}
          <li class="nav-item">
            <a href="{{route('offerBanner.index')}}" class="nav-link {{ request()->is('admin/offerBanner*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-percent" aria-hidden="true"></i>
              <p>
                Promotional Banner
              </p>
            </a>
          </li>

          {{-- Category --}}
          <li class="nav-item">
            <a href="{{route('category.index')}}" class="nav-link {{ request()->is('admin/category*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-list" aria-hidden="true"></i>
              <p>
                Category
              </p>
            </a>
          </li>

          {{-- Sub Category --}}
          <li class="nav-item">
            <a href="{{route('subCategory.index')}}" class="nav-link {{ request()->is('admin/subCategory*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-list" aria-hidden="true"></i>
              <p>
                Sub Category
              </p>
            </a>
          </li>

          {{-- Product --}}
          <li class="nav-item">
            <a href="{{route('product.index')}}" class="nav-link {{ request()->is('admin/product*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-archive" aria-hidden="true"></i>
              <p>
                Product
              </p>
            </a>
          </li>

          {{-- Best Seller --}}
          <li class="nav-item">
            <a href="{{route('bestSeller.index')}}" class="nav-link {{ request()->is('admin/bestSeller*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-star" aria-hidden="true"></i>
              <p>
                Best Seller
              </p>
            </a>
          </li>

          {{-- Party Time --}}
          <li class="nav-item">
            <a href="{{route('partyTime.index')}}" class="nav-link {{ request()->is('admin/partyTime*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-star" aria-hidden="true"></i>
              <p>
                Party Time
              </p>
            </a>
          </li>

          {{-- Mobile And Accessories --}}
          <li class="nav-item">
            <a href="{{route('mobileAndAccessories.index')}}" class="nav-link {{ request()->is('admin/mobileAndAccessories*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-star" aria-hidden="true"></i>
              <p>
                Mobile And Accessories
              </p>
            </a>
          </li>

          {{-- Coupon Code --}}
          {{-- <li class="nav-item">
            <a href="{{route('couponCode.index')}}" class="nav-link {{ request()->is('admin/couponCode*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-gift" aria-hidden="true"></i>
              <p>
                Coupon Code
              </p>
            </a>
          </li> --}}

          {{-- Delivery Boy Management --}}
          <li class="nav-item">
            <a href="{{route('delivery-boy-management.index')}}" class="nav-link {{ request()->is('admin/delivery-boy-management*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-motorcycle" aria-hidden="true"></i>
              <p>
                Delivery Boy
              </p>
            </a>
          </li>
          {{-- Pincode --}}
          <li class="nav-item">
            <a href="{{route('pincode.index')}}" class="nav-link {{ request()->is('admin/pincode*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-map-marker-alt" aria-hidden="true"></i>
              <p>
                Pincode
              </p>
            </a>
          </li>

          {{-- Delivery Charge --}}
          {{-- <li class="nav-item">
                <a href="{{route('deliveryCharge.index')}}" class="nav-link {{ request()->is('admin/deliveryCharge*') ? 'active' : '' }}">
          <i class="nav-icon fa fa-money-check-alt" aria-hidden="true"></i>
          <p>
            Delivery Charge
          </p>
          </a>
          </li> --}}


          {{-- Setting --}}
          <li class="nav-item">
            <a href="{{route('setting.index')}}" class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
              <p>
                Setting
              </p>
            </a>
          </li>

          {{-- Unit --}}
          <li class="nav-item">
            <a href="{{route('unit.index')}}" class="nav-link {{ request()->is('admin/unit*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-motorcycle" aria-hidden="true"></i>
              <p>
                Unit
              </p>
            </a>
          </li>

          {{-- Report --}}
          <li class="nav-item">
            <a href="{{route('order_report.index')}}" class="nav-link {{ request()->is('admin/report_order*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-chart-bar" aria-hidden="true"></i>
              <p>
                Order Report
              </p>
            </a>
          </li>

          {{-- Change Password --}}
          <li class="nav-item">
            <a href="{{route('change_password.index')}}" class="nav-link {{ request()->is('admin/change_password*') ? 'active' : '' }}">
              <i class="nav-icon fa fa-cog" aria-hidden="true"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('content')



  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="/dashboard">Indian Clothes</a>.</strong>
    All rights reserved.
    {{-- <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div> --}}
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>
  <!-- Sparkline -->
  <script src="{{asset('plugins/sparklines/sparkline.js')}}"></script>
  <!-- JQVMap -->
  <script src="{{asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
  <script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
  <!-- Summernote -->
  <script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- owl carousel js -->
  <script src="{{asset('css/owl.carousel-2/owl.carousel.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script src="{{ asset('js/simple-datatables/simple-datatables.js') }}"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script>
    // Function to hide the alert after 3 seconds
    function hideAlert(alertId) {
      var alert = document.getElementById(alertId);
      if (alert) {
        alert.style.display = 'none';
      }
    }

    // Hide alerts after 3 seconds
    setTimeout(function() {
      hideAlert('error-alert');
      hideAlert('success-alert');
    }, 3000);

    const CSRF_TOKEN = "{{ csrf_token() }}"
  </script>

  @yield('scripts')
</body>

</html>
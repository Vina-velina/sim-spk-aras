 <!-- Favicon -->
 <link rel="icon" href="{{ config('general.fav') }}" type="image/x-icon">

 <!-- Bootstrap css -->
 <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

 <!-- Icons css -->
 <link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet">

 <!--  Right-sidemenu css -->
 <link href="{{ asset('assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

 <!--  Left-Sidebar css -->
 <link rel="stylesheet" href="{{ asset('assets/css/sidemenu.css') }}">

 <!--- Dashboard-2 css-->
 <link href="{{ asset('assets/css/all.css') }}" rel="stylesheet">

 <!--- Color css-->
 <link id="theme" href="{{ asset('assets/css/colors/color.css') }}" rel="stylesheet">

 <!-- Internal Data table css -->
 <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
 <link href="{{ asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
 <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

 <!--  Owl-carousel css-->
 <link href="{{ asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />

 <!-- Maps css -->
 <link href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

 <!-- Jvectormap css -->
 <link href="{{ asset('assets/plugins/jqvmap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />

 <!--- Animations css-->
 <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}">
 @yield('otherCssPlugin')

 @yield('otherCssQuery')

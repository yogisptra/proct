<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>Dashboard - Admin</title>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('frontoffice/assets/img/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('frontoffice/assets/img/favicon/favicon-196x196.png') }}" sizes="196x196">
    <link rel="icon" type="image/png" href="{{ asset('frontoffice/assets/img/favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="icon" type="image/png" href="{{ asset('frontoffice/assets/img/favicon/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('frontoffice/assets/img/favicon/favicon-16x16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('frontoffice/assets/img/favicon/favicon-128.png') }}" sizes="128x128">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/vendors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/charts/jquery-jvectormap-2.0.3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/charts/morris.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/extensions/unslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/weather-icons/climacons.min.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/plugins/calendars/clndr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/fonts/meteocons/style.min.css') }}">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/assets/css/style.css') }}">
    <!-- END Custom CSS-->

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/plugins/forms/switch.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/fonts/simple-line-icons/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/core/colors/palette-switch.css') }}">
    <!-- END Page Level CSS-->
    <!--Form Wizard CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/plugins/forms/wizard.css') }}">
    <!--- End Form Wizard -->
  </head>
  <body class="horizontal-layout horizontal-top-icon-menu 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">

    <!-- fixed-top-->
    @include('backoffice.layouts.header')
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- Navbar -->
    @include('backoffice.layouts.navbar')
    <!-- End Navbar -->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row"></div>
          <!-- Content -->
          @yield('content')
          <!-- End Content -->

          <!-- Modal -->
          @include('backoffice.layouts._modal')
      </div>
    </div>
      

    <!-- Footer -->
    @include('backoffice.layouts.footer')

    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('backoffice/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <!-- BEGIN Chart JS-->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{ asset('backoffice/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/js/scripts/forms/switch.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/raphael-min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/morris.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/extensions/underscore-min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/extensions/clndr.min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/charts/echarts/echarts.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/extensions/unslider-min.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/vendors/js/extensions/jquery.steps.min.js') }}"></script>


    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="{{ asset('backoffice/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('backoffice/app-assets/js/core/app.js') }}"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{ asset('backoffice/app-assets/js/scripts/pages/dashboard-ecommerce.js') }}"></script>
    <!-- END PAGE LEVEL JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

	  @yield('script')
    @stack('modal-scripts')
  </body>
</html>

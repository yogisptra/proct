<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template.">
		<meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
		<meta name="author" content="PIXINVENT">
		<title>{{ $title }}</title>
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
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CMuli:300,400,500,700" rel="stylesheet">
		<!-- BEGIN VENDOR CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/vendors.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/forms/icheck/icheck.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/vendors/css/forms/icheck/custom.css') }}">
		<!-- END VENDOR CSS-->
		<!-- BEGIN ROBUST CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/app.css') }}">
		<!-- END ROBUST CSS-->
		<!-- BEGIN Page Level CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/core/colors/palette-gradient.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/app-assets/css/pages/login-register.css') }}">
		<!-- END Page Level CSS-->
		<!-- BEGIN Custom CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('backoffice/assets/css/style.css') }}">
		<!-- END Custom CSS-->
	</head>
	<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column   menu-expanded blank-page blank-page" data-open="hover" data-menu="horizontal-menu" data-col="1-column">
		<!-- ////////////////////////////////////////////////////////////////////////////-->
		@yield('content')
		<!-- ////////////////////////////////////////////////////////////////////////////-->

		<!-- BEGIN VENDOR JS-->
		<script src="{{ asset('backoffice/app-assets/vendors/js/vendors.min.js') }}"></script>
		<!-- BEGIN VENDOR JS-->
		<!-- BEGIN PAGE VENDOR JS-->
		<script src="{{ asset('backoffice/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
		<script src="{{ asset('backoffice/app-assets/vendors/js/forms/icheck/icheck.min.js') }}"></script>
		<script src="{{ asset('backoffice/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
		<!-- END PAGE VENDOR JS-->
		<!-- BEGIN ROBUST JS-->
		<script src="{{ asset('backoffice/app-assets/js/core/app-menu.js') }}"></script>
		<script src="{{ asset('backoffice/app-assets/js/core/app.js') }}"></script>
		<!-- END ROBUST JS-->
		<!-- BEGIN PAGE LEVEL JS-->
		<script src="{{ asset('backoffice/app-assets/js/scripts/forms/form-login-register.js') }}"></script>
		<!-- END PAGE LEVEL JS-->
	</body>
</html>
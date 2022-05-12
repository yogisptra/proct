<!DOCTYPE html>
<html class="no-js" lang="id" dir="ltr">

<head>
    <!-- METAs-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="keywords" content="Donasi, Sedekah, Crowdfunding, Galang Dana, Yayasan, Fundraise, Donatur, Campaign">
    <meta name="author" content="rckryd">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @section('fb-opengraph')
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:title" content="{{ config('app.name', 'Website-Name') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ url('frontoffice/assets/img/logo.png') }}" />
    <meta property="og:description" content="{{ config('app.description', 'Web-Description') }}" />
    <meta property="og:keyword" content="{{ config('app.keyword', 'Web-Description') }}" />
    <meta name="description" content="{{ config('app.description', 'Web-Description') }}">
    @endsection
    <!-- TITLE-->
    <title>{{ @$title }} - Donasi.Co</title>

    <!-- HEAD LINKS (CSS or etc.)-->
    @yield('top-resource')
    <!-- Favicon -->
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
    <!-- Favicon's Meta-->
    <meta name="application-name" content="Donasi.Co">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png">
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png">
    <!-- Main style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/styles.css') }}">
    <!-- Vendor style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/swiper.min.css') }}">
</head>

<body class="preload">
    <!-- CONTENT-->
    @yield('content')

    <!-- FOOT LINKS (JS or etc.)-->
    <!-- JS-->
    <script src="{{ asset('frontoffice/assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/vendor/inlineSVG.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/inlineSVG.set.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/bundle.js') }}"></script>

    <!-- WARNING! this scripts below used for this page only-->
    @yield('bottom-resource')
    <!-- FOOTER-->
</body>

</html>
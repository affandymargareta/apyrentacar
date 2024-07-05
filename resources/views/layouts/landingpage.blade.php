<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- <title>Apy Renta Car</title> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('title')
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/jquery.timepicker.css') }}">

    
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/landingpage/css/style.css') }}">
    @yield('css')
    <style>
      /* Make the image fully responsive */
      .carousel-inner img {
        width: 100%;
        height: 100%;
      }
      .heroContent {
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #f8f9fa;
        font-size: 20px;
        width: max-content;
        /* display: flex; */
      }
      .car-wrap .text .price1 span {
      font-size: 30px;
      font-weight: 400;
      color: #1089ff;
      /* color: rgba(0, 0, 0, 0.3); */
      }
    </style>
  </head>
  <body>

  @yield('content')
  @include('partials.header')
  @include('partials.footer')


  @yield('js')
  <script src="{{ asset('assets/landingpage/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/aos.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/jquery.timepicker.min.js') }}"></script>
  <script src="{{ asset('assets/landingpage/js/scrollax.min.js') }}"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> -->
  <!-- <script src="{{ asset('assets/landingpage/js/google-map.js') }}"></script> -->
  <script src="{{ asset('assets/landingpage/js/main.js') }}"></script>
    
  </body>
</html>
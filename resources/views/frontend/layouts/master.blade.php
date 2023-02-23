<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/x-icon" href="{{ !empty($site_info->favicon) ? asset($site_info->favicon) : '' }}">
    <meta name="robots" content="follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>
    
    <!-- SEO -->
    {!! SEO::generate() !!}

    <!-- CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('frontend/libs/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/animate.css')}}">
    
    <link rel="stylesheet" href="{{asset('frontend/libs/owlcarousel/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/owlcarousel/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/fancybox/css/fancybox.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/libs/aos.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/libs/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/libs/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/jquery.timepicker.css')}}">

    
    <link rel="stylesheet" href="{{asset('frontend/libs/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/icomoon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/libs/fontawesome/all.min.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/css/style.css?v='.time())}}">
    <link rel="stylesheet" href="{{asset('frontend/css/custom.css?v='.time())}}">
    <!-- /CSS -->
    @yield('page_css')
</head>

<body>
    <!-- Header -->
    @include('frontend.layouts.header')
    <!-- /Header -->

    <!-- Main -->
    @yield('content')
    <!-- End Main -->

    <!-- Footer -->
    @include('frontend.layouts.footer')
    <!-- End Footer -->


    
    
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#008ac8"/></svg></div>


    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="{{asset('frontend/libs/jquery-migrate-3.0.1.min.js')}}"></script>
    <script src="{{asset('frontend/libs/popper.min.js')}}"></script>
    <script src="{{asset('frontend/libs/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/libs/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('frontend/libs/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/libs/jquery.stellar.min.js')}}"></script>
    <script src="{{asset('frontend/libs/owlcarousel/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/libs/fancybox/js/fancybox.umd.js')}}"></script>
    <script src="{{asset('frontend/libs/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('frontend/libs/aos.js')}}"></script>
    <script src="{{asset('frontend/libs/jquery.animateNumber.min.js')}}"></script>
    <script src="{{asset('frontend/libs/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('frontend/libs/scrollax.min.js')}}"></script>
    
    {{-- <script src="{{asset('frontend/libs/google-map.js')}}"></script> --}}
    <script src="{{asset('frontend/libs/main.js')}}"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('frontend/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/libs/animate/wow.min.js')}}"></script>
    <script src="{{asset('frontend/libs/owlcarousel/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/libs/slick/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/libs/fancybox/js/fancybox.umd.js')}}"></script>
    <script src="{{asset('frontend/libs/countdown/jquery.countdown.min.js')}}"></script>
    <script src="{{url('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@3.3.122/build/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.js" integrity="sha512-kD7tmrKmC9SIAmSjWfr4nNhW2tiFxdusha570xUOISMqg8QLeLQPSrqIT0UciOZGoLpVyyFRBYYqmiY9i5Xr7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{asset('frontend/js/main.js?v='.time())}}"></script>
    {{-- <script src="{{asset('frontend/js/ajax.js?v='.time())}}"></script> --}}
    {{-- <script src="{{asset('frontend/js/customer.js?v='.time())}}"></script> --}}
    <script type="text/javascript">
        $(function() {
            @if (Session::has('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}'
                })
            @endif
    
            @if (Session::has('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}'
                })
            @endif

            @if (Session::has('warning'))
                Toast.fire({
                    icon: 'warning',
                    title: '{{ Session::get('warning') }}'
                })
            @endif
        });
    </script>
    <!-- /JS -->
    @yield('page_script')
</body>

</html>
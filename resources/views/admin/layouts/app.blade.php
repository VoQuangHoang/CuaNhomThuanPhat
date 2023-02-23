<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Admin {{ !empty($site_info->company) ? ' - '.$site_info->company : NULL}}</title>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <link rel="icon" type="image/x-icon" href="{{asset(!empty($site_info->favicon) ? $site_info->favicon : 'backend/img/logo.png')}}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-toggle/3.6.1/bootstrap4-toggle.min.css"
          integrity="sha512-EzrsULyNzUc4xnMaqTrB4EpGvudqpetxG/WNjCpG6ZyyAGxeB6OBF9o246+mwx3l/9Cn838iLIcrxpPHTiygAA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
          integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
          crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
          integrity="sha512-aEe/ZxePawj0+G2R+AaIxgrQuKT68I28qh+wgLrcAJOz3rxCP+TwrK5SPN+E5I+1IQjNtcfvb96HDagwrKRdBw=="
          crossorigin="anonymous"/>
          
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('backend/plugins/daterangepicker/daterangepicker.css') }}" />

    <!-- Bootstrap Colorpicker -->
    <link rel="stylesheet" href="{{url('backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}">

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" href="{{url('backend/plugins/sweetalert2/sweetalert2.min.css')}}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{url('backend/plugins/select2/css/select2.min.css')}}">

    <!-- My CSS -->
    <link rel="stylesheet" href="{{ url('backend/css/mystyle.css') }}">

    @include('admin.layouts.datatables_css')

    @stack('third_party_stylesheets')

    @yield('page_css')

    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ !empty($site_info->logo) ? $site_info->logo : asset('backend/img/logo.png')}}" alt="TXBBLogo" height="60" width="60">
    </div>
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset(Auth()->check() ? Auth::user()->image : '/backend/images/user.png')}}"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-dark">
                        <img src="{{asset(Auth()->check() ? Auth::user()->image : '/backend/images/user.png')}}"
                             class="img-circle elevation-2 bg-white"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0">@yield('controller')</h4>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home')}}">Trang tổng quan</a></li>
                            @if(URL::current() != route('admin.home'))
                            <li class="breadcrumb-item"><a href="@yield('controller_route')">@yield('controller')</a></li>
                            <li class="breadcrumb-item active">@yield('action')</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <a id="back-to-top" href="#" class="btn btn-info back-to-top" role="button" aria-label="Scroll to top">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        {{-- <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.1.0
        </div> --}}
        <strong>
            Copyright &copy; {{ date('Y') }} <a href="https://jks.vn" target="_blank">JKS.VN</a>.
        </strong>
        All rights reserved.
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"
        integrity="sha512-AJUWwfMxFuQLv1iPZOTZX0N/jTCIrLxyZjTRKQostNU71MzZTEPHjajSK20Kj1TwJELpP7gl+ShXw5brpnKwEg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"
        integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous"></script>
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.3/bootstrapSwitch.min.js"
        integrity="sha512-DAc/LqVY2liDbikmJwUS1MSE3pIH0DFprKHZKPcJC7e3TtAOzT55gEMTleegwyuIWgCfOPOM8eLbbvFaG9F/cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });

    $("input[data-bootstrap-switch]").each(function () {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>

<!-- Datatables Js -->
@include('admin.layouts.datatables_js')

<!-- CKEditor - CKFinder -->
<script src="{{ asset('backend/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('backend/plugins/ckfinder/ckfinder.js') }}"></script>

<!-- Nestable -->
<script src="{{ url('backend/js/jquery.nestable.js') }}"></script>

<!-- Sweetalert2  -->
<script src="{{url('backend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

<!-- My Script -->
<script src="{{ url('backend/js/myscript.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('backend/plugins/select2/js/i18n/vi.js') }}"></script>

<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{url('backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>

<script src="{{ url('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>


<script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>

<!-- Modal Delete Script-->
@include('admin.layouts.modal-confim-delete')
@include('admin.layouts.modal-confim-aff')

<!-- Sweet Alert Config-->
@include('admin.layouts.sweet-alert')

@stack('third_party_scripts')

@yield('page_scripts')
@livewireScripts
<script type="text/javascript">
$(document).ready(function(){
    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('span[data-count]');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('.dropdown-body');
    var key = '{{env('PUSHER_APP_KEY')}}';
    console.log(notificationsToggle);
    console.log(notificationsCount);
    if (notificationsCount <= 0) {
        notificationsWrapper.hide();
    }

    //Thay giá trị PUSHER_APP_KEY vào chỗ xxx này nhé
    var pusher = new Pusher('ad196c8e9d8bd44fbd4a', {
        encrypted: true,
        cluster: "ap1"
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('test-push');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\TestPush', function(data) {
        var existingNotifications = notifications.html();
        // var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        
        var newNotificationHtml = `
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">`+data.message+` <span class="float-right text-muted text-sm">3 mins</span></a>
        `;
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
        notificationsWrapper.show();
        alert(data.message);
    });
});
//     $(document).ready(function(){
//         var pusher = new Pusher('ad196c8e9d8bd44fbd4a', {
//             encrypted: true,
//             cluster: "ap1"
//         });
//         var channel = pusher.subscribe('test-push');
//         channel.bind('App\\Events\\TestPush', addMessageDemo);
//     });

//   function addMessageDemo(data) {
//     var notificationsWrapper   = $('.dropdown-notifications');
//     var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
//     var notificationsCountElem = notificationsToggle.find('span[data-count]');
//     var notificationsCount     = parseInt(notificationsCountElem.data('count'));
//     var notifications          = notificationsWrapper.find('.dropdown-body');
//     var liTag = $("<li class='list-group-item'></li>");
//     console.log(data.message)
//     liTag.html(data.message);
//     $('#messages').append(liTag);
//     // alert(data.message);

//     var existingNotifications = notifications.html();
//     var newNotificationHtml = `<div class="dropdown-divider"></div><a href="#" class="dropdown-item">`+data.message+` <span class="float-right text-muted text-sm">3 mins</span></a>`;

//     notifications.html(newNotificationHtml + existingNotifications);

//     notificationsCount += 1;
//     notificationsCountElem.attr('data-count', notificationsCount);
//     notificationsWrapper.find('.notif-count').text(notificationsCount);

//   }
</script>

</body>
</html>

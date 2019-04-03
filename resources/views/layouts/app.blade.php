<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="app">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Segoor') }} | @yield('title')</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/icon.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/font.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/ie/html5shiv.js')}}"></script>
    <script src="{{asset('assets/js/ie/respond.min.js')}}"></script>
    <script src="{{asset('assets/js/ie/excanvas.js')}}"></script>
    <![endif]-->
    <!-- Scripts -->

    <style>
        body {
            color:black;
            background-color:white;
            margin:0;
            padding:0;
            background-image:url({{asset('/assets/images/utb4.jpg')}});
            -webkit-background-size: cover; /* pour anciens Chrome et Safari */
            background-size: cover; /

        }
        body image{
            -webkit-filter: blur(3px);
            filter: blur(3px);
        }
    </style>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
    <div class="container aside-xl">
        <a class="navbar-brand block" href="{{url('/')}}"><span class="text-uppercase">{{ config('app.name', 'Segoor') }} </span></a>
        @yield('content')
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder">
        <p>
            <small>Power with <i class="fa fa-heart text-danger"></i>, by <a href="htpp://www.segoor.com" target="_blank">Segoor</a><br>&copy;{{date('Y')}}</small>
        </p>
    </div>
</footer>
<!-- / footer -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<!-- App -->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('assets/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/js/app.plugin.js')}}"></script>
</body>
</html>

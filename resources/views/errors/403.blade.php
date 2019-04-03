<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Coco Republik') }}</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
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
</head>
<body class="">
<section id="content">
    <div class="row m-n">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="text-center m-b-lg">
                <h1 class="h text-white animated fadeInDownBig">403</h1>
            </div>
            <div class="list-group bg-info auto m-b-sm m-b-lg">
                <a href="{{url('/')}}" class="list-group-item">
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <i class="fa fa-fw fa-home icon-muted"></i> Aller à la page d'accueil
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <i class="fa fa-fw fa-question icon-muted"></i> Envoyez-nous un conseil
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <span class="badge bg-info lt">021-215-584</span>
                    <i class="fa fa-fw fa-phone icon-muted"></i> Appelez-nous
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item">
                    <i class="fa fa-chevron-right icon-muted"></i>
                    <span class="badge bg-info lt">Se deconnecter</span>
                    <i class="fa fa-fw fa-power-off"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<footer id="footer">
    <div class="text-center padder clearfix">
        <p>
            <small>Power with <i class="fa fa-heart text-danger"></i>, by <a href="http://www.segoor.com" target="_blank"> Segoor</a><br>&copy;{{date('Y')}}</small>
        </p>
    </div>
</footer>

</body>
</html>
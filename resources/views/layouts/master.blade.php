<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="app">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Segoor') }} - @yield('title')</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/icon.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/font.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/app.v1.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/js/datatables/datatables.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/js/chosen/chosen.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/js/sweetalert/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/toastr/toastr.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/js/bootstrap-select/bootstrap-select.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/js/dropzone/dropzone.min.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/js/pickadate.js/themes/default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/pickadate.js/themes/default.date.css')}}">
    <link href="{{asset('assets/js/fileinput/jquery.fileuploader.css')}}" media="all" rel="stylesheet">
    <link href="{{asset('assets/js/fileinput/jquery.fileuploader-theme-thumbnails.css')}}" media="all" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/pickmeup.css')}}" type="text/css" />

    @yield('styles')

    <!--[if lt IE 9]>
    <script src="{{asset('assets/js/ie/html5shiv.js')}}"></script>
    <script src="{{asset('assets/js/ie/respond.min.js')}}"></script>
    <script src="{{asset('assets/js/ie/excanvas.js')}}"></script>
    <![endif]-->
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<section class="vbox">
    @include('includes.header')
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('includes.sidebar')
            <!-- /.aside -->
            <section id="content">

                    <!--<section class="vbox stretch">-->
                        @yield('content')
                    <!--</section>-->
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
        </section>
    </section>
</section>

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/js/fileinput/jquery.fileuploader.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/fileinput/custom.js')}}"></script>
<script src="{{asset('assets/js/fileinput/fileinput.js')}}"></script>
<!-- App -->
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('assets/js/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('assets/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/chosen/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-customselect-1.9.1.min.js')}}"></script>

<script src="{{asset('assets/js/sweetalert/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/toastr/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/tableExport/libs/FileSaver/FileSaver.min.js')}}"></script>
<script src="{{asset('assets/js/tableExport/libs/js-xlsx/xlsx.core.min.js')}}"></script>
<script src="{{asset('assets/js/tableExport/libs/jsPDF/jspdf.min.js')}}"></script>
<script src="{{asset('assets/js/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js')}}"></script>
<script src="{{asset('assets/js/tableExport/tableExport.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.filter_input.js')}}"></script>
<script src="{{asset('assets/js/printThis/printThis.js')}}"></script>

<script src="{{asset('assets/js/pickadate.js/picker.js')}}"></script>
<script src="{{asset('assets/js/pickadate.js/picker.date.js')}}"></script>
<script src="{{asset('assets/js/pickadate.js/picker.time.js')}}"></script>
<script src="{{asset('assets/js/pickadate.js/translations/fr_FR.js')}}"></script>

<script src="{{asset('assets/plugins/pickmeup/jquery.pickmeup.twitter-bootstrap.js')}}"></script>
<script src="{{asset('assets/plugins/pickmeup/jquery.pickmeup.uikit.js')}}"></script>
<script src="{{asset('assets/plugins/pickmeup/pickmeup.js')}}"></script>

<script>
    var $date_limit = $('.datepicker-limit');
    var $date = $('.datepicker');
    var $input_text =  $('.input_text');
    var $input_alpha_no = $('.input_alpha_no_space');
    var $input_alpha = $('.input_alpha');
    var $input_numeric =  $('.input_numeric');
    var $input_select = $(".chosen-select");
    $(function () {
        $date_limit.pickadate({
            selectMonths: true,
            selectYears: true,
            formatSubmit: 'yyyy/mm/dd',
            hiddenName: true,
            max: new Date('yyy/mm/dd'),
            disable: [
                true,
                1,2,3,4,5,6
            ]
        });
        $date.pickadate({
            selectMonths: true,
            selectYears: true,
            formatSubmit: 'yyyy/mm/dd',
            hiddenName: true
        });
        $input_text.filter_input({regex: '[a-z A-Z]', events: 'keypress paste'});
        $input_alpha_no.filter_input({regex: '[a-zA-Z0-9]', events: 'keypress paste'});
        $input_alpha.filter_input({regex: '[a-z A-Z 0-9]', events: 'keypress paste'});
        $input_numeric.filter_input({regex: '[0-9]', events: 'keypress paste'});
        $input_select.chosen({
            width: "100%",
            no_results_text: "Oups, rien trouvé!",
            no_results: "sfgs"
        });
        $.ajaxSetup({
            error: function (jqXhr) {
                if (jqXhr.status === 401) {
                    window.location.href = "/";
                }
            }
        });
        $(".chosen-select").chosen({
            width: "100%",
            no_results_text: "Oups, rien trouvé!",
            no_results: "sfgs"
        });

        pickmeup.defaults.locales['en'] = {
            days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            months: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'],
            monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jui', 'Jui', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec']
        };

        pickmeup('.date', {
            format	: 'd-m-Y'
        });
    });
</script>

@yield('scripts')

</body>
</html>
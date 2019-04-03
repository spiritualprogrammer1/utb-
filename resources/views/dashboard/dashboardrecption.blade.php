@section('title') Administration générale @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder">
                    <section class="row m-b-md">
                        <div class="col-sm-6">
                            <h3 class="m-b-xs text-black">Tableau de bord</h3>
                            <small>Bienvenu a vous, <span
                                        style="text-transform: capitalize">{{ Auth::user()->username }}</span>, <i
                                        class="fa fa-map-marker fa-lg text-primary"></i> Abidjan
                            </small>
                        </div>
                        <div class="col-sm-3 text-right text-left-xs m-t-md">
                            <div class="has-success" id="periode">
                                <input class="input-sm  form-control col-sm-3" placeholder="Date debut" name="datedebu" id="datedebu" style="width: 87px">

                                <input class="input-sm col-sm-3 form-control"  placeholder="Date fin" name="datefin" id="datefin" style="width: 87px">
                                <a href="#" class="btn btn-sm col-sm-3 btn-icon btn-info" id="valider"><i class="fa fa-search"></i></a>
                            </div>



                            <!--<a href="#nav, #sidebar" class="btn btn-icon b-2x btn-info btn-rounded" data-toggle="class:nav-xs, show"><i class="fa fa-bars"></i></a>-->
                        </div>
                    </section>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-success lter text-center">
                                    <a href="#">
                                        <i class="fa fa-user fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">Total Client
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_clientparticulier"
                                       class="lien_clientparticulier">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="clientparticulier">{{number_format($clientparticulier)}}</span>
                                            </div>
                                            <small class="text-muted">PARTICULIER</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin=""
                                       id="lien_client_entreprise" class="lien_client_entreprise">
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span
                                                        class="client_entreprise">{{number_format($cliententreprise)}}</span>
                                            </div>
                                            <small class="text-muted">ENTREPRISE</small>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 b-b b-r">
                            <a href="#" title="Bon de Sortie" class="block padder-v hover lien_nbrevehic"
                               data-toggle="modal" data-site="" data-debu="" data-fin=""
                               id="lien_nbrevehic">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                            <i class="fa fa-truck i-sm text-white"></i>
                                          </span>
                                <span class="clear">
                                            <span class="h3 block m-t-xs text-success">
                                            <span class="nbrevehic">{{number_format($nbrevehic)}}</span>
                                            </span>
                                            <small class="text-muted text-u-c">total des vehicules</small>
                                        </span>
                            </a>
                        </div>
                    </div>
                </section>
            </section>
        </section>

    </section>
    @include('dashboard.modaldashbord')
@endsection
@section('scripts')
    <script src="{{asset('assets/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript">
        $('#datedebu').datepicker({
            format: "yyyy-mm-dd",

        })
        $('#datefin').datepicker({
            format: "yyyy-mm-dd",

        })



        $('#datefin').datepicker().on('changeDate', function(e) {

            var inputdate=$("#datefin").val();
            var d = new Date();
            var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
            if(Date.parse(inputdate) > Date.parse(currentdate)){
                $("#datefin").val('');
                toastr["error"]("Veuillez rentrer une date ultérieur", "Oups!");

                //Mettez ici tous vos actions et messages d'erreur...
                //Mettez ici tous vos actions et messages d'erreur...
            }
        });



        $('#datedebu').datepicker().on('changeDate', function(e) {

            var inputdate=$("#datedebu").val();
            var d = new Date();
            var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
            if(Date.parse(inputdate) > Date.parse(currentdate)){
                $("#datedebu").val('');
                toastr["error"]("Veuillez rentrer une date ultérieur", "Oups!");

                //Mettez ici tous vos actions et messages d'erreur...
                //Mettez ici tous vos actions et messages d'erreur...
            }
        });

        function dateController(val){


            var inputdate=$(val).val();
            var d = new Date();
            var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
            if(Date.parse(inputdate) > Date.parse(currentdate)){
                $(val).val('');
                //Mettez ici tous vos actions et messages d'erreur...
                //Mettez ici tous vos actions et messages d'erreur...
            }
        }
        function addZero(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }




        $('#valider').on('mouseup', function (e) {

            var datedebu = $("#datedebu").val() + ' 00:00:00';
            var datefin = $('#datefin').val() + ' 23:59:59';

            var site=$('#site').val();

            e.preventDefault;

            $.get("{{url('dashboareceptionnaire')}}", {datedebu: datedebu, datefin: datefin}, function (data) {
                console.log(data.cliententreprise);
                console.log(data.clientparticulier);
                console.log(data.nbrevehic);
                $('.client_entreprise').text(data.cliententreprise);
                $('.clientparticulier').text(data.clientparticulier);
                $('.nbrevehic').text(data.nbrevehic);
                $('#lien_nbrevehic').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_client_entreprise').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_clientparticulier').attr({"data-debu": datedebu, "data-fin": datefin});
            });
        });


        /****Client***/

        $('#lien_clientparticulier').on('click', function () {
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'clientparticulier_reception',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        $('#lien_client_entreprise').on('click', function () {
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'client_entreprise_commerc',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })









        //=========================//
        /**********Total revision en attente d"essai********************/

        /**********Total diagnostique********************/

        /**************total befor test***************/





        $('#lien_releasevhicvisit').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releasevhicvisit',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        /*******lien_nbrevehic**********/

        $('#lien_nbrevehic').on('click', function () {
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'nbrevehic_recptio',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            });

        })
        /*****lien_pieceAvaliderr*****/

        $('#lien_pieceAvaliderr').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'bondesortievalide',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        /*********lien_pieceValider********/

        $('#lien_pieceValider').on('click', function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'pieceValider',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })
        /**************lien_repaittent**************/

        $('#lien_repaittent').on('click', function () {
            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'repaittent',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })

        /**********lien_repairEffectuer***********/

        $('#lien_repairEffectuer').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'repairEffectuer',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })
        /***************lien_repairencours**********/

        $('#lien_repairencours').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'repairencours',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })

        //********************lien_revisionattente

        $('#lien_revisionattente').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'revisionattente',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })
        /********************lien_revisionencours*******/
        $('#lien_revisionencours').on('click', function () {
            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'revisionencours',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })

        /***************lien_visitecheffetc*******/

        $('#lien_visitecheffetc').on('click', function () {
            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'visitecheffetc',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {

                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");


                },

            });
        })

        /********lien_releaserevisionattent*******/
        $('#lien_releaserevisionattent').on('click', function () {
            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releaserevisionattent',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        })

        /***********lien_visitechencours*****/

        $('#lien_visitechencours').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'visitechencours',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");


                },

            });
        })


        /*******lien_visiteTechnattente***/
        $('#lien_visiteTechnattente').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'visiteTechnattente',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");


                },

            });
        })


    </script>

@endsection

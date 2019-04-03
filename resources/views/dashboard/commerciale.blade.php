@section('title') Chef commerciale @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder">
                    <section class="row m-b-md">
                        <div class="col-sm-6">
                            <h3 class="m-b-xs text-black">Tableau de bord </h3>
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
                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border  bg-success lter text-center">
                                    <a href="#">
                                        <i class="fa fa-files-o fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">Facture
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_totalfacturearegle"
                                       class="lien_totalfacturearegle">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="totalfacturearegle">{{number_format($factureareglé)}}</span>
                                            </div>
                                            <small class="text-muted">non soldée</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_totalfactsolde"
                                       class="lien_totalfactsolde">
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span class="totalfactsolde">{{number_format($facturesoldé)}}</span></div>
                                            <small class="text-muted">soldée</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-warning lter text-center">
                                    <a href="#">
                                        <i class="fa fa-print fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">DEVIS COMPLEMENTAIRE
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_devisattente"
                                       class="lien_devisattente">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="totaldevisattente">{{number_format($totaldevisattente)}}</span>
                                            </div>
                                            <small class="text-muted">en attente</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_devisvalide"
                                       class="lien_devisvalide">
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span class="totaldevisvalide">{{number_format($totaldevisvalide)}}</span></div>
                                            <small class="text-muted">validé</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-success lter text-center">
                                    <a href="#">
                                        <i class="fa fa-files-o fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">Devis
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_totalproformaattente"
                                       class="lien_totalproformaattente">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="totalproformaattente">{{number_format($totalproformaattente)}}</span>
                                            </div>
                                            <small class="text-muted">en attente</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_totalproformavalidé"
                                       class="lien_totalproformavalidé">
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span class="totalproformavalidé">{{number_format($totalproformavalidé)}}</span></div>
                                            <small class="text-muted">validé</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


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

            $.get("{{url('dashboradcommerciale')}}", {datedebu: datedebu, datefin: datefin}, function (data) {
                console.log(datedebu)
                $('.totaldevisolde').text(data.totaldevisolde);
                $('.totproattente').text(data.totproattente);
                $('.totaldevisvalide').text(data.totaldevisvalide);
                $('.totaldevisattente').text(data.totaldevisattente);
                $('.totfacturereglé').text(data.totreglé);
                $('.totareglé').text(data.totareglé);
                $('.totalfactsolde').text(data.facturesoldé);
                $('.totalfacturearegle').text(data.factureareglé);
                $('.totalfactureareglé').text(data.nbatprofdj);
                $('.factureglé').text(data.nbrefactregledj);
                $('.totalproformaattente').text(data.totalproformaattente)
                $('.totalproformavalidé').text(data.totalproformavalidé);
                $('.tot_rglt_amount_mont').text(data.tot_rglt_amount_mont)
                $('.client_entreprise').text(data.client_entreprise);
                $('.clientparticulier').text(data.clientparticulier);
                $('.totaldevinonsolde').text(data.totaldevinonsolde);
                $('#lien_totalfacturearegle').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisnonsolde').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisattente').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_afterTestAttent').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_nbrevisionattent').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalbefor_test').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisvalide').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalproformaattente').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalproformavalidé').attr({"data-fin": datefin});
                $('#lien_client_entreprise').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_clientparticulier').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_reglement').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalfactsolde').attr({"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totlien_devisoldealfacturearegle').attr({ "data-fin": datefin});

                $('#lien_devisolde').attr({"data-debu": datedebu, "data-fin": datefin});


            });


        });
        //=================devis  solde================/
        $('#lien_devisolde').on('click',function(){
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'devisolde',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            });
        });


        //=================devis non solde================/
        $('#lien_devisnonsolde').on('click',function(){
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'devisnonsolde',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            });
        });

        //=================deviscomplementaire ne attente================/
        $('#lien_devisattente').on('click',function(){
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'devisattente_commerc',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            });
        });
        /*****************/
        $('#lien_devisvalide').on('click',function() {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'devisvalide_commerc',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });


        });

        /****proformat validé******/

        $('#lien_totalproformavalidé').on('click',function()
        {
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'proformvalide_commerc',
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

        /******proformat en attente****/

        $('#lien_totalproformaattente').on('click',function()
        {
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'proformattente_commer',
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

        /****facture a reglé***/

        $('#lien_totalfacturearegle').on('click',function()
        {

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'factureasoldé_commerc',
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

        /*******facture soldé****/

        $('#lien_totalfactsolde').on('click',function()
        {

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'factursoldercomerciale',
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



        /********Reeglement*****/

        //        $('#lien_reglement').on('click',function()
        //        {
        //            var site = $(this).attr('data-site');
        //
        //
        //            var datedebu = $(this).attr('data-debu');
        //            var datefin = $(this).attr('data-fin');
        //
        //
        //            $.ajax({
        //                url: 'totat_reglement',
        //                type: 'GET',
        //                dataType: 'html',
        //                data: {datedebu: datedebu, datefin: datefin,site: site},
        //                success: function (data) {
        //                    $(".dashboard").html(data);
        //                    $('#dashboard').modal("show");
        //                    console.log(data);
        //
        //                },
        //
        //            });
        //        })


        /****Client***/















        //=========================//


        /**************total befor test***************/
        $('#lien_nbrepairattent').on('click', function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'nbrepairattent',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin, site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })
        /*****total visite en attente******/


        $('#lien_nbrevisitattente').on('click', function () {
            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'nbrevisitattente',
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

        /*******lien_releasattente*/

        $('#lien_releasattente').on('click', function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releasattente',
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

        /************/


        $('#lien_releaseattentepair').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'releaseattentepair',
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
        /***lien_releasevisiatten*/

        $('#lien_releasevisiatten').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releasevisiatten',
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

        /*********lien_releasevhicrepair*******/

        $('#lien_releasevhicrepair').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releasevhicrepair',
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
        /**lien_releasevhicvisit***/
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

        /************lien_releasevhicRevision*******/

        $('#lien_releasevhicRevision').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'releasevhicRevision',
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

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'nbrevehic',
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
        /*****lien_pieceAvaliderr*****/

        $('#lien_pieceAvaliderr').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'pieceAvaliderr',
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

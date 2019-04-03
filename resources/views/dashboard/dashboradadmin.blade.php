@section('title') @endsection
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
                        <div class="col-sm-12 col-sm-6">
                            <div class="panel b-a">
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="utilisateur connecte"
                                           class="block padder-v hover lien_totaldiagnostique"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="userconnected">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="fa fa-user i-1x text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-primary">
                                            <span class="totaldiagnostique">{{number_format($userconnect)}}</span>
                                            </span>
                                            <small class="text-muted text-u-c"> Utilisateur connecté</small>
                                          </span>
                                        </a>
                                    </div>

                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total utilisateur"
                                           class="block padder-v hover lien_totaldiagnostique"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="totaluser">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                            <i class="fa fa-user i-1x text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-info">
                                            <span class="totaldiagnostique">{{number_format($userTotal)}}</span>
                                            </span>
                                            <small class="text-muted text-u-c">Total utilisateur</small>
                                          </span>
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
        $('#periode').hide();

        $('#site').on('change',function () {
            $('#periode').show();
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

            $.get("{{url('technicaldashboard')}}", {datedebu: datedebu, datefin: datefin,site:site}, function (data) {
                console.log(site)
                $('.totalexpirassurane').text(data.totalexpirassurane);
                $('.totalexpivisit').text(data.totalexpivisit)
                $('.totaldevisolde').text(data.totaldevisolde);
                $('.totaldevinonsolde').text(data.totaldevinonsolde);
                $('.totproattente').text(data.totproattente);
                $('.totaldevisattente').text(data.totaldevisattente);
                $('.totaldevisvalide').text(data.totaldevisvalide);
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
                $('.totalbefor_test').text(data.totalbefor_test);
                $('.afterTestAttent').text(data.afterTestAttent);
                $('.totaldiagnostique').text(data.totaldiagnostique);
                $('.nbrepairattent').text(data.nbrepairattent);
                $('.nbrevisitattente').text(data.nbrevisitattente);
                $('.nbrevisionattent').text(data.nbrevisionattent);
                $('.releasattente').text(data.releasattente);
                $('.releaseattentepair').text(data.releaseattentepair);
                $('.releasevisiatten').text(data.releasevisiatten);
                $('.releaserevisionattent').text(data.releaserevisionattent);
                $('.releasevhicrepair').text(data.releasevhicrepair);
                $('.releasevhicvisit').text(data.releasevhicvisit);
                $('.releasevhicRevision').text(data.releasevhicRevision);
                $('.nbrevehic').text(data.nbrevehic);
                $('.pieceAvaliderr').text(data.pieceAvaliderr);
                $('.pieceValider').text(data.pieceValider);
                $('.taupieceAvalider').text(data.taupieceAvalider + "%");
                $('.taupiecevalider').text(data.taupiecevalider + "%");
                $('.repaittent').text(data.repaittent);
                $('.repairEffectuer').text(data.repairEffectuer);
                $('.repairencours').text(data.repairencours);
                $('.revisioneffectuer').text(data.revisioneffectuer);

                $('.tauxreparationoneffectuer').text(data.tauxreparationoneffectuer + "%");
                $('.tauxreparationencours').text(data.tauxreparationencours + "%");
                $('.revisionattente').text(data.revisionattente);
                $('.revisionencours').text(data.revisionencours);
                $('.tauxrevisioneffectuer').text(data.tauxrevisioneffectuer + "%");
                $('.tauxrevisionencours').text(data.tauxrevisionencours);
                $('.visiteTechnattente').text(data.visiteTechnattente);
                $('.visitechencours').text(data.visitechencours);
                $('.tauxvisiteonecours').text(data.tauxvisiteonecours + "%");
                $('.tauxvisiteoneffectuer').text(data.tauxvisiteoneffectuer + "%");
                $('.visitecheffetc').text(data.visitecheffetc);
                $('#lien_expirassurane').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_expivisit').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisolde').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisnonsolde').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisvalide').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_devisattente').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_afterTestAttent').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_nbrevisionattent').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalbefor_test').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_nbrepairattent').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_nbrevisitattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releaserevisionattent').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releasattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releaseattentepair').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totaldiagnostique').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releasevisiatten').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releasevhicrepair').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releasevhicvisit').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_releasevhicRevision').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_nbrevehic').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_pieceAvaliderr').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_pieceValider').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_repaittent').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_repairEffectuer').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_repairencours').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_revisionattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_revisionencours').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_visitecheffetc').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $("#lien_visitechencours").attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_visiteTechnattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_revisioneffectuer').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});

                $('#lien_totalproformaattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalproformavalidé').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_client_entreprise').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_clientparticulier').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_reglement').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalfactsolde').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalfacturearegle').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});

            });


        });

        //======================================================================
        $('#totaluser').on('click',function(){
            $.ajax({
                url: 'totaluser',
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            })
        });
        /*************expiration assurance*****************/
        $('#lien_expirassurane').on('click',function () {
            $.ajax({
                url: 'expirassurane',
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        });
        /***********expiration visite technique********/
        $('#lien_expivisit').on('click',function(){
            $.ajax({
                url: 'expirationvisi',
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });
        });
        $('#lien_devisvalide').on('click',function() {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'devisvalide',
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
                url: 'devisattente',
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

        //============================
        $('#userconnected').on('click',function(){
            $.ajax({
                url: 'userconnected',
                type: 'GET',
                dataType: 'html',
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },


            })

        })

        /****proformat validé******/

        $('#lien_totalproformavalidé').on('click',function()
        {
            var site = $(this).attr('data-site');


            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'proformvalide',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
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
            var site = $(this).attr('data-site');


            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'proformattente',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
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
            var site = $(this).attr('data-site');


            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'factureasoldé',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
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
            var site = $(this).attr('data-site');


            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'factursolder',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
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


        $('#lien_clientparticulier').on('click', function () {

            var site = $(this).attr('data-site');


            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'clientparticulier',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        $('#lien_client_entreprise').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'client_entreprise',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })




        $('#lien_revisioneffectuer').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');


            $.ajax({
                url: 'revisioneffectuer',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        $('#lien_afterTestAttent').on('click', function () {


            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'aftertestattent',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })



        //=========================//
        /**********Total revision en attente d"essai********************/
        $('#lien_nbrevisionattent').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'revisionattentessai',
                type: 'GET',
                dataType: 'html',
                data: {datedebu: datedebu, datefin: datefin,site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        })

        /**********Total diagnostique********************/
        $('#lien_totaldiagnostique').on('click', function () {

            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'totaldiagnostic',
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
        /**************total befor test***************/
        $('#lien_totalbefor_test').on('click', function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'totalbefor_test',
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

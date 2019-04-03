@section('title') Magasinier @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <section>
            <section class="vbox">
                <section class="scrollable padder">
                    <section class="row m-b-md">
                        <div class="col-sm-6">
                            <h3 class="m-b-xs text-black">Tableau de bord du Magasinier </h3>
                            <small>Bienvenu a vous, <span
                                        style="text-transform: capitalize">{{ Auth::user()->username }}</span>, <i
                                        class="fa fa-map-marker fa-lg text-primary"></i> Abidjan
                            </small>
                        </div>

                    </section>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel b-a">
                                <div class="row m-n">
                                    <!---------- bon de Sortie revision en attente -------------->
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total fournisseur"
                                           class="block padder-v hover"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_totalfournisseur">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="i i-users2 text-white"></i>
                                          </span>
                                            <span class="clear">
                                                <?php $site=\Illuminate\Support\Facades\Auth::user()->employee->site_id; ?>
                                                <span class="h3 block m-t-xs text-primary">
                                            <span class="totalfournisseur">{{number_format(App\Supplier::where('site_id',$site)->count())}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Fournisseurs</small>
                                          </span>
                                        </a>

                                    </div>
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total approbation de piece en attente"
                                           class="block padder-v hover"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_approbationattente">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-warning hover-rotate"></i>
                                            <i class="fa fa-cog text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-primary">
                                            <span class="apprabationattente">{{number_format($demands)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Appro. de pièce en attente</small>
                                          </span>
                                        </a>

                                    </div>


                                    <!---------- approbation en attente -------------->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel b-a">
                                <div class="row m-n">
                                    <!---------- bon de Sortie revision en attente -------------->
                                    <div class="col-md-12 b-b b-r">
                                        <a href="#" title="total fournisseur"
                                           class="block padder-v hover"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_stockminimal">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="i i-cog text-white"></i>
                                          </span>
                                            <span class="clear">
                                                <span class="h3 block m-t-xs text-primary">
                                            <span class="totalfournisseur">{{number_format($stockminimal)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Stock <b class="text text-warning" style="color:red; ">minimal</b></small>
                                          </span>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="row bg-light dk m-b">

                        </div>

                    </div>

                </section>
            </section>
        </section>


    </section>

    <!-- Modal -->

    <!-- /.Live preview-->
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

            $.get("{{url('technicalManagerdashboard')}}", {datedebu: datedebu, datefin: datefin,site:site}, function (data) {
                console.log(data.totalexpirassurane);

                $('.totalacquisition').text(data.totalacquisition);
                $('.apprabationattente').text(data.approbationenattente);
                $('.totalfournisseur').text(data.totalfournisseur);
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
                $('.userconnected').text(data.userconnected)
                $('.totaluser').text(data.totaluser);

                $('.tauxreparationoneffectuer').text(data.tauxreparationoneffectuer + "%");
                $('.tauxreparationencours').text(data.tauxreparationencours + "%");
                $('.revisionattente').text(data.revisionattente);
                $('.revisionencours').text(data.revisionencours);
                $('.tauxrevisioneffectuer').text(data.tauxrevisioneffectuer + "%");
                $('.tauxrevisionencours').text(data.tauxrevisionencours +"%");
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
                $('#lien_totalfournisseur').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_approbationattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#userconnected').attr({"data-site": site});

                $('#totaluser').attr({"data-site":site})
                $('#lien_clientparticulier').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});


                $('#lien_totalproformaattente').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalproformavalidé').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_client_entreprise').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_reglement').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalfactsolde').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalfacturearegle').attr({"data-site": site,"data-debu": datedebu, "data-fin": datefin});

            });


        });

        $('#lien_totalfournisseur').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'fournisseurMagasini',
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


        $('#lien_approbationattente').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'approbationattenteStock',
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




        /*********lien_pieceValider********/

        $('#lien_stockminimal').on('click', function () {

            $.ajax({
                url: 'stockminimal',
                type: 'GET',
                dataType: 'html',
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
                url: 'repaittentManager',
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
                url: 'repairEffectuerManager',
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
                url: 'repairencoursMang',
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
                url: 'revisionattenteManag',
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
                url: 'revisionencoursManag',
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
                url: 'visitecheffetcManag',
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
                url: 'releaserevisionattmanager',
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
                url: 'visitechencoursMang',
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
                url: 'visiteTechnattenteMang',
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

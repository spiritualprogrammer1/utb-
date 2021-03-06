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
                        <div class="col-sm-3 text-left-xs m-t-md ">
                            <select class="chosen-select input-sm form-control col-sm-" name="reference" id="site"
                                    required>
                                <option value disabled selected>Choisissez le site</option>

                                <option style="text-transform:uppercase;color:#133d55"  value="all_site" class="alert alert-info">Tout les sites</option>

                            @forelse($sites as $key=>$site)
                                    <option style="text-transform: uppercase"
                                            value="{{$site->id}}">{{$site->name}}</option>
                                @empty
                                    <option value>Aucun Site Disponible</option>
                                @endforelse
                            </select>
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
                        {{--@if(Auth::user()->can('information des car'))--}}
                        <div class="col-sm-6" >
                            <div class="panel b-a">
                                <div class="row m-n">
                                    <!---------- bon de Sortie revision en attente -------------->

                                   <div class="row" >


                                       <div class="col-md-6 b-b b-r">
                                           <a href="#" title="Demande de piece en attente"
                                              class="block padder-v hover lien_releaserevisionattent"
                                              data-toggle="modal" data-site="" data-debu="" data-fin=""
                                              id="lien_releaserevisionattent">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                            <i class="fa fa-bolt i-1x text-white"></i>
                                          </span>
                                               <span class="clear">
                                            <span class="h3 block m-t-xs text-danger"><span
                                                        class="releaserevisionattent">{{number_format($releasattente)}}</span></span>

                                            <small class="text-muted text-u-c">Demande de pièce en attente</small>
                                          </span>
                                           </a>
                                       </div>


                                       <!---------- bon de Sortie reparation en attente -------------->
                                       <div class="col-md-6 b-b b-r">
                                           <a href="#" title="Total car" class="block padder-v hover lien_nbrevehic"
                                              data-toggle="modal" data-site="" data-debu="" data-fin=""
                                              id="lien_nbrevehic">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                            <i class="fa fa-truck i-sm text-white"></i>
                                          </span>
                                               <span class="clear">
                                            <span class="h3 block m-t-xs text-success">
                                            <span class="nbrevehic">{{number_format($nbbus)}}</span>
                                            </span>

                                            <small class="text-muted text-u-c">total Car</small>
                                        </span>
                                           </a>
                                       </div>

                                   </div>


                                    <!---------- bon de Sortie visite en attente -------------->

                                  <div class="row">
                                      <div class="col-md-6 b-b b-r">
                                          <a href="#" title="Total diagnostique"
                                             class="block padder-v hover lien_totaldiagnostique"
                                             data-toggle="modal" data-site="" data-debu="" data-fin=""
                                             id="lien_totaldiagnostique">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                            <i class="fa fa-fire i-1x text-white"></i>
                                          </span>
                                              <span class="clear">
                                            <span class="h3 block m-t-xs text-danger">
                                            <span class="totaldiagnostique">{{number_format($totaldiagnostique)}}</span>
                                            </span>

                                            <small class="text-muted text-u-c">Total diagnostique</small>
                                          </span>
                                          </a>
                                      </div>

                                      <!---------- approbation en attente -------------->
                                      <div class="col-md-6 b-b b-r">
                                          <a href="#" title="BS. validé"
                                             class="block padder-v hover lien_pieceAvaliderr" data-toggle="modal"
                                             data-site="" data-debu="" data-fin="" id="lien_pieceAvaliderr">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="fa fa-check-square i-sm text-white"></i>
                                          </span>
                                              <span class="clear">
                                            <span class="h3 block m-t-xs text-primary"><span
                                                        class="pieceAvaliderr">{{number_format($bondesortievalide)}}</span></span>

                                            <small class="text-muted text-u-c">BS. validé</small>
                                         </span>
                                          </a>
                                      </div>
                                  </div>

                                </div>
                            </div>
                        </div>
                        {{--@endif--}}
                            {{--@if(Auth::user()->can('information des car'))--}}
                        <div class="col-sm-6" >
                            <div class="panel b-a" >
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="utilisateur connecte"
                                           class="block padder-v hover"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="userconnected">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="fa fa-user i-1x text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-primary">
                                            <span class="userconnected">{{number_format($userconnect)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Utilisateur connecté</small>
                                          </span>
                                        </a>
                                    </div>

                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total utilisateur"
                                           class="block padder-v hover "
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="totaluser">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                            <i class="fa fa-user i-1x text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-info">
                                            <span class="totaluser">{{number_format($userTotal)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c">Total utilisateur</small>
                                          </span>
                                        </a>
                                    </div>





                                </div>
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
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
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="fa fa-cog text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-primary">
                                            <span class="apprabationattente">{{number_format($approbationenattente)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Appro. de pièce en attente</small>
                                          </span>
                                        </a>

                                    </div>

                                </div>
                        </div>
                    </div>

                        <div class="col-sm-6" >
                            <div class="panel b-a">
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total car dans le garage" class="block padder-v hover lien_nbrecar_garage"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_nbrecar_garage">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                            <i class="fa fa-truck i-sm text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-success">

                                            <span class="nbr_car_garage">{{number_format($nbr_car_garage)}}</span>
                                            </span>
                                            <small class="text-muted text-u-c">total  véhicule dans le garage</small>
                                        </span>
                                        </a>
                                    </div>

                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total utilisateur"
                                           class="block padder-v hover lien_pannekm"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_pannekm">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                            <i class="fa fa-car fa-2x i-1x text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-info">
                                            <span class="pannekm">{{number_format($pannekm)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c">Panne  > 100 000 km</small>
                                          </span>
                                        </a>
                                    </div>





                                </div>
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total accident"
                                           class="block padder-v hover"
                                           data-toggle="modal" data-site="" class="lien_totalaccident" data-debu="" data-fin=""
                                           id="lien_totalaccident">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-primary hover-rotate"></i>
                                            <i class="fa fa-ambulance text-white"></i>
                                          </span>
                                            <span class="clear">
                                                <?php $site=\Illuminate\Support\Facades\Auth::user()->employee->site_id; ?>
                                                <span class="h3 block m-t-xs text-primary">
                                            <span class="totalaccident">{{number_format($nbreaccident)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> Nombre ACCIDENT</small>
                                          </span>
                                        </a>

                                    </div>
                                    <div class="col-md-6 b-b b-r">
                                        <a href="#" title="total accident km>100 000"
                                           class="block padder-v hover lien_totalaccidentkilometrage"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_totalaccidentkilometrage">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                            <i class="fa fa-ambulance text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-primary">
                                            <span class="totalaccidentkilometrage">{{number_format($totalaccidentkilometrage)}}</span>

                                            </span>
                                            <small class="text-muted text-u-c"> TOTAL ACCIDENT KM > 100 000</small>
                                          </span>
                                        </a>

                                    </div>

                                </div>
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->
                                    <div class="col-md-12 b-b b-r">
                                        <a href="#" title="total car dans le garage" class="block padder-v hover lien_nbr_panne_garage"
                                           data-toggle="modal" data-site="" data-debu="" data-fin=""
                                           id="lien_nbr_panne_garage">
                                          <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-danger-lt hover-rotate"></i>
                                            <i class="fa fa-car fa-2x i-sm text-white"></i>
                                          </span>
                                            <span class="clear">
                                            <span class="h3 block m-t-xs text-success">

                                            <span class="nbr_panne_garage">{{number_format($nbr_panne_garage)}}</span>
                                            </span>
                                            <small class="text-muted text-u-c">total  de pannes dans le garage</small>
                                        </span>
                                        </a>
                                    </div>







                                </div>
                                <div class="row m-n">
                                    <!---------- utilisateur -------------->



                                </div>

                            </div>
                        </div>
                            {{--@endif--}}
                            {{--@if(Auth::user()->can('information des car'))--}}
                    <div class="row">

                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-info lter text-center">
                                    <a href="#">
                                        <i class="fa fa-cogs fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">Essai en attente - AT
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_nbrepairattent"
                                       class="lien_nbrepairattent">
                                        <div class="col-xs-4 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="nbrepairattent">{{number_format($nbrepairattent)}}</span>

                                            </div>
                                            <small class="text-muted">Reparation</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_nbrevisionattent"
                                       class="">
                                        <div class="col-xs-4">
                                            <div class="h3 font-bold"><span class="nbrevisionattent">{{number_format($nbrevisionattent)}}</span></div>

                                            <small class="text-muted">Revision</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_nbrevisitattente"
                                       class="lien_nbrevisitattente">
                                        <div class="col-xs-4">
                                            <div class="h3 font-bold"><span
                                                        class="nbrevisitattente">{{number_format($nbrevisitattente)}}</span>

                                            </div>
                                            <small class="text-muted">Visite</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-danger lter text-center">
                                    <a href="#">
                                        <i class="fa fa-calendar-times-o fa fa-3x m-t m-b text-white animated fadeInLeft"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">ALERTE EXPIRATION
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-debu="" data-site="" data-fin="" id="lien_expivisit"
                                       class="lien_expivisit">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="totalexpivisit">{{number_format($num_visite_expiration)}}</span>
                                            </div>
                                            <small class="text-muted">VISITE TECH</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_expirassurane"
                                       class="lien_expirassurane">
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span class="totalexpirassurane">{{number_format($num_insurance_expiration)}}</span></div>
                                            <small class="text-muted">ASSURANCE</small>

                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="panel b-a">
                                <div class="panel-heading no-border bg-primary lt text-center">
                                    <a href="#">
                                        <i class="fa fa-cog fa fa-3x m-t m-b text-white"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">Essais effectués
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin=""
                                       id="lien_totalbefor_test" class="lien_totalbefor_test">
                                        <div class="col-xs-6 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="totalbefor_test">{{number_format($totalbefor_test)}}</span>
                                            </div>
                                            <small class="text-muted">Avant travaux</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin=""
                                       id="lien_afterTestAttent" class="lien_afterTestAttent" >
                                        <div class="col-xs-6">
                                            <div class="h3 font-bold"><span
                                                        class="afterTestAttent">{{number_format($afterTestAttent)}}</span>
                                            </div>
                                            <small class="text-muted">Apres Travaux</small>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-3 col-sm-6">
                            {{--<div class="panel b-a">--}}
                                <div class="panel-heading no-border bg-primary lter text-center">
                                    <a href="#">
                                        <i class="fa fa-wrench fa fa-3x m-t m-b text-white"></i>
                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                               class="text-u-c">total reparation
                                        </small>
                                    </a>
                                </div>
                                <div class="padder-v text-center clearfix">
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_repairencours"
                                       class="lien_repairencours">
                                        <div class="col-xs-4 b-r">
                                            <div class="h3 font-bold"><span
                                                        class="repairencours">{{number_format($repairencours)}}</span>

                                            </div>
                                            <small class="text-muted">En cours</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_repaittent"
                                       class="lien_repaittent">
                                        <div class="col-xs-4">
                                            <div class="h3 font-bold">
                                                <span class="repaittent">{{number_format($repaittent)}}</span>

                                            </div>
                                            <small class="text-muted">En attente</small>
                                        </div>
                                    </a>
                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_repairEffectuer"
                                       class="lien_repairEffectuer">
                                        <div class="col-xs-4">
                                            <div class="h3 font-bold"><span
                                                        class="repairEffectuer">{{number_format($repairEffectuer)}}</span>
                                            </div>
                                            <small class="text-muted">Effectuée</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                            {{--@endif--}}


                    </div>



                    <div class="row bg-light dk m-b">
                        <div class="col-md-6 dker">
                            <section>
                                <div class="panel-body">
                                    <div id="" style="height: 350px">

                                        <section class="panel panel-default" id="progressbar">
                                            <header class="panel-heading">
                                                Progression
                                            </header>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="i i-check icon-muted"></i> Approbations  en attente
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$taupieceAvalider}}%" style="width:{{$taupieceAvalider}}% "></div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="taupieceAvalider">{{$taupieceAvalider}}%</span></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="i i-checked icon-muted"></i> Approbations  validées
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$taupiecevalider}}%" style="width:{{$taupiecevalider}}%"></div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="taupiecevalider">{{$taupiecevalider}}%</span></span>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-wrench icon-muted"></i> Reparations en cours
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxreparationencours}}%" style="width:{{$tauxreparationencours}}% "></div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="tauxreparationencours">{{$tauxreparationencours}}%</span></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-wrench icon-muted"></i> Reparations effectuées
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxreparationoneffectuer}}%" style="width:{{$tauxreparationoneffectuer}}% "></div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="tauxreparationoneffectuer">{{$tauxreparationoneffectuer}}%</span></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-eye icon-muted"></i> Revisions en cours
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxrevisionencours}}%" style="width:{{$tauxrevisionencours}}%"></div>


                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="tauxrevisionencours">{{$tauxrevisionencours}}%</span></span>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-eye icon-muted"></i> Revisions effectuées
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxrevisioneffectuer}}%" style="width:{{$tauxrevisioneffectuer}}%"></div>

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">

                                                                    <span class="badge bg-primary"><span class="tauxrevisioneffectuer">{{$tauxrevisioneffectuer}}%</span></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-magic icon-muted"></i> Visites techniques en cours
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxvisiteonecours}}%" style="width:{{$tauxvisiteonecours}}%"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="tauxvisiteonecours">{{$tauxvisiteonecours}}%</span></span>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <i class="fa fa-magic icon-muted"></i> Visites techniques fini
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="progress progress-xs m-t-sm">
                                                                        <div class="progress-bar bg-info" data-toggle="tooltip"
                                                                             data-original-title="{{$tauxvisiteoneffectuer}}%" style="width:{{$tauxvisiteoneffectuer}}%"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1">
                                                                    <span class="badge bg-primary"><span class="tauxvisiteoneffectuer">{{$tauxvisiteoneffectuer}}%</span></span>

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </li>
                                            </ul>
                                        </section>


                                    </div>
                                </div>
                            </section>
                        </div>
                        <section class="col-md-6">
                            <section>
                                <div class="panel-body flot-legend">
                                    <div id="" style="height:240px">

                                        <div class="col-md-6 col-sm-6">
                                            <div class="panel b-a">
                                                <div class="panel-heading no-border bg-primary lter text-center">
                                                    <a href="#">
                                                        <i class="fa fa-eye-slash fa fa-3x m-t m-b text-white"></i>
                                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                                               class="text-u-c">total visite technique
                                                        </small>
                                                    </a>
                                                </div>
                                                <div class="padder-v text-center clearfix">
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_visitechencours"
                                                       class="lien_visitechencour">
                                                        <div class="col-xs-4 b-r">
                                                            <div class="h3 font-bold"><span
                                                                        class="visitechencours">{{number_format($visitechencours)}}</span>

                                                            </div>
                                                            <small class="text-muted">En cours</small>
                                                        </div>
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_visiteTechnattente"
                                                       class="lien_visiteTechnattente">
                                                        <div class="col-xs-4">
                                                            <div class="h3 font-bold">
                                                                <span class="visiteTechnattente">{{number_format($visiteTechnattente)}}</span>

                                                            </div>
                                                            <small class="text-muted">En attente</small>
                                                        </div>
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_visitecheffetc"
                                                       class="lien_visitecheffetc">
                                                        <div class="col-xs-4">
                                                            <div class="h3 font-bold"><span
                                                                        class="visitecheffetc">{{number_format($visitecheffetc)}}</span>
                                                            </div>
                                                            <small class="text-muted">Effectuée</small>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div class="panel b-a">
                                                <div class="panel-heading no-border bg-primary lter text-center">
                                                    <a href="#">
                                                        <i class="fa fa-magic fa fa-3x m-t m-b text-white"></i>
                                                        <small style="top: 65px; position: absolute; right: 0; left: 0"
                                                               class="text-u-c">total revision
                                                        </small>
                                                    </a>
                                                </div>
                                                <div class="padder-v text-center clearfix">
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_revisionencours"
                                                       class="lien_revisionencours">
                                                        <div class="col-xs-4 b-r">
                                                            <div class="h3 font-bold"><span
                                                                        class="revisionencours">{{number_format($revisionencours)}}</span>
                                                            </div>
                                                            <small class="text-muted">En cours</small>
                                                        </div>
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_revisionattente"
                                                       class="lien_revisionattente">
                                                        <div class="col-xs-4">
                                                            <div class="h3 font-bold">
                                                                <span class="revisionattente">{{number_format($revisionattente)}}</span>
                                                            </div>
                                                            <small class="text-muted">En attente</small>
                                                        </div>
                                                    </a>
                                                    <a href="#" data-toggle="modal" data-site="" data-debu="" data-fin="" id="lien_revisioneffectuer"
                                                       class="lien_revisioneffectuer">
                                                        <div class="col-xs-4">
                                                            <div class="h3 font-bold"><span
                                                                        class="revisioneffectuer">{{number_format($revisioneffectuer)}}</span>
                                                            </div>

                                                            <small class="text-muted">Effectuée</small>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        </section>
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
        $loading_mail=$('#loading_mail');
        $('#periode').hide();
        $('#site').on('change',function () {
         var site =$('#site').val();
            $loading_mail.show();

            $.get("{{url('technicaldashboardsite')}}", {site: site}, function (data) {
                console.log(data.totalexpirassurane);

                $('.pannekm').text(data.pannekm);

                $('.nbr_panne_garage').text(data.nbr_panne_garage);

                $('.totalaccidentkilometrage').text(data.totalaccidentkilometrage);

                $('.totalaccident').text(data.nbreaccident);
                $('.nbr_car_garage').text(data.nbrevei)
                $('.totalacquisition').text(data.totalacquisition);
                $('.apprabationattente').text(data.approbationenattente);
                $('.totalfournisseur').text(data.totalfournisseur);
                $('.totalexpirassurane').text(data.num_insurance_expiration);
                $('.totalexpivisit').text(data.num_visite_expiration)
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
                $('.pieceAvaliderr').text(data.bsvalide);
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



                $('#lien_nbr_panne_garage').attr({"data-site":site});

                $('#lien_totalaccident').attr({"data-site":site});
                $('#lien_totalaccidentkilometrage').attr({"data-site":site});
                $('#lien_pannekm').attr({"data-site":site});

                $('#lien_expirassurane').attr({"data-site":site});
                $('#lien_nbrecar_garage').attr({"data-site":site})
                $('#lien_expivisit').attr({"data-site":site});
                $('#lien_devisolde').attr({"data-site":site});
                $('#lien_devisnonsolde').attr({"data-site":site});
                $('#lien_devisvalide').attr({"data-site":site});
                $('#lien_devisattente').attr({"data-site":site});
                $('#lien_afterTestAttent').attr({"data-site": site});
                $('#lien_nbrevisionattent').attr({"data-site": site});
                $('#lien_totalbefor_test').attr({"data-site": site});
                $('#lien_nbrepairattent').attr({"data-site": site});
                $('#lien_nbrevisitattente').attr({"data-site": site});
                $('#lien_releaserevisionattent').attr({"data-site": site});
                $('#lien_releasattente').attr({"data-site": site});
                $('#lien_releaseattentepair').attr({"data-site": site});
                $('#lien_totaldiagnostique').attr({"data-site": site});
                $('#lien_releasevisiatten').attr({"data-site": site});
                $('#lien_releasevhicrepair').attr({"data-site": site});
                $('#lien_releasevhicvisit').attr({"data-site": site});
                $('#lien_releasevhicRevision').attr({"data-site": site});
                $('#lien_nbrevehic').attr({"data-site": site});
                $('#lien_pieceAvaliderr').attr({"data-site": site});
                $('#lien_pieceValider').attr({"data-site": site});
                $('#lien_repaittent').attr({"data-site": site});
                $('#lien_repairEffectuer').attr({"data-site": site});
                $('#lien_repairencours').attr({"data-site": site});
                $('#lien_revisionattente').attr({"data-site": site});
                $('#lien_revisionencours').attr({"data-site": site});
                $('#lien_visitecheffetc').attr({"data-site": site});
                $("#lien_visitechencours").attr({"data-site": site});
                $('#lien_visiteTechnattente').attr({"data-site": site});
                $('#lien_revisioneffectuer').attr({"data-site": site});
                $('#lien_totalfournisseur').attr({"data-site": site});
                $('#lien_approbationattente').attr({"data-site": site});
                $('#userconnected').attr({"data-site": site});

                $('#totaluser').attr({"data-site":site})
                $('#lien_clientparticulier').attr({"data-site": site});


                $('#lien_totalproformaattente').attr({"data-site": site});
                $('#lien_totalproformavalidé').attr({"data-site": site});
                $('#lien_client_entreprise').attr({"data-site": site});
                $('#lien_reglement').attr({"data-site": site});
                $('#lien_totalfactsolde').attr({"data-site": site});
                $('#lien_totalfacturearegle').attr({"data-site": site});

            });



            $.ajax(
                {
                    url:'requet_notif',
                    type:'GET',
                    data:'site_id='+site,
                    dataType:'html',
                    success : function (data) {
                        $('#notif').html(data);
                    }}
            )



            if(site=="all_site")
            {
                $('#periode').hide();
            }
            else{
                $('#periode').show();
            }



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
                console.log(data.totalexpirassurane);

                $('.totalaccident').text(data.nbreaccident);
                $('.pannekm').text(data.pannekm);
                $('.nbr_panne_garage').text(data.nbr_panne_garage);

                $('.totalaccidentkilometrage').text(data.totalaccidentkilometrage);

                $('.totalacquisition').text(data.totalacquisition);
                $('.apprabationattente').text(data.approbationenattente);
                $('.nbr_car_garage').text(data.nbrevei)
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

                $('#lien_nbr_panne_garage').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});


                $('#lien_pannekm').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});
                $('#lien_totalaccidentkilometrage').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});

                $('#lien_totalaccident').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});

                $('#lien_nbrecar_garage').attr({"data-site":site,"data-debu": datedebu, "data-fin": datefin});

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


        $('#lien_totalaccidentkilometrage').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'totalaccidentkilometrage',
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



        $('#lien_totalfournisseur').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'fournisseur',
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
        /**************/

        $('#lien_nbr_panne_garage').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'nbr_panne_garage',
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
        /******************************/

        $('#lien_pannekm').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'pannekm',
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
        /***************/



        $('#lien_nbrecar_garage').on('click',function () {
            var site = $(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'vehic_garage',
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
                url: 'approbationattente',
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



        //======================================================================
        $('#totaluser').on('click',function(){
           var  site = $(this).attr('data-site');
            $.ajax({
                url: 'totaluser',
                type: 'GET',
                dataType: 'html',
                data:{site:site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);
                },
            })
        });
        /*************expiration assurance*****************/
        $('#lien_expirassurane').on('click',function () {
            var site=$(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');
            $.ajax({
                url: 'expirassurane',
                type: 'GET',
                dataType: 'html',
                data: {site: site},
                success: function (data) {
                    $(".dashboard").html(data);
                    $('#dashboard').modal("show");
                    console.log(data);

                },

            });

        });
        /***********expiration visite technique********/
        $('#lien_expivisit').on('click',function(){
            var site=$(this).attr('data-site');
            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'expirationvisi',
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
            var site=$(this).attr('data-site');
            $.ajax({
                url: 'userconnected',
                type: 'GET',
                dataType: 'html',
                data:{site:site},
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



        /******lien nombre d'accident******/

        $('#lien_totalaccident').on('click', function () {

            var site = $(this).attr('data-site');

            var datedebu = $(this).attr('data-debu');
            var datefin = $(this).attr('data-fin');

            $.ajax({
                url: 'totalaccident',
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

@section('title') Informations des Fournisseurs @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-list"></i> INFORMATIONS FOURNISSEURS</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon pull-left"><i class="i i-users2"></i></a>
    </header>
    <section class="hbox stretch">
        <aside class="aside b-r b-light bg-light">
            <section class="vbox">
                <header class="header clearfix dk b-b b-light">
                    <a href="{{url('supplier/supplier/create')}}" class="btn btn-sm btn-link btn-icon pull-right"
                       title="Ajouter d'un nouveau fournisseur">
                        <i class="i i-plus i-2x"></i>
                    </a>
                    <p class="h4 font-thin pull-left m-r-sm m-b-sm">Fournisseurs</p></header>
                <section class="scrollable hover">
                    <div class="list-group bg-light auto no-radius no-border no-bg m-t-n-xxs m-b-none">
                        <a href="#" id="2" class="list-group-item suppliers">Tous les fournisseurs </a>
                        <a href="#" id="0" class="list-group-item suppliers">Entreprise </a>
                        <a href="#" id="1" class="list-group-item suppliers">Particulier</a>
                    </div>
                </section>
            </section>
        </aside>
        <aside class="aside-md b-r b-light bg-light lt">
            <section class="vbox">
                <header class="header clearfix bg b-b b-light">
                    <form method="post">
                        <div class="input-group m-t-sm">
                            <input type="text" id="search" class="input-sm form-control" placeholder="Recherche">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="button">Go!</button> </span>
                        </div>
                    </form>
                </header>
                <section class="scrollable hover">
                    <div class="list-group auto no-radius no-border no-bg m-t-n-xxs m-b-none">
                        <div class="cssload-container m-t-n-lg none">
                            <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                                <div class="cssload-progress-item "></div>
                            </div>
                        </div>
                        <table class="table table-stripped" id="supplierList">
                            @forelse($suppliers as $key => $supplier)
                                <tr>
                                    <td class="list-group-item">
                                        <a href="#" id="{{$supplier->id}}"
                                           class="supplier-select capitalize"> {{$supplier->name}} </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td><a href="#" class="list-group-item"> Aucun fournisseur disponible</a></td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </section>
            </section>
        </aside>
        <section>
            <header class="header bg-light lter clearfix b-b b-light">
                <div class="progress-container m-t-lg none" style="margin-left: 325px">
                    <div class="progress m-t-sm">
                        <div class="progress-bar">
                            <div class="progress-shadow"></div>
                        </div>
                    </div>
                </div>
            </header>
            <section class="vbox bg-white">
                <section class="scrollable wrapper-lg">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center"><img src="{{asset('assets/images/a6.png')}}" alt="..."
                                                          class="img-circle m-b">
                                <div class="name" style="text-transform: capitalize">xxxx xxxxxxxx</div>
                                <p class="email">xxxx@xxxx.xx</p></div>
                        </div>
                        <div class="col-md-6"><h3 class="font-bold m-b-none m-t-none name capitalize"> Xxxxx xxxxx</h3>
                            <p class="email">xxxx@xxxx.xx</p>
                            <p><i class="fa fa-lg fa-circle-o text-primary m-r-sm"> <span id="type"> xxxxxxx</span></i>
                                <strong><span id="type" class="capitalize"></span></strong></p>
                            <ul class="nav nav-pills nav-stacked">
                                <li class="bg-light"><a href="#"><i
                                                class="i i-phone m-r-sm"></i><span> Appelez</span></a>
                                </li>
                                <li class="bg-light"><a href="#" id="emailto"><i class="i i-mail m-r-sm text-success-dker"></i>
                                        <span class="text-success-dker">Envvoyer un Email</span>
                                    </a>
                                </li>
                                <li class="bg-light"><a href="#"><i class="i i-chat m-r-sm"></i>
                                        <span>Envoyer un message</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="line b-b m-t m-b"></div>
                    <div class="wrapper m-b">
                        <div class="row m-b">
                            <div class="col-sm-3">
                                <small><i class="i i-phone"></i> Téléphone</small>
                                <div class="text-lt font-bold" id="phone">xxx xxxxxxxx</div>
                            </div>
                            <div class="col-sm-3">
                                <small><i class="i i-phone3"></i> Mobile</small>
                                <div class="text-lt font-bold" id="mobile">xxx xxxxxxxx</div>
                            </div>
                            <div class="col-sm-6">
                                <small><i class="i i-pin"></i> Adresse</small>
                                <div class="text-lt" id="address" style="word-wrap: break-word">
                                    <p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                                </div>
                            </div>
                        </div>
                        <div id="divRccm">
                            <small>R.C.C.M</small>
                            <div class="text-lt m-b" id="rccm">
                                <p>
                                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                </p>
                            </div>
                        </div>

                    </div>
                </section>
            </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
       data-target="#nav,html"></a>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/scripts/supplier.js')}}"></script>
@endsection
@section('title') Gestion des bons de livraison @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-md bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header text-dark-dker text-center"><strong>GESTION DES BONS DE LIVRAISON</strong>
            </div>
            <section class="panel panel-default">
                <div class="panel-body">
                    <form id="deliveryForm" method="post" action="stock" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="delivery" type="hidden" value="1">
                        <div class="form-group has-success">
                            <label>Référence du Bon de Livraison</label>
                            <input type="text" class="form-control input-sm text-danger-dk" name="number" id="number"
                                   minlength="2" placeholder="Numéro du bon de livraison" required>
                        </div>
                        <div class="form-group has-warning">
                            <label>Référence de la Commande</label>
                            <input type="text" class="form-control input-sm text-danger-dk" name="order" id="number"
                                   minlength="2" placeholder="Numéro de la Commande" required>
                        </div>
                        <div class="form-group">
                            <label>Montant</label>
                            <input type="text" class="form-control input-sm text-danger-dk" id="amount" name="amount"
                                   placeholder="Montant du bon de livraison">
                        </div>
                        <div class="form-group">
                            <label>Date de Livraison</label>
                            <input type="text" class="form-control datepicker input-sm" id="date" name="date"
                                   placeholder="{{\Jenssegers\Date\Date::now()->format('j F Y')}}">
                        </div>
                        <div class="form-group">
                            <label>Fournisseur</label>
                            <select class="chosen-select form-control input-sm" id="supplier" name="supplier"
                                    data-placeholder="CHOISISSEZ LE FOURNISSEUR...">
                                <option></option>
                                @forelse($suppliers as $key=>$supplier)
                                    <option value="{{$supplier->id}}" class="uppercase">{{$supplier->name}}</option>
                                @empty
                                    <option disabled>AUCUN FOURNISSEUR DISPONIBLE</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group m-t-md text-center">
                            <input type="file" class="filestyle" id="image" name="image"
                                   data-classButton="btn btn-default btn-sm"
                                   data-classInput="form-control inline v-middle input-sm"
                                   data-buttonText="Charge le Bon de Livraison..">
                        </div>
                        <button type="submit" class="btn btn-sm btn-default btn-group-justified uppercase m-t-md"
                                id="submit"><i class="fa fa-floppy-o"></i> enregistrer le bon
                        </button>
                    </form>
                </div>
            </section>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-6 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide" class="btn btn-sm btn-default active pull-left">
                                <i class="fa fa-caret-right text fa-lg"></i>
                                <i class="fa fa-caret-left text-active fa-lg"></i>
                            </a>
                            <form id="periodForm" method="get" novalidate>
                                {{csrf_field()}}
                                <div class="form-group col-sm-4 m-r-n-md has-warning">
                                    <input class="input-sm datepicker form-control" placeholder="Date debut"
                                           name="begin"
                                           id="begin">
                                </div>
                                <div class="form-group col-sm-4 m-r-n-sm has-warning">
                                    <input class="input-sm col-sm-3 form-control datepicker" placeholder="Date fin"
                                           name="end"
                                           id="end">
                                </div>
                                <div class="form-group col-sm-1  m-l-n-sm">
                                    <button type="submit" class="btn btn-sm col-sm-3 btn-icon btn-success"><i
                                                class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3 m-b-xs">
                            <div class="input-group">
                                <input type="text" id="search" class="input-sm form-control" placeholder="Recherche">
                                <span class="input-group-btn">
                          <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span>
                            </div>
                        </div>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#deliveryTable').tableExport({type:'xlsx',escape:'false'});">
                                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default"
                               onClick="$('#deliveryTable').tableExport({type:'pdf',escape:'false'});">
                                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                               onClick="$('#deliveryTable').tableExport({type:'csv',escape:'false'});">
                                <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                            </a>
                        </div>
                    </div>
                </header>

                <section class="scrollable wrapper w-f">
                    <div class="cssload-container m-t-n-lg none">
                        <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                            <div class="cssload-progress-item"></div>
                        </div>
                    </div>
                    <section class="panel panel-default" id="view">
                        <div class="table-responsive">
                            <table class="table table-striped e b-info capitalize" id="deliveryTable">
                                <thead>
                                <tr>
                                    <th width="20"></th>
                                    <th>Référence Bon</th>
                                    <th>Référence Com</th>
                                    <th>Montant</th>
                                    <th>Fournisseur</th>
                                    <!--<th title="Date d'établissement">Date <i class="i i-dots"></i></th>-->
                                    <th title="Date d'enregistrement"><i class="i i-calendar"></i> Date</th>
                                </tr>
                                </thead>
                                <tbody id="deliveryRow">
                                @forelse($deliveries as $key=>$delivery)
                                    <tr id="delivery{{$delivery->ids}}" class="animated fadeInDown">
                                        <td>
                                            <a href="#" id="{{$delivery->ids}}" data-number="{{$delivery->number}}"
                                               class="preview" data-toggle="modal">
                                                <i class="fa fa-search-plus text-muted"></i>
                                            </a>
                                        </td>
                                        <td class="uppercase text-danger-dk">{{$delivery->number}}</td>
                                        <td class="uppercase text-danger-dk">{{$delivery->order}}</td>
                                        <td class="text-success-dker">{{number_format($delivery->amount)}} frs</td>
                                        <td>{{$delivery->supplier->name}}</td>
                                        <td>{{\Jenssegers\Date\Date::parse($delivery->delivered_at)->format('d/m/Y')}}</td>
                                    <!--<td>{{$delivery->created_at->format('d/m/Y')}}</td>-->
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune données disponible</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
                <footer class="footer bg-white b-t">
                    <div class="row text-center-xs">
                        <div class="col-md-6 hidden-sm">
                            <!--<p class="text-muted m-t"></p>-->
                        </div>
                        <div class="col-md-6 col-sm-12 text-right text-center-xs" id="pagination">
                        </div>
                    </div>
                </footer>
            </section>
        </aside>
    </section>
    <div class="modal fade" id="modal">
        <div class="modal-dialog modal-lg text-center grow pic">
            <p class="text-warning-dker uppercase font-bold">
                <span id="delivery_number"></span>
                <a href="#" class="text-success-lt m-l-lg" onclick="$('#delivery_preview').printThis({ });"
                   title="imprimer"><i class="fa fa-print fa-lg"></i></a>
                <a type="button" class="m-l-sm text-danger-dk" data-dismiss="modal" aria-hidden="true" title="Fermer"><i
                            class="fa fa-times-circle-o fa-lg"></i></a>
            </p>
            <img src="" id="delivery_preview" class="img-responsive img-rounded center-block">
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/file-input/bootstrap-filestyle.min.js')}}"></script>
    <script src="{{asset('assets/js/paging/paging.js')}}"></script>
    <script src="{{asset('assets/js/scripts/stock.delivery.js')}}"></script>
@endsection
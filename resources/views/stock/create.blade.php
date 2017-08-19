@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-lg bg-light dker b-r" id="subNav">
            <form method="post" id="stockForm" role="form" class="panelf b-a bg-light" novalidate>
                {{csrf_field()}}
                <input name="stock_id" type="hidden" id="stock_id">
                <section>
                    <div class="panel-group m-b" id="accordion_stock">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_stock"
                                   href="#reference">
                                    <p class="text-dark-dker capitalize"><strong>1. Référencement du stock</strong></p>
                                </a>
                            </div>
                            <div id="reference" class="panel-collapse collapse in" style="height: auto;">
                                <div class="panel-body panel-danger text-gsm">
                                    <div class="has-success form-group-sm m-b-sm">
                                        <label class="control-label">REFERENCE DU STOCK</label>
                                        <input type="text" name="reference" id="reference" min="3"
                                               class="form-control input-sm text-danger-dk"
                                               placeholder="Reference du stock" required>
                                    </div>
                                    <div class="form-group-sm m-b-sm">
                                        <label>Type de piece</label>
                                        <select class="chosen-select input-sm form-control"
                                                data-placeholder="CHOISISEZ UN TYPE..." id="type" name="type">
                                            <option></option>
                                            @forelse($types as $key => $type)
                                                <option value="{{$type->id}}" class="uppercase">{{$type->name}}</option>
                                            @empty
                                                <option>AUCUN TYPE DISPONIBLE</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="row m-b-lg m-t-md">
                                        <div class="form-group form-group-sm  col-sm-6">
                                            <label class="control-label">Marque de Piece</label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label">Modele de Piece</label>
                                            <a href="#" id="model_spinner" style="position: absolute"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-left none m-t-n-sm">
                                                <i class="fa fa-spin fa-spinner fa-lg"></i>
                                            </a>
                                        </div>
                                        <div class="form-group form-group-sm  col-sm-6"
                                             style="position: absolute; width: 164px; margin-top: 23px">
                                            <select class="chosen-select input-sm form-control"
                                                    data-placeholder="CHOISISEZ UNE MARQUE..." id="brand" name="brand">
                                                <option></option>
                                                @forelse($brands as $key => $brand)
                                                    <option value="{{$brand->id}}"
                                                            class="uppercase">{{$brand->name}}</option>
                                                @empty
                                                    <option>AUCUNE FAMILLE DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6"
                                             style="position: absolute; margin-left: 140px; width: 164px; margin-top: 23px">
                                            <select class="chosen-select input-sm form-control"
                                                    data-placeholder="CHOISISEZ UN MODELE..." id="model" name="model">
                                                <option selected disabled>......................................
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group form-group-sm col-sm-6 m-b-lg">
                                            <label class="control-label">Famille</label>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label">Sous Famille</label>
                                            <a href="#" id="sub_spinner" style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-spin fa-spinner fa-lg"></i>
                                            </a>
                                        </div>
                                        <div class="form-group form-group-sm col-sm-6"
                                             style="position: absolute; width: 164px; margin-top: 23px">
                                            <select class="chosen-select input-sm form-control"
                                                    data-placeholder="CHOISISEZ UNE FAMILLE..."
                                                    id="category" name="category">
                                                <option></option>
                                                @forelse($categories as $key => $category)
                                                    <option value="{{$category->id}}"
                                                            class="uppercase">{{$category->name}}</option>
                                                @empty
                                                    <option disabled>AUCUNE FAMILLE DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 m-t-md"
                                             style="position: absolute; margin-left: 140px; width: 164px; margin-top: 23px">
                                            <select class="chosen-select input-sm form-control parsley-validated"
                                                    data-placeholder="CHOISISEZ UNE SOUS FAMILLE..." id="subcategory"
                                                    name="sub_category">
                                                <option selected disabled>......................................
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_stock"
                                   href="#acquisition">
                                    <p class="text-dark-dker capitalize"><strong>2. Acquisition du stock</strong></p>
                                </a>
                            </div>
                            <div id="acquisition" class="panel-collapse collapse" style="height: auto;">
                                <div class="panel-body panel-danger text-gsm">
                                    <div class="row">
                                        <div class="form-group form-group-sm col-sm-4">
                                            <label class="control-label">Prix Unit.</label>
                                            <input type="text" name="price" id="price"
                                                   class="form-control input-sm input_numeric" placeholder="0">
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="control-label">Quantité</label>
                                            <input type="text" name="quantity" id="quantity"
                                                   class="form-control input-sm input_numeric" placeholder="0">
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label class="control-label">Total</label>
                                            <input type="text" id="total" name="total"
                                                   class="form-control input-sm input_numeric" placeholder="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle collapsed" data-toggle="collapse"
                                   data-parent="#accordion_stock" href="#warehouse">
                                    <p class="text-dark-dker"><strong>3. Entreposage du stock</strong></p>
                                </a>
                            </div>
                            <div id="warehouse" class="panel-collapse collapse" style="height: auto;">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="form-group form-group-sm col-sm-12 m-b-lg">
                                            <label>Rayon de rangement</label>
                                        </div>
                                        <div class="form-group form-group-sm col-sm-12"
                                             style="position: absolute; width: 300px; margin-top: 23px">
                                            <select class="chosen-select input-sm form-control" id="ray"
                                                    data-placeholder="CHOISISEZ UN RAYON DE RANGEMENT...">
                                                <option></option>
                                                @forelse($rays as $key => $ray)
                                                    <option value="{{$ray->id}}"
                                                            class="uppercase">{{$ray->name}}</option>
                                                @empty
                                                    <option>AUCUN RAYON DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 m-b-lg m-t-sm">
                                            <label>Etagere</label>
                                            <a href="#" id="shelf_spinner" style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-spin fa-spinner fa-lg"></i>
                                            </a>
                                        </div>
                                        <div class="form-group col-sm-6"
                                             style="position: absolute; width: 164px; margin-top: 85px">
                                            <select class="chosen-select input-sm form-control" id="shelf"
                                                    data-placeholder="CHOISISEZ UNE ETAGERE...">
                                                <option value selected disabled>......................................
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 m-t-sm">
                                            <label>Casier</label>
                                            <a href="#" id="bloc_spinner" style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-spin fa-spinner fa-lg"></i>
                                            </a>
                                        </div>
                                        <div class="form-group col-sm-6"
                                             style="position: absolute; margin-left: 140px; width: 164px; margin-top: 85px">
                                            <select class="chosen-select input-sm form-control" id="block" name="block"
                                                    data-placeholder="CHOISISEZ UN CASIER...">
                                                <option selected disabled>......................................
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="accordion-toggle collapsed" data-toggle="collapse"
                                   data-parent="#accordion_stock" href="#livraison">
                                    <p class="text-dark-dker"><strong>4. Bon de livraison</strong></p>
                                </a>
                            </div>
                            <div id="livraison" class="panel-collapse collapse" style="height: auto;">
                                <div class="panel-body text-center">
                                    <div class="form-group form-group-sm col-sm-12 m-b-lg text-center">
                                        <label class="text-center">Référence du bon de livraison</label>
                                    </div>
                                    <div class="form-group-sm form-group-sm col-sm-12"
                                         style="position: absolute; width: 265px; margin-top: 23px">
                                        <select class="chosen-select input-sm form-control" id="delivery" name="stock_delivery"
                                                data-placeholder="CHOISISEZ UNE REFERENCE DE BON...">
                                            <option></option>
                                            @forelse($deliveries as $key => $delivery)
                                                <option value="{{$delivery->ids}}"
                                                        class="uppercase">{{$delivery->number}}</option>
                                            @empty
                                                <option disabled>AUCUNE REFERENCE DISPONIBLE</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group form-group-sm col-sm-12 m-t-sm">
                                        <label>Fournisseur</label>
                                        <input class="form-control input-sm text-center uppercase text-danger-dk" readonly id="supplier">
                                    </div>
                                    <div class="form-group form-group-sm col-sm-12 ">
                                        <label>Référence Commande</label>
                                        <input class="form-control input-sm text-center uppercase text-danger-dk" readonly id="order">
                                    </div>
                                    <div style="margin-top: 90px">
                                        <button type="submit" value="save" id="submit"
                                                class="btn btn-sms btn-success btn-group-justified uppercase">
                                            <i class="fa fa-floppy-o"></i> enregistrer le stock
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-6 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide" class="btn btn-sm btn-default active pull-left m-r-md">
                                <i class="fa fa-caret-right text fa-lg"></i>
                                <i class="fa fa-caret-left text-active fa-lg"></i>
                            </a>
                            <h4><i class="i i-stack"></i> GESTION DE STOCK</h4>
                        </div>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#stockTable').tableExport({type:'xlsx',escape:'false'});">
                                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default"
                               onClick="$('#stockTable').tableExport({type:'pdf',escape:'false'});">
                                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                               onClick="$('#stockTable').tableExport({type:'csv',escape:'false'});">
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
                            <table class="table datatable table-responsive table-striped m-b-none capitalize" id="stockTable">
                                <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Type</th>
                                    <th>Famille</th>
                                    <th>Sous Famille</th>
                                    <th>Qté</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                    <th><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody id="stockRow">
                                @foreach($stocks as $key => $stock)
                                    <tr id="stock{{$stock->id}}">
                                        <td style="text-transform: uppercase">{{$stock->reference}}</td>
                                        <td>{{$stock->type->name}}</td>
                                        <td>{{$stock->sub_category->category->name}}</td>
                                        <td>{{$stock->sub_category->name}}</td>
                                        <td>{{number_format($stock->quantity)}}</td>
                                        <td>{{$stock->created_at->format('d/m/Y')}}</td>
                                        <td>
                                            <a href="#" id="{{$stock->id}}" onclick="stockEdit(this)"><i
                                                        class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
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
@endsection
@section('scripts')
    <script src="{{asset('assets/js/scripts/stock.create.js')}}"></script>
@endsection
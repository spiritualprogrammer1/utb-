@section('title') Gestion de Fournisseurs @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-users2"></i> GESTION DES FOURNISSEURS</p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-users2"></i></a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   title="Exporter la liste fournisseur en format EXCEL"
                   onClick="$('#supplierTable').tableExport({type:'xlsx',escape:'false'});">
                    <img src='{{asset('assets/images/icons/xls.png')}}' width="20"/> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default" title="Exporter la liste fournisseur en format PDF"
                   onClick="$('#supplierTable').tableExport({type:'pdf',escape:'false'});">
                    <img src='{{asset('assets/images/icons/pdf.png')}}' width="20"/> Pdf
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   title="Exporter la liste fournisseur en format CSV"
                   onClick="$('#supplierTable').tableExport({type:'csv',escape:'false'});">
                    <img src='{{asset('assets/images/icons/csv.png')}}' width="20"/> CSV
                </a>
            </div>
        </header>
        <section class="scrollable">
            <section class="hbox">
                <!-- .aside -->
                <aside class="aside-lg bg-light dker wrapper">
                    <form id="supplierForm" method="post" role="form" class="panel b-a bg-light">
                        {{csrf_field()}}
                        <input name="supplier_id" type="hidden" id="supplier_id">
                        <header class="panel-heading font-bold m-t-n-sm">
                            <div class="col-sm-6">
                                <div class="radio i-checks">
                                    <label>
                                        <input class="input-sm supplier" type="radio" name="type"
                                               value="0" checked required>
                                        <i></i>Entreprise
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="radio i-checks">
                                    <label>
                                        <input class="input-sm supplier" type="radio" name="type"
                                               value="1" required>
                                        <i></i>Particulier
                                    </label>
                                </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <div class="form-group">
                                <label id="lblName" for="lblName"><i class="i i-cube"></i> Raison social</label>
                                <input name="name" id="name" class="form-control input-sm input_alpha input"
                                       placeholder="Entrer la raison social" minlength="3" required>
                            </div>
                            <div class="form-group">
                                <div id="divRccm">
                                    <label for="rccm">R.C.C.M</label>
                                    <input name="rccm" id="rccm"
                                           class="form-control input-sm input_alpha input"
                                           placeholder="Entrer le R.C.C.M">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country">Pays</label>
                                <select class="form-control item-select input-sm" data-placeholder="Choose a country..."
                                        name="country" id="country">
                                    <option selected disabled value>Choisissez un pays</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}"
                                                @if($country->id == 53) selected @endif>{{$country->nicename}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class=" col-sm-4">
                                                <label for="phone">Indicatif</label>
                                                <input class="form-control phonecode input-sm input" value="+225"
                                                       name="indicatif" readonly>
                                            </div>
                                            <div class="col-sm-8">
                                                <label for="phone"><i class="i i-phone"></i> Téléphone</label>
                                                <input name="phone" id="phone"
                                                       class="form-control  input-sm input_numeric input"
                                                       placeholder="Numero de telephone">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class=" col-sm-4">
                                                <label for="mobile">Indicatif</label>
                                                <input class="form-control phonecode input-sm input" value="+225"
                                                       readonly>
                                            </div>
                                            <div class="col-sm-8">
                                                <label for="mobile"><i class="i i-phone3"></i> Mobile</label>
                                                <input name="mobile" id="mobile"
                                                       class="form-control input-sm input_numeric input"
                                                       placeholder="Numero du mobile" minlength="8" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Adresse e-mail</label>
                                <input name="email" type="email" id="email" class="form-control input-sm input"
                                       placeholder="Entrer l'adresse de messagerie" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Adresse</label>
                                <textarea rows="3" name="address" id="address"
                                          class="form-control input-sm input_alpha input"
                                          placeholder="Adresse geographique du fournisseur"></textarea>
                            </div>
                            <div class="m-t-sm">
                                <div class="col-sm-11 row">
                                    <button type="submit" value="save" id="submit"
                                            class="btn btn-sm btn-success btn-block uppercase">
                                        <i class="fa fa-floppy-o"></i> enregistrer
                                    </button>
                                </div>
                                <a href="#" id="btn_reset" class="btn btn-sm btn-icon btn-default pull-right disabled"
                                   onclick="cleaner()">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </aside>
                <!-- /.aside -->
                <!-- .aside -->
                <aside class="wrapper bg-light dker">
                    <section class="panel no-border scrollable">
                        <div class="table-responsive">
                            <table class="table datatable table-responsive table-striped m-b-none" id="supplierTable">
                                <thead>
                                <tr>
                                    <th><i class="i i-user2"></i> Nom</th>
                                    <th><i class="i i-mail"></i> email</th>
                                    <th><i class="i i-pin"></i> Pays</th>
                                    <th><i class="i i-phone3"></i> Mobile</th>
                                    <th><i class="i i-phone"></i> Téléphone</th>
                                    <th width="5" class="text-center"><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody class="capitalize" id="supplierRow">
                                @foreach($suppliers as $key => $supplier)
                                    <tr id="supplier{{$supplier->id}}">
                                        <td>{{$supplier->name}}</td>
                                        <td style="text-transform: lowercase">{{$supplier->email}}</td>
                                        <td>{{$supplier->country->nicename}}</td>
                                        <td>+{{$supplier->country->phonecode}} {{$supplier->mobile}}</td>
                                        <td>+{{$supplier->country->phonecode}} {{$supplier->phone}}</td>
                                        <td class="text-center">
                                            <button type="button" id="{{$supplier->id}}"
                                                    class="btn btn-sm btn-default btn-rounded supplier-edit">
                                                <i class="fa fa-pencil text-danger-dker"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </aside>
                <!-- /.aside -->
            </section>
        </section>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/scripts/supplier.js')}}"></script>
@endsection
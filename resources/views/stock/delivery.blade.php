@section('title') Gestion des bons de livraison @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-md bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header text-dark-dker text-center"><strong>GESTION DES BONS DE LIVRAISON</strong>
            </div>
            <section class="panel panel-default">
                <div class="panel-body" style="position: relative;height: 450px;overflow: scroll">
                    <form id="deliveryForm" method="post"  role="form" enctype="multipart/form-data">
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
                            <select class="chosen-select custom-select form-control input-sm" id="supplier" name="supplier"
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
                                   data-classButton="btn btn-info btn-sm"
                                   data-classInput="form-control inline v-middle input-sm"
                                   data-buttonText="Charge le Bon de Livraison..">
                        </div>
                        <button type="submit" class="btn btn-sm btn-success btn-group-justified uppercase m-t-md"
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
                            <form id="searchForm" method="get" novalidate>
                                {{csrf_field()}}
                                <input type="hidden" name="delivery" value="1">
                                <div class="form-group col-sm-4 m-r-n-md has-warning">
                                    <input class="input-sm datepicker form-control" placeholder="Date debut"
                                           name="begin">
                                </div>
                                <div class="form-group col-sm-4 m-r-n-sm has-warning">
                                    <input class="input-sm col-sm-3 form-control datepicker" placeholder="Date fin"
                                           name="end">
                                </div>
                                <div class="form-group col-sm-1  m-l-n-sm">
                                    <button type="submit" id="submit_search" class="btn btn-sm col-sm-3 btn-icon btn-success"><i
                                                class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
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
                    <section class="panel panel-default">
                        <div class="table-responsive" id="view">
                            <table class="table table-striped e b-info capitalize" id="deliveryTable">
                                <thead>
                                <tr>
                                    {{--<th width="20"></th>--}}
                                    <th>#</th>
                                    <th>Référence Bon</th>
                                    <th>Référence Com</th>
                                    <th>Montant</th>
                                    <th>Fournisseur</th>
                                    <!--<th title="Date d'établissement">Date <i class="i i-dots"></i></th>-->
                                    <th title="Date d'enregistrement"><i class="i i-calendar"></i> Date</th>
                                </tr>
                                </thead>
                                <tbody id="deliveryRow">
                                @foreach($deliveries as $key=>$delivery)
                                    <tr id="delivery{{$delivery->ids}}" class="animated fadeInDown">
                                        {{--<td>--}}
                                            {{--<a href="#" id="{{$delivery->ids}}" data-number="{{$delivery->number}}"--}}
                                               {{--class="preview" data-toggle="modal">--}}
                                                {{--<i class="fa fa-search-plus text-muted"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                        <td>
                                            {{$key+1}}
                                        </td>
                                        <td class="uppercase text-danger-dk">{{$delivery->number}}</td>
                                        <td class="uppercase text-danger-dk">{{$delivery->order}}</td>
                                        <td class="text-success-dker">{{number_format($delivery->amount)}} frs</td>
                                        <td>{{$delivery->supplier->name}}</td>
                                        <td>{{\Jenssegers\Date\Date::parse($delivery->delivered_at)->format('d/m/Y')}}</td>
                                    <!--<td>{{$delivery->created_at->format('d/m/Y')}}</td>-->
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
                <div class="cssload-container m-t-n-lg none">
                    <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                        <div class="cssload-progress-item"></div>
                    </div>
                </div>
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
    {{--<script src="{{asset('assets/js/scripts/stock.delivery.js')}}"></script>--}}
    <script>
        var $form = $('#deliveryForm'),
                $supplier = $('#supplier'),
                $amount = $('#amount'),
                $number = $('#number'),
                $delivery_row = $('#deliveryRow'),
                $preview = $('.preview'),
                $spinner = $('.cssload-container'),
                $delivery_preview = $('#delivery_preview'),
                $modal = $('#modal'),
                $delivery_number = $('#delivery_number'),
                $submit = $('#submit'),
                $table = $('#deliveryTable'),
                $form_search = $('#searchForm'),
                $submit_search = $('#submit_search'),
                $view = $('#view');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });


            $(".custom-select").chosen({
                disable_search_threshold: 10,
                no_results_text: "Oops, rien n'a été trouvé!",
                width: "95%"
            });



            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]),
                        type = 'post',
                        url = '{{route('home.store')}}',
                        msg = "le Bon de Livraison a bien été enregistré",
                        status = "success";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $number.focus();
                        toastr[status](msg, "<span style='text-transform: uppercase'>" + data.number + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="delivery' + data.ids + '" class="alert alert-info text-danger-dk">' +
                                '<td><a href="#" id="' + data.ids + '" data-number="' + data.number + '" onclick="preview(this)" data-toggle="modal"><i class="fa fa-search-plus text-muted"></i></a></td>' +
                                '<td class="uppercase">' + data.number + '</td>' +
                                '<td class="uppercase">' + data.order + '</td>' +
                                '<td>' + data.amount + '</td>' +
                                '<td>' + data.supplier + '</td>' +
                                '<td>' + data.delivered + '</td>' +
                                '<tr>';
                        $delivery_row.before(row);
                        $form.trigger('reset');
                        $supplier.val('');
                        $supplier.trigger("chosen:updated");
                        $submit.button('reset');
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
                    error: function (jqXhr) {
                        if (jqXhr.status === 401)
                            window.location.href = "/";
                        if (jqXhr.status === 422) {
                            var errors = jqXhr.responseJSON.message;
                            var errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml += value[0] + '</br>';
                            });
                            swal(
                                    'Oops...',
                                    errorsHtml,
                                    'error'
                            );
                            $submit.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $submit.button('reset');
                        }
                    }
                });
            });
            $preview.on('click', function () {
                preview(this)
            });
            $form_search.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $submit_search.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>'});
                $submit_search.button('loading');
                $.get('search?' + formData, function (data) {
                    $view.html(data);
                    $submit_search.button('reset');
                });
            })
        });
        function preview(obj) {
            $spinner.show();
            var id = $(obj).attr('id'),
                    number = $(obj).attr('data-number');


            $.get('preview/' + id, function (data) {
                $delivery_number.html(number);
                $delivery_preview.attr('src', data);
                $spinner.hide();
                $modal.modal('show')
            });
        }


    </script>
@endsection
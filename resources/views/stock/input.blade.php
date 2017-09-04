@section('title') Entrées/Sorties  Stock @endsection
@section('styles')
    <style>
        @media print {
            .row {
                display: none;
            }
        }
    </style>
@endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-lg bg-light dker b-r" id="subNav">
            <section>
                <form method="post" id="inputForm" action="stock" role="form" class="panel b-a bg-light lter">
                    {{csrf_field()}}
                    <h5 class="uppercase m-l-sm">Entrée du stock
                        <button type="submit" id="submit_input"
                                class="btn btn-success btn-sm btn-rounded pull-right m-r-sm m-t-n-xs"
                                title="Ajouter un stock">
                            <i class="fa fa-check-circle"></i> VALIDER
                        </button>
                        <a id="add_input" class="btn btn-icon btn-info btn-sm btn-rounded pull-right m-r-md m-t-n-xs"
                           title="Ajouter un stock">
                            <i class="fa fa-plus"></i>
                        </a>
                        <input type="hidden" name="input" value="1">
                    </h5>
                    <div class="panel-body panel-default">
                        <div class="row">
                            <div class="form-group-sm has-success m-b-sm col-md-7">
                                <select class="input-sm form-control" id="reference_input" data-type="delivery"
                                        name="deliveries" onchange="infoReference(this)" data-id="0"
                                        data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>
                                    <option selected disabled>Bon livraison</option>
                                    @forelse($deliveries as $key => $delivery)
                                        <option value="{{$delivery->id}}"
                                                class="uppercase">{{$delivery->number}}</option>
                                    @empty
                                        <option disabled>AUCUNE REFERENCE DISPONIBLE</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-5 m-l-n-md">
                                <p class="form-control-static m-t-xs capitalize" style="word-wrap: break-word" id="supplier">...</p>
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-striped" id="input_table">
                                <thead>
                                <tr>
                                    <th>Référence du stock</th>
                                    <th width="30">Quantité</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select class="input-sm form-control" id="reference_input" data-type="input"
                                                name="reference[]" onchange="infoReference(this)" data-id="0"
                                                data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>
                                            <option selected disabled>Choisissez une reférence</option>
                                            @forelse($stocks as $key => $stock)
                                                <option value="{{$stock->id}}"
                                                        class="uppercase">{{$stock->reference}}</option>
                                            @empty
                                                <option disabled>AUCUNE REFERENCE DISPONIBLE</option>
                                            @endforelse
                                        </select>
                                        <p class="form-control-static text-center">
                                            <span id="info_input_family0">...</span>
                                        </p>
                                    </td>
                                    <td>
                                        <input class="form-control input-sm" name="quantity[]" id="quantity_input"
                                               type="number" placeholder="0" data-id="0" onkeyup="calcul($(this))"
                                               required>
                                        <input id="quantity_count0" type="hidden" value="0">
                                        <p class="form-control-static text-center">
                                            <span id="info_input_qty0" class="qty">...</span>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </section>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-4 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide"
                               class="btn btn-sm btn-default active pull-left m-r-md">
                                <i class="fa fa-caret-right text fa-lg"></i>
                                <i class="fa fa-caret-left text-active fa-lg"></i>
                            </a>
                            <h4><i class="fa fa-sign-in"></i> ENTREE DE STOCK</h4>
                        </div>

                        <form id="searchForm" class="col-md-4 m-t-xs has-success">
                            {{csrf_field()}}
                            <input name="input" type="hidden" value="1">
                            <div class="col-md-6">
                                <input type="text" class="input-sm form-control datepicker" name="begin"
                                       placeholder="Date de Debut">
                            </div>
                            <div class="col-md-6 input-group">
                                <input type="text" class="input-sm form-control datepicker" name="end"
                                       placeholder="Date de Fin">
                                <span class="input-group-btn">
                        <button class="btn btn-sm btn-success" id="submit_search" type="submit"><i
                                    class="fa fa-search"></i></button>
                      </span>
                            </div>
                        </form>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#inputTable').tableExport({type:'xlsx',escape:'false'});">
                                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default"
                               onClick="$('#inputTable').tableExport({type:'pdf',escape:'false'});">
                                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> PDF
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                               onClick="$('#inputTable').tableExport({type:'csv',escape:'false'});">
                                <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                            </a>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper">
                    <section class="panel panel-default">
                        <div class="table-responsive" id="result">
                            <table class="table datatable table-striped b-t b-light" id="inputTable">
                                <thead>
                                <tr>
                                    <th width="10"></th>
                                    <th>Reference</th>
                                    <th>Bon livraison</th>
                                    <th>Qté Entrée</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                </tr>
                                </thead>
                                <tbody class="capitalize" id="inputRow">
                                @foreach($movements as $key => $movement)
                                    <tr id="input{{$movement->id}}">
                                        <td>
                                            <a href="#" id="{{$movement->id}}" class="info">
                                                <i class="fa fa-search-plus text-muted"></i>
                                            </a>
                                        </td>
                                        <td class="uppercase">{{$movement->reference}}</td>
                                        <td class="uppercase">{{$movement->delivery->number}}</td>
                                        <td>{{$movement->item_stock->sum('quantity')}}</td>
                                        <td>{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
                <div class="cssload-container m-t-n-lg none" id="spinner">
                    <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                        <div class="cssload-progress-item"></div>
                    </div>
                </div>
            </section>
        </aside>
    </section>

    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content" id="view">

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        @endsection

        @section('scripts')
            <script>
                var $add_input = $('#add_input'),
                    $form_input = $('#inputForm'),
                    $table = $('#inputTable'),
                    $row = $('#inputRow'),
                    $info = $('.info'),
                    $modal = $('#modal'),
                    $content = $('#view'),
                    $spinner = $('#spinner'),
                    $form_search = $('#searchForm'),
                    $result = $('#result'),
                    $supplier = $('#supplier'),
                    $submit_search = $('#submit_search'),
                    $submit_input = $('#submit_input');

                $(function () {
                    $table.dataTable({
                        "sPaginationType": "full_numbers",
                        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        "iDisplayLength": 50,
                        "language": {
                            "url": "../assets/js/datatables/French.json"
                        }
                    });
                    $add_input.on('click', function () {
                        var $table = $('#input_table tbody');
                        $table.append($('#input_table tbody tr:last').clone());
                        var rows = $('#input_table tr');

                        var count = rows.length,
                            lastRow = rows[count - 1],
                            text_input = $(lastRow).find('input'),
                            text_select = $(lastRow).find('select'),
                            text_span = $(lastRow).find('span');

                        text_select.eq(0).attr('id', 'reference_input' + count);
                        text_select.eq(0).attr('data-id', count);
                        text_span.eq(0).attr('id', 'info_input_family' + count);
                        text_span.eq(1).attr('id', 'info_input_qty' + count);
                        text_input.eq(0).attr('id', 'quantity' + count);
                        text_input.eq(0).attr('data-id', count);
                        text_input.eq(1).attr('id', 'quantity_count' + count);
                        $('#quantity' + count).val('');
                        $('#quantity_count' + count).val('0');
                        $('#info_input_qty' + count).html('...');
                        $('#info_input_family' + count).html('...');
                    });
                    $form_input.on('submit', function (e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        var type = 'post';
                        var url = 'stock';
                        status = "success";
                        var msg = "L'Entrer bien été valider";
                        $submit_input.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                        $submit_input.button('loading');
                        $.ajax({
                            url: url,
                            type: type,
                            data: formData,
                            success: function (data) {
                                $form_input.trigger('reset');
                                toastr[status](msg, "<span class='uppercase'>Entrer de Stock</span>!");
                                toastr.options.preventDuplicates = true;
                                var row = '<tr id="input' + data.id + '" class="alert alert-info text-danger-dk">' +
                                    '<td><a href="#" id="' + data.id + '" onclick="information($(this))"><i  class="fa fa-search-plus text-muted"></i></a></td>' +
                                    '<td class="uppercase">' + data.reference + '</td>' +
                                    '<td class="uppercase">' + data.delivery + '</td>' +
                                    '<td>' + data.quantity + '</td>' +
                                    '<td>' + data.date + '</td><tr>';
                                $row.before(row);
                                $submit_input.button('reset');
                            },
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
                                    $submit_input.button('reset');
                                } else {
                                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                                    $submit_input.button('reset');
                                }
                            }
                        });
                    });
                    $info.on('click', function () {
                        information(this)
                    });
                    $form_search.on('submit', function (e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        $submit_search.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>'});
                        $submit_search.button('loading');
                        $.get('search?' + formData, function (data) {
                            $result.html(data);
                            $submit_search.button('reset');
                        });
                    })
                });
                function infoReference(obj) {
                    var ids = $(obj).val(),
                        type = $(obj).attr('data-type'),
                        id = $(obj).attr('data-id'),
                        info_input_family = $('#info_input_family' + id),
                        qty_count = $('#quantity_count' + id),
                        info_input_qty = $('#info_input_qty' + id);
                    $.get('references/' + ids + '/' + type, function (data) {
                        if (type ==="delivery"){
                            $supplier.html(data.supplier);
                        }else {
                            info_input_family.html(data.family + " - " + data.subfamily);
                            info_input_qty.html(data.qty);
                            qty_count.val(data.qty);
                        }

                    })
                }
                function information(obj) {
                    $spinner.show();
                    var id = $(obj).attr('id'),
                        type = "input";
                    $.get('movement/' + id + '/' + type, function (data) {
                        $content.html(data);
                        $modal.modal('show');
                        $spinner.hide();
                    })
                }
                function calcul(obj) {
                    var id = $(obj).attr('data-id'),
                        val = $(obj).val(),
                        qty = $('#quantity_count' + id).val(),
                        quantity = $('#info_input_qty' + id);
                    result = parseInt(qty) + parseInt(val);
                    quantity.html(result);
                    if (result < 0) {
                        $submit_input.addClass('disabled');
                        quantity.addClass('text-danger')
                    } else {
                        $submit_input.removeClass('disabled');
                        quantity.removeClass('text-danger')
                    }
                }
            </script>
@endsection
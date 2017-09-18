@section('title') Sorties de pieces @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lter b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-stack"></i> SORTIE DE PIECES</p>
            <a class="btn btn-sm btn-default btn-rounded btn-icon disabled pull-left m-r-xl" id="file" data-value=""
               title="Fiche d'etat...">
                <i class="fa fa-file-pdf-o"></i>
            </a>
            <form id="searchForm" class="col-md-4 m-t-sm m-l-xl none">
                {{csrf_field()}}
                <input name="delivered" type="hidden" value="1">
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
                   onClick="$('#demandTable').tableExport({type:'xlsx',escape:'false'});">
                    <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onClick="$('#demandTable').tableExport({type:'pdf',escape:'false'});">
                    <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> PDF
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#demandTable').tableExport({type:'csv',escape:'false'});">
                    <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                </a>
            </div>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-md-2 col-md-push-10">
                    <div class="panel">
                        <div class="panel-heading b-b">Filtre</div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" value="demand" checked class="filter"><i></i> En attente
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" value="delivered" class="filter"><i></i> Effectuées
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-md-pull-2">
                    <div class="row row-sm">
                        <section class="panel">
                            <div class="panel-heading b-b">Liste des demande de pieces</div>
                            <div class="panel-body">
                                <div class="table-responsive" id="view">
                                    <table class="table table-striped m-b-none capitalize" id="demandTable">
                                        <thead>
                                        <tr>
                                            <th>Reference OT</th>
                                            <th>Réf. demande</th>
                                            <th>Qté Dmdé</th>
                                            <th>Qté Livrée</th>
                                            <th>Car</th>
                                            <th><i class="i i-calendar"></i> Date</th>
                                            <th><i class="i i-cog"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($demands as $key=>$demand)
                                            <tr id="output{{$demand->id}}">
                                                <td class="uppercase text-danger-dker">{{$demand->diagnostic->state->reference}}</td>
                                                <td class="uppercase text-danger-dker">{{$demand->reference}}</td>
                                                <td class="text-success-dk text-center">{{number_format($demand->demand_piece->sum('quantity'))}}</td>
                                                <td>{{number_format($demand->demand_piece->sum('delivered'))}}</td>
                                                <td>{{$demand->diagnostic->state->bus->model->brand->name." ".$demand->diagnostic->state->bus->model->name}}</td>
                                                <td>{{Jenssegers\Date\Date::parse($demand->created_at)->format('j M Y')}}</td>
                                                <td><a href="#" id="{{$demand->id}}" onclick="validate(this)"
                                                       data-car="{{$demand->diagnostic->state->bus->model->brand->name." ".$demand->diagnostic->state->bus->model->name}}"
                                                       data-demand="{{$demand->reference}}"
                                                       data-ot="{{$demand->diagnostic->state->reference}}" data-key="{{$key + 1}}">
                                                        <i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cssload-container none" id="spinner">
                                    <div class="cssload-progress cssload-float cssload-shadow">
                                        <div class="cssload-progress-item"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <div class="modal fade" id="deliveredModal">
        <div class="modal-dialog">
            <div class="modal-content" id="modalView">

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="validateModal">
        <div class="modal-dialog modal-lg">
            <form id="validateForm" class="modal-content">
                {{csrf_field()}}
                <input name="output" value="1" type="hidden">
                <input name="demand" type="hidden" id="demand_id">
                <input name="key" type="hidden" id="key">
                <div class="modal-header">
                    <section class="panel panel-info m-b-n-sm">
                        <div class="panel-body">
                            <a href="#" class="thumb-md pull-right m-l m-t-xs">
                                <img src="{{asset('assets/images/car_wrench.png')}}"> <i
                                        class="on md b-white bottom"></i>
                            </a>
                            <div class="clear font-bold"><a href="#" class="text-primary-dk uppercase">@<span
                                            id="ot"></span></a>
                                <small class="block  uppercase text-danger-dker" id="demand"></small>
                                <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car"></a>
                            </div>
                        </div>
                        <h3 class="text-center font-bold m-t-n-xl">SORTIE DES PIECES</h3>
                    </section>
                </div>
                <div class="modal-body">
                    <table class="table table-striped m-b-none" id="pieceTable">
                        <thead>
                        <tr>
                            <th colspan="3" class="text-center b-r-2x">Demande de pièces</th>
                            <th colspan="2" class="text-center">Livraison</th>
                        </tr>
                        <tr>
                            <th>Pièces demandées</th>
                            <th width="2">Quantité</th>
                            <th width="2">Livrée</th>
                            <th width="150">Stock Referent</th>
                            <th width="2">Dispo.</th>
                            <th width="2">Quantité</th>
                        </tr>
                        </thead>
                        <tbody id="pieceRow">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-rounded btn-icon" data-dismiss="modal"><i
                                class="fa fa-close"></i></button>
                    <button type="submit" class="btn btn-success btn-rounded uppercase" id="submit"><i
                                class="i i-checked"></i> Valider
                    </button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    <script>
        var $filter = $('.filter'),
            $form = $('#validateForm'),
            $table = $('#demandTable'),
            $info = $('.info'),
            $modal_info = $('#deliveredModal'),
            $modal_info_content = $('#modalView'),
            $spinner = $('#spinner'),
            $search = $('#searchForm'),
            $result = $('#result'),
            $table_piece = $('#pieceTable'),
            $piece_row = $('#pieceRow'),
            $modal_validate = $('#validateModal'),
            $ot = $('#ot'),
            $demand = $('#demand'),
            $car = $('#car'),
            $demand_id = $('#demand_id'),
            $submit_search = $('#submit_search'),
            $key = $('#key'),
            $view = $('#view'),
            $submit = $('#submit');

        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var type = 'post';
                var url = 'home';
                status = "success";
                var msg = "LA SORTIE A ETE VALIDER";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $form.trigger('reset');
                        toastr[status](msg, "<span class='uppercase'>"+ data.demand +"</span>");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="output' + data.id + '" class="alert alert-info text-danger font-bold">' +
                            '<td class="uppercase">' + data.reference + '</td>' +
                            '<td class="uppercase">' + data.demand + '</td>' +
                            '<td>' + data.quantity + '</td>' +
                            '<td>' + data.delivered + '</td>' +
                            '<td>' + data.bus + '</td>' +
                            '<td>' + data.date + '</td>' +
                            ' <td><a href="#" id="' + data.id + '" onclick="validate(this)" data-car="' + data.car + '"' +
                            'data-demand="' + data.demand + '" data-ot="' + data.reference + '" data-key="'+data.key+'"> ' +
                            '<i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        console.log(data.finished);
                        if (data.finished === '1'){
                            $('#output' + data.id).remove();
                        }else {
                            $('#output' + data.id).replaceWith(row);
                        }
                        $submit.button('reset');
                        $modal_validate.modal('hide');
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
                            $submit.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $submit.button('reset');
                        }
                    }
                });
            });
            $info.on('click', function () {
                information(this)
            });
            $search.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $submit_search.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>'});
                $submit_search.button('loading');
                $.get('search?' + formData, function (data) {
                    $view.html(data);
                    $submit_search.button('reset');
                });
            });
            $filter.on('click', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('home/' + id, function (data) {
                    $view.html(data);
                    if (id === "demand"){
                        $search.fadeOut("slow");
                    }else {
                        $search.fadeIn("slow");
                    }
                    $spinner.hide();
                })
            })
        });
        function format(x) {
            return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function validate(obj) {
            $spinner.show();
            var id = $(obj).attr('id');
            $.get('home/' + id, function (data) {
                $car.html($(obj).attr('data-car'));
                $ot.html($(obj).attr('data-ot'));
                $demand.html($(obj).attr('data-demand'));
                $demand_id.val(id);
                $key.val($(obj).attr('data-key'));
                $piece_row.empty();
                var i = 1;
                $.each(data, function (index, modelObj) {
                    $table_piece.append('<tr class="capitalize animated fadeInLeft"><td>' + modelObj.piece +
                        '<input class="form-control input-sm" name="piece[]" value="' + modelObj.id + '" type="hidden"></td>' +
                        '<td>' + format(modelObj.quantity) + '</td><td>' + format(modelObj.delivered) + '' +
                        '<input name="delivered[]" value="' + modelObj.delivered + '" type="hidden"></td>' +
                        '<td><select class="chosen-select input-sm form-control" id="' + i + '" name="reference[]" ' +
                        'onchange="infoReference(this)" required>' +
                        '<option selected disabled>Choissisez le stock</option>' +
                            @forelse($stocks as $key => $stock)
                                '<option value="{{$stock->id}}" class="uppercase">{{$stock->reference}}</option>' +
                            @empty
                                '<option disabled>AUCUNE REFERENCE DISPONIBLE</option>' +
                            @endforelse
                                ' </select></td><td><p class="text-danger-dker m-t-xs" id="qty' + i + '">...</p>' +
                        '<input class="form-control input-sm" id="rest' + i + '" type="hidden"></td>' +
                        '<td><input class="form-control input-sm" name="quantity[]" data-id="' + i + '" id="quantity' + i + '" onchange="calcul($(this))"' +
                        'type="number"></td></tr>');
                    i++;
                });
                $modal_validate.modal('show');
                $spinner.hide()
            })
        }
        function infoReference(obj) {
            var id = $(obj).attr('id'),
                ids = $(obj).val(),
                quantity = $('#quantity' + id),
                qty = $('#qty' + id),
                rest = $('#rest' + id),
                type = "input";
            quantity.addClass('loading-input');
            $.get('references/' + ids + '/' + type, function (data) {
                qty.html(data.qty);
                rest.val(data.qty);
                quantity.removeClass('loading-input');
            })
        }
        function information(obj) {
            $spinner.show();
            var id = $(obj).attr('id'),
                type = "output";
            $.get('movement/' + id + '/' + type, function (data) {
                $modal_info_content.html(data);
                $modal_info.modal('show');
                $spinner.hide();
            })
        }
        function calcul(obj) {
            var id = $(obj).attr('data-id'),
                val = $(obj).val(),
                quantity = $('#rest' + id).val(),
                rest = $('#qty' + id);
            result = parseInt(quantity) - parseInt(val);
            rest.html(result);
            /*if (result < 0) {
             $submit_output.addClass('disabled');
             quantity.addClass('text-danger')
             } else {
             $submit_output.removeClass('disabled');
             quantity.removeClass('text-danger')
             }*/
        }
    </script>
@endsection
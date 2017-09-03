@section('title') Approbation de sortie des pièces @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-gavel"></i> APPROBATION DE SORTIE DES PIECES
            </p>
            <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value=""
               title="Fiche d'etat...">
                <i class="fa fa-file-pdf-o"></i>
            </a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onclick="$('#approvalTable').tableExport({type:'xlsx',escape:'false'});">
                    <img src="{{asset('assets/images/icons/xls.png')}}" width="20"> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onclick="$('#approvalTable').tableExport({type:'pdf',escape:'false'});">
                    <img src="{{asset('assets/images/icons/pdf.png')}}" width="20"> PDF
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onclick="$('#approvalTable').tableExport({type:'csv',escape:'false'});">
                    <img src="{{asset('assets/images/icons/csv.png')}}" width="20"> CSV
                </a>
            </div>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-md-3 col-md-push-9">
                    <div class="panel">
                        <div class="panel-heading b-b">Filtre</div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" checked value="waiting" class="filter"><i></i>
                                        Demande en attente
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" value="validated" class="filter"><i></i>
                                        Demande approvée
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-md-pull-3">
                    <div class="row">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive" id="view">
                                    <table class="table table-striped m-b-none capitalize" id="approvalTable">
                                        <thead>
                                        <tr>
                                            <th width="5"></th>
                                            <th width="5"></th>
                                            <th>Reference OT</th>
                                            <th>Immatriculation</th>
                                            <th>Chassis</th>
                                            <th>Car</th>
                                            <th><i class="fa fa-calendar"></i> Date</th>
                                            <th><i class="fa fa-cog"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($diagnostics as $key=>$diagnostic)
                                            <tr id="approval{{$diagnostic->id}}" class="fadeIn">
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <a href="#" id="{{$diagnostic->id}}" class=""><i
                                                                class="fa fa-search-plus text-muted"></i></a>
                                                </td>
                                                <td class="uppercase text-danger-dker">{{$diagnostic->process->reference}}</td>
                                                <td class="uppercase text-primary-dker">{{$diagnostic->process->state->bus->matriculation}}</td>
                                                <td class="uppercase">{{$diagnostic->process->state->bus->chassis}}</td>
                                                <td>{{$diagnostic->process->state->bus->model->brand->name." ".$diagnostic->process->state->bus->model->name}}</td>
                                                <td>{{\Jenssegers\Date\Date::parse($diagnostic->created_at)->format('j M Y')}}</td>
                                                <td><a href="#" id="{{$diagnostic->id}}" class="waiting"
                                                       data-car="{{$diagnostic->process->state->bus->model->brand->name." ".$diagnostic->process->state->bus->model->name}}"
                                                       data-matriculation="{{$diagnostic->process->state->bus->matriculation}}"
                                                       data-ot="{{$diagnostic->process->reference}}">
                                                        <i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cssload-container m-t-md none" id="spinner">
                                    <div class="cssload-progress cssload-float cssload-shadow m-t-md">
                                        <div class="cssload-progress-item"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <div class="modal fade" id="validateModal">
        <div class="modal-dialog">
            <form id="validateForm" class="modal-content">
                {{csrf_field()}}
                {{method_field('put')}}
                <input id="reference" name="reference" type="hidden">
                <div class="modal-header">
                    <section class="panel panel-info m-b-n-sm">
                        <div class="panel-body">
                            <a href="#" class="thumb-md pull-right m-l m-t-xs">
                                <img src="{{asset('assets/images/car_wrench.png')}}"> <i
                                        class="on md b-white bottom"></i>
                            </a>
                            <div class="clear font-bold"><a href="#" class="text-primary-dk uppercase">@<span
                                            id="matriculation"></span></a>
                                <small class="block  uppercase text-danger-dker" id="ot"></small>
                                <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car"></a>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-body">
                    <div class="panel-group m-b" id="accordion2">
                        <div class="panel panel-info">
                            <div class="panel-heading uppercase">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2"
                                   href="#collapseOne">
                                    <i class="fa fa-question-circle"></i> Pièces demandées
                                </a>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
                                <div class="panel-body">
                                    <table class="table table-striped m-b-none" id="pieceTable">
                                        <thead>
                                        <tr>
                                            <th width="95%">Pièces</th>
                                            <th>Quantité</th>
                                        </tr>
                                        </thead>
                                        <tbody id="pieceRow">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading uppercase">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2"
                                   href="#collapseTwo">
                                    <i class="fa fa-plus-circle"></i> Ajout de nouvelle pièces
                                </a>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <table class="table"
                                           id="pieceNew">
                                        <thead>
                                        <tr>
                                            <th>Piece à ajouté<a class="btn btn-icon btn-rounded btn-sm m-t-n-sm btn-info pull-right" title="Ajouter une pièce" id="piece_add">
                                                    <i class="fa fa-plus-circle"></i></a></th>
                                            <th width="85">Qté</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal"><i class="fa fa-close"></i></button>
                    <button type="submit" id="submit" class="btn btn-success btn-rounded uppercase">
                        <i class="i i-checked"></i> Valider
                    </button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <table class="table"
           id="pieceAdd">
        <tbody>
        <tr>
            <td><textarea class="form-control input-sm" name="piece[]" id="piece"
                          placeholder="Nom piece + Marque & Model"
                          rows="1"></textarea>
            </td>
            <td>
                <input class="form-control input-sm"
                       name="quantity[]"
                       id="quantity"
                       placeholder="0"
                       type="number">
            </td>
        </tr>
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        var $table = $('#approvalTable'),
            $filter = $('.filter'),
            $view = $('#view'),
            $waiting = $('.waiting'),
            $modal_validate = $('#validateModal'),
            $table_piece = $('#pieceTable'),
            $piece_row = $('#pieceRow'),
            $car = $('#car'),
            $ot = $('#ot'),
            $matriculation = $('#matriculation'),
            $piece_add = $('#piece_add'),
            $form = $('#validateForm'),
            $submit = $('#submit'),
            $file = $('#file'),
            $reference = $('#reference'),
            $spinner = $('#spinner');

        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "../../assets/js/datatables/French.json"
                }
            });
            $filter.on('click', function () {
                $spinner.show();
                var id = $(this).val();
                $.get(id, function (data) {
                    $view.html(data);
                    $spinner.hide()
                })
            });
            $waiting.on('click', function () {
                waiting($(this))
            });
            $piece_add.on('click', function () {
                var $table = $('#pieceNew tbody');
                $table.append($('#pieceAdd tbody tr:last').clone());
                var rows = $('#pieceNew tr');

                var count = rows.length,
                    lastRow = rows[count - 1],
                    text_area = $(lastRow).find('textarea'),
                    text_input = $(lastRow).find('input');

                text_area.eq(0).attr('id', 'piece' + count);
                text_input.eq(0).attr('id', 'quantity' + count);
                text_area.eq(0).attr('required', true);
                text_input.eq(0).attr('required', true);
                $('#quantity' + count).val('');
                $('#piece' + count).val('');
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'put',
                    url = $(this).attr('action'),
                    status = "success",
                    msg = "La sortie a été Approuver";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $form.trigger('reset');
                        $file.attr('data-value', data.id);
                        $file.addClass('btn-danger');
                        $file.removeClass('btn-default disabled');
                        toastr[status](msg, "<span class='uppercase'>" + data.reference + "</span>!");
                        toastr.options.preventDuplicates = true;
                         $('#approval'+data.id).remove();
                        $submit.button('reset');
                        $modal_validate.modal('hide')
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
        });
        function format(x) {
            return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function waiting(obj) {
            $spinner.show();
            var id = $(obj).attr('id');
            $.get(id, function (data) {
                $car.html($(obj).attr('data-car'));
                $matriculation.html($(obj).attr('data-matriculation'));
                $ot.html($(obj).attr('data-ot'));
                $form.attr('action', +id);
                $reference.val($(obj).attr('data-ot'));
                $piece_row.empty();
                $.each(data, function (index, modelObj) {
                    console.log(modelObj['pieces']);
                    $table_piece.append('<tr class="capitalize animated fadeInLeft"><td>' + modelObj.piece +
                        '</td><td>' + format(modelObj.quantity) + '</td><td></td></tr>');
                });
                $modal_validate.modal('show');
                $spinner.hide()
            })
        }
    </script>
@endsection
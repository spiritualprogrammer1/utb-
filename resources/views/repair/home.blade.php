@section('title') Reparation du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-xxl bg-light dker b-r hide" id="subNav">
            <form id="createForm" method="post" action="" class="panel panel-default">
                {{csrf_field()}}
                <header class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="chosen-select form-control input-sm uppercase col-md-6" name="diagnostic"
                                    id="diagnostic" data-placeholder="Choissisez l'ordre de travail">
                                <option></option>
                                @foreach($diagnostics as $diagnostic)
                                    <option value="{{$diagnostic->id}}" name="diagnostic"
                                            id="diagnostic{{$diagnostic->id}}"
                                            data-bus="{{$diagnostic->state->bus->model->brand->name." ".$diagnostic->state->bus->model->brand->name}}"
                                            data-matriculation="{{$diagnostic->state->bus->matriculation}}">
                                        {{$diagnostic->state->reference}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 text-danger-dker font-bold">
                            <span id="reference_matriculation"></span>
                            <span id="reference_bus"></span>
                            <button type="submit" id="submit_create"
                                    class="btn btn-success btn-success btn-sm pull-right uppercase">
                                <i class="i i-checked"></i> valider
                            </button>
                        </div>
                    </div>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-10">
                            <select multiple="" class="chosen-select input-sm form-control"
                                    data-placeholder="Techniciens affectés à la réparation" name="technician[]">
                                <option></option>
                                @foreach($technicians as $technician)
                                    <option class="capitalize"
                                            value="{{$technician->id}}">{{$technician->username}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <a class="btn btn-icon btn-sm btn-info" title="Ajouter une description" id="diagnostic_add">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table" id="reference_table">
                            <tbody>
                            <tr>
                                <td>
                                    <section class="panel panel-info pos-rlt clearfix m-b-n-sm">
                                        <header class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input class="form-control input-sm" name="title[]"
                                                           id="reference_title"
                                                           minlength="3"
                                                           placeholder="Intitulé de la réparation (ex: reglage des freins)"
                                                           required>
                                                </div>
                                                <div class="col-md-1">
                                                    <ul class="nav nav-pills pull-right">
                                                        <li>
                                                            <a href="#" class="panel-toggle text-muted"><i
                                                                        class="fa fa-caret-down text-active"></i><i
                                                                        class="fa fa-caret-up text"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </header>
                                        <div class="panel-body clearfix">
                                        <textarea class="form-control input-sm" name="description[]"
                                                  id="reference_description" style="overflow: scroll"
                                                  rows="6" minlength="6"
                                                  placeholder="Detail de la réparation (ex: remplacement des freins arrieres et...)"></textarea>
                                        </div>
                                    </section>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-light lt b-b  b-b clearfix">
                    <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-wrench"></i> REPARATION</p>
                    <a href="#subNav" data-toggle="class:show" class="btn btn-sm btn-info btn-icon btn-rounded
                    @if($active == '0') disabled @endif" id="repairAdd">
                        <i class="fa fa-plus text"></i>
                        <i class="fa fa-minus text-active"></i>
                    </a>
                    <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value=""
                       title="Fiche d'etat...">
                        <i class="fa fa-file-pdf-o"></i>
                    </a>
                </header>
                <section class="scrollable wrapper bg-light dker w-f">
                    <section class="panel panel-default">
                        <header class="panel-heading">
                                Reparation en cours ...
                        </header>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none capitalize" id="repairTable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Reference OT</th>
                                    <th>Immatriculation</th>
                                    <th>Chassis</th>
                                    <th>Car</th>
                                    <th>Date</th>
                                    <th><i class="fa fa-cog"></i></th>
                                </tr>
                                </thead>
                                <tbody id="repairRow">
                                @foreach($repairs as $key=>$repair)
                                    <tr id="repair{{$repair->id}}">
                                        <td>{{$key + 1}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->reference}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->matriculation}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->chassis}}</td>
                                        <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
                                        <td>{{\Jenssegers\Date\Date::parse($repair->updated_at)->format('j M Y')}}</td>
                                        <td><a href="#" id="{{$repair->id}}" class="repair"
                                               data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                                               data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                                               data-ot="{{$repair->diagnostic->state->reference}}">
                                                <i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <div class="cssload-container m-t-n-md none" id="spinner">
                        <div class="cssload-progress cssload-float cssload-shadow m-t-n-md">
                            <div class="cssload-progress-item"></div>
                        </div>
                    </div>
                </section>
            </section>
        </aside>
    </section>
    <div class="modal fade" id="validateModal">
        <div class="modal-dialog modal-lg">
            <form id="validateForm" class="modal-content">
                {{csrf_field()}}
                <input name="reference" id="ot_reference" type="hidden">
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
                    <div class="panel panel-info m-b-none">
                        <section class="panel panel-info" id="view">
                        </section>
                    </div>
                </div>
                <div class="modal-footer m-t-non">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="ro pull-left">
                                <div class="checkbox i-checks text-danger-dker">
                                    <label>
                                        <input type="checkbox" name="finish" value="1" id="finish"><i></i>
                                        <u class=" font-bold">Cochez si réparation terminée!</u>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 pull-right">
                            <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal"><i
                                        class="fa fa-close"></i></button>
                            <button type="submit" id="submit" class="btn btn-success btn-rounded uppercase">
                                <i class="i i-checked"></i> Mettre à jour la réparation
                            </button>
                        </div>
                    </div>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <table class="table"
           id="pieceAdd">
        <tbody>
        <tr>
            <td>
             <textarea class="form-control input-sm"
                       name="piece[]"
                       id="piece"
                       placeholder="Nom piece + Marque & Model"
                       rows="2" required></textarea>
            </td>
            <td>
                <input class="form-control input-sm"
                       name="quantity[]"
                       id="quantity"
                       placeholder="0"
                       type="number" required>
                <a href="#piece_row"
                   data-dismiss="alert"
                   class="btn btn-default btn-xs pull-right">
                    <i class="fa fa-trash-o text-danger-dker"></i>
                </a>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        var $table = $('#repairTable'),
            $form_create = $('#createForm'),
            $form = $('#validateForm'),
            $file = $('#file'),
            $submit_create = $('#submit_create'),
            $diagnostic = $('#diagnostic'),
            $reference_matriculation = $('#reference_matriculation'),
            $reference_bus = $('#reference_bus'),
            $repair_row = $('#repairRow'),
            $sub_nav = $('#subNav'),
            $repair_add = $('#repairAdd'),
            $repair = $('.repair'),
            $car = $('#car'),
            $ot = $('#ot'),
            $matriculation = $('#matriculation'),
            $diagnostic_add = $('#diagnostic_add'),
            $modal_validate = $('#validateModal'),
            $description_row = $('#descriptionRow'),
            $table_description = $('#descriptionTable'),
            $pieces_table = $('#piecesTable'),
            $pieces_row = $('#piecesRow'),
            $view = $('#view'),
            $submit = $('#submit'),
            $ot_reference = $('#ot_reference'),
            $spinner = $('#spinner'),
            $finish = $('#finish');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 5,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });
            $form_create.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'post',
                    url = 'home',
                    status = "success",
                    msg = "La Reception a bien été enregistrer";
                $submit_create.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit_create.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $form_create.trigger('reset');
                        $file.attr('data-value', data.id);
                        $file.addClass('btn-danger');
                        $file.removeClass('btn-default disabled');
                        toastr[status](msg, "<span class='uppercase'>" + data.reference + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="repair' + data.id + '" class="alert alert-info text-danger-dk font-bold">' +
                            '<td>' + data.count + '</td>' +
                            '<td class="uppercase">' + data.reference + '</td>' +
                            '<td class="uppercase">' + data.matriculation + '</td>' +
                            '<td class="uppercase">' + data.chassis + '</td>' +
                            '<td>' + data.bus + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="stockEdit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        $repair_row.before(row);
                        $('#diagnostic' + data.diagnostic);
                        diagnostics();
                        $sub_nav.addClass('hide');
                        $submit_create.button('reset');
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
                            $submit_create.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $submit_create.button('reset');
                        }
                    }
                });
            });
            $diagnostic_add.on('click', function () {
                var $table = $('#reference_table tbody');
                $table.append($('#reference_table tbody tr:last').clone());
                var rows = $('#reference_table tr');

                var count = rows.length,
                    lastRow = rows[count - 1],
                    text_area = $(lastRow).find('textarea'),
                    text_input = $(lastRow).find('input');

                text_area.eq(0).attr('id', 'reference_description' + count);
                text_input.eq(0).attr('id', 'reference_title' + count);
                $('#reference_title' + count).val('');
                $('#reference_description' + count).val('');
            });
            $repair.on('click', function () {
                repair($(this))
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'put',
                    url = $(this).attr('action'),
                    status = "info",
                    msg = "LA REPARATION A ETE MIS A JOUR";
                if ($finish.is(":checked")){
                    status = "success";
                    msg = "LA REPARATION EST TERMINEE";
                }
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
                        toastr[status](msg, "<span class='uppercase font-bold'>" + data.reference + "</span>!");
                        toastr.options.preventDuplicates = true;
                        if (data.finish === '1'){
                            $('#repair'+data.id).remove();
                        }else {
                            $('#repair'+data.id).addClass('alert alert-info text-danger-dk font-bold');
                        }
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
            $finish.on('click', function () {
                var check;
                check = $finish.is(":checked");
                if (check) {
                    $submit.removeClass('btn-success');
                    $submit.addClass('btn-danger');
                    $submit.html('<i class="fa fa-lock"></i> Terminer la réparation')
                } else {
                    $submit.removeClass('btn-danger');
                    $submit.addClass('btn-success');
                    $submit.html('<i class="i i-checked"></i> Mettre à jour la réparation')
                }
            });
            /*$diagnostic.on('change', function () {
             console.log($(this).attr('data-bus'));
             $reference_bus.html($(this).attr('data-bus'));
             $reference_matriculation.html($(this).attr('data-matriculation'))

             });*/
            //diagnostics();
            function repair(obj) {
                $spinner.show();
                var id = $(obj).attr('id');
                $.get('home/' + id, function (data) {
                    $car.html($(obj).attr('data-car'));
                    $matriculation.html($(obj).attr('data-matriculation'));
                    $ot_reference.val($(obj).attr('data-ot'));
                    $ot.html($(obj).attr('data-ot'));
                    $form.attr('action', 'home/'+id);
                    $view.html(data);
                    $modal_validate.modal('show');
                    $spinner.hide()
                });
            }
        });
        function diagnostics() {
            var id = '0';
            $.get('home/' + id, function (data) {
                console.log(data.length);
                if (data.length === 0) {
                    $repair_add.addClass('disabled')
                }
                $diagnostic.empty();
                $diagnostic.append('<option></option>');
                $.each(data, function (index, modelObj) {
                    $diagnostic.append('<option value="' + modelObj['state'].id + '" class="uppercase">' + modelObj['state'].reference + '</option>');
                    $diagnostic.trigger("chosen:updated");
                })
            })
        }
    </script>
@endsection
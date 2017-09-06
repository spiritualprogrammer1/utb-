@section('title') Reparation du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-xxl bg-light dker b-r hide" id="subNav">
            <form id="createForm" class="panel panel-default">
                {{csrf_field()}}
                <header class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">
                            <select class="chosen-select form-control input-sm uppercase col-md-6" name="diagnostic"
                                    id="diagnostic" data-placeholder="Choissisez l'ordre de travail">
                                <option></option>
                                @foreach($diagnostics as $diagnostic)
                                    <option value="{{$diagnostic->id}}" name="diagnostic" id="diagnostic{{$diagnostic->id}}"
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
                                                    <input class="form-control input-sm" name="title[]" id="reference_title"
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
                <section class="scrollable wrapper w-f">
                    <section class="panel panel-default">
                        <header class="panel-heading">
                            <div class="row">

                                    Reparation en cours ...

                            </div>
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
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td class="uppercase">{{$repair->diagnostic->state->reference}}</td>
                                        <td class="uppercase">{{$repair->diagnostic->state->bus->matriculation}}</td>
                                        <td class="uppercase">{{$repair->diagnostic->state->bus->chassis}}</td>
                                        <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
                                        <td>{{$repair->updated_at->format('d/m/Y')}}</td>
                                        <td><a href="#" id="{{$repair->id}}" class="waiting"
                                               data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                                               data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                                               data-ot="{{$repair->diagnostic->reference}}">
                                                <i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </section>
            </section>
        </aside>
    </section>

@endsection
@section('scripts')
    <script>
        var $table = $('#repairTable'),
            $form_create = $('#createForm'),
            $file = $('#file'),
            $submit_create = $('#submit_create'),
            $diagnostic = $('#diagnostic'),
            $reference_matriculation = $('#reference_matriculation'),
            $reference_bus = $('#reference_bus'),
            $repair_row = $('#repairRow'),
            $sub_nav = $('#subNav'),
            $repair_add = $('#repairAdd'),
            $diagnostic_add = $('#diagnostic_add');
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
                        $('#diagnostic'+data.diagnostic);
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
            /*$diagnostic.on('change', function () {
                console.log($(this).attr('data-bus'));
                $reference_bus.html($(this).attr('data-bus'));
                $reference_matriculation.html($(this).attr('data-matriculation'))

            });*/
            //diagnostics();
            function diagnostics() {
                var id = '0';
                $.get('home/'+id, function (data) {
                    console.log(data.length);
                    if (data.length === 0){
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
        })
    </script>
@endsection
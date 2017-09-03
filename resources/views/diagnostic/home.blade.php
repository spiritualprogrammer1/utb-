@section('title') Diagnostique du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-white" id="page">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-bug"></i> DIAGNOSTIQUE DU CAR</p>
            <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value=""
               title="Fiche d'etat...">
                <i class="fa fa-file-pdf-o"></i>
            </a>
        </header>
        <section class="scrollable wrapper bg-light dker">
            <section class="scrollable padder">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <form id="wizardform" method="post" action="">
                                {{csrf_field()}}
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <ul class="nav nav-tabs font-bold capitalize">
                                            <li><a href="#step1" data-toggle="tab">Choix d'un ordre de travail</a></li>
                                            <li><a href="#step2" data-toggle="tab">Etat du car</a></li>
                                            <li><a href="#step3" data-toggle="tab">Essais avant travaux</a></li>
                                            <li><a href="#step4" data-toggle="tab">Diagnostic du car</a></li>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <div class="progress progress-xs m-t-n-xs">
                                            <div class="progress-bar bg-success"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="tab-content">
                                                    <div class="tab-pane" id="step1">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <section class="panel panel-info  m-t-n-md">
                                                                    <header class="panel-heading font-bold">
                                                                        <h3 class="panel-title">Choisissez un ordre de
                                                                            travail <i
                                                                                    class="i i-checkmark"></i>
                                                                        </h3>
                                                                    </header>
                                                                    <div class="panel-body panel">
                                                                        <div class="row">
                                                                            <div class="table-responsive" id="view">
                                                                                <table class="table table-striped m-b-none capitalize"
                                                                                       id="processTable">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th></th>
                                                                                        <th>Ordre de Tavail</th>
                                                                                        <th>Immatriculation</th>
                                                                                        <th>Chassis</th>
                                                                                        <th>Marque</th>
                                                                                        <th>Modele</th>
                                                                                        <th>Date</th>
                                                                                        <th><i class="i i-check"></i>
                                                                                        </th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody id="vehicleRow">
                                                                                    @foreach($processes as $key=>$process)
                                                                                        <tr class="animated fadeIn">
                                                                                            <td>{{$key + 1}}</td>
                                                                                            <td class="uppercase">{{$process->reference}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$process->state->bus->matriculation}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$process->state->bus->chassis}}</td>
                                                                                            <td>{{$process->state->bus->model->brand->name}}</td>
                                                                                            <td>{{$process->state->bus->model->name}}</td>
                                                                                            <td>{{$process->created_at->format('d/m/Y')}}</td>
                                                                                            <td width="10">
                                                                                                <div class="radio i-checks">
                                                                                                    <label class="m-t-n-xl"
                                                                                                           style="width: 5px; height: 50px">
                                                                                                        <input type="radio"
                                                                                                               name="process"
                                                                                                               class="process"
                                                                                                               value="{{$process->id}}"
                                                                                                               data-trigger="change"
                                                                                                               data-required="true">
                                                                                                        <i></i>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div class="cssload-container m-t-n-lg none"
                                                                                 id="spinner2">
                                                                                <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                                                                                    <div class="cssload-progress-item"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <ul class="pager wizard m-b-sm">
                                                            <li class="previous first" style="display:none;"><a
                                                                        href="#">First</a></li>
                                                            <li class="previous"><a href="#">Precedent</a></li>
                                                            <li class="next"><a href="#">Suivant</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="step2">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <section class="panel panel-info m-t-n-md">
                                                                    <header class="panel-heading font-bold">
                                                                        <h3 class="panel-title">Incidents & Remarques
                                                                            eventuels du car</h3>
                                                                    </header>
                                                                    <div class="panel-body  panel">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <div class="row">
                                                                                    <section
                                                                                            class="panel panel-warning">
                                                                                        <header class="panel-heading">
                                                                                            Incident
                                                                                        </header>
                                                                                        <section class="panel-body">
                                                                                            <span id="incident"
                                                                                                  class="font-thin"></span>
                                                                                        </section>
                                                                                    </section>
                                                                                    <section
                                                                                            class="panel panel-warning">
                                                                                        <header class="panel-heading">
                                                                                            Remaques eventuelles
                                                                                        </header>
                                                                                        <section class="panel-body">
                                                                                            <span id="remark"
                                                                                                  class="font-thin"></span>
                                                                                        </section>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="row">
                                                                                    <section class="panel panel-info">
                                                                                        <div class="panel-body">
                                                                                            <a href="#"
                                                                                               class="thumb pull-right m-l m-t-xs avatar">
                                                                                                <img src="http://segar-ciera.dev/assets/images/Car_Repair_icon.png">
                                                                                                <i class="on md b-white bottom"></i>
                                                                                            </a>
                                                                                            <div class="clear">
                                                                                                <a href="#"
                                                                                                   class="text-info font-bold">
                                                                                                    @
                                                                                                    <span class="uppercase text-danger matriculation"></span></a>
                                                                                                <small class="block text-primary capitalize font-bold">
                                                                                                    <span class="vehicle"></span>
                                                                                                </small>
                                                                                                <a href="#"
                                                                                                   class="btn btn-xs btn-success m-t-xs">
                                                                                                    <span class="reference uppercase ot"></span>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </section>

                                                                                </div>
                                                                            </div>
                                                                            <div class="cssload-container m-t-n-lg none"
                                                                                 id="spinner">
                                                                                <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                                                                                    <div class="cssload-progress-item"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 m-b-md text-center text-primary-dker">
                                                            <div class="checkbox i-checks">
                                                                <label>
                                                                    <input type="checkbox" data-trigger="change"
                                                                           data-required="true" name="accept"><i></i>
                                                                    Accepter et continuer
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <ul class="pager wizard m-b-sm">
                                                            <li class="previous first" style="display:none;"><a
                                                                        href="#">First</a></li>
                                                            <li class="previous"><a href="#">Precedent</a></li>
                                                            <li class="next last" style="display:none;"><a
                                                                        href="#">Last</a>
                                                            </li>
                                                            <li class="next"><a href="#">Suivant</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="step3">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <section class="panel panel-info m-t-n-md">
                                                                    <header class="panel-heading font-bold">
                                                                        <h3 class="panel-title">Essais avant
                                                                            travaux</h3>
                                                                    </header>
                                                                    <div class="panel-body  panel" id="before_works">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="control-label">Choix
                                                                                        du Technicien</label>
                                                                                    <select class="chosen-select form-control input-sm before_works"
                                                                                            data-placeholder="Choissisez un technicien"
                                                                                            name="tester"
                                                                                            data-trigger="change"
                                                                                            data-required="true">
                                                                                        <option></option>
                                                                                        @foreach($technicians as $key=>$technician)
                                                                                            <option class="capitalize"
                                                                                                    value="{{$technician->id}}">{{$technician->username}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <table class="table table-striped">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td width="1">Depart:</td>
                                                                                        <td class="input-group">
                                                                                            <input type="number"
                                                                                                   name="leaving"
                                                                                                   class="form-control input-sm"
                                                                                                   id="depart" readonly>
                                                                                            <span class="input-group-btn">
                                                                                     <button class="btn btn-default btn-sm"
                                                                                             type="button">km</button>
                                                                                        </span>
                                                                                        </td>
                                                                                        <td width="1" class="m-t-sm">
                                                                                            Distance:
                                                                                        </td>
                                                                                        <td class="input-group">
                                                                                            <input type="number"
                                                                                                   name="distance"
                                                                                                   class="form-control input-sm before_works"
                                                                                                   id="distance"
                                                                                                   data-trigger="change"
                                                                                                   data-required="true"
                                                                                                   readonly>
                                                                                            <span class="input-group-btn">
                                                                                                 <button class="btn btn-default btn-sm"
                                                                                                         type="button">km</button>
                                                                                                </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td>Arrivé:</td>
                                                                                        <td class="input-group">
                                                                                            <input type="number"
                                                                                                   data-trigger="change"
                                                                                                   data-required="true"
                                                                                                   name="arrive"
                                                                                                   class="form-control input-sm before_works"
                                                                                                   id="arrive">
                                                                                            <span class="input-group-btn">
                                                                                                 <button class="btn btn-default btn-sm"
                                                                                                         type="button">km</button>
                                                                                                </span>
                                                                                        </td>
                                                                                        <td>Lieu:</td>
                                                                                        <td class="input-group"
                                                                                            width="100%">
                                                                                            <input type="text"
                                                                                                   name="place"
                                                                                                   class="form-control input-sm before_works capitalize"
                                                                                                   data-trigger="change"
                                                                                                   data-required="true">
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group m-t-n-lg">
                                                                            <label>Remarque du technicien</label>
                                                                            <textarea rows="8"
                                                                                      class="form-control input-sm text-area before_works"
                                                                                      name="description"
                                                                                      data-trigger="change"
                                                                                      data-required="true"
                                                                                      minlength="6"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 m-b-lg">
                                                            <!--<div class="form-group">
                                                                <label class="control-label text-danger-dker">Test avant travaux?</label>
                                                                <div class="m-l-md">
                                                                    <label class="switch">
                                                                        <input type="checkbox" checked value="1" name="test" id="test">
                                                                        <span></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        </div>
                                                        <ul class="pager wizard m-b-sm">
                                                            <li class="previous first" style="display:none;"><a
                                                                        href="#">First</a></li>
                                                            <li class="previous"><a href="#">Precedent</a></li>
                                                            <li class="next last" style="display:none;"><a
                                                                        href="#">Last</a>
                                                            </li>
                                                            <li class="next"><a href="#">Suivant</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane" id="step4">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <section class="panel panel-info m-t-n-md">
                                                                    <header class="panel-heading font-bold">
                                                                        <h3 class="panel-title">Detection des
                                                                            pannes
                                                                            <button class="btn btn-sm btn-info uppercase m-l-lg"
                                                                                    id="diagnostic_add">
                                                                                <i class="fa fa-plus-square"></i>
                                                                                Ajouter un diagnostique
                                                                            </button>
                                                                            <a href="#"
                                                                               class="btn btn-sm btn-info pull-right uppercase"
                                                                               id="piece_add">
                                                                                <i class="fa fa-plus-circle"></i>
                                                                                Demande des pieces
                                                                            </a></h3>
                                                                    </header>
                                                                    <div class="panel-body  panel">
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <div class="row">
                                                                                    <table class="table"
                                                                                           id="diagnosticTable">
                                                                                        <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <section
                                                                                                        class="panel panel-success m-t-sm">
                                                                                                    <header class="panel-heading bg-white">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-5">
                                                                                                                <select class="chosen-selecte form-control input-sm"
                                                                                                                        data-placeholder="Choissisez le technicien"
                                                                                                                        name="technician[]"
                                                                                                                        id="technician"
                                                                                                                        data-trigger="change"
                                                                                                                        data-required="true"
                                                                                                                        required>
                                                                                                                    <option></option>
                                                                                                                    @foreach($technicians as $key=>$technician)
                                                                                                                        <option class="capitalize"
                                                                                                                                value="{{$technician->id}}">{{$technician->username}}</option>
                                                                                                                    @endforeach
                                                                                                                </select>
                                                                                                            </div>
                                                                                                            <div class="col-md-7">
                                                                                                                <input class="form-control input-sm capitalize"
                                                                                                                       name="title[]"
                                                                                                                       minlength="3"
                                                                                                                       placeholder="Intitulé du diagnostic"
                                                                                                                       required
                                                                                                                       id="title">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </header>
                                                                                                    <div class="panel-body">
                                                                                        <textarea name="diagnostic[]"
                                                                                                  required
                                                                                                  id="diagnostic"
                                                                                                  class="form-control input-sm"
                                                                                                  style="overflow: scroll;"
                                                                                                  minlength="6"
                                                                                                  rows="2"
                                                                                                  placeholder="Detail du diagnostic"></textarea>
                                                                                                    </div>
                                                                                                </section>
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="row">
                                                                                    <table class="table"
                                                                                           id="pieceTable">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th>Pieces demandées</th>
                                                                                            <th width="85">Qtés</th>
                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <tr id="piece_row">
                                                                                            <td>
                                                                                                <textarea
                                                                                                        class="form-control input-sm"
                                                                                                        name="piece[]"
                                                                                                        id="piece"
                                                                                                        placeholder="Nom piece + Marque & Model"
                                                                                                        rows="2"></textarea>
                                                                                            </td>
                                                                                            <td>
                                                                                                <input class="form-control input-sm"
                                                                                                       name="quantity[]"
                                                                                                       id="quantity"
                                                                                                       placeholder="0"
                                                                                                       type="number">
                                                                                                <a href="#piece_row"
                                                                                                   data-dismiss="alert"
                                                                                                   class="btn btn-default btn-xs pull-right">
                                                                                                    <i class="fa fa-trash-o text-danger-dker"></i>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label"><i class="fa fa-paper-plane-o"></i> Prestation</label>
                                                            <select class="chosen-select form-control input-sm"
                                                                    data-placeholder="Choissisez la prestation"
                                                                    name="service"
                                                                    data-trigger="change"
                                                                    data-required="true">
                                                                <option></option>
                                                                <option class="capitalize" value="2">Reparation</option>
                                                                <option class="capitalize" value="3">Revision</option>
                                                                <option class="capitalize" value="4">Visite Technique</option>
                                                            </select>
                                                            <button type="submit" id="submit"
                                                                    class="btn btn-sm btn-success btn-group-justified uppercase m-t-sm">
                                                                <i class="fa fa-save"></i> Enregistrer
                                                            </button>
                                                            <p class="m-t-md"><i class="fa fa-id-badge"></i> : <span
                                                                        class="ot uppercase font-bold text-danger-dker"></span>
                                                            </p>
                                                            <p><i class="fa fa-id-card-o"></i> : <span
                                                                        class="matriculation uppercase font-bold text-danger-dker"></span>
                                                            </p>
                                                            <p class="m-b-md"><i class="fa fa-bus"></i> : <span
                                                                        class="vehicle uppercase font-bold text-danger-dker"></span>
                                                            </p>
                                                        </div>
                                                        <ul class="pager wizard m-b-sm">
                                                            <li class="previous"><a href="#">Precedent</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>

@endsection
@section('scripts')
    <script src="{{asset('assets/js/parsley/parsley.min.js')}}"></script>
    <script src="{{asset('assets/js/wizard/jquery.bootstrap.wizard.js')}}"></script>
    <script src="{{asset('assets/js/wizard/demo.js')}}"></script>
    <script>
        var $table = $('#processTable'),
            $form = $('#wizardform'),
            $first = $('.first'),
            $file = $('#file'),
            $submit = $('#submit'),
            $remark = $('#remark'),
            $incident = $('#incident'),
            $matriculation = $('.matriculation'),
            $vehicle = $('.vehicle'),
            $ot = $('.ot'),
            $process = $('.process'),
            $depart = $('#depart'),
            $arrive = $('#arrive'),
            $distance = $('#distance'),
            $test = $('#test'),
            $piece_add = $('#piece_add'),
            $diagnostic_add = $('#diagnostic_add'),
            $view = $('#view'),
            $spinner2 = $('#spinner2'),
            $before = $('#before_works'),
            $before_input = $('.before_works');
        $spinner = $('#spinner');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 5,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'post',
                    url = 'home',
                    status = "success",
                    msg = "Le Diagnostic été enregistrer";
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
                        processes();
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;
                        $submit.button('reset');
                        $first.click();
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
            $process.on('click', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('home/' + id + '/edit', function (data) {
                    $incident.html(data.incident);
                    $remark.html(data.remark);
                    $matriculation.html(data.matriculation);
                    $vehicle.html(data.bus);
                    $ot.html(data.ot);
                    $depart.val(data.depart);
                    $spinner.hide();
                })
            });
            $arrive.on('change', function () {
                var depart = $depart.val(),
                    arrive = $(this).val();
                var result = parseInt(arrive) - parseInt(depart);
                if (arrive < depart) {
                    $distance.val('')
                } else {
                    $distance.val(result)
                }

            });
            $test.on('click', function () {
                var check;
                check = $test.is(":checked");
                if (check) {

                } else {

                }
            });
            $piece_add.on('click', function () {
                var $table = $('#pieceTable tbody');
                $table.append($('#pieceTable tbody tr:last').clone());
                var rows = $('#pieceTable tr');

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
            $diagnostic_add.on('click', function () {
                var $table = $('#diagnosticTable tbody');
                $table.append($('#diagnosticTable tbody tr:last').clone());
                var rows = $('#diagnosticTable tr');

                var count = rows.length,
                    lastRow = rows[count - 1],
                    text_select = $(lastRow).find('select'),
                    text_area = $(lastRow).find('textarea'),
                    text_input = $(lastRow).find('input');

                text_select.eq(0).attr('id', 'technician' + count);
                text_area.eq(0).attr('id', 'diagnostic' + count);
                text_input.eq(0).attr('id', 'title' + count);
                $('#technician' + count).val('');
                $('#title' + count).val('');
                $('#diagnostic' + count).val('');
            });
        });
        function processes() {
            $spinner2.show();
            var id = '0';
            $.get('home/' + id, function (data) {
                $view.html(data);
                $spinner2.hide();
            })
        }
    </script>
@endsection
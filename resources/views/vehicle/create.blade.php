@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-lg bg-light dker b-r" id="subNav">
            <section>
                <form method="post" id="busForm" role="form" action="../vehicle" class="panel b-a bg-light lter">
                    {{csrf_field()}}
                    {{method_field('put')}}
                    <div class="panel-body panel-danger">
                        <h4 class="font-thin m-t-n-sm text-dark">AJOUTER UN CAR
                            <a href="#" class="btn btn-icon btn-default btn-rounded pull-right btn-info none"
                               id="refresh">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </h4>
                        <div class="form-group m-t-md">
                            <label class="control-label">Designation</label>
                            <input type="text" name="designation" min="3" id="designation"
                                   class="form-control input-sm text-primary-dk input"
                                   placeholder="Designation du vehicule (facultative)">
                        </div>
                        <div class="has-error form-group">
                            <label class="control-label">Immatriculation *</label>
                            <input type="text" name="matriculation" min="3" id="matriculation"
                                   class="form-control input-sm text-danger-dk uppercase input"
                                   placeholder="Immatriculation du vehicule" required>
                        </div>
                        <div class="has-error form-group">
                            <label class="control-label">Numero chassis *</label>
                            <input type="text" name="chassis" min="3" id="chassis"
                                   class="form-control input-sm text-danger-dk uppercase input"
                                   placeholder="Numéro du chassis" required>
                        </div>
                        <div class="row m-t-md">
                            <div class="form-group-sm  col-sm-6">
                                <label>Marque </label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UNE MARQUE..." id="brand" name="brand">
                                    <option></option>
                                    @forelse($brands as $key => $brand)
                                        <option value="{{$brand->id}}"
                                                class="uppercase">{{$brand->name}}</option>
                                    @empty
                                        <option>AUCUNE MARQUE DISPONIBLE</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6">
                                <label class="control-label">Modele</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UN MODELE..." id="model" name="model">
                                    <option selected disabled>......................................
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group m-t-md">
                            <label class="control-label">P.M.C *</label>
                            <input type="text" name="first_circulation" id="first_circulation"
                                   class="form-control input-sm datepicker capitalize"
                                   placeholder="Date de mise en circulation" required>
                        </div>
                        <div class="form-group">
                            <label>Date Expiration Assurance *</label>
                            <input type="text" name="assurance" id="assurance"
                                   class="form-control input-sm datepicker"
                                   placeholder=">Date d'expiration de l'assurance" required>
                        </div>
                        <div class="form-group">
                            <label>Date Expiration Visite Technique *</label>
                            <input type="text" name="visit" id="visit"
                                   class="form-control input-sm datepicker"
                                   placeholder=">Date d'expiration de la visite technique" required>
                        </div>
                        <button type="submit" value="save" id="submit"
                                class="btn btn-success btn-group-justified input-sm uppercase m-t-md">
                            <i class="fa fa-floppy-o"></i> enregistrer le car
                        </button>
                    </div>
                </form>
            </section>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-6 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide"
                               class="btn btn-sm btn-default active pull-left m-r-md">
                                <i class="fa fa-caret-right text fa-lg"></i>
                                <i class="fa fa-caret-left text-active fa-lg"></i>
                            </a>
                            <h4><i class="fa fa-bus"></i> GESTION DE CARS</h4>
                        </div>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#vehicleTable').tableExport({type:'xlsx',escape:'false'});">
                                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default"
                               onClick="$('#vehicleTable').tableExport({type:'pdf',escape:'false'});">
                                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                               onClick="$('#vehicleTable').tableExport({type:'csv',escape:'false'});">
                                <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                            </a>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper w-f">
                    <section class="panel panel-default" id="view">
                        <div class="table-responsive">
                            <table class="table datatable table-responsive table-striped m-b-none capitalize"
                                   id="vehicleTable">
                                <thead>
                                <tr>
                                    <th>Immatriculation</th>
                                    <th>Chassis</th>
                                    <th>Marque</th>
                                    <th>Modele</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                    <th><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody id="vehicleRow">
                                @foreach($buses as $key=>$bus)
                                    <tr id="bus{{$bus->id}}" class="animated fadeIn">
                                        <td class="text-danger-dk uppercase">{{$bus->matriculation}}</td>
                                        <td class="text-danger-dk uppercase">{{$bus->chassis}}</td>
                                        <td>{{$bus->model->brand->name}}</td>
                                        <td>{{$bus->model->name}}</td>
                                        <td>{{$bus->created_at->format('d/m/Y')}}</td>
                                        <td><a href="#" id="{{$bus->id}}" class="bus"><i
                                                        class="fa fa-pencil"></i></a></td>
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
@endsection
@section('scripts')
    <script>
        var $table = $('#vehicleTable'),
            $form = $('#busForm'),
            $submit = $('#submit'),
            $chosen = $('.chosen-select'),
            $brand = $('#brand'),
            $matriculation = $('#matriculation'),
            $row = $('#vehicleRow'),
            $bus = $('.bus'),
            $models = $('#model'),
            $circulation = $('#first_circulation'),
            $refresh = $('#refresh'),
            $visit = $('#visit'),
            $assurance = $('#assurance'),
            $chassis = $('#chassis'),
            $input = $('.input'),
            $spinner = $('.cssload-container'),
            $designation = $('#designation');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            $brand.on('change', function () {
                var id = $(this).val();
                models(id);
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    state = $submit.val(),
                    type = 'post',
                    url = '../vehicle',
                    status = "success",
                    msg = "Le Car a bien été enregistrer";
                if (state === 'edit') {
                    url = $(this).attr('action');
                    type = 'put';
                    status = "info";
                    msg = "Le Car a bien été modifier";
                }
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="vehicle' + data.id + '" class="alert alert-danger bg-light dker text-primary-dk animated fadeInDown">' +
                            '<td class="uppercase">' + data.matriculation + '</td>' +
                            '<td class="uppercase">' + data.chassis + '</td>' +
                            '<td>' + data.brand + '</td>' +
                            '<td>' + data.model + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        if (state === 'save'){
                            $row.before(row);
                        }else {
                            $('#bus'+data.id).replaceWith(row);
                        }
                        $submit.button('reset');
                        refresh();
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
            $bus.on('click', function () {
                var id = $(this).attr('id');
                edit(id)
            });
            $refresh.on('click', function () {
                refresh()
            })
        });
        function edit(id) {
            $input.addClass('loading-input');
            $.get('../vehicle/' + id + '/edit', function (data) {
                $form.attr('action', '../vehicle/' + id);
                $submit.val('edit');
                $submit.removeClass('btn-success');
                $submit.addClass('btn-info');
                $submit.html('<i class="fa fa-pencil"></i> modifier le car');
                $designation.val(data.designation);
                $matriculation.val(data.matriculation);
                $chassis.val(data.chassis);
                //$circulation.val(data.circulation);
                models(data.brand);
                $brand.val(data.brand);
                $models.val(data.model);
                $models.trigger('chosen:updated');
                $chosen.trigger('chosen:updated');
                $input.removeClass('loading-input');
                $refresh.show();
            })
        }
        function models(id) {
            $.get('../models/' + id, function (data) {
                if (data.length === 0) {
                    $models.empty();
                    $models.trigger("chosen:updated");
                } else {
                    $models.empty();
                    $.each(data, function (index, modelObj) {
                        $models.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
                        $models.trigger("chosen:updated");
                    })
                }
            })
        }
        function refresh() {
            $form.trigger('reset');
            $models.empty();
            $chosen.trigger('chosen:updated');
            $matriculation.focus();
            $submit.val("save");
            $submit.addClass('btn-success');
            $submit.removeClass('btn-info');
            $submit.html('<i class="fa fa-save"></i> enregistrer le car');
            $refresh.hide();
        }
    </script>

@endsection
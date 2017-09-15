@section('title') Essais apres travaux @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-md bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header">Filtre des travaux</div>
            <ul class="nav">
                <li class="b-b "><a href="#" class="filter" id="1">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                        <i class="i i-settings"></i> Réparation</a>
                </li>
                <li class="b-b "><a href="#" class="filter" id="2">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                        <i class="i i-gauge"></i> Révision</a>
                </li>
                <li class="b-b "><a href="#" class="filter" id="3">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                        <i class="i i-params"></i> Visite Technique</a>
                </li>
            </ul>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-8 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide" class="btn btn-sm btn-default active"><i
                                        class="fa fa-caret-right text fa-lg"></i><i
                                        class="fa fa-caret-left text-active fa-lg"></i></a>
                            <div class="btn-group m-l-md">
                                <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value=""
                                   title="Fiche d'etat...">
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-sm-4 m-b-xs">
                            <div class="input-group">
                                <input type="text" class="input-sm form-control" placeholder="Search">
                                <span class="input-group-btn">
                          <button class="btn btn-sm btn-default" type="button">Go!</button>
                        </span>
                            </div>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper w-f">
                    <section class="panel panel-default bg-light lter">
                        <div class="table-responsive" id="view">
                            <table class="table table-striped m-b-none capitalize" id="approvalTable">
                                <thead>
                                <tr>
                                    <th width="1"></th>
                                    <th>Réference OT</th>
                                    <th>Immatriculation</th>
                                    <th>Chassis</th>
                                    <th>Car</th>
                                    <th>Date</th>
                                    <th width="5"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($repairs as $key=>$repair)
                                    <tr id="approval{{$repair->id}}">
                                        <td>{{$key + 1}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->reference}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->matriculation}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->chassis}}</td>
                                        <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
                                        <td>{{Jenssegers\Date\Date::parse($repair->update_at)->format('j M Y')}}</td>
                                        <td><a href="#" id="{{$repair->diagnostic_id}}" class="repair"
                                               data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                                               data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                                               data-ot="{{$repair->diagnostic->state->reference}}"
                                               data-kilometer="@if($repair->diagnostic->work->where('state','4')->isNotEmpty()){{$repair->diagnostic->work->where('state','4')->sum('distance') + $repair->diagnostic->work->where('state','1')->first()->distance + $repair->diagnostic->state->kilometer}}@else{{$repair->diagnostic->work->where('state','1')->first()->distance + $repair->diagnostic->state->kilometer}}@endif">
                                                <i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="cssload-container m-t-n-md none" id="spinner">
                            <div class="cssload-progress cssload-float cssload-shadow m-t-n-md">
                                <div class="cssload-progress-item"></div>
                            </div>
                        </div>
                    </section>
                </section>
            </section>
        </aside>
    </section>
    <div class="modal fade" id="validateModal">
        <div class="modal-dialog modal-lg">
            <form id="validateForm" action="" method="post" class="modal-content">
                {{csrf_field()}}
                {{method_field('put')}}
                <input name="repair" id="type" value="1" type="hidden">
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
                            <h4 style="" class="text-center m-t-n-xl font-thin m-l-lg text-dark-dker">APPROBATION DES
                                TRAVAUX DE
                                <span class="font-bold uppercase">Réparation</span></h4>
                        </div>
                    </section>
                </div>
                <div class="modal-body m-b-none">
                    <div class="row row-sm">
                        <section class="panel panel-info">
                            <header class="panel-heading bg-light">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#afterworks" data-toggle="tab">
                                            Essais apres travaux
                                        </a>
                                    </li>
                                    <li class=""><a href="#works" data-toggle="tab">Travaux effectués</a></li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="afterworks">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Choix
                                                        du Technicien</label>
                                                    <select class="chosen-select form-control input-sm before_works"
                                                            data-placeholder="Choisissez un technicien"
                                                            name="tester">
                                                        <option></option>
                                                        @foreach($technicians as $technician)
                                                            <option class="capitalize"
                                                                    value="{{$technician->id}}">{{$technician->username}}
                                                            </option>
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
                                                            <input type="number" name="leaving"
                                                                   class="form-control input-sm" id="depart"
                                                                   readonly>
                                                            <span class="input-group-btn">
                                                                                     <button class="btn btn-default btn-sm"
                                                                                             type="button">km</button>
                                                                                        </span>
                                                        </td>
                                                        <td width="1" class="m-t-sm">
                                                            Distance:
                                                        </td>
                                                        <td class="input-group">
                                                            <input type="number" name="distance"
                                                                   class="form-control input-sm"
                                                                   id="distance" required readonly>
                                                            <span class="input-group-btn">
                                                                                                 <button class="btn btn-default btn-sm"
                                                                                                         type="button">km</button>
                                                                                                </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Arrivé:</td>
                                                        <td class="input-group">
                                                            <input type="number" name="arrive"
                                                                   class="form-control input-sm"
                                                                   id="arrive" required>
                                                            <span class="input-group-btn">
                                                                                                 <button class="btn btn-default btn-sm"
                                                                                                         type="button">km</button>
                                                                                                </span>
                                                        </td>
                                                        <td>Lieu:</td>
                                                        <td class="input-group" width="100%">
                                                            <input type="text" name="place"
                                                                   class="form-control input-sm capitalize"
                                                                   required>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label class="control-label">Remarques</label>
                                                <textarea class="form-control input-sm" rows="4" minlength="6"
                                                          name="description"
                                                          id="remark"
                                                          required style="overflow: scroll"
                                                          placeholder="Saisissez les remarques des problemes constatés"></textarea>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="row m-t-md">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                        <span class="col-sm-12 font-bold text-success text-center"><i
                                                    class="fa fa-thumbs-up fa-2x"></i></span>
                                                            <div class="col-sm-12 m-t-sm m-b-sm"
                                                                 style="margin-left: 30px">
                                                                <label class="switch">
                                                                    <input type="radio" name="valid" value="5"
                                                                           required class="valid">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <label class="col-sm-12 control-label text-center uppercase font-bold text-success">Approuver!</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group text-danger">
                                        <span class="col-sm-12 font-bold text-center">
                                            <i class="fa fa-thumbs-down fa-2x"></i>
                                        </span>
                                                            <div class="col-sm-12 m-t-sm m-b-sm"
                                                                 style="margin-left: 30px">
                                                                <label class="switch">
                                                                    <input type="radio" name="valid" value="4"
                                                                           class="valid" required>
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                            <label class="col-sm-12 control-label text-center uppercase font-bold">Desapprouver!</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="works">
                                        <div class="panel-group m-b" id="accordionDescriptions">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal"><i
                                class="fa fa-close"></i></button>
                    <button type="submit" id="submit" class="btn btn-default btn-rounded uppercase">
                        <i class="i i-question"></i> Quelle est votre decision?
                    </button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script>
        var $repair = $('.repair'),
            $spinner = $('#spinner'),
            $car = $('#car'),
            $ot = $('#ot'),
            $matriculation = $('#matriculation'),
            $form = $('#validateForm'),
            $descriptions = $('#accordionDescriptions'),
            $valid = $('.valid'),
            $remark = $('#remark'),
            $file = $('#file'),
            $submit = $('#submit'),
            $modal = $('#validateModal'),
            $depart = $('#depart'),
            $arrive = $('#arrive'),
            $table = $('#approvalTable'),
            $filter = $('.filter'),
            $view = $('#view'),
            $type = $('#type'),
            $distance = $('#distance');

        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });
            $repair.on('click', function () {
                validate($(this))
            });
            $valid.on('click', function () {
                var id = $(this).val();
                if (id === '4') {
                    //$remark.attr('disabled', false);
                    $remark.val('');
                    $submit.removeClass('btn-success');
                    $submit.addClass('btn-danger');
                    $submit.html('<i class="i i-cancel"></i> Desapprouver les travaux');
                    $submit.val('invalid')
                } else {
                    $remark.val('Rien à Signaler');
                    //$remark.attr('disabled', true);
                    $submit.removeClass('btn-danger');
                    $submit.addClass('btn-success');
                    $submit.html('<i class="i i-checked"></i> Approuver les travaux');
                    $submit.val('valid')
                }
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
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'put',
                    url = $(this).attr('action'),
                    status = "warning",
                    msg = "LES TRAVAUX ONT ETE DESAPPROUVER";
                if ($submit.val() === 'valid') {
                    status = "success";
                    msg = "LES TRAVAUX ONT ETE APPROUVER";
                }
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
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
                        $('#approval' + data.id).remove();
                        $submit.button('reset');
                        $modal.modal('hide')
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
            $filter.on('click', function () {
                $spinner.show();
                var id = $(this).attr('id');
                if (id === '1'){
                    $type.attr('name', 'repair')
                }else if(id === '2'){
                    $type.attr('name', 'revision')
                }else {
                    $type.attr('name', 'visit')
                }
                $.get('home/'+id+'/edit', function (data) {
                    $view.html(data);
                    $spinner.hide();
                })
            })
        });
        function validate(obj) {
            $spinner.show();
            var id = $(obj).attr('id'),
                active = '',
                collapse = '';
            $car.html($(obj).attr('data-car'));
            $matriculation.html($(obj).attr('data-matriculation'));
            $ot.html($(obj).attr('data-ot'));
            $depart.val($(obj).attr('data-kilometer'));
            $form.attr('action', 'home/' + id);
            $.get('home/' + id, function (data) {
                $descriptions.empty();
                $.each(data, function (index, modelObj) {
                    if (index === 0) {
                        active = 'in'
                    }else {
                        collapse = 'collapsed';
                        active = ''
                    }
                    $descriptions.append('<div class="panel panel-info"><div class="panel-heading">' +
                        '<a class="accordion-toggle '+collapse+' capitalize" data-toggle="collapse" data-parent="#accordionDescriptions" href="#detail' + index + '">' +
                        '' + modelObj.title + ' <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' +
                        '' + modelObj.created_at + '</small></a></div>' +
                        '<div id="detail' + index + '" class="panel-collapse collapse ' + active + '" style="height: auto;">' +
                        '<div class="panel-body text-sm">' + modelObj.description + '</div> </div></div>');
                });
                $spinner.hide();
                $modal.modal('show');
            });
        }
    </script>
@endsection
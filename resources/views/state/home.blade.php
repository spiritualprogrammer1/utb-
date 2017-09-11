@section('title') Etat du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-white" id="page">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-bus"></i> RECEPTION DU CAR</p>
            <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value="" title="Fiche d'etat...">
                <i class="fa fa-file-pdf-o"></i>
            </a>
        </header>
        <section class="scrollable wrapper bg-light dker">
            <section class="scrollable padder">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                        <form id="wizardform" method="post">
                            {{csrf_field()}}
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <ul class="nav nav-tabs font-bold capitalize">
                                        <li><a href="#step1" data-toggle="tab">Choix du car</a></li>
                                        <li><a href="#step2" data-toggle="tab">Description des evenements</a></li>
                                        <li><a href="#step3" data-toggle="tab">Etat du car</a></li>
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
                                                    <div class="col-md-9">
                                                        <div class="row">
                                                            <section class="panel panel-info  m-t-n-md">
                                                                <header class="panel-heading font-bold">
                                                                    <h3 class="panel-title">Choisissez Le Car <i
                                                                                class="i i-checkmark"></i>
                                                                    </h3>
                                                                </header>
                                                                <div class="panel-body panel">
                                                                    <div class="row">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped m-b-none capitalize"
                                                                                   id="vehicleTable">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th>Immatriculation</th>
                                                                                    <th>Chassis</th>
                                                                                    <th>Marque</th>
                                                                                    <th>Modele</th>
                                                                                    <th><i class="i i-check"></i></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody id="vehicleRow">
                                                                                @foreach($buses as $key=>$bus)
                                                                                    <tr id="bus{{$bus->id}}"
                                                                                        class="animated fadeIn">
                                                                                        <td>{{$bus->designation}}</td>
                                                                                        <td class="text-danger-dk uppercase">{{$bus->matriculation}}</td>
                                                                                        <td class="text-danger-dk uppercase">{{$bus->chassis}}</td>
                                                                                        <td>{{$bus->model->brand->name}}</td>
                                                                                        <td>{{$bus->model->name}}</td>
                                                                                        <td width="10">
                                                                                            <div class="radio i-checks">
                                                                                                <label class="m-t-n-xl"
                                                                                                       style="width: 5px; height: 50px">
                                                                                                    <input type="radio"
                                                                                                           name="bus"
                                                                                                           value="{{$bus->id}}"
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
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="step2">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <section class="panel panel-info m-t-n-md">
                                                                <header class="panel-heading font-bold">
                                                                    <h3 class="panel-title">Descrivez les evenements</h3>
                                                                </header>
                                                                <div class="panel-body  panel">
                                                                    <div class="row">
                                                                        <div class="form-group m-b-md">
                                                                            <label class="col-sm-3 control-label m-t-xl"><b>Description de l'incident</b></label>
                                                                            <div class="col-sm-8">
                                                                                <textarea id="incident" name="incident" class="form-control input-sm" placeholder="Veuillez decrire l'incident survenu..."
                                                                                          data-trigger="change" data-required="true" minlength="6"  style="overflow:scroll;height:150px;max-height:150px"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group m-b-sm">
                                                                            <label class="col-sm-3 control-label m-t-xl"><b>Remarques eventuelles</b></label>
                                                                            <div class="col-sm-8">
                                                                                <textarea id="remark" name="remark" class="form-control m-t-md input-sm" placeholder="Veuillez decrire les Remarques eventuelles constatées..."
                                                                                          data-trigger="change" data-required="true" minlength="6"  style="overflow:scroll;height:150px;max-height:150px"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 m-b-md">
                                                        <label class="control-label">Kilometrage</label>
                                                        <div class="input-group">
                                                            <input type="number" name="kilometer" class="form-control input-sm input-numeric"
                                                                   data-trigger="change" data-required="true" data-typr="number" placeholder="0">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default btn-sm" type="button">km</button>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="step3">
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <section class="panel panel-info m-t-n-md">
                                                                <header class="panel-heading font-bold">
                                                                    <h3 class="panel-title">Etat du car</h3>
                                                                </header>
                                                                <div class="panel-body  panel">
                                                                    <div class="row">
                                                                        <div class="form-group m-b-md">
                                                                            @forelse($fields as $key=>$field)
                                                                                <div class="col-sm-3">
                                                                                    <label class="checkbox-inlinet i-checks m-r-md m-b-sm">
                                                                                        <input type="checkbox" value="{{$field->id}}" name="field[]"><i></i> {{strtoupper($field->name)}}
                                                                                    </label>
                                                                                </div>
                                                                            @empty
                                                                                Aucun etat disponible
                                                                            @endforelse
                                                                        </div>
                                                                        <div class="form-group m-b-xl text-center m-l-xl m-t-lg">
                                                                            <div class="col-md-5 m-l-xl">
                                                                                <div class="row">
                                                                                    <section class="panel panel-default m-t-md">
                                                                                        <header class="panel-heading font-bold">
                                                                                            <h3 class="panel-title text-sm">Enjoliveur <i class="fa fa-chevron-circle-down"></i></h3>
                                                                                        </header>
                                                                                        <div class="panel-body panel m-b-none">
                                                                                            <div class="text-center uppercase">
                                                                                                @forelse($trims as $key=>$trim)
                                                                                                    <label class="radio-inline i-checks">
                                                                                                        <input type="checkbox" class="input-sm" value="{{$trim->id}}" name="trim[]" ><i></i>{{$trim->name}}
                                                                                                    </label>
                                                                                                @empty
                                                                                                    Aucun enjoliveur disponible
                                                                                                @endforelse
                                                                                            </div>
                                                                                        </div>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4 m-l-md">
                                                                                <div class="row">
                                                                                    <section class="panel panel-default m-t-md">
                                                                                        <header class="panel-heading font-bold">
                                                                                            <h3 class="panel-title text-sm">Niveau de Carburant <i class="fa fa-chevron-circle-down"></i></h3>
                                                                                        </header>
                                                                                        <div class="panel-body  panel m-t-xs m-b-none">
                                                                                            <div class="m-t-sm text-center">
                                                                                                @forelse($fuels as $key=>$fuel)
                                                                                                    <label class="radio-inline i-checks">
                                                                                                        <input type="radio" name="fuel" class="input-sm m-t-xs"
                                                                                                               value="{{$fuel->id}}" required>
                                                                                                        <i></i>{{$fuel->name}}
                                                                                                    </label>
                                                                                                @empty
                                                                                                    Aucun niveau de carburant disponible
                                                                                                @endforelse
                                                                                            </div>
                                                                                        </div>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 m-b-lg">
                                                        <button class="btn btn-success btn-group-justified btn-sm uppercase" id="submit" type="submit">
                                                            <i class="fa fa-save"></i> enregistrer
                                                        </button>
                                                    </div>
                                                </div>

                                                <ul class="pager wizard m-b-sm">
                                                    <li class="previous first" style="display:none;"><a
                                                                href="#">First</a></li>
                                                    <li class="previous"><a href="#">Precedent</a></li>
                                                    <li class="next last" style="display:none;"><a href="#">Last</a>
                                                    </li>
                                                    <li class="next"><a href="#">Suivant</a></li>
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
        var $table = $('#vehicleTable'),
            $form = $('#wizardform'),
            $first = $('.first'),
            $file = $('#file'),
            $submit = $('#submit');
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
                    msg = "LA RECEPTION A ETE ENREGISTRE";
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
                        $file.removeClass('btn-defauld disabled');
                        $first.click();
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;
                        $submit.button('reset');
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
        })
    </script>
@endsection
@section('title') Essais apres travaux @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-md bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header">Filtre des travaux</div>
            <ul class="nav">
                <li class="b-b "><a href="#">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                        <i class="i i-settings"></i> Réparation</a>
                </li>
                <li class="b-b "><a href="#">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                        <i class="i i-gauge"></i> Révision</a>
                </li>
                <li class="b-b "><a href="#">
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-default" title="Refresh"><i
                                            class="fa fa-refresh"></i></button>
                                <button type="button" class="btn btn-sm btn-default" title="Remove"><i
                                            class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-sm btn-default" title="Filter"
                                        data-toggle="dropdown"><i class="fa fa-filter"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </div>
                            <a href="modal.html" data-toggle="ajaxModal" class="btn btn-sm btn-default"><i
                                        class="fa fa-plus"></i> Create</a>
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
                        <div class="table-responsive">
                            <table class="table table-striped m-b-none capitalize">
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
                                @forelse($repairs as $key=>$repair)
                                    <tr id="repair{{$repair->id}}">
                                        <td>{{$key + 1}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->reference}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->matriculation}}</td>
                                        <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->chassis}}</td>
                                        <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
                                        <td>{{Jenssegers\Date\Date::parse($repair->update_at)->format('j M Y')}}</td>
                                        <td><a href="#" id="{{$repair->id}}" class="repair"
                                               data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                                               data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                                               data-ot="{{$repair->diagnostic->state->reference}}">
                                                <i class="fa fa-pencil"></i></a></td>
                                    </tr>
                                @empty
                                @endforelse
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
                            <h4 style="" class="text-center m-t-n-xl font-thin m-l-lg text-dark-dker">APPROBATION DE
                                L'ESSAI APRES TRAVAUX</h4>
                        </div>
                    </section>
                </div>
                <div class="modal-body">
                    <div class="panel panel-info m-b-none">
                        <section class="panel panel-info col-sm-8">
                            <table class="table table-striped m-b-none" id="descriptionTable">
                                <thead>
                                <tr>
                                    <th width="30%">Intitulé</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody id="descriptionRow"></tbody>
                            </table>
                        </section>
                        <section class="panel col-sm-4">
                            <div class="row">
                                <label class="control-label">Remarques</label>
                                <textarea class="form-control input-sm" rows="8" minlength="6" name="remark"
                                          required style="overflow: scroll"></textarea>
                            </div>
                            <div class="row m-t-md">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="col-sm-12 font-bold text-success text-center"><i
                                                    class="fa fa-thumbs-up fa-2x"></i></span>
                                        <div class="col-sm-12 m-t-sm m-b-sm m-l-sm">
                                            <label class="switch">
                                                <input type="radio" name="valid" value="1" required>
                                                <span></span>
                                            </label>
                                        </div>
                                        <label class="col-sm-12 control-label text-center uppercase font-bold text-success">Approuver!</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-danger">
                                        <span class="col-sm-12 font-bold text-center"><i
                                                    class="fa fa-thumbs-down fa-2x"></i></span>
                                        <div class="col-sm-12 m-t-sm m-b-sm m-l-sm">
                                            <label class="switch">
                                                <input type="radio" name="valid" value="0" required>
                                                <span></span>
                                            </label>
                                        </div>
                                        <label class="col-sm-12 control-label text-center uppercase font-bold">Desapprouver!</label>
                                    </div>
                                </div>
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
@endsection
@section('scripts')
    <script>
        var $repair = $('.repair'),
            $spinner = $('#spinner'),
            $car = $('#car'),
            $ot = $('#ot'),
            $matriculation = $('#matriculation'),
            $form = $('#validateForm'),
            $description_table = $('#descriptionTable'),
            $description_row = $('#descriptionRow'),
            $modal = $('#validateModal');

        $(function () {
            $repair.on('click', function () {
                $spinner.show();
                var id = $(this).attr('id');
                $.get('home/' + id, function (data) {
                    $car.html($(this).attr('data-car'));
                    $matriculation.html($(this).attr('data-matriculation'));
                    $ot.html($(this).attr('data-ot'));
                    $form.attr('action', 'home/' + id);
                   $description_row.empty();
                    $.each(data, function (index, modelObj) {
                        $description_table.append('<tr><td>' + modelObj.title + '</td><td>' + modelObj.description + '</td></tr>');
                    });
                    $modal.modal('show');
                    $spinner.hide()
                });
            })
        });
    </script>
@endsection
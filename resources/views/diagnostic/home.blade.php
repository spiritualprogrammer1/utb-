@section('title') Diagnosti @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-white" id="page">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-bug"></i> DIAGNOSTIQUE DU CAR</p>
            {{--<a class="btn btn-sm btn-default disabled none btn-rounded btn-icon " id="file" data-value=""--}}
               {{--title="Fiche d'etat...">--}}
                {{--<img src="{{asset('img/pdf.png')}}" width="25">--}}
                {{--<i class="fa fa-file-pdf-o"></i>--}}
            {{--</a>--}}
            <a class="btn btn-sm btn-default disabled none  btn-rounded btn-icon " id="filep" data-value=""
               title="Fiche de diagnostic...">
                <img src="{{asset('img/pdf.png')}}" width="25">
                {{--<i class="fa fa-file-pdf-o"></i>--}}
            </a>

            <a class="btn btn-sm btn-default  none  btn-rounded btn-icon " id="filework" data-value=""
               title="Fiche essaie avant travaux...">
                <img src="{{asset('img/pdf1.jpg')}}" width="25">
                {{--<i class="fa fa-file-pdf-o"></i>--}}
            </a>
            <img src="{{asset('assets/images/Spinner.gif')}}" width="50" class="m-t-sm none"
                 id="file_load">
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
                                                                                       id="stateTable">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th></th>
                                                                                        <th>Ordre de Tavail</th>
                                                                                        <th>Immatriculation</th>
                                                                                        <th>Chassis</th>
                                                                                        <th>Marque</th>
                                                                                        <th>Modele</th>
                                                                                        <th>Date</th>
                                                                                        <th><i class="i i-check"></i></th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($states as $key=>$state)
                                                                                        <tr class="animated fadeIn"
                                                                                            id="state{{$state->id}}">
                                                                                            <td>{{$key + 1}}</td>
                                                                                            <td class="uppercase">{{$state->reference}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$state->bus->matriculation}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$state->bus->chassis}}</td>
                                                                                            <td>{{$state->bus->model->brand->name}}</td>
                                                                                            <td>{{$state->bus->model->name}}</td>
                                                                                            <td>{{$state->created_at->format('d/m/Y')}}</td>
                                                                                            <td width="10">
                                                                                                <div class="radio i-checks">
                                                                                                    <label class="m-t-n"
                                                                                                           style="width: 5px; height: 50px">
                                                                                                        <input type="radio"
                                                                                                               name="state"
                                                                                                               class="state"
                                                                                                               value="{{$state->id}}"
                                                                                                               data-trigger="change"
                                                                                                               data-required="true"
                                                                                                               data-error-message="Choissisez un Ordre de Travail, SVP">
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
                                                                            eventuelles </h3>
                                                                    </header>
                                                                    <div class="panel-body  panel">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <section class="panel panel-info">
                                                                                        <div class="panel-body">
                                                                                            <a href="#"
                                                                                               class="thumb pull-right m-l m-t-xs avatar">
                                                                                                <img src="{{asset('assets/images/Car_Repair_icon.png')}}">
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
                                                                            <div class="col-md-6" id="vehicle_history">
                                                                                <div class="row">


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
                                                                           data-required="true" name="accept"
                                                                           data-error-message="Accepter pour continuer"><i></i>
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
                                                                                            id="tester"
                                                                                            data-trigger="change"

                                                                                            >
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
                                                                                                   readonly
                                                                                                   data-error-message="La Distance est obligatoire">
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
                                                                                                   data-required="true",
                                                                                                   id="lieu"
                                                                                                   data-error-message="Saissisez le Lieu de l'essai">
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
                                                                                      id="descrip"
                                                                                      data-trigger="change"
                                                                                      data-required="true"
                                                                                      minlength="6"
                                                                                      data-error-message="Saissisez les Remarques effectuées pendand l'essai"
                                                                                      data-length="[6,30]"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 m-b-lg">
                                                            <div class="col-sm-2">
                                                                <a class="btn btn-danger" data_id="" id="befor_test" onclick="savetest(this)">SAUVEGARDER</a>
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
                                                    <div class="tab-pane" id="step4">
                                                        <div class="col-md-10">
                                                            <div class="row">
                                                                <section class="panel panel-info m-t-n-md">
                                                                    <header class="panel-heading font-bold">
                                                                        <h3 class="panel-title">Detection des
                                                                            pannes
                                                                            <a class="btn btn-sm btn-info uppercase m-l-lg"
                                                                                    id="diagnostic_add">
                                                                                <i class="fa fa-plus-square"></i>
                                                                                Ajouter un diagnostique
                                                                            </a>
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
                                                                                                                        data-error-message="Choissisez le Technician du Diagnostic"
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
                                                                                                                       data-error-message="Saissisez l'Intitulé ou Sujet du Diagnostic"
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
                                                                                                  data-length="6"
                                                                                                  rows="2"
                                                                                                  data-error-message="Saissisez les Details du diagnostic"
                                                                                                  placeholder="Detail du diagnostic"></textarea>
                                                                                                    </div>
                                                                                                </section>
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
                                                            <label class="control-label"><i
                                                                        class="fa fa-paper-plane-o"></i>
                                                                Prestation</label>
                                                            <select class="chosen-select form-control input-sm"
                                                                    data-placeholder="Choissisez la prestation"
                                                                    name="service"
                                                                    data-trigger="keyup"
                                                                    data-required="true">
                                                                <option></option>
                                                                <option class="capitalize" value="1">Reparation</option>
                                                                <option class="capitalize" value="2">Revision</option>
                                                                <option class="capitalize" value="3">Visite Technique
                                                                </option>
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
    <table class="table" id="pieceAdd">
        <tbody>
        <tr>
            <td>
             <textarea class="form-control input-sm"
                       name="piece[]"
                       id="piece"
                       placeholder="Nom piece + Marque & Model"
                       rows="2" required></textarea>

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
    <div class="modal fade" id="diagnosModal">
        <div class="modal-dialog modal-lfg" style="width: 700px;">
            <div class="modal-content" id="file_content">
            </div>
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/parsley/parsley.min.js')}}"></script>
    <script src="{{asset('assets/js/wizard/jquery.bootstrap.wizard.js')}}"></script>
    <script src="{{asset('assets/js/wizard/demo.js')}}"></script>
    <script>
        var $table = $('#stateTable'),
            $form = $('#wizardform'),
            $first = $('.first'),
            $file = $('#file'),
                $filep=$('#filep'),
            $submit = $('#submit'),
                $modale = $('#diagnosModal'),
                $file_content=$('#file_content'),
            $remark = $('#remark'),
                $file_load=$('#file_load'),
            $incident = $('#incident'),
                $filework=$('#filework'),
            $matriculation = $('.matriculation'),
            $vehicle = $('.vehicle'),
            $ot = $('.ot'),
                $vehicle_history=$('#vehicle_history'),
            $state = $('.state'),
              $count_diagnostique=$('#count_diagnostique'),
                $approvalpiece=$('#approvalpiece'),
            $depart = $('#depart'),
            $arrive = $('#arrive'),
            $distance = $('#distance'),
            $test = $('#test'),
            $piece_add = $('#piece_add'),
            $diagnostic_add = $('#diagnostic_add'),
            $chosen = $('.chosen-select'),
            $spinner = $('#spinner');
//         $file.hide();
//        $filework.hide();


        function savetest(obj) {
          var state_id = $('#befor_test').val();

            var  arrive=$arrive.val(),
                leaving=$('#depart').val(),
                distance=$('#distance').val(),
                lieu=$('#lieu').val(),
                tester=$('#tester').val(),
                descrip=$('#descrip').val(),
                arrive=$('#arrive').val();

            if(leaving==" " || distance==" " || lieu==" " || descrip=="" || arrive=="")
            {
                toastr["warning"]('Veuillez entré les données svp!')
            }
            else{
                $.get('savetest/' + state_id +'/' +leaving +'/'+ distance+'/'+ lieu +'/'+tester +'/'+descrip +'/'+arrive, function (data) {

                    toastr["success"]('essaie enregistré')
//               $('#befor_test').prop(disabled, true);
                    $arrive.val(" ");
                    $('#depart').val(" ");
                    $('#distance').val(" ");
                    $('#lieu').val(" ");
//               $('#tester').val("")
                    $('#descrip').val(" ")
                    $('#arrive').val("")
                 //   $view_work.html(data);
                    $filework.attr({"id": data.before_test});
                    $filework.attr({"data-value": data.before_test});
                    $filework.show()
                });

            }


        }


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
                        $chosen.trigger('chosen:updated');
                        $filep.attr('data-value', data.diagnostic_id);
                        $filep.removeClass('btn-default disabled none');
                        $filep.addClass('btn-danger');
                        $filep.removeClass('btn-default disabled none');

                        $filework.attr('data-value',data.work_id);
                        $filework.addClass('btn-warning');
                        $filework.removeClass('btn-default disabled none');
                        $('#state' + data.id).remove();
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;
                        $submit.button('reset');
                        $first.click();
                        score();
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






            $filep.on('click', function () {
                $file_load.removeClass('none')
                var id = $(this).attr('data-value');
                $.get('filesdiagnostique/' + id, function (data) {
                    $file_content.html(data);
                    $modale.modal('show')
                    $file_load.hide();
                })
            });

            $filework.on('click',function () {
                $file_load.removeClass('none')

                var id = $(this).attr('data-value');
                $.get('filesworks/' + id, function (data) {
                    $file_content.html(data);
                    $modale.modal('show')
                     $file_load.hide()
                })

            })





            $state.on('click', function () {
                $spinner.show();
                var id = $(this).val();
                $('#befor_test').val(id);
                $.get('home/' + id, function (data) {
                    $incident.html(data.incident);
                    $remark.html(data.remark);
                    $matriculation.html(data.matriculation);
                    $vehicle.html(data.bus);
                    $ot.html(data.ot);

                    $('#depart').val(data.depart)
                    $('#depart').prop('readonly', true);
                    $('#distance').val(data.distance),
                        $('#distance').prop('readonly', true);

                        $('#lieu').val(data.place),
                        $('#lieu').prop('readonly', true);
                        $('#tester').val(data.employee),
                        $('#tester').prop('readonly', true);
                    $('#tester').trigger("chosen:updated");
                        $('#descrip').val(data.description),
                            $('#descrip').prop('readonly', true);
                       $('#arrive').val(data.arrive);
                    $('#arrive').prop('readonly',true);

                    if(data.employee == undefined)
                    {

                        $('#befor_test').show();
                        $('#arrive').prop('readonly',false);
                        $('#descrip').prop('readonly', false);
                        $('#lieu').prop('readonly', false);
                        $('#depart').prop('readonly', false);
                        $('#tester').prop('readonly', false);
                        $('#distance').prop('readonly', false);

                    }
                    else{
                        $('#befor_test').hide();
                    }


                    $depart.val(data.depart);
                    $.get('bus_history/' + data.bus_id, function (data) {
                        $vehicle_history.html(data);

                    });
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
                $table.append($('#pieceAdd tbody tr:last').clone());
                var rows = $('#pieceTable tr');

                var count = rows.length,
                    lastRow = rows[count - 1],
                    text_area = $(lastRow).find('textarea'),
                    text_input = $(lastRow).find('input');

                text_area.eq(0).attr('id', 'piece' + count);
                text_input.eq(0).attr('id', 'quantity' + count);
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


            function score()
            {
                $.get('score',function(data){
                    $count_diagnostique.html(data.diagnostic_count);
                    $approvalpiece.html(data.demans);
                })
            }
        });
    </script>
@endsection
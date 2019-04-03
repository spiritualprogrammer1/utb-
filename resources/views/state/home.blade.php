@section('title') Etat du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-white" id="page">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-bus"></i> RECEPTION DU CAR</p>
            <a class="btn btn-sm btn-default disabled btn-rounded btn-icon" id="file" data-value="" title="Fiche de réception...">
                <i class="fa fa-file-pdf-o"></i>

            </a>
            <img src="{{asset('assets/images/loading.gif')}}" class="m-t-sm none"
                 id="file_loader">
        </header>
        <section class="scrollable wrapper bg-light dker">
            <section class="scrollable padder">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <form id="wizardform" method="post" enctype="multipart/form-data">
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
                                                                                <table class="table table-striped m-b-nones capitalize"
                                                                                       id="vehicleTable">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Marque</th>
                                                                                        <th>Immatriculation</th>
                                                                                        <th>Chassis</th>
                                                                                        <th>Modele</th>
                                                                                        <th>Année de circulation</th>
                                                                                        <th><i class="i i-check"></i></th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody id="vehicleRow">
                                                                                    @foreach($buses as $key=>$bus)
                                                                                        <tr id="bus{{$bus->id}}"
                                                                                            class="animated fadeIn">
                                                                                            <td>{{$bus->model->brand->name}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$bus->matriculation}}</td>
                                                                                            <td class="text-danger-dk uppercase">{{$bus->chassis}}</td>
                                                                                            <td>{{$bus->model->name}}</td>
                                                                                            <?php

                                                                                            $start_date = new DateTime(date('d-m-Y',strtotime($bus->first_circulation)));
                                                                                            $end_date = new DateTime(date('d-m-Y'));
                                                                                           $dd = date_diff($start_date,$end_date);
                                                                                              //  dd($start_date);


//                                                                                            $date1= strtotime($bus->created_at->format('d-m-Y'));
//                                                                                                 $date2 = strtotime(Jenssegers\Date\Date::now()->format('d-m-Y'));
//                                                                                            $nbJoursTimestamp = $date2 - $date1;
//                                                                                            $nbjours = $nbJoursTimestamp/86400;
                                                                                            ?>
                                                                                            <td><span class="text-info">{{$dd->d}} jours</span> <span class="">{{$dd->m}} mois</span> <span class="text-danger">{{$dd->y}} année</span> </td>
                                                                                            <td width="1">
                                                                                                <div class="radio i-checks" style="margin-top: 0">
                                                                                                    <label class="">
                                                                                                        <input type="radio"
                                                                                                               name="bus"
                                                                                                               class="car_id"

                                                                                                               value="{{$bus->id}}"
                                                                                                               data-trigger="change"
                                                                                                               data-required="true"
                                                                                                               data-error-message ="Choissisez un Car, SVP!">
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
                                                                                          data-trigger="change" data-required="true" data-length="[6,300]"
                                                                                          data-error-message ="Saissisez la Description de l'incident, SVP!"
                                                                                          style="overflow:scroll;height:150px;max-height:150px"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group m-b-sm">
                                                                                <label class="col-sm-3 control-label m-t-xl"><b>Remarques eventuelles</b></label>
                                                                                <div class="col-sm-8">
                                                                                <textarea id="remark" name="remark" class="form-control m-t-md input-sm" placeholder="Veuillez decrire les Remarques eventuelles constatées..."
                                                                                          data-trigger="change" data-required="true" minlength="6"
                                                                                          data-error-message ="Saissisez les Remarques eventuelles, SVP!"
                                                                                          style="overflow:scroll;height:150px;max-height:150px"></textarea>
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
                                                                       data-trigger="change" data-required="true" data-typr="number" placeholder="0"
                                                                       data-error-message ="Entrer le kilmetrage du véhicule, SVP!">
                                                                <span class="input-group-btn">
                                                                <button class="btn btn-default btn-sm" type="button">km</button>
                                                                </span>
                                                            </div>
                                                            {{--<label class="control-label">Kilometrage/moteur</label>--}}
                                                            {{--<div class="input-group" id="kilometer_engine">--}}
                                                                {{--<input type="number" class="kilometer_eng"  name="kilometer_engine" class="form-control input-sm input-numeric"--}}
                                                                       {{--data-trigger="change" data-required="true" data-typr="number" placeholder="0"--}}
                                                                       {{--data-error-message ="Entrer le kilmetrage du moteur, SVP!">--}}
                                                                {{--<span class="input-group-btn">--}}
                                                                {{--<button class="btn btn-default btn-sm" type="button">km</button>--}}
                                                                {{--</span>--}}
                                                            {{--</div>--}}
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
                                                                                                            <input type="checkbox" class="input-sm" value="{{$trim->id}}" name="trim[]"><i></i>{{$trim->name}}
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
                                                                                                            <input type="radio" name="fuel[]" class="input-sm m-t-xs"
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
                                                                            <div class="form-group ">
                                                                                <div class="col-sm-12">
                                                                                    <h5><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"
                                                                                                                                                      id="accident" name="accident"><i></i>ACCIDENT? </label></h5>
                                                                                    <div class="panel-danger panel" id="accessShow">
                                                                                        <div class="form-group col-md-4" >
                                                                                            <label for="email"></i>Nom du chauffeur</label>
                                                                                            <input type="text" name="driver_name" id="driver_name"
                                                                                                   class="form-control" placeholder="Entrer le nom du chauffeur" >
                                                                                        </div>

                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="email"></i>Lieu</label>
                                                                                            <input  id="lieu" name="lieu" type="text"  class="form-control input-sm"
                                                                                                    placeholder="Description" >
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="control-label"><i class="fa fa-number"></i> Date </label>
                                                                                            <input type="text" name="date_accident" id="date_accident"
                                                                                                   class="form-control date" placeholder="Entrer date de l accident" >
                                                                                        </div>
                                                                                        <div class="form-group col-md-9">
                                                                                            <label for="email"></i>Description de l'accident</label>
                                                                                            <input  id="description_accident" name="description_accident" type="text"  class="form-control input-sm"
                                                                                                    placeholder="Description" >
                                                                                        </div>





                                                                                    </div>

                                                                                </div>
                                                                                <div class="col-sm-12">
                                                                                    <h5><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"
                                                                                                                                                      id="panne_gar" name="panne_gar"><i></i><strong class="text-danger">PANNE EN GAR ?</strong>  </label></h5>


                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-12">
                                                                                <div class="row">
                                                                                    <div class="clsbox-1" runat="server">
                                                                                        <input placeholder="deposer ici"   type="file" name="image_voi[]">
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
    <div class="modal fade" id="stateModal">
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
        var $table = $('#vehicleTable'),
                $form = $('#wizardform'),
                $first = $('.first'),
                $file = $('#file'),
                $modal=$('#stateModal'),
                $count_diagnostique =$('#count_diagnostique');
        $file_loader = $('#file_loader'),
                $file_content = $('#file_content'),
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

            $('.car_id').on('click',function () {
                id=$(this).val();


                $.get('data_car/'+id,function (data) {

                    if(data.kilometer_engine==null)
                    {
                        $('.kilometer_eng').removeAttr('data-trigger');
                        $('.kilometer_eng').removeAttr('data-required');
                        $('#kilometer_engine').hide();

                    }
                    else{
                        $('#kilometer_engine').show();
                        $('#kilometer_engine').val(data.kilometer_engine);
                        $('.kilometer_eng').addAttr('data-trigger');
                        $('.kilometer_eng').addAttr('data-required');
                    }






                })
            });




            $form.on('submit', function (e) {
                e.preventDefault();
//                var formData = $(this).serialize(),
                var formData = new FormData($(this)[0]);
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
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $form.trigger('reset');
                        score();
                        $file.attr('data-value', data.id);
                        $file.addClass('btn-danger');
                        $file.removeClass('btn-defauld disabled');
                        $first.click();
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;

                        $submit.button('reset');
                        $file.show();
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


            $file.on('click', function () {
                $file_loader.show();

                var id = $(this).attr('data-value');
                $.ajax({
                    url: '{{url('state/filestate')}}/'+id,
                    type: 'get',
                    data: id,
                    success: function (data) {
                        $file_content.html(data);
                        $modal.modal('show');
                        $file_loader.hide();
                    },
                });


            });

            function score()
            {
                $.get('score',function (data) {
                    $count_diagnostique.html(data)
                })
            }
        })
        $('#accessShow').hide();
        $("#accident").on("click", function () {
            console.log('sd');
            var check;
            check = $("#accident").is(":checked");
            if (check) {
                $("#accessShow").fadeIn('slow');
                var password = document.getElementById("password")
                    , confirm_password = document.getElementById("confirm_password");

                function validatePassword() {
                    if (password.value != confirm_password.value) {
                        confirm_password.setCustomValidity("Les 2 mot de passe ne correspondent pas");
                    } else {
                        confirm_password.setCustomValidity('');
                    }
                }

                password.onchange = validatePassword;
                confirm_password.onkeyup = validatePassword;
                $('#password').attr("required", true);
                $('#confirm_password').attr("required", true);
            } else {
                $("#accessShow").fadeOut('slow');
                $('#password').attr("required", false);
                $('#confirm_password').attr("required", false);
            }
        });

        $(document).ready(function() {

            // enable fileuploader plugin
            $('input[name="image_voi[]"]').fileuploader({
                extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
                changeInput: ' ',
                theme: 'thumbnails',
                enableApi: true,
                addMore: true,
                thumbnails: {
                    box: '<div  class="fileuploader-items"  >' +
                    '<ul class="fileuploader-items-list">' +
                    '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner" style="width: 300px;height: 110px" style="font-size: 10px">Ajouter une photo</div></li>' +
                    '</ul>' +
                    '</div>',
                    item: '<li class="fileuploader-item" >' +
                    '<div class="fileuploader-item-inner" >' +
                    '<div class="thumbnail-holder" >${image}</div>' +
                    '<div class="actions-holder" >' +
                    '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                    '</div>' +
                    '<div class="progress-holder">${progressBar}</div>' +
                    '</div>' +
                    '</li>',
                    item2: '<li class="fileuploader-item"   >' +
                    '<div class="fileuploader-item-inner" >' +
                    '<div class="thumbnail-holder" >${image}</div>' +
                    '<div class="actions-holder">' +
                    '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</li>',
                    startImageRenderer: true,
                    canvasImage: false,
                    _selectors: {
                        list: '.fileuploader-items-list',
                        item: '.fileuploader-item',
                        start: '.fileuploader-action-start',
                        retry: '.fileuploader-action-retry',
                        remove: '.fileuploader-action-remove'
                    },
                    onItemShow: function(item, listEl) {
                        var plusInput = listEl.find('.fileuploader-thumbnails-input');

                        plusInput.insertAfter(item.html);

                        if(item.format == 'image') {
                            item.html.find('.fileuploader-item-icon').hide();
                        }
                    }
                },
                afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                            api = $.fileuploader.getInstance(inputEl.get(0));

                    plusInput.on('click', function() {
                        api.open();
                    });
                },
            });

        });


    </script>
@endsection
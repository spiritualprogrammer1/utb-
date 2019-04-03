@section('title') Gestion utilisateurs @endsection
@extends('layouts.master')
@section('content')
    <section class="scroll-x hbox stretch ">

        <aside class="aside-lg bg-light dker b-r" id="subNav">
            <div class="" style="position: relative;height: 600px;overflow: scroll">

            <section >
                <form method="post" action="{{route('index.store')}}" id="userForm" role="form" class="panel b-a bg-light lter" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="panel-body panel-danger" style="margin-top: 25px">
                        <h4 class="font-thin text-center m-t-n-sm alert-alert-info" >RECHERCHER UN UTILISATEUR</h4>
                        <div class="form-group">
                            <label>Choisissez le L'utilisateur</label>
                            <select name="user" id="user" class="chosen-select form-control input-sm"
                                    data-placeholder="Selectionnez le site" >
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" class="text-uppercase text-info">{{$user->first_name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </form>
            </section>

            </div>
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
                            <h4><i class="fa fa-users text-info-lter"></i> INFORMATION DE L'UTILISATEUR</h4>
                        </div>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#userTable').tableExport({type:'xlsx',escape:'false'});">
                                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default"
                               onClick="$('#userTable').tableExport({type:'pdf',escape:'false'});">
                                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
                            </a>
                            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                               onClick="$('#userTable').tableExport({type:'csv',escape:'false'});">
                                <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                            </a>
                        </div>
                    </div>
                </header>
                <section class="scrollable wrapper wrapper wrapper pull-center " id="data_user" >
                    {{--<section class="panel panel-default" id="view">--}}
                        {{--<div class="table-responsive">--}}
                            {{--<div class="row">--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<label class="control-label col-md-2"> Nom </label>--}}
                                    {{--<input  type="text" name="name" id="name"--}}
                                           {{--class="form-control col-md-4" placeholder="Entrer le nom" >--}}

                                {{--</div>--}}
                                {{--<div class="form-group col-md-6">--}}
                                    {{--<label class="control-label"> Prenom </label>--}}
                                    {{--<input type="text" name="username" id="username"--}}
                                           {{--class="form-control date" placeholder="Entrer le nom" >--}}

                                {{--</div>--}}

                            {{--</div>--}}
                            {{--<div class="row">--}}

                                {{--<div class="form-group col-md-6">--}}
                                    {{--<label class="control-label"> Email </label>--}}
                                    {{--<input type="text" name="name" id="name"--}}
                                           {{--class="form-control date" placeholder="Entrer le nom" >--}}

                                {{--</div>--}}
                                {{--<div class="form-group col-md-6">--}}
                                    {{--<label class="control-label"> Service </label>--}}
                                    {{--<input type="text" name="username" id="username"--}}
                                           {{--class="form-control date" placeholder="Entrer le nom" >--}}

                                {{--</div>--}}

                            {{--</div>--}}
                            {{--<div class="panel-group">--}}
                                {{--<div class="panel panel-default">--}}
                                    {{--<div class="panel-heading">--}}
                                        {{--<h4 class="panel-title">--}}
                                            {{--<a data-toggle="collapse" href="#collapse1">Cliquer pour voir les roles</a>--}}
                                        {{--</h4>--}}
                                    {{--</div>--}}
                                    {{--<div id="collapse1" class="panel-collapse collapse">--}}
                                        {{--<div class="row">--}}
                                            {{--{!! Form::open(array('route' => 'post_permission','method'=>'POST','id'=>'roleform')) !!}--}}
                                            {{--{{csrf_field()}}--}}
                                            {{--<input type="hidden" name="id" value="{{$role->id}}">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-md-12 text-center">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<strong style="color: #0d5e92">Permission:</strong>--}}
                                                        {{--<br/>--}}

                                                        {{--@foreach($permission as $value)--}}
                                                            {{--<label>{!! Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions->toArray()) ? true : false, array('class' => 'name'),'required') !!}--}}
                                                                {{--{{ $value->display_name }}</label>  ||--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-xs-12 col-sm-12 col-md-12 text-center">--}}
                                                    {{--<button type="submit" id="rolesend" class="btn btn-primary" value="enregistrer"><i class="fa fa-floppy-o"></i>Enregistrer</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--{!! Form::close() !!}--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<button class="btn btn-primary ">--}}
                                {{--Modifier--}}
                            {{--</button>--}}

                        {{--</div>--}}
                    {{--</section>--}}
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
        var $table = $('#userTable'),
            $chosen = $('.chosen-select'),
            $submit = $('#submit'),
            $row = $('#row'),
            $form = $('#userForm');
        $service=$('#service');
        $poste=$('#poste');
        $loader_ray=$('#loader_ray');
        $user =$('#user');
        $('#accessShow').hide();
        $(function () {


            $user.on('change',function(){
                $('.cssload-container').show();

                id = $user.val()


                $.get('fetch_data_user?id=' + id, function (data) {

                    $('#data_user').html(data).fadeIn()

                    $('.cssload-container').hide()
                })

            });


            $("#access").on("click", function () {
                console.log('sd');
                var check;
                check = $("#access").is(":checked");
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
                var formData = new FormData($(this)[0]);
                    type = 'post',
                    url = '{{route('index.store')}}',
                    status = "success",
                    msg = "LE COMPTE A BIEN ETE CREER";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
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
                        $chosen.trigger('chosen:updated');
                        toastr[status](msg, "<span class='uppercase'>" + data.username + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="user' + data.id + '" class="alert alert-info text-danger-dk font-bold">' +
                            '<td>' + data.username + '</td>' +
                            '<td>' + data.mobile + '</td>' +
                                '<td class="text-lowercase">' + data.email + '</td>' +
                            '<td>'+ data.service +'</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" >' +
                            '<i class="fa fa-pencil"></i></a></td><tr>';
                        $('#userRow').append(row);
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
        });
//        var password = document.getElementById("password")
//            , confirm_password = document.getElementById("confirm_password");
//
//        function validatePassword() {
//            if (password.value != confirm_password.value) {
//                confirm_password.setCustomValidity("Les 2 mot de passe ne correspondent pas");
//            } else {
//                confirm_password.setCustomValidity('');
//            }
//        }
//        password.onchange = validatePassword;
//        confirm_password.onkeyup = validatePassword;

        $service.on('change',function() {
            id =$(this).val();
            $poste.empty();
            $loader_ray.show();
            $.get('fetch_poste?id=' + id, function (data) {
                $.each(data, function (index, modelObj) {
                    $poste.append('<option value="' + modelObj.id + '">' + modelObj.name + '</option>');
                    $poste.trigger("chosen:updated");
                })
                $loader_ray.hide();
            })

        });

        var btnCust = '<button type="button" class="btn btn-default" title="" ' +
                'onclick="console(\'\')">' +
                '<i class="glyphicon glyphicon-tag"></i>' +
                '</button>';
        $("#avatar-2").fileinput({
            overwriteInitial: true,
            maxFileSize: 500000,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'supprimer le fichier ',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="{{asset('logo/pcture_user.png')}}" alt="Your Avatar" style="width:125px"><h6 class="text-muted"></h6>',
            layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
            allowedFileExtensions: ["docx","pdf","jpg", "png", "gif"]
        });


    </script>
@endsection
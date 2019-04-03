@section('title') Gestion utilisateurs @endsection
@extends('layouts.master')
@section('content')
    <section class="scroll-x hbox stretch ">

        <aside class="aside-lg bg-light dker b-r">
            <div class="" style="position: relative;height: 600px;overflow: scroll">

            <section>
                <form method="post" action="{{route('store')}}" id="userForm" role="form" class="panel b-a bg-light lter" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="user" value="1">
                    <div class="panel-body panel-danger">
                        <h4 class="font-thin text-center m-t-n-sm">AJOUTER UN UTILISATEUR</h4>
                        <div class="form-group">
                            <label>Choisissez le site</label>
                            <select name="site" id="site" class="chosen-select form-control input-sm"
                                    data-placeholder="Selectionnez le site" >
                                <option></option>
                                @foreach($sites as $site)
                                    <option value="{{$site->id}}">{{$site->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Choisissez le service</label>
                            <select name="service" id="service" class="chosen-select form-control input-sm"
                                    data-placeholder="Selectionnez le service" >
                                <option></option>
                                @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">

                            <div class="row">
                                <div class="col-sm-1">
                                    <img src="{{asset('img/loading.gif')}}"  style="position: absolute"
                                         class="m-t-md m-l-n-sm none"
                                         id="loader_ray" width="20">
                                </div>
                           <div class="col-sm-10">
                               <label>Choisissez le poste</label>
                               <select class="chosen-select form-control input-sm"
                                       id="poste" name="poste">
                                   <option value disabled selected>
                                       ............................
                                   </option>
                               </select>
                           </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nom</label>
                            <input type="text" name="last_name" min="3" id="name"
                                   class="form-control input-sm text-primary-dk input"
                                   placeholder="Entrez le nom de l'utilisateur" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Prénoms</label>
                            <input type="text" name="first_name" min="3"
                                   class="form-control input-sm text-danger-dk input"
                                   placeholder="Entrez le prenom de l'utilisateur" required>
                        </div>
                        <div class="form-group">
                            <div class="row">
                        <div class="col-sm-4">
                                <div class="kv-avatar center-block text-center" style="width:200px">
                                    <input id="avatar-2" name="image" type="file" class="file-loading" >
                                </div>
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mobile</label>
                            <input type="text" name="mobile" min="3"
                                   class="form-control input-sm text-danger-dk input"
                                   placeholder="Numero de telephone" required>
                        </div>


                        <h5><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"
                                                                                          id="access" name="access"><i></i>Donneer
                                un acces? </label></h5>
                        <div class="panel-danger panel" id="accessShow">
                        <div class="form-group">
                            <label class="control-label">Adresse E-mail</label>
                            <input type="text" name="email" min="3"
                                   class="form-control input-sm text-danger-dk input"
                                   placeholder="Adresse e-mail" >
                        </div>
                        <div class="form-group-sm">
                            <label class="control-label">Mot de passe</label>
                            <input type="password" name="password" id="password"
                                   class="form-control input-sm" min="8"
                                   placeholder="Mot de passe du compte" >
                        </div>
                        <div class="form-group">
                            <label>Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="confirm_password"
                                   class="form-control input-sm"
                                   placeholder="Re-ssaisisez le mot de passe" >
                        </div>
                        </div>
                        <button type="submit" value="save" id="submit"
                                class="btn btn-success btn-group-justified input-sm uppercase m-t-md">
                            <i class="fa fa-floppy-o"></i> enregistrer le compte
                        </button>
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
                            <h4><i class="fa fa-bus"></i> GESTION DES UTILISATEURS</h4>
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
                <section class="scrollable wrapper">
                    <section class="panel panel-default" id="view">
                        <div class="table-responsive">
                            <table class="table datatable table-responsive table-striped m-b-none capitalize"
                                   id="userTable">
                                <thead>
                                <tr>
                                    <th>Nom & Prénoms</th>
                                    <th>Téléphone</th>
                                    <th>E-mail</th>
                                    <th>service</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                    <th><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody id="userRow">
                                @foreach($employes as $key=>$employe)
                                    <tr id="user{{$employe->id}}" class="animated fadeInDown">
                                        <td>{{$employe->username}}</td>
                                        <td>{{$employe->mobile}}</td>
                                        <td class="text-lowercase">{{$employe->email}}</td>
                                        <td>{{$employe->service->name}}</td>
                                        <td>{{Jenssegers\Date\Date::parse($employe->created_at)->format('j F Y')}}</td>
                                        <td><a href="#" id="{{$employe->id}}" class="bus"><i
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
        var $table = $('#userTable'),
            $chosen = $('.chosen-select'),
            $submit = $('#submit'),
            $row = $('#row'),
            $form = $('#userForm');
        $service=$('#service');
        $poste=$('#poste');
        $loader_ray=$('#loader_ray');
        $('#accessShow').hide();
        $(function () {
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
                    url = '{{route('store')}}',
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
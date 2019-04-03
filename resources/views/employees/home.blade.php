@section('title') Gestion des Employés @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-users2"></i> NOUVEAU COMPTE</p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-users2"></i></a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#employeeTable').tableExport({type:'excel',escape:'false'});">
                    <img src='{{asset('assets/images/icons/xls.png')}}' width="20"/> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onClick="$('#employeeTable').tableExport({type:'pdf',escape:'false'});">
                    <img src='{{asset('assets/images/icons/pdf.png')}}' width="20"/> Pdf
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#employeeTable').tableExport({type:'csv',escape:'false'});">
                    <img src='{{asset('assets/images/icons/csv.png')}}' width="20"/> CSV
                </a>
            </div>
        </header>
        <section class="scrollable">
            <section class="hbox">
                <!-- .aside -->
                <aside class="aside-lg bg-light dker wrapper">
                    <form  method="post" role="form" id="employeeForm" class="panel b-a bg-light">
                        {{csrf_field()}}
                        <div class="panel-body">
                            <div class="form-group">
                                <label for=""><i class="i i-cube"></i> Service</label>
                                <select class="chosen-select input-sm form-control" name="service" id="service" required>
                                    <option value selected disabled>Choisissez un service....</option>
                                    @forelse($services as $key=>$service)
                                        <option value="{{$service->id}}">{{strtoupper($service->display_name)}}</option>
                                    @empty
                                        <option value selected disabled>Aucun Service Disponible</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for=""><i class="i i-cube"></i> Poste</label>
                                <select class="chosen-select input-sm form-control" name="post" id="post" required>
                                    <option value selected disabled>Choisissez un poste....</option>
                                    @forelse($posts as $key=>$post)
                                        <option value="{{$post->id}}">{{strtoupper($post->name)}}</option>
                                    @empty
                                        <option value selected disabled>Aucun Poste Disponible</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <div id="divRccm">
                                    <label for="last_name"><i class="i i-user3"></i> Nom</label>
                                    <input class="form-control input-sm" id="name" type="text" minlength="3" name="last_name"
                                           placeholder="Nom de l'utilisateur" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name"><i class="i i-user3"></i> Prénom</label>
                                <input class="form-control input-sm" type="text" minlength="3" id="first_name" name="first_name"
                                       placeholder="Prenom de l'utilisateur" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class=" col-sm-4">
                                                <label for="phone">Indicatif</label>
                                                <input class="form-control phonecode input-sm"
                                                       value="+225" name="indicatif" readonly>
                                            </div>
                                            <div class="col-sm-8">
                                                <label for="mobile"><i class="i i-phone3"></i> Mobile</label>
                                                <input name="mobile" id="mobile" type="number" minlength="8" class="form-control input-sm"
                                                       placeholder="Numero mobile">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="i i-mail"></i> Adresse e-mail</label>
                                <input name="email" id="email" type="email" minlength="3" class="form-control input-sm"
                                       placeholder="Entrer l'adresse de messagerie" required>
                            </div>
                            <h5><label class="checkbox m-l m-t-none m-b-none i-checks"><input type="checkbox"  id="access" name="access"><i></i>Donneer un acces? </label></h5>
                            <div class="panel-danger panel" id="accessShow">
                                <div class="form-group">
                                    <label class="control-label"><i class="fa fa-lock"></i> Mot de passe</label>
                                    <input type="password" name="password" id="password" minlength="6"
                                           class="form-control input-sm" placeholder="Entrer le mot de passe">
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><i class="fa fa-lock"></i> Confirmez le mot de passe</label>
                                    <input type="password" name="password_confirmation" minlength="6" id="confirm_password"
                                           class="form-control input-sm" placeholder="Re-saisissez le mot de passe">
                                </div>
                            </div>
                            <button type="submit" style="text-transform: uppercase" value="save" id="submit"
                                    class="btn btn-success btn-group-justified input-sm">
                                <i class="fa fa-floppy-o"></i> Enregistrer
                            </button>

                            <!--<button type="submit" class="btn btn-sm btn-default">Submit</button>-->
                        </div>
                    </form>
                </aside>
                <!-- /.aside -->
                <!-- .aside -->
                <aside class="wrapper bg-light dker">
                    <section class="panel no-border scrollable">
                        <div class="table-responsive">
                            <table class="table datatablhe table-responsive table-striped m-b-none" id="employeeTable">
                                <thead>
                                <tr>
                                    <th>Nom & prenom</th>
                                    <th>email</th>
                                    <th>Mobile</th>
                                    <th>Service</th>
                                    <th>Poste</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                </tr>
                                </thead>
                                <tbody style="text-transform: capitalize" id="employeeRow">
                                @foreach($employees as $key=>$employee)
                                    <tr>
                                        <td>{{$employee->username}}</td>
                                        <td style="text-transform: lowercase">{{$employee->email}}</td>
                                        <td>{{$employee->mobile}}</td>
                                        <td>{{$employee->service->display_name}}</td>
                                        <td>{{$employee->post->name}}</td>
                                        <td>{{$employee->created_at->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                </aside>
                <!-- /.aside -->
            </section>
        </section>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#employeeTable').DataTable( {
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/french.json')}}"
                },
                "order": [[ 4, "asc" ]]
            } );
            $('#accessShow').hide();
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
            $('#employeeForm').on('submit', function (e) {
                e.preventDefault();
                var  formData = $(this).serialize();
                var $this = $('#submit');
                var state = $this.val();
                $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>&nbsp; En cours...'});
                $this.button('loading');
                $.ajax({
                    url: '{{route('user.store')}}',
                    type: "post",
                    data: formData,
                    success: function (data) {
                        toastr["success"]('a bien été enregistrer', "<span style='text-transform: uppercase'>" + data.username + "</span>!");
                        toastr.options.preventDuplicates = true;
                        $(this).trigger('reset');
                        $("#service").chosen("destroy");
                        $("#post").chosen("destroy");
                        $("#category").chosen("destroy");
                        var row = '<tr id="employee' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td>' + data.username + '</td>' +
                            '<td style="text-transform: lowercase">' + data.email + '</td>' +
                            '<td>' + data.mobile + '</td>' +
                            '<td>' + data.post + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<tr>';
                        if (state == 'save') {
                            $('#employeeRow').append(row);
                        } else {
                            $('#employeeRow' + data.id).replaceWith(row);
                        }
                    },
                    error: function (jqXhr) {
                        if (jqXhr.status === 401)
                            $(location).prop('pathname', 'auth/login');
                        if (jqXhr.status === 422) {
                            $errors = jqXhr.responseJSON;
                            $.each($errors, function (key, value) {
                                $ferrors = value.email
                            });
                            toastr["error"]($ferrors, "Oups!");
                            toastr.options.preventDuplicates = true;
                        } else {
                        }
                    }
                });
                $this.button('reset')
            });
        });
    </script>
@endsection
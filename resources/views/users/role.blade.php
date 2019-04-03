@section('title') Etat du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')
<section class="hbox stretch">
    <aside class="aside-xxl b-l b-r" >
        <section class="vbox flex">
            <form id="roleForm">
                {{csrf_field()}}
                <input name="roles" type="hidden" value="1">
            <header class="header clearfix">
                <h4 class="font-thin text-dar text-center">CREER UN RÔLE
                <button class="btn btn-success btn-sm uppercase pull-right" id="submit"><i class="fa fa-plus-circle"></i> Ajouter</button></h4>
            </header>
            <section>
                <section>
                    <section>
                        <div class="padder">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <input class="input-sm form-control" name="name" required placeholder="Nom_du_role *">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input class="input-sm form-control" name="display" required placeholder="Nom a afficher *">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="input-sm form-control" name="description" placeholder="Description du role">
                                </div>
                            <section class="panel panel-info">
                                <header class="panel-heading bg-light">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#stock" data-toggle="tab">Stock</a></li>
                                        <li><a href="#bus" data-toggle="tab">Car</a></li>
                                        <li><a href="#approval" data-toggle="tab">Approbation</a></li>
                                        <li><a href="#after" data-toggle="tab">Essais</a></li>
                                    </ul>
                                </header>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane capitalize active" id="stock">
                                            @foreach($permissions->where('type','stock') as $permission)
                                            <div class="checkbox i-checks">
                                                <label>
                                                    <input type="checkbox" value="{{$permission->id}}" name="permission[]">
                                                    <i></i> {{$permission->display_name}}
                                                </label>
                                            </div>
                                                @endforeach
                                            <div class="line"></div>
                                                @foreach($permissions->where('type','supplier') as $permission)
                                                    <div class="checkbox i-checks">
                                                        <label>
                                                            <input type="checkbox" value="{{$permission->id}}" name="permission[]">
                                                            <i></i> {{$permission->display_name}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                        </div>
                                        <div class="tab-pane capitalize" id="bus">
                                            @foreach($permissions->where('type','bus') as $permission)
                                                <div class="checkbox i-checks">
                                                    <label>
                                                        <input type="checkbox" value="{{$permission->id}}" name="permission[]">
                                                        <i></i> {{$permission->display_name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="tab-pane capitalize" id="approval">
                                            @foreach($permissions->where('type','approval') as $permission)
                                                <div class="checkbox i-checks">
                                                    <label>
                                                        <input type="checkbox" value="{{$permission->id}}"  name="permission[]">
                                                        <i></i> {{$permission->display_name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="tab-pane capitalize " id="after">
                                            @foreach($permissions->where('type','after_work') as $permission)
                                                <div class="checkbox i-checks">
                                                    <label>
                                                        <input type="checkbox" value="{{$permission->id}}" name="permission[]">
                                                        <i></i> {{$permission->display_name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>
                           </div>
                    </section>
                </section>
            </section>
            </form>
        </section>
    </aside>
    <aside>
        <section class="scrollable wrapper">
            <section class="panel panel-default" id="view">
                <div class="table-responsive">
                    <table class="table datatable table-responsive table-striped m-b-none capitalize"
                           id="roleTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Nom du rôle</th>
                            <th>Description</th>
                            <th><i class="i i-cog2"></i></th>
                        </tr>
                        </thead>
                        <tbody id="roleRow">
                        @foreach($roles as $key=>$role)
                            <tr id="user{{$role->id}}" class="animated fadeInDown">
                                <td>{{$key + 1}}</td>
                                <td>{{$role->display_name}}</td>
                                <td class="text-lowercase">{{$role->description}}</td>
                                <td><a href="#" id="{{$role->id}}" class="role"><i
                                                class="fa fa-pencil text-primary-dk"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </aside>
</section>
@endsection
@section('scripts')
    <script>
        var $table = $('#roleTable'),
            $form = $('#roleForm'),
            $row = $('#roleRow'),
            $submit = $('#submit');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-5'l><'col-sm-7'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 5,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'post',
                    url = 'index',
                    status = "success",
                    msg = "LE RÔLE A BIEN ETE CREER";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $form.trigger('reset');
                        toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="role' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td>' + data.index + '</td>' +
                            '<td>' + data.name + '</td>' +
                            '<td>' + data.display + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="edit(this)">' +
                            '<i class="fa fa-pencil text-primary-dk"></i></a></td><tr>';
                        $row.before(row);
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
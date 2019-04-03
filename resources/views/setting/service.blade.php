@section('title') Parametrage @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DU SERVICE</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#service" class="" data-toggle="tab">SERVICE</a></li>
                    <li class=""><a href="#poste" data-toggle="tab">POSTE</a></li>
                </ul>
                <div class="panel panel-default tab-content">
                    <!---------- Category tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel active" id="service">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none">Gestion des services</h4>
                                    <form id="serviceForm"  method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="service_id" type="hidden" name="service_id">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" id="service_name" minlength="3"
                                                   placeholder="Libelle service" class="input-sm form-control " required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="display_name" id="display_name" minlength="3"
                                                   placeholder="Description" class="input-sm form-control " required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="service_btn"
                                                    class="btn btn-sm btn-success" style="text-transform: uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                            <a href="#" class="btn btn-sm btn-icon btn-default pull-right btn_reset"
                                               onclick="reset_btn($('#service_btn'),$('#service_id') ,$('#service_name'), $('#display_name')); $(this).hide()">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none table_1">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-transform: capitalize" id="serviceRow">
                                    @foreach($service as $key=>$service)
                                        <tr id="service{{$service->id}}">
                                            <td>{{$service->name}}</td>
                                            <td>{{$service->created_at->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="#" id="{{$service->id}}" onclick="servicEdit(this)"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->

                    <!---------- Sub Category tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel" id="poste">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none">Gestion des postes</h4>
                                    <form id="posteForm" action="{{route('/create_postes')}}" method="post" role="form" >
                                        {{csrf_field()}}
                                        <input id="poste_id" type="hidden" name="poste_id">
                                        <div class="form-group">
                                            <label>Service</label>
                                            <select class="chosen-select form-control" id="servi_id" name="service" required>
                                             @foreach($services as $service)
                                                    <option value="{{$service->id}}">{{$service->name}}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" id="poste_name" minlength="3"
                                                   placeholder="libelle poste" class="input-sm form-control input_text" required>
                                        </div>

                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="postes_btn"
                                                    class="btn btn-sm btn-success" style="text-transform: uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                            <a href="#" class="btn btn-sm btn-icon btn-default pull-right btn_reset"
                                               onclick="reset_btn_2($('#postes_btn'), $('#poste_id'), $('#price'),$('#poste_name'), $('#servi_id')); $(this).hide()">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none postess">
                                    <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Poste</th>

                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-transform: capitalize" id="postesRow">
                                    @foreach($postes as $key => $poste)
                                        <tr id="postes{{$poste->id}}">
                                            <td>{{$poste->service->name}}</td>
                                            <td>{{$poste->name}}</td>

                                            <td>
                                                <a href="#" id="{{$poste->id}}" onclick="posteEdit(this)"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!------------- End ------------->


                </div>
            </div>
        </aside>



    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
       data-target="#nav,html"></a>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.btn_reset').hide();
            $('.table_1').dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[1, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            $('.postess').dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[2, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            loadservices();
        });

        function reset_btn(obj, id, name) {
            id.val('');
            name.val('');
            obj.val('save');
            obj.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $('.btn_reset').hide();
        }

        function reset_btn_2(obj, id, name, selected) {
            id.val('');
            name.val('');
            obj.val('save');
            selected.val('');
            selected.trigger("chosen:updated");
            obj.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $('.btn_reset').hide();
        }

        /**********************
         *  CATEGORY JS BEGIN *
         *********************/

        function loadservices() {
            var $this = $('#servi_id');
            $.get('fetch_services', function (data) {
                $this.empty();
                $this.append('<option value selected disabled>Choisissez un service</option>');
                $.each(data, function (index, modelObj) {
                    $this.append('<option style="text-transform: uppercase" value="' + modelObj.id + '">' + modelObj.name + '</option>');
                    $this.trigger("chosen:updated");
                });
            })
        }

        function servicEdit(obj) {
            $('.btn_reset').show();
            var $this = $('#service_btn');
            var id = $(obj).attr('id');
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('service_get?id=' + id, function (data) {
                $('#service_name').val(data.name);
                $('#display_name').val(data.display_name);
                $('#service_id').val(data.id);
            })
        }

        $('#serviceForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var $this = $('#service_btn');
            var state = $this.val();
            var type = 'post';
            var url = '{{route('/service_create')}}';
            var msg = "la categorie a été enregistrer";
            if (state == 'edit') {
                url = '{{route('/service_updated')}}';
                msg = "la categorie a été modifier";
            }
            $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
            $this.button('loading');
            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (data) {
                    loadservices();
                    $(this).trigger('reset');
                    $('#serviceForm').trigger('reset');
                    $('#service_name').focus();
                    toastr["success"](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                    toastr.options.preventDuplicates = true;
                    var row = '<tr id="service' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td style="text-transform: capitalize">' + data.name + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="servicEdit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                    if (state == 'save') {
                        $('#serviceRow').before(row);
                    } else {
                        $('#service' + data.id).replaceWith(row);
                    }
                },
                error: function (jqXhr) {
                    if (jqXhr.status === 401)
                        window.location.href = "/";
                    if (jqXhr.status === 422) {
                        $errors = jqXhr.responseJSON;
                        $.each($errors, function (key, value) {
                            $ferrors = value.name
                        });
                        toastr["error"]($ferrors, "Oups");
                        toastr.options.preventDuplicates = true;
                    } else {
                    }
                }
            });
            $this.button('reset');
            reset_btn($this, $('#category_id'), $('#category_name'));
        });
        /******** END **********/


        /**************************
         *  SUB CATEGORY JS BEGIN *
         *************************/
        function posteEdit(obj) {
            $('.btn_reset').show();
            var $this = $('#postes_btn');
            var id = $(obj).attr('id');
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('postes_get?id=' + id, function (data) {
                $('#poste_name').val(data.name);
                $('#poste_id').val(data.id);
                $('#price').val(data.price);
                $('#servi_id').val(data.service_id);
                $('#servi_id').trigger("chosen:updated");
            })
        }

        $('#posteForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var $this = $('#postes_btn');
            var state = $this.val();
            var type = 'post';
            var url = '{{route('/create_postes')}}';
            var msg = "le poste  a été enregistrer";
            if (state == 'edit') {
                url = '{{route('/updateposte')}}';
                msg = "le poste  a été modifier";
            }
            $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
            $this.button('loading');
            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (data) {
                    $('#posteForm').trigger('reset');
                    $(this).trigger('reset');
                    $('#poste_name').focus();
                    toastr["success"](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                    toastr.options.preventDuplicates = true;
                    var row = '<tr id="postes' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td style="text-transform: capitalize">' + data.service + '</td>' +
                            '<td style="text-transform: capitalize">' + data.name + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="posteEdit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                    if (state == 'save') {
                        $('#postesRow').before(row);
                    } else {
                        $('#postes' + data.id).replaceWith(row);
                    }
                },
                error: function (jqXhr) {
                    if (jqXhr.status === 401)
                        window.location.href = "/";
                    if (jqXhr.status === 422) {
                        $errors = jqXhr.responseJSON;
                        $.each($errors, function (key, value) {
                            $ferrors = value.name
                        });
                        toastr["error"]($ferrors, "Oups!");
                        toastr.options.preventDuplicates = true;
                    } else {
                    }
                }
            });
            $this.button('reset');
            reset_btn_2($this, $('#poste_id'), $('#poste_name'), $('#categories'));
        });
        /******** END **********/


        /**********************
         *  TYPE JS BEGIN *
         *********************/
        function typeEdit(obj) {
            $('.btn_reset').show();
            var $this = $('#type_btn');
            var id = $(obj).attr('id');
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('type_get?id=' + id, function (data) {
                $('#type_name').val(data.name);
                $('#type_id').val(data.id);
                $('#description').val(data.description);
            })
        }



    </script>
@endsection
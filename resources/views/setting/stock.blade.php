@section('title') Parametrage du stock @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DU STOCK</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#category" class="" data-toggle="tab">FAMILLE DES PIECES</a></li>
                    <li class=""><a href="#sub" data-toggle="tab">SOUS FAMILLE DES PIECES</a></li>
                    <li class=""><a href="#type" data-toggle="tab">TYPE DE PIECE</a></li>
                </ul>
                <div class="panel panel-default tab-content">
                    <!---------- Category tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel actives" id="category">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">FAMILLE DES PIECES</h4>
                                    <form id="familyForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="family_id" type="hidden" name="family_id">
                                        <input type="hidden" name="family" value="1">
                                        <div class="form-group m-t-lg">
                                            <label>Nom de la famille:</label>
                                            <a href="#" id="family_reset" onclick="family_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="family_name" minlength="3"
                                                   placeholder="Intitulé de la famille"
                                                   class="input-sm form-control input_text" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="family_submit"
                                                    class="btn btn-sm btn-success btn-group-justified btn-rounded uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none table_1 capitalize">
                                    <thead>
                                    <tr>
                                        <th>Famille</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="familyRow">
                                    @foreach($categories as $key=>$category)
                                        <tr id="family{{$category->id}}">
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$category->id}}" class="family-edit">
                                                    <i class="fa fa-pencil text-success-dker"></i></a>
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
                    <ul class="list-group tab-pane list-group-lg panel-primary panel" id="sub">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">SOUS FAMILLE</h4>
                                    <form id="sub_family_form" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="sub_family_id" type="hidden" name="sub_family_id">
                                        <input name="sub_family" type="hidden" value="1">
                                        <div class="form-group">
                                            <label>Famille</label>
                                            <select class="chosen-select form-control" id="families" name="category"
                                                    required>
                                                <option selected disabled>CHOISISEZ UNE FAMILLE</option>
                                                @forelse($categories as $key=>$category)
                                                    <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                                                @empty
                                                    <option disabled>AUCUNE FAMILLE DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nom de sous famille</label>
                                            <a href="#" id="sub_family_reset" onclick="sub_family_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="sub_family_name" minlength="3"
                                                   placeholder="Intitulé de sous famille"
                                                   class="input-sm form-control input_text" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="sub_family_submit"
                                                    class="btn btn-sm btn-success btn-group-justified btn-rounded uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none table_2 capitalize">
                                    <thead>
                                    <tr>
                                        <th>Famille</th>
                                        <th>Sous famille</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="sub_family_row">
                                    @foreach($subs as $key => $sub)
                                        <tr id="sub_family{{$sub->id}}">
                                            <td>{{$sub->category->name}}</td>
                                            <td>{{$sub->name}}</td>
                                            <td>{{$sub->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$sub->id}}" class="sub-family-edit">
                                                    <i class="fa fa-pencil text-success-dker"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!------------- End ------------->

                    <!---------- Type tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel active" id="type">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">TYPE DE PIECES</h4>
                                    <form id="typeForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="type_id" type="hidden" name="type_id">
                                        <input type="hidden" name="type">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" id="type_name" minlength="3"
                                                   placeholder="Nom du type" class="input-sm form-control input_text"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <a href="#" id="type_reset" style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <textarea rows="3" name="description" id="type_description"
                                                      placeholder="Description du type"
                                                      class="input-sm form-control input_text"></textarea>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="type_submit"
                                                    class="btn btn-sm btn-success btn-rounded btn-group-justified uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped capitalize m-b-none table_2">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="typeRow">
                                    @foreach($types as $key=>$type)
                                        <tr id="type{{$type->id}}">
                                            <td>{{$type->name}}</td>
                                            <td>{{$type->description}}</td>
                                            <td>{{$type->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$type->id}}" class="type-edit"><i
                                                            class="fa fa-pencil text-success-dker"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->
                </div>
            </div>
        </aside>
        <!--<section class="aside-md">
            <section class="vbox bg-white">

            </section>
        </section>-->
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
       data-target="#nav,html"></a>
@endsection

@section('scripts')
    <script>
        var $table_1 = $('.table_1'),
            $table_2 = $('.table_2'),

            /*** Family ***/
            $family_form = $('#familyForm'),
            $family_name = $('#family_name'),
            $family_id = $('#family_id'),
            $family_reset = $('#family_reset'),
            $family_submit = $('#family_submit'),
            $family_row = $('#familyRow'),
            $family_edit = $('.family-edit'),
            /*** end ***/

            /*** Suh Family ***/
            $sub_family_name = $('#sub_family_name'),
            $families = $('#families'),
            $sub_family_id = $('#sub_category_id'),
            $sub_family_submit = $('#sub_family_submit'),
            $sub_family_form = $('#sub_family_form'),
            $sub_family_reset = $('#sub_family_reset'),
            $sub_family_row = $('#sub_family_row'),
            $sub_family_edit = $('.sub-family-edit'),
            /*** end ***/

            /*** Suh Family ***/
            $type_form = $('#typeForm'),
            $type_name = $('#type_name'),
            $type_id = $('#type_id'),
            $type_description = $('#type_description'),
            $type_submit = $('#type_submit'),
            $type_reset = $('#type_reset'),
            $type_edit = $('.type-edit'),
            $type_row = $('#typeRow');
            /*** end ***/
        $(function () {
            $table_1.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[1, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            $table_2.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[2, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });

            /*** Family ***/
            $family_form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    $this = $family_submit,
                    state = $this.val(),
                    type = 'post',
                    url = 'stock_store',
                    msg = "la categorie a été enregistrer",
                    status = "success";
                if (state === 'edit') {
                    url = $(this).attr('action');
                    status = "info";
                    type = 'put';
                    msg = "la categorie a bien été modifier";
                }
                $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
                $this.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $family_name.focus();
                        toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="family' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td style="text-transform: capitalize">' + data.name + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="family_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        if (state === 'save') {
                            $family_row.before(row);
                        } else {
                            $('#family' + data.id).replaceWith(row);
                        }
                        families();
                        $this.button('reset');
                        family_reset()
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
                            $this.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $this.button('reset');
                        }
                    }
                });
            });
            $family_edit.on('click', function () {
                $family_reset.show();
                $family_name.addClass('loading-input');
                var id = $(this).attr('id'),
                    type = "family";
                $family_submit.val('edit');
                $family_submit.html('<i class="fa fa-pencil"></i> modifier');
                $family_submit.removeClass('btn-success');
                $family_submit.addClass('btn-info');
                $family_form.attr('action', 'stock_update/' + id);
                $.get('stock_edit/' + type + '/' + id, function (data) {
                    $family_name.val(data.name);
                    $family_id.val(data.id);
                    $family_name.removeClass('loading-input');
                })
            });
            /*** end ***/

            /*** Sub Family ***/
            $sub_family_edit.on('click', function () {
                sub_family_edit(this)
            });
            $sub_family_form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    state = $sub_family_submit.val(),
                    type = 'post',
                    url = 'stock_store',
                    msg = "La Sous Famille a été enregistrer",
                    status = "success";
                if (state === 'edit') {
                    url = $(this).attr('action');
                    status = "info";
                    type = 'put';
                    msg = "La Modification a bien été effectuée";
                }
                $sub_family_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
                $sub_family_submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $sub_family_name.focus();
                        toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="sub_family' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td>' + data.category + '</td>' +
                            '<td>' + data.name + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="sub_family_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        if (state === 'save') {
                            $sub_family_row.before(row);
                        } else {
                            $('#sub_family' + data.id).replaceWith(row);
                        }
                        $sub_family_submit.button('reset');
                        sub_family_reset();
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
                            $sub_family_submit.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $sub_family_submit.button('reset');
                        }
                    }
                });
            });
            /*** end ***/

            /*** Type ***/
            $type_form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    state = $type_submit.val(),
                    type = 'post',
                    url = 'stock_store',
                    msg = "le type a bien été enregistré",
                    status = "success";
                if (state === 'edit') {
                    url = $(this).attr('action');
                    type ="put";
                    status = "info";
                    msg = "La Modification a bien été effectuée";
                }
                $type_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
                $type_submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $type_name.focus();
                        toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="type' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td>' + data.name + '</td>' +
                            '<td>' + data.description + '</td>' +
                            '<td>' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="type_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<tr>';
                        if (state === 'save') {
                            $type_row.before(row);
                        } else {
                            $('#type' + data.id).replaceWith(row);
                        }
                        $type_submit.button('reset');
                        type_reset();
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
                            $type_submit.button('reset');
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $type_submit.button('reset');
                        }
                    }
                });
            });
            $type_reset.on('click', function () {
                type_reset();
            });
            $type_edit.on('click', function () {
               type_edit(this)
            });
            /*** end ***/
        });
        /*** Family ***/
        function family_reset() {
            $family_form.trigger('reset');
            $family_submit.val('save');
            $family_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $family_submit.removeClass('btn-info');
            $family_submit.addClass('btn-success');
            $family_reset.hide()
        }
        function family_edit(obj) {
            $family_reset.show();
            $family_name.addClass('loading-input');
            var id = $(obj).attr('id'),
                type = "family";
            $family_submit.val('edit');
            $family_submit.html('<i class="fa fa-pencil"></i> modifier');
            $family_submit.removeClass('btn-success');
            $family_submit.addClass('btn-info');
            $family_form.attr('action', 'stock_update/' + id);
            $.get('stock_edit/' + type + '/' + id, function (data) {
                $family_name.val(data.name);
                $family_id.val(data.id);
                $family_name.removeClass('loading-input');
            })
        }
        /*** end ***/

        /*** Suh Family ***/
        function families() {
            $.get('families', function (data) {
                $families.empty();
                $families.append('<option selected disabled>CHOISISSEZ UNE FAMILLE</option>');
                $.each(data, function (index, modelObj) {
                    $families.append('<option value="' + modelObj.id + '">' + modelObj.name + '</option>');
                    $families.trigger("chosen:updated");
                });
            })
        }
        function sub_family_reset() {
            $sub_family_form.trigger('reset');
            $sub_family_submit.val('save');
            $sub_family_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $families.trigger("chosen:updated");
            $sub_family_submit.removeClass('btn-info');
            $sub_family_submit.addClass('btn-success');
            $sub_family_reset.hide();
        }
        function sub_family_edit(obj) {
            $sub_family_name.addClass('loading-input');
            $sub_family_reset.show();
            var id = $(obj).attr('id'),
                type = "sub_family";
            $sub_family_submit.val('edit');
            $sub_family_submit.html('<i class="fa fa-pencil"></i> modifier');
            $sub_family_form.attr('action', 'stock_update/' + id);
            $.get('stock_edit/' + type + '/' + id, function (data) {
                $sub_family_name.val(data.name);
                $sub_family_id.val(data.id);
                $families.val(data.category_id);
                $families.trigger("chosen:updated");
                $sub_family_submit.removeClass('btn-success');
                $sub_family_submit.addClass('btn-info');
                $sub_family_name.removeClass('loading-input');
            })
        }
        /*** end ***/

        /*** Type ***/
        function type_reset() {
            $type_form.trigger('reset');
            $type_submit.val('save');
            $type_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $type_submit.removeClass('btn-info');
            $type_submit.addClass('btn-success');
            $type_reset.hide();
        }
        function type_edit(obj) {
            $type_name.addClass('loading-input');
            $type_description.addClass('loading-input');
            $type_reset.show();
            var id = $(obj).attr('id'),
                type = "type";
            $.get('stock_edit/' + type + '/' + id, function (data) {
                $type_name.val(data.name);
                $type_id.val(data.id);
                $type_description.val(data.description);
                $type_form.attr('action', 'stock_update/' + id);
                $type_submit.val('edit');
                $type_submit.html('<i class="fa fa-pencil"></i> modifier');
                $type_submit.removeClass('btn-success');
                $type_submit.addClass('btn-info');
                $type_name.removeClass('loading-input');
                $type_description.removeClass('loading-input');
            })
        }
        /*** end ***/


    </script>
@endsection
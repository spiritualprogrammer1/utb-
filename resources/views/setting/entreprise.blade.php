@section('title') PARAMETRE ENTREPRISE @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox" xmlns="http://www.w3.org/1999/html">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-building-o"></i>PARAMETRE ENTREPRISE</p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="fa fa-building-o"></i></a>

        </header>
        <section class="scrollable">
            <section class="hbox">
                <!-- .aside -->
                <aside class="aside-lg bg-light dker wrapper">
                    <form method="post" role="form" id="validateForm"
                          class="panel b-a bg-light" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="entreprise_id" id="entreprise_id">
                        <div class="panel-body">

                            <div class="form-group">
                                <div id="divRccm">
                                    <label for="last_name"><i class="fa fa-file-text-o"></i> sigle</label>
                                    <input class="form-control input-sm" id="name" type="text" minlength="3"
                                           name="name"
                                           placeholder="Libelle" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="first_name"><i class="fa fa-file-text-o"></i> Definition sigle</label>
                                <input class="form-control input-sm" type="text" minlength="3" id="first_name"
                                       name="display_name"
                                       placeholder="definition libelle" required>
                            </div>
                            <div class="form-group">
                                <label for="first_name"><i class="fa fa-file-text"></i> Pieds de page</label>
                                <textarea id="footer" class="form-control input-sm"  name="footer" placeholder="Information concernat le pieds de page" required></textarea>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="kv-avatar center-block text-center" style="width:200px">
                                        <input id="avatar-2" name="picture" type="file" class="file-loading" required>
                                    </div>
                                </div>
                                <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                            </div>
                            <button  type="submit" value="save" id="btn_validate"
                                    class="btn btn-success btn-group-justified  btn-rounded uppercaseinput-sm ">
                                <i class="fa fa-floppy-o"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </aside>
                <!-- /.aside -->
                <!-- .aside -->
                <aside class="wrapper bg-light dker">
                    <section class="panel no-border scrollable">
                        <div class="table-responsive scrollable">
                            <table class="table datatablhe table-responsive table-striped m-b-none" id="entreprisetable">
                                <thead>
                                <tr>
                                    <th>Libelle</th>
                                    <th>definiton du libelle</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                    <th><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody style="text-transform: capitalize" id="entrepriseRow">
                                @foreach($entreprise as $entrepris)
                                    <tr id="entrep{{$entrepris->id}}">
                                    <td >{{$entrepris->name}}</td>
                                    <td >{{$entrepris->display_name}}</td>
                                    <td>
                                        <a href="#" id="{{$entrepris->id}}" onclick="entrepriseEdit(this)"><i class="fa fa-pencil"></i></a>
                                    </td>
                                        <td >{{$entrepris->created_at->format('d/m/Y H:i:s')}}</td>
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

        var $table = $('#entrepriseTable'),
            $form = $('#validateForm'),
            $btn_validate = $('#btn_validate'),
                $btn_update=$('#btn_update'),
            $chosen_select = $('.chosen-select');
        $btn_update.hide();

        @if($entreprisecount>=1)

        $btn_validate.val('edit');
        $btn_validate.html('<i class="fa fa-pencil"></i> modifier');
        $btn_validate.prop('disabled', true);
        @endif

        $form.on('submit', function (e) {

            e.preventDefault();
            //   var formData = $(this).serialize();
            $this=$btn_validate;
            var state = $this.val();
            var type = 'post';
            var url = '{{route('post_entreprise')}}';
            var msg = "Enregistrement effectué";
            if (state == 'edit') {
                url = '{{route('update_entreprise')}}';
                msg = "modification effectué";
            }

            var formData = new FormData($(this)[0]);
            var $this = $btn_validate;
            var state = $this.val();
            $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Traitement en cours...'});
            $this.button('loading');
            $.ajax({
                url: url,
                type: "post",
                data: formData,
                success: function (data) {
                    toastr["success"](msg);
                    toastr.options.preventDuplicates = true;
                    $this.button('reset');
                    $(this).trigger('reset');
                    $form.trigger('reset');
                    $chosen_select.val('');
                    $chosen_select.trigger("chosen:updated");
                    var row = '<tr id="entrep' + data.id + '" class="alert alert-info text-danger-dk">' +
                            '<td style="text-transform: lowercase">' + data.name + '</td>' +
                            '<td >' + data.display_name + '</td>' +
                            '<td >' + data.date + '</td>' +
                            '<td><a href="#" id="' + data.id + '" onclick="entrepriseEdit(this)"><i class="fa fa-pencil"></i></a></td>' +


                            '<tr>';
                    $('#entreprise_id').val(data.id)
                    $btn_validate.val('edit');
                    $btn_validate.html('<i class="fa fa-pencil"></i> modifier');

                    if(data.entreprisecount>=1)
                    {
                        $btn_validate.val('edit');
                        $btn_validate.html('<i class="fa fa-pencil"></i> modifier');
                    }

                    if (state === 'save') {
                        $('#entrepriseRow').append(row);
                    } else {
                        $('#entrep' + data.id).replaceWith(row);
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function (jqXhr) {
                    if (jqXhr.status === 401)
                        $(location).prop('pathname', 'auth/login');
                    if (jqXhr.status === 422) {
                        var errors = jqXhr.responseJSON.message;
                        var errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml += value[0] + '</br>';
                        });
                        $this.button('reset');
                        swal(
                                'Oops...',
                                errorsHtml,
                                'error'
                        )
                    } else {
                        alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                        $this.button('reset');
                    }
                }
            });
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
            defaultPreviewContent: '<img src="{{asset('logo/logo.png')}}" alt="Your Avatar" style="width:125px"><h6 class="text-muted"></h6>',
            layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
            allowedFileExtensions: ["docx","pdf","jpg", "png", "gif"]
        });

        function entrepriseEdit(obj) {

            var id = $(obj).attr('id');
            $btn_validate.val('edit');
            $btn_validate.html('<i class="fa fa-pencil"></i> modifier');
            $btn_validate.removeAttr( "disabled" );
            $.get('entreprise_get?id=' + id, function (data) {
                $('#name').val(data.name);
                $('#entreprise_id').val(data.id);
                $('#first_name').val(data.display_name);
                $('#footer').val(data.footer)

            })
        }

        $btn_update.on('click',function(e) {
            alert('rfrfrf')

            {{--e.preventDefault();--}}
            {{--//   var formData = $(this).serialize();--}}
            {{--var formData = new FormData($(this)[0]);--}}
            {{--$this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Traitement en cours...'});--}}
            {{--$this.button('loading');--}}
            {{--$.ajax({--}}
                {{--url: '{{route('update_entreprise')}}',--}}
                {{--type: "post",--}}
                {{--data: formData,--}}
                {{--success: function (data) {--}}
                    {{--toastr["success"]('Enregistrement effectué', "<span style='text-transform: uppercase'>" + data.username + "</span>!");--}}
                    {{--toastr.options.preventDuplicates = true;--}}
                    {{--$btn_update.button('reset');--}}
                    {{--$(this).trigger('reset');--}}
                    {{--$form.trigger('reset');--}}
                    {{--var row = '<tr id="entrep' + data.id + '" class="alert alert-info text-danger-dk">' +--}}
                            {{--'<td style="text-transform: lowercase">' + data.name + '</td>' +--}}
                            {{--'<td >' + data.display_name + '</td>' +--}}
                            {{--'<td><a href="#" id="' + data.id + '" onclick="entrepriseEdit(this)"><i class="fa fa-pencil"></i></a></td>' +--}}

                            {{--'<tr>';--}}
                    {{--if (state === 'save') {--}}
                        {{--$('#entrepriseRow').append(row);--}}
                    {{--} else {--}}
                        {{--$('#entrepriseRow' + data.id).replaceWith(row);--}}
                    {{--}--}}
                {{--},--}}
                {{--cache: false,--}}
                {{--contentType: false,--}}
                {{--processData: false,--}}
                {{--error: function (jqXhr) {--}}
                    {{--if (jqXhr.status === 401)--}}
                        {{--$(location).prop('pathname', 'auth/login');--}}
                    {{--if (jqXhr.status === 422) {--}}
                        {{--var errors = jqXhr.responseJSON.message;--}}
                        {{--var errorsHtml = '';--}}
                        {{--$.each(errors, function (key, value) {--}}
                            {{--errorsHtml += value[0] + '</br>';--}}
                        {{--});--}}
                        {{--$this.button('reset');--}}
                        {{--swal(--}}
                                {{--'Oops...',--}}
                                {{--errorsHtml,--}}
                                {{--'error'--}}
                        {{--)--}}
                    {{--} else {--}}
                        {{--alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);--}}
                        {{--$this.button('reset');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}

        });
        $(function () {

            $table.DataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/french.json')}}"
                },
                "order": [[4, "asc"]]
            });

        });


    </script>
@endsection
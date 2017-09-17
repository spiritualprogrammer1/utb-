@section('title') Approbation de sortie du car @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="fa fa-gavel"></i> APPROBATION DE SORTIE DU CAR
            </p>
            <a class="btn btn-sm btn-default btn-rounded btn-icon disabled" id="file" data-value=""
               title="Fiche d'etat...">
                <i class="fa fa-file-pdf-o"></i>
            </a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onclick="$('#approvalTable').tableExport({type:'xlsx',escape:'false'});">
                    <img src="{{asset('assets/images/icons/xls.png')}}" width="20"> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onclick="$('#approvalTable').tableExport({type:'pdf',escape:'false'});">
                    <img src="{{asset('assets/images/icons/pdf.png')}}" width="20"> PDF
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onclick="$('#approvalTable').tableExport({type:'csv',escape:'false'});">
                    <img src="{{asset('assets/images/icons/csv.png')}}" width="20"> CSV
                </a>
            </div>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-md-3 col-md-push-9">
                    <div class="panel">
                        <div class="panel-heading b-b">Filtre</div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" checked value="repair" class="filter"><i></i>
                                        Réparation
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" value="revision" class="filter"><i></i>
                                        Revision
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" value="visit" class="filter"><i></i>
                                        Visite Technique
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-md-pull-3">
                    <div class="row">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="table-responsive" id="view">
                                    <table class="table table-striped m-b-none capitalize" id="approvalTable">
                                        <thead>
                                        <tr>
                                            <th width="5"></th>
                                            <th width="5"></th>
                                            <th>Reference OT</th>
                                            <th>Immatriculation</th>
                                            <th>Car</th>
                                            <th><i class="fa fa-calendar"></i> Date</th>
                                            <th><i class="fa fa-cog"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($repairs as $key=>$repair)
                                            <tr id="approval{{$repair->id}}" class="fadeIn">
                                                <td>{{$key + 1}}</td>
                                                <td>
                                                    <a href="#" id="{{$repair->id}}" class="">
                                                        <i class="fa fa-search-plus text-muted"></i>
                                                    </a>
                                                </td>
                                                <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->reference}}</td>
                                                <td class="uppercase text-primary-dker">{{$repair->diagnostic->state->bus->matriculation}}</td>
                                                <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
                                                <td>{{\Jenssegers\Date\Date::parse($repair->updated_at)->format('j M Y')}}</td>
                                                <td><a href="#" id="{{$repair->id}}" data-type="repair" class="approval"
                                                       data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                                                       data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                                                       data-ot="{{$repair->diagnostic->state->reference}}" data-diagnostic="{{$repair->diagnostic->id}}">
                                                        <i class="fa fa-pencil"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="cssload-container m-t-md none" id="spinner">
                                    <div class="cssload-progress cssload-float cssload-shadow m-t-md">
                                        <div class="cssload-progress-item"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <div class="modal fade" id="validateModal">
        <div class="modal-dialog">
            <form id="validateForm" class="modal-content">
                {{csrf_field()}}
                <input id="diagnostic_id" name="diagnostic" type="hidden">
                <input id="id" name="id" type="hidden">
                <input id="repair" name="repair" type="hidden" value="1">
                <input id="revision" name="revision" type="hidden">
                <input id="visit" name="visit" type="hidden">
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
                            <h4 style="margin-left: 100px" class="text-center m-t-n-xl font-thin text-dark-dker">APPROBATION DE
                                <span class="font-bold">SORTIE DU CAR</span></h4>
                        </div>
                    </section>
                </div>
                <div class="modal-body">
                    <div class="form-group has-success">
                        <textarea class="form-control input-sm m-t-n-sm" name="remark" rows="2"
                                  placeholder="Faites une petite remarque?"></textarea>
                    </div>

                    <div class="panel-group m-b" id="accordionDetail">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal"><i
                                class="fa fa-close"></i></button>
                    <button type="submit" id="submit" class="btn btn-success btn-rounded uppercase">
                        <i class="i i-checked"></i> approuver la sortie
                    </button>
                </div>
            </form><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script>
        var $table = $('#approvalTable'),
            $filter = $('.filter'),
            $approval = $('.approval'),
            $view = $('#view'),
            $modal = $('#validateModal'),
            $table_piece = $('#pieceTable'),
            $piece_row = $('#pieceRow'),
            $car = $('#car'),
            $ot = $('#ot'),
            $matriculation = $('#matriculation'),
            $piece_add = $('#piece_add'),
            $form = $('#validateForm'),
            $submit = $('#submit'),
            $file = $('#file'),
            $reference = $('#reference'),
            $spinner = $('#spinner'),
            $id = $('#id'),
            $diagnostic = $('#diagnostic_id'),
            $accordion = $('#accordionDetail');

        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "../../assets/js/datatables/French.json"
                }
            });
            $filter.on('click', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('home/'+id, function (data) {
                    $view.html(data);
                    $spinner.hide()
                })
            });
            $approval.on('click', function () {
                approval($(this))
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize(),
                    type = 'post',
                    url = 'home',
                    status = "success",
                    msg = "LA SORTIE A ETE APPROUVER";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    success: function (data) {
                        $form.trigger('reset');
                        $file.attr('data-value', data.id);
                        $file.addClass('btn-danger');
                        $file.removeClass('btn-default disabled');
                        toastr[status](msg, "<span class='uppercase'>" + data.reference + "</span>!");
                        toastr.options.preventDuplicates = true;
                        $('#approval' + data.id).remove();
                        $submit.button('reset');
                        $modal.modal('hide')
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

        function approval(obj) {
            $spinner.show();
            var id = $(obj).attr('id'),
                type = $(obj).attr('data-type'),
                active = '',
                collapse = '';
            $car.html($(obj).attr('data-car'));
            $matriculation.html($(obj).attr('data-matriculation'));
            $ot.html($(obj).attr('data-ot'));
            $id.val(id);
            $diagnostic.val($(obj).attr('data-diagnostic'));
            $reference.val($(obj).attr('data-ot'));
            $.get('descriptions/' + id + '/' + type, function (data) {
                $accordion.empty();
                $.each(data, function (index, modelObj) {
                    if (index === 0) {
                        active = 'in'
                    }else {
                        collapse = 'collapsed';
                        active = ''
                    }
                    $accordion.append('<div class="panel panel-info"><div class="panel-heading">' +
                        '<a class="accordion-toggle '+collapse+' capitalize" data-toggle="collapse" data-parent="#accordionDetail" href="#detail' + index + '">' +
                        '' + modelObj.title + ' <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' +
                        '' + modelObj.created_at + '</small></a></div>' +
                        '<div id="detail' + index + '" class="panel-collapse collapse ' + active + '" style="height: auto;">' +
                        '<div class="panel-body text-sm">' + modelObj.description + '</div> </div></div>');
                });

                $modal.modal('show');
                $spinner.hide()
            })
        }
    </script>
@endsection
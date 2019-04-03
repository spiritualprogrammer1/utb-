@section('title') Reporting @endsection
@extends('layouts.master')
@section('content')
<section class="hbox stretch">
    {{--<aside class="aside-md bg-light dker b-r" id="subNav">--}}
        {{--<div class="wrapper b-b header">Filtre des reporting</div>--}}
        {{--<ul class="nav">--}}
            {{--<li class="b-b "><a href="#" class="filter" id="1">--}}
                    {{--<i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>--}}
                    {{--<i class="i i-settings"></i> Car</a>--}}
            {{--</li>--}}
            {{--<li class="b-b "><a href="#" class="filter" id="2">--}}
                    {{--<i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>--}}
                    {{--<i class="i i-gauge"></i> stock</a>--}}
            {{--</li>--}}
            {{--<li class="b-b "><a href="#" class="filter" id="3">--}}
                    {{--<i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>--}}
                    {{--<i class="i i-params"></i> Visite Technique</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</aside>--}}
    <aside>
        <section class="vbox">
            <header class="header bg-white b-b clearfix">
                <div class="row m-t-sm">
                    <div class="col-sm-8 m-b-xs">
                        <a href="#subNav" data-toggle="class:hide" class="btn btn-sm btn-default active"><i
                                class="fa fa-caret-right text fa-lg"></i><i
                                class="fa fa-caret-left text-active fa-lg"></i></a>
                        <span class="h4 font-thin m-l-sm m-t-sm" id="title">
                                <i class="fa fa-bus"></i> CAR
                            </span>

                    </div>

                    <div class="btn-group pull-right" data-toggle="">
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

                </div>
            </header>
            <section class="scrollable wrapper w-f">


                <section class="panel panel-default bg-light lter" >


                    <form action="#" method="post" id="formsearch">

                        {{csrf_field()}}

                    <div class="row" >

                        <div class="form-group-sm has-success m-b-sm col-md-4">
                            <label class="text-success">Site</label>
                            <select class="input-sm form-control" id="reference_input" data-type="delivery"
                                    name="site" onchange="infoReference(this)" data-id="0"
                                    data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>
                                <option value="total">total</option>
                                <option value="1">Site1</option>
                                <option value="2">Site2</option>


                            </select>
                        </div>


                        <div class="form-group-sm has-success m-b-sm col-md-4">
                            <label class="text-success">Societe</label>
                            <select class="input-sm form-control" id="reference_input" data-type="delivery"
                                    name="societe" onchange="infoReference(this)" data-id="0"
                                    data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>
                                <option value="total">TOUS</option>
                                <option value="AHT">AHT</option>
                                <option value="UTB">UTB</option>

                            </select>
                        </div>
                        <div class="form-group-sm has-success m-b-sm col-md-4">
                            <label class="text-success"><strong>car</strong></label>
                            <select class="input-sm form-control" id="reference_input" data-type="delivery"
                                    name="car" onchange="infoReference(this)" data-id="0"
                                    data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>

                                <option value="total">TOTAL</option>


                                @foreach($bus as $bu)

                                <option value="{{$bu->id}}">{{$bu->matriculation}} </option>

                                    @endforeach

                            </select>
                        </div>
                        <div class="form-group-sm has-success m-b-sm col-md-4">
                            <label class="text-success"><strong>prestation</strong></label>
                            <select class="input-sm form-control" id="reference_input" data-type="delivery"
                                    name="prestation" onchange="infoReference(this)" data-id="0"
                                    data-placeholder="CHOISISSEZ UNE REFERENCE DE BON..." required>
                                <option value="total">Total</option>
                                <option value="1">Reparation</option>
                                <option value="2">Visite technique</option>
                                <option value="3">Révision</option>

                            </select>
                        </div>
                        <div class="form-group-sm has-danger m-b-sm col-md-3">
                            <div class="col-sm-12 text-right text-left-xs m-t-md">
                                <div class="has-success" id="periode">
                                    <input class="input-sm  form-control col-sm-12" placeholder="Date debut" name="datedebu" id="datedebu" >
                                </div>



                                <!--<a href="#nav, #sidebar" class="btn btn-icon b-2x btn-info btn-rounded" data-toggle="class:nav-xs, show"><i class="fa fa-bars"></i></a>-->
                            </div>
                        </div>

                        <div class="form-group-sm has-danger m-b-sm col-md-3">
                            <div class="col-sm-12  text-left-xs m-t-md">
                                <div class="has-success" id="periode">
                                    <input class="input-sm col-sm-3 form-control"  placeholder="Date fin" name="datefin" id="datefin" >                                </div>



                                <!--<a href="#nav, #sidebar" class="btn btn-icon b-2x btn-info btn-rounded" data-toggle="class:nav-xs, show"><i class="fa fa-bars"></i></a>-->
                            </div>
                        </div>

                        <div class="form-group-sm has-success  col-md-2">
                            <br/>


                            <button type="submit" class="btn btn-info" id="search"><i class="fa fa-search"></i></button>
                        </div>

                    </div>

                    </form>


<br/><br/>
                    <div class="row text-center">
                        <span class="aler alert-danger  text-center" style="font-size: 20px;font-family: italic"> <u><i>Resultat reporting</i></u> </span>

                    </div>

                    <br/>
                    <br/>



                    <div class="row" style="margin-left: 2px;margin-right: 2px" >
                        <div class="table-responsive" id="dataserach">




                        </div>

                    </div>

                    <div class="cssload-container m-t-n-md none" id="spinner">
                        <div class="cssload-progress cssload-float cssload-shadow m-t-n-md">
                            <div class="cssload-progress-item"></div>
                        </div>
                    </div>

                </section>






            </section>
        </section>
    </aside>
</section>

@endsection


@section('scripts')
    <script src="{{asset('assets/js/datepicker/bootstrap-datepicker.js')}}"></script>



    <script type="text/javascript">
        $('#datedebu').datepicker({
            format: "yyyy-mm-dd",

        })
        $('#datefin').datepicker({
            format: "yyyy-mm-dd",

        })

        </script>
<script>
    var $repair = $('.repair'),
        $spinner = $('#spinner'),
        $car = $('#car'),
        $ot = $('#ot'),
        $matriculation = $('#matriculation'),
        $form = $('#validateForm'),
        $descriptions = $('#accordionDescriptions'),
        $valid = $('.valid'),
        $remark = $('#remark'),
        $file = $('#file'),
        $submit = $('#submit'),
        $fileModal=$('#fileModal'),
        $file_content=$('#file_content'),
        $modal = $('#validateModal'),
        $depart = $('#depart'),
        $arrive = $('#arrive'),
        $table = $('#approvalTable'),
        $filter = $('.filter'),
        $view = $('#view'),
        $type = $('#type'),
        $title = $('#title'),
        $titles = $('.title'),
        $chosen = $('.chosen-select'),
        $distance = $('#distance');

    $spinner = $('#spinner');

    $search = $('#search');
    $formsearch=$('#formsearch');

    $dataserach=$('#dataserach');

    $(function () {
        $table.dataTable({
            "sPaginationType": "full_numbers",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "iDisplayLength": 50,
            "language": {
                "url": "../assets/js/datatables/French.json"
            }
        });



        $formsearch.on('submit',function (e) {

            e.preventDefault();
            $spinner.show();
            var formData = $(this).serialize(),
                type = 'post',
                url = $(this).attr('action'),
                status = "warning",
                msg = "recherche en cours";


            $.ajax({
                url: "{{route('reporting')}}",
                type: type,
                data: formData,
                success: function (data) {
                    $form.trigger('reset');

                    $dataserach.html(data)



                    $submit.button('reset');

                    $spinner.hide();
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

        })




        $repair.on('click', function () {
            validate($(this))
        });
        $valid.on('click', function () {
            var id = $(this).val();
            if (id === '4') {
                //$remark.attr('disabled', false);
                $remark.val('');
                $submit.removeClass('btn-success');
                $submit.addClass('btn-danger');
                $submit.html('<i class="i i-cancel"></i> Desapprouver les travaux');
                $submit.val('invalid')
            } else {
                $remark.val('Rien à Signaler');
                //$remark.attr('disabled', true);
                $submit.removeClass('btn-danger');
                $submit.addClass('btn-success');
                $submit.html('<i class="i i-checked"></i> Approuver les travaux');
                $submit.val('valid')
            }
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
        $form.on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize(),
                type = 'put',
                url = $(this).attr('action'),
                status = "warning",
                msg = "LES TRAVAUX ONT ETE DESAPPROUVER";
            if ($submit.val() === 'valid') {
                status = "success";
                msg = "LES TRAVAUX ONT ETE APPROUVER";
            }
            $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
            $submit.button('loading');
            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (data) {
                    $form.trigger('reset');
                    score();
                    $chosen.trigger('chosen:updated');
                    $file.attr('data-value', data.work_id);
                    $file.addClass('btn-danger');
                    $file.removeClass('btn-default disabled none');
                    toastr[status](msg);
                    //    toastr[status](msg, "<span class='uppercase font-bold'>" + data.reference + "</span>!");
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
        $file.on('click',function () {
            $spinner.show();
            var id = $(this).attr('data-value') ;
            $.get('filesafertworks/' + id, function (data) {
                $file_content.html(data);
                $fileModal.modal('show')
                $spinner.hide();
            })
        })


        function score()
        {

            $.get('score',function (data) {
                $('#testVisit').html(data.testVist);
                $('#testRevision').html(data.testRevision);
                $('#testRepair').html(data.testRepaire);
                $('#count_repaircours').html(data.repairencours);
                $('#count_revisioncours').html(data.revisionencours)
                $('#count_visitoncours').html(data.visitencours);
                $('#aftertestvisit').html(data.aftertestvisit);
                $('#aftertestrevision').html(data.aftertestrevision);
                $('#aftertestrepair').html(data.aftertestrepair);
            })
        }

        $filter.on('click', function () {
            $spinner.show();
            var id = $(this).attr('id');
            if (id === '1'){
                $type.attr('name', 'repair');
                $titles.html('Réparation');
                $title.fadeOut('slow', function () {
                    $(this).html('<i class="fa fa-wrench"></i> REPARATION');
                }).fadeIn("slow");
                $file.addClass('disabled none');
            }else if(id === '2'){
                $type.attr('name', 'revision');
                $titles.html('Revision');
                $title.fadeOut('slow', function () {
                    $(this).html('<i class="i i-gauge"></i> REVISION');
                    $file.addClass('disabled none');
                }).fadeIn("slow");
            }else {
                $type.attr('name', 'visit');
                $titles.html('Visite Technique');
                $title.fadeOut('slow', function () {
                    $(this).html('<i class="i i-params"></i> VISITE TECHNIQUE');
                    $file.addClass('disabled none');
                }).fadeIn("slow");
            }
            $.get('home/'+id+'/edit', function (data) {
                $view.html(data);
                $spinner.hide();
            })
        })
    });
    function validate(obj) {
        $spinner.show();
        var id = $(obj).attr('id'),
            active = '',
            collapse = '';
        $car.html($(obj).attr('data-car'));
        $matriculation.html($(obj).attr('data-matriculation'));
        $ot.html($(obj).attr('data-ot'));
        $depart.val($(obj).attr('data-kilometer'));
        $form.attr('action', 'home/' + id);
        $.get('home/' + id, function (data) {
            $descriptions.empty();
            $.each(data, function (index, modelObj) {
                if (index === 0) {
                    active = 'in'
                }else {
                    collapse = 'collapsed';
                    active = ''
                }
                $descriptions.append('<div class="panel panel-info"><div class="panel-heading">' +
                    '<a class="accordion-toggle '+collapse+' capitalize" data-toggle="collapse" data-parent="#accordionDescriptions" href="#detail' + index + '">' +
                    '' + modelObj.title + ' <small class="pull-right text-muted"><i class="fa fa-clock-o"></i> ' +
                    '' + modelObj.created_at + '</small></a></div>' +
                    '<div id="detail' + index + '" class="panel-collapse collapse ' + active + '" style="height: auto;">' +
                    '<div class="panel-body text-sm">' + modelObj.description + '</div> </div></div>');
            });
            $spinner.hide();
            $modal.modal('show');
        });
    }
</script>
@endsection
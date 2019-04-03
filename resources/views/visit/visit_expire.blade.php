@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">

        <section class="vbox">
            <header class="header bg-white b-b clearfix">
                <div class="row m-t-sm">
                    <div class="col-sm-6 m-b-xs">
                        <a href="#subNav" data-toggle="class:hide"
                           class="btn btn-sm btn-default active pull-left m-r-md">
                            <i class="fa fa-caret-right text fa-lg"></i>
                            <i class="fa fa-caret-left text-active fa-lg"></i>
                        </a>
                        <?php $count= count($visit_expiration); ?>
                        <h5><i class="fa fa-bus"></i> LISTE DES CARS DONT LA VISITE EXPIRE BIENTOT : <b style="color:#761c19">{{$count}} véhicule(s)</b>  </h5>

                    </div>
                    <div class="btn-group pull-right" data-toggle="buttons">
                        <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                           onClick="$('#vehicleTable').tableExport({type:'xlsx',escape:'false'});">
                            <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                        </a>
                        <a href="#" class="btn btn-sm btn-bg btn-default"
                           onClick="$('#vehicleTable').tableExport({type:'pdf',escape:'false'});">
                            <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
                        </a>
                        <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                           onClick="$('#vehicleTable').tableExport({type:'csv',escape:'false'});">
                            <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                        </a>
                    </div>
                </div>
            </header>

            <section class="scrollable wrapper w-f">
                <section class="panel panel-default">
                    <div class="table-responsive" id="view">
                        <table class="table table-striped m-b-none capitalize"
                               id="vehicleTable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Immatriculation</th>
                                <th>Chassis</th>
                                <th>Marque</th>
                                <th>Modele</th>
                                <th><i class="i i-calendar text-warning"></i> VISITE</th>
                            </tr>
                            </thead>
                            <tbody id="vehicleRow">
                            @for($i=0;$i<$count;$i++)
                                <tr id="bus{{$visit_expiration[$i]['id']}}" class="animated fadeIn">
                                    <td>{{$visit_expiration[$i]['designation']}}</td>
                                    <td class="text-info-dk uppercase">{{$visit_expiration[$i]['matriculation']}}</td>
                                    <td class="text-info-dk uppercase">{{$visit_expiration[$i]['chassis']}}</td>
                                    <td>{{$visit_expiration[$i]->model->brand->name}}</td>
                                    <td>{{$visit_expiration[$i]->model->name}}</td>
                                    <?php $visit=App\Visit::where('bus_id',$visit_expiration[$i]->id)->orderBy('id','DESC')->first();
                                    ?>
                                    <td class="text-danger">{{\Jenssegers\Date\Date::parse($visit['date'])->format('j M Y')}}</td>

                                </tr>
                            @endfor
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

        {{--</section>--}}

        {{--{{$insurance_expiration[0]}}--}}
        {{--@foreach($bus as $bu)--}}
        {{--{{$bu->assurance->date}}--}}
        {{--@endforeach--}}

        @endsection
        @section('scripts')
            <script>
                var $table = $('#vehicleTable'),
                        $brand = $('.brand'),
                        $spinner = $('.cssload-container'),
                        $all = $('#all');
                $view = $('#view');
                $(function () {
                    $table.dataTable({
                        "sPaginationType": "full_numbers",
                        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                        "iDisplayLength": 50,
                        "language": {
                            "url": "{{asset('assets/js/datatables/French.json')}}"
                        }
                    });
                    $brand.on('click', function () {
                        $spinner.show();
                        var id = $(this).attr('id');
                        $.get('vehicle/' + id, function (data) {
                            $view.html(data);
                            $spinner.hide();
                        })
                    });
                    $all.on('click', function () {
                        $spinner.show();
                        var id = "0";
                        $.get('models/' + id, function (data) {
                            $view.html(data);
                            $spinner.hide();
                        })
                    });
                });
            </script>

@endsection
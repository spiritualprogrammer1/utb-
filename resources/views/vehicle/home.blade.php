@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-sm bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header">Filtrer par marque</div>
            <ul class="nav uppercase">
                @if(empty($brands))
                @else
                    <li class="b-b ">
                        <a href="#" id="all">
                            <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                            Tous
                        </a>
                    </li>
                @endif
                @forelse($brands as $key=>$brand)
                    <li class="b-b ">
                        <a href="#" id="{{$brand->id}}" class="brand">
                            <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                            {{$brand->name}}
                        </a>
                    </li>
                @empty
                    <li class="b-b ">
                        <a href="#">
                            <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>
                            Aucune Marque Disponible
                        </a>
                    </li>
                @endforelse
            </ul>
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
                            <h4><i class="fa fa-bus"></i> LISTE DE CARS</h4>
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
                                    <th><i class="i i-calendar"></i> Assurance</th>
                                    <th><i class="i i-calendar"></i> Visit T.</th>
                                </tr>
                                </thead>
                                <tbody id="vehicleRow">
                                @foreach($buses as $key=>$bus)
                                    <tr id="bus{{$bus->id}}" class="animated fadeIn">
                                        <td>{{$bus->id}}</td>
                                        <td class="text-danger-dk uppercase">{{$bus->matriculation}}</td>
                                        <td class="text-danger-dk uppercase">{{$bus->chassis}}</td>
                                        <td>{{$bus->model->brand->name}}</td>
                                        <td>{{$bus->model->name}}</td>
                                        <?php $assurance=App\Assurance::where('bus_id',$bus->id)->orderBy('id','DESC')->first();
                                           $visite=App\Visit::where('bus_id',$bus->id)->orderBy('id','DESC')->first();
                                        ?>
                                        <td>{{\Jenssegers\Date\Date::parse($assurance['date'])->format('j M Y')}}</td>
                                        <td>{{\Jenssegers\Date\Date::parse($visite['date'])->format('j M Y')}}</td>

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
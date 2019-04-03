<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">LISTE DES CARS DONT LA VISITE EXPIRE BIENTOT
                <div class="btn-group pull-right" data-toggle="buttons">
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#vehicleTable').tableExport({type:'excel',escape:'false'});">
                        <img src="{{asset('assets/images/icons/xls.png')}}" width="20"> Excel
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default"
                       onclick="$('#vehicleTable').tableExport({type:'pdf',escape:'false'});">
                        <img src="{{asset('assets/images/icons/pdf.png')}}" width="20"> Pdf
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#vehicleTable').tableExport({type:'csv',escape:'false'});">
                        <img src="{{asset('assets/images/icons/csv.png')}}" width="20"> CSV
                    </a>
                </div>
            </h4>
        </div>
        <div class="modal-body">
            <div class="panel-body clearfix">
                <div class="row">
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
                        @for($i=0;$i<$num_visite_expiration;$i++)
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

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
<script>
    $('#vehicleTable').dataTable( {
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "order": [[4, "desc"]],
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    } );
</script>
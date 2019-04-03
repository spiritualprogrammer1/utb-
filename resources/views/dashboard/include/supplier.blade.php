<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des fournisseurs
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
                    <table class="table table-responsive table-stripped" id="vehicleTable">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>rccm</th>
                            <th>telephone</th>
                            <th>email</th>
                            <th>type</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key=> $data)
                            <tr id="contractor">
                                <td class="alert alert-info" style="color:#a30921">{{strtoupper($data->name)}}</td>
                                <td style="text-transform: capitalize">@if($data->type==1)
                                        xxxxxxxxxxxxxxxxxx
                                @else
                                        {{$data->rccm}}
                                    @endif
                                </td>
                                <td>{{$data->email}}</td>
                                <td>{{$data->phone}}</td>
                                <td>@if($data->type==1)
                                        Particulier
                                    @else
                                        Entreprise
                                    @endif</td>
                            </tr>
                        @endforeach
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
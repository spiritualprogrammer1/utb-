<style>
    .modal-dialog{
        width: 1000px;
    }

</style>

<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des accidents de plus de 100 000 Km
                <div class="btn-group pull-right" data-toggle="buttons">
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#vehicleTable').tableExport({type:'excel',escape:'false'});">
                        <img src="http://stock.dev/assets/images/icons/xls.png" width="20"> Excel
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default"
                       onclick="$('#vehicleTable').tableExport({type:'pdf',escape:'false'});">
                        <img src="http://stock.dev/assets/images/icons/pdf.png" width="20"> Pdf
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#vehicleTable').tableExport({type:'csv',escape:'false'});">
                        <img src="http://stock.dev/assets/images/icons/csv.png" width="20"> CSV
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
                            <th>#</th>
                            <th>Societe</th>
                            <th>Immatriculation</th>
                            <th>Type & Model</th>
                            <th>Description</th>
                            <th>Lieu</th>
                            <th><i class="i i-calendar"></i> Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key=> $data)
                            <tr id="contractor">
                                <td>{{$key+1}}</td>
                                <td class="text-danger">{{strtoupper($data->bus->societe)}}</td>
                                <td class="text-info">{{strtoupper($data->bus->matriculation)}}</td>
                                <td class="text-alert" style="text-transform: capitalize">{{$data->bus->model->name." ".$data->bus->model->brand->name}}</td>
                                <td class="alert alert-info">{{$data->description_accident}}</td>
                                <td class="alert alert-success">{{$data->lieu}}</td>
                                <td>{{date('d-m-Y', strtotime($data->date_accident))}}</td>
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
        "order": [[5, "desc"]],
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    } );
</script>
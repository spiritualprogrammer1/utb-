<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des factures
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
        <div class="modal-body ">
            <div class="panel-body clearfix">
                <div class="row">
                    <table class="table table-responsive table-stripped" id="clienttable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference </th>
                            <th>Nom du client</th>
                            <th>Immatriculation</th>
                            <th>contact</th>
                            <th><i class="i i-calendar"></i> Date</th>

                        </tr>
                        </thead>
                        <tbody style="text-transform: capitalize" id="versmen">

                        @foreach($data as $key=> $dat)
                            <tr class="versment">
                                <th>{{$key+1}}</th>
                                <td   class="text-center ">{{$dat->proforma_invoice->reference}}</td>
                                <td   class="text-center ">{{$dat->process->state->vehicle->client->name}}</td>
                                <td   class="text-center ">{{$dat->process->state->vehicle->matriculation}}</td>
                                <td   class="text-center ">{{$dat->process->state->vehicle->client->contact}}</td>
                                <td   class="text-center ">{{$dat->created_at->format('d/m/Y')}}</td>

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


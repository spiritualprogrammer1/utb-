<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des vehicules
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
                            <th>Reference O.T</th>
                            <th>Code de reglement</th>
                            <th>amount versé</th>
                            <th><i class="i i-calendar"></i> Date</th>

                        </tr>
                        </thead>
                        <tbody style="text-transform: capitalize" id="versmen">

                        @foreach($reglementesp as $regl)
                            <tr class="versment">
                                <td   class="text-center ">{{$regl->codepro}}</td>
                                <td class="text-center">{{$regl->code}}</td>
                                <td class="text-center ">{{$regl->amount}}</td>
                                <td class="text-center">{{$regl->date}}</td>
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

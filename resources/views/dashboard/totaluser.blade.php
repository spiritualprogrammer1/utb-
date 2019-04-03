<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des Utilisateurs
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
        <div class="modal-body ">
            <div class="panel-body clearfix">
                <div class="row">
                    <table class="table table-responsive table-stripped" id="clienttable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userTotal as $key=> $userTota)
                            <tr id="contractor">
                                <td>{{$key+1}}</td>
                                <td class="alert alert-info">
                                    {{strtoupper($userTota->first_name)}}
                                </td>
                                <td style="text-transform: capitalize">{{strtoupper($userTota->last_name)}}</td>
                                <td>{{strtoupper($userTota->email)}}</td>
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

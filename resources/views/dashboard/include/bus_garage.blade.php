
<style>
    .modal-dialog{
        width:1300px;

    }
</style>
<div class="modal-dialog " aria-labelledby="myLargeModalLabel">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Liste des vehicules dans le garage
                <div class="btn-group pull-right" data-toggle="buttons">
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#datarem').tableExport({type:'excel',escape:'false'});">
                        <img src="{{asset('assets/images/icons/xls.png')}}" width="20"> Excel
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default"
                       onclick="$('#datarem').tableExport({type:'pdf',escape:'false'});">
                        <img src="{{asset('assets/images/icons/pdf.png')}}" width="20"> Pdf
                    </a>
                    <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                       onclick="$('#datarem').tableExport({type:'csv',escape:'false'});">
                        <img src="{{asset('assets/images/icons/csv.png')}}" width="20"> CSV
                    </a>
                </div>
            </h4>
        </div>
        <div class="modal-body">
            <div class="panel-body clearfix">
                <div class="table-responsive">
                    <table class="table datatable table-striped b-t b-light capitalize" id="datarem">
                        <thead>
                        <tr>
                            <th style="width:60px">N°</th>
                            <th style="width: 50px">Immat</th>
                            <th style="width:200px">Marque ET Type</th>
                            <th  style="width: 60px">Date entrée</th>

                            <th>Commentaire</th>
                        </tr>
                        </thead>
                        <tbody id="repairRow">
                        @for($k=0;$k<count($processes);$k++)
                            @if(!empty($processes[$k]) and isset($processes[$k]) and count($processes[$k])!=0)
                                <tr id="">
                                    <td>{{$k+1}}</td>
<!--                                    --><?php //dd($processes[$k][0]['bus']['model']['brand']['name']); ?>


                                    <td class="text-success">{{strtoupper($processes[$k][0]['bus']['matriculation'])}}</td>
                                    <td>{{strtoupper($processes[$k][0]['bus']['model']['brand']['name'])}} ||  {{$processes[$k][0]['bus']['model']['name']}}</td>

                                    <td class="alert alert-danger">{{date('d/m/Y',strtotime($processes[$k][0]['created_at']))}}</td>


                                    <td width="50px" class="alert alert-info">{{strtoupper($processes[$k][0]['incident'])}}</td>



                                </tr>
                            @endif
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

    $table=$('#datarem');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    });

</script>
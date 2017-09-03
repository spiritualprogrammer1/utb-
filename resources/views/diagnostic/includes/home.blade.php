<table class="table table-striped m-b-none capitalize"
       id="processTable">
    <thead>
    <tr>
        <th></th>
        <th>Ordre de Tavail</th>
        <th>Immatriculation</th>
        <th>Chassis</th>
        <th>Marque</th>
        <th>Modele</th>
        <th>Date</th>
        <th><i class="i i-check"></i>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($processes as $key=>$process)
        <tr class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            <td class="uppercase">{{$process->reference}}</td>
            <td class="text-danger-dk uppercase">{{$process->state->bus->matriculation}}</td>
            <td class="text-danger-dk uppercase">{{$process->state->bus->chassis}}</td>
            <td>{{$process->state->bus->model->brand->name}}</td>
            <td>{{$process->state->bus->model->name}}</td>
            <td>{{$process->created_at->format('d/m/Y')}}</td>
            <td width="10">
                <div class="radio i-checks">
                    <label class="m-t-n-xl"
                           style="width: 5px; height: 50px">
                        <input type="radio"
                               name="process"
                               class="process"
                               value="{{$process->id}}"
                               data-trigger="change"
                               data-required="true">
                        <i></i>
                    </label>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var $table = $('#processTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 5,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
</script>
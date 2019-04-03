<table class="table table-striped m-b-none capitalize"
       id="stateTable">
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
    @foreach($states as $key=>$state)
        <tr class="animated fadeIn" id="state{{$state->id}}">
            <td>{{$key + 1}}</td>
            <td class="uppercase">{{$state->reference}}</td>
            <td class="text-danger-dk uppercase">{{$state->bus->matriculation}}</td>
            <td class="text-danger-dk uppercase">{{$state->bus->chassis}}</td>
            <td>{{$state->bus->model->brand->name}}</td>
            <td>{{$state->bus->model->name}}</td>
            <td>{{$state->created_at->format('d/m/Y')}}</td>
            <td width="10">
                <div class="radio i-checks">
                    <label class="m-t-n-xl"
                           style="width: 5px; height: 50px">
                        <input type="radio"
                               name="state"
                               class="state"
                               value="{{$state->id}}"
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
    var $table = $('#stateTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
</script>
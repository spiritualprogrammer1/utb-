<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th width="1"></th>
        <th>Réference OT</th>
        <th>Immatriculation</th>
        <th>Chassis</th>
        <th>Car</th>
        <th>Date</th>
        <th width="5"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($repairs as $key=>$repair)
        <tr id="approval{{$repair->id}}"  class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->reference}}</td>
            <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->matriculation}}</td>
            <td class="uppercase text-danger-dker">{{$repair->diagnostic->state->bus->chassis}}</td>
            <td>{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}</td>
            <td>{{Jenssegers\Date\Date::parse($repair->update_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$repair->id}}" onclick="validate(this)"
                   data-car="{{$repair->diagnostic->state->bus->model->brand->name." ".$repair->diagnostic->state->bus->model->name}}"
                   data-matriculation="{{$repair->diagnostic->state->bus->matriculation}}"
                   data-ot="{{$repair->diagnostic->state->reference}}"
                   data-kilometer="@if($repair->diagnostic->work->where('state','4')->isNotEmpty()){{$repair->diagnostic->work->where('state','4')->sum('distance') + $repair->diagnostic->work->where('state','1')->first()->distance + $repair->diagnostic->state->kilometer}}@else{{$repair->diagnostic->work->where('state','1')->first()->distance + $repair->diagnostic->state->kilometer}}@endif">
                    <i class="fa fa-pencil"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var  $table = $('#approvalTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
</script>
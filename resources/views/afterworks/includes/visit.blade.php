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
    @foreach($visits as $key=>$visit)
        <tr id="approval{{$visit->id}}" class="animated fadeInRight">
            <td>{{$key + 1}}</td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->state->reference}}</td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->state->bus->matriculation}}</td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->state->bus->chassis}}</td>
            <td>{{$visit->diagnostic->state->bus->model->brand->name." ".$visit->diagnostic->state->bus->model->name}}</td>
            <td>{{Jenssegers\Date\Date::parse($visit->update_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$visit->diagnostic_id}}" class="repair"
                   data-car="{{$visit->diagnostic->state->bus->model->brand->name." ".$visit->diagnostic->state->bus->model->name}}"
                   data-matriculation="{{$visit->diagnostic->state->bus->matriculation}}"
                   data-ot="{{$visit->diagnostic->state->reference}}"
                   data-kilometer="@if($visit->diagnostic->work->where('state','4')->isNotEmpty()){{$visit->diagnostic->work->where('state','4')->sum('distance') + $visit->diagnostic->work->where('state','1')->first()->distance + $visit->diagnostic->state->kilometer}}@else{{$visit->diagnostic->work->where('state','1')->first()->distance + $visit->diagnostic->state->kilometer}}@endif">
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
<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th width="1"></th>
        <th>Réference OT</th>
        <th>Immatriculation</th>
        <th>Chassis</th>
        <th>Car</th>
        <th>Date</th>
        <th width="1"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($revisions as $key=>$revision)
        <tr id="approval{{$revision->id}}" class="animated fadeInLeft">
            <td>{{$key + 1}}</td>
            <td class="uppercase text-danger-dker">{{$revision->diagnostic->state->reference}}</td>
            <td class="uppercase text-danger-dker">{{$revision->diagnostic->state->bus->matriculation}}</td>
            <td class="uppercase text-danger-dker">{{$revision->diagnostic->state->bus->chassis}}</td>
            <td>{{$revision->diagnostic->state->bus->model->brand->name." ".$revision->diagnostic->state->bus->model->name}}</td>
            <td>{{Jenssegers\Date\Date::parse($revision->update_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$revision->id}}" onclick="validate(this)"
                   data-car="{{$revision->diagnostic->state->bus->model->brand->name." ".$revision->diagnostic->state->bus->model->name}}"
                   data-matriculation="{{$revision->diagnostic->state->bus->matriculation}}"
                   data-ot="{{$revision->diagnostic->state->reference}}"
                   data-kilometer="@if($revision->diagnostic->work->where('state','4')->isNotEmpty()){{$revision->diagnostic->work->where('state','4')->sum('distance') + $revision->diagnostic->work->where('state','1')->first()->distance + $revision->diagnostic->state->kilometer}}@else{{$revision->diagnostic->work->where('state','1')->first()->distance + $revision->diagnostic->state->kilometer}}@endif">
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
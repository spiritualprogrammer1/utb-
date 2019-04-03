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
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->statee->reference}}</td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->statee->bus->matriculation}}</td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->statee->bus->chassis}}</td>
            <td>{{$visit->diagnostic->statee->bus->model->brand->name." ".$visit->diagnostic->statee->bus->model->name}}</td>
            <td>{{Jenssegers\Date\Date::parse($visit->update_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$visit->id}}" onclick="validate(this)"
                   data-car="{{$visit->diagnostic->statee->bus->model->brand->name." ".$visit->diagnostic->statee->bus->model->name}}"
                   data-matriculation="{{$visit->diagnostic->statee->bus->matriculation}}"
                   data-ot="{{$visit->diagnostic->statee->reference}}"
                   data-kilometer="@if($visit->diagnostic->work->where('state','4')->isNotEmpty()){{$visit->diagnostic->work->last()->arrive}}@else{{$visit->diagnostic->work->where('state','1')->first()->distance + $visit->diagnostic->statee->kilometer}}@endif">
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
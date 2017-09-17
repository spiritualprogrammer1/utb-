<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th width="1"></th>
        <th width="1"></th>
        <th>Reference OT</th>
        <th>Immatriculation</th>
        <th>Car</th>
        <th><i class="fa fa-calendar"></i> Date</th>
        <th><i class="fa fa-cog"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($visits as $key=>$visit)
        <tr id="approval{{$visit->id}}" class="animated fadeInRight">
            <td>{{$key + 1}}</td>
            <td>
                <a href="#" id="{{$visit->id}}" class="">
                    <i class="fa fa-search-plus text-muted"></i>
                </a>
            </td>
            <td class="uppercase text-danger-dker">{{$visit->diagnostic->state->reference}}</td>
            <td class="uppercase text-primary-dker">{{$visit->diagnostic->state->bus->matriculation}}</td>
            <td>{{$visit->diagnostic->state->bus->model->brand->name." ".$visit->diagnostic->state->bus->model->name}}</td>
            <td>{{\Jenssegers\Date\Date::parse($visit->updated_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$visit->id}}" data-type="visit" onclick="approval(this)"
                   data-car="{{$visit->diagnostic->state->bus->model->brand->name." ".$visit->diagnostic->state->bus->model->name}}"
                   data-matriculation="{{$visit->diagnostic->state->bus->matriculation}}"
                   data-ot="{{$visit->diagnostic->state->reference}}" data-diagnostic="{{$visit->diagnostic->id}}">
                    <i class="fa fa-pencil"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
var $table = $('#approvalTable');
$table.dataTable({
    "sPaginationType": "full_numbers",
    "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
    "iDisplayLength": 50,
    "language": {
        "url": "../../assets/js/datatables/French.json"
    }
});
</script>
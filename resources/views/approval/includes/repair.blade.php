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
    @foreach($repairs as $key=>$repair)
        <tr id="approval{{$repair->id}}" class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            <td>
                <a href="#" id="{{$repair->id}}" class="">
                    <i class="fa fa-search-plus text-muted"></i>
                </a>
            </td>
            <td class="uppercase text-danger-dker">{{$repair->diagnostic->statee->reference}}</td>
            <td class="uppercase text-primary-dker">{{$repair->diagnostic->statee->bus->matriculation}}</td>
            <td>{{$repair->diagnostic->statee->bus->model->brand->name." ".$repair->diagnostic->statee->bus->model->name}}</td>
            <td>{{\Jenssegers\Date\Date::parse($repair->updated_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$repair->id}}" data-type="repair" class="approval"
                   data-car="{{$repair->diagnostic->statee->bus->model->brand->name." ".$repair->diagnostic->statee->bus->model->name}}"
                   data-matriculation="{{$repair->diagnostic->statee->bus->matriculation}}"
                   data-ot="{{$repair->diagnostic->statee->reference}}" data-diagnostic="{{$repair->diagnostic->id}}">
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
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
    @foreach($revisions as $key=>$revision)
        <tr id="approval{{$revision->id}}" class="fadeInLeft">
            <td>{{$key + 1}}</td>
            <td>
                <a href="#" id="{{$revision->id}}" class="">
                    <i class="fa fa-search-plus text-muted"></i>
                </a>
            </td>
            <td class="uppercase text-danger-dker">{{$revision->diagnostic->state->reference}}</td>
            <td class="uppercase text-primary-dker">{{$revision->diagnostic->state->bus->matriculation}}</td>
            <td>{{$revision->diagnostic->state->bus->model->brand->name." ".$revision->diagnostic->state->bus->model->name}}</td>
            <td>{{\Jenssegers\Date\Date::parse($revision->updated_at)->format('j M Y')}}</td>
            <td><a href="#" id="{{$revision->id}}" data-type="revision" class="approval"
                   data-car="{{$revision->diagnostic->state->bus->model->brand->name." ".$revision->diagnostic->state->bus->model->name}}"
                   data-matriculation="{{$revision->diagnostic->state->bus->matriculation}}"
                   data-ot="{{$revision->diagnostic->state->reference}}" data-diagnostic="{{$revision->diagnostic->id}}">
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
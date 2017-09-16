<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th width="1"></th>
        <th width="1"></th>
        <th>Reference</th>
        <th>Reference OT</th>
        <th>Immatriculation</th>
        <th>Chassis</th>
        <th>Car</th>
        <th><i class="fa fa-calendar"></i> Date</th>
        @if($id == "validated")
        @else
            <th><i class="fa fa-cog"></i></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($demands as $key=>$demand)
        <tr id="approval{{$demand->id}}" class="animated fadeInLeft">
            <td>{{$key + 1}}</td>
            <td>
                <a href="#" id="{{$demand->id}}" class=""><i
                            class="fa fa-search-plus text-muted"></i></a>
            </td>
            <td class="uppercase text-danger-dker">{{$demand->diagnostic->state->reference}}</td>
            <td class="uppercase text-danger-dker">{{$demand->diagnostic->state->reference}}</td>
            <td class="uppercase text-primary-dker">{{$demand->diagnostic->state->bus->matriculation}}</td>
            <td class="uppercase">{{$demand->diagnostic->state->bus->chassis}}</td>
            <td>{{$demand->diagnostic->state->bus->model->brand->name." ".$demand->diagnostic->state->bus->model->name}}</td>
            @if($id == "validated")
                <td>{{\Jenssegers\Date\Date::parse($demand->diagnostic->updated_at)->format('j M Y')}}</td>
            @else
                <td>{{\Jenssegers\Date\Date::parse($demand->created_at)->format('j M Y')}}</td>
                <td><a href="#" id="{{$demand->id}}" onclick="waiting(this)"
                       data-car="{{$demand->diagnostic->state->bus->model->brand->name." ".$demand->diagnostic->state->bus->model->name}}"
                       data-matriculation="{{$demand->diagnostic->state->bus->matriculation}}"
                       data-ot="{{$demand->diagnostic->state->reference}}">
                        <i class="fa fa-pencil"></i></a></td>
            @endif
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
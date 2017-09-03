<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th width="5"></th>
        <th width="5"></th>
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
    @foreach($diagnostics as $key=>$diagnostic)
        <tr id="approval{{$diagnostic->id}}" class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            <td>
                <a href="#" id="{{$diagnostic->id}}" class=""><i
                            class="fa fa-search-plus text-muted"></i></a>
            </td>
            <td class="uppercase">{{$diagnostic->process->reference}}</td>
            <td class="uppercase">{{$diagnostic->process->state->bus->matriculation}}</td>
            <td class="uppercase">{{$diagnostic->process->state->bus->chassis}}</td>
            <td>{{$diagnostic->process->state->bus->model->brand->name." ".$diagnostic->process->state->bus->model->name}}</td>
            @if($id == "validated")
                <td>{{\Jenssegers\Date\Date::parse($diagnostic->updated_at)->format('j M Y')}}</td>
            @else
                <td>{{\Jenssegers\Date\Date::parse($diagnostic->created_at)->format('j M Y')}}</td>
                <td><a href="#" id="{{$diagnostic->id}}" onclick="waiting(this)"
                       data-car="{{$diagnostic->process->state->bus->model->brand->name." ".$diagnostic->process->state->bus->model->name}}"
                       data-matriculation="{{$diagnostic->process->state->bus->matriculation}}"
                       data-ot="{{$diagnostic->process->reference}}">
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
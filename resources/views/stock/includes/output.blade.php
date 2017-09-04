<table class="table table-striped m-b-none capitalize" id="demandTable">
    <thead>
    <tr>
        <th></th>
        @if($id == "demand")
        @else
            <th></th>
        @endif
        <th>Reference OT</th>
        <th>Reference demande</th>
        <th>Qté Dmdé</th>
        <th>Qté Livrée</th>
        <th>Car</th>
        <th><i class="i i-calendar"></i> Date</th>
        @if($id == "demand")
            <th><i class="i i-cog"></i></th>
        @else
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($demands as $key=>$demand)
        <tr id="output{{$demand->id}}" class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            @if($id == "demand")
            @else
                <td><a href="#" id="{{$demand->id}}" onclick="information(this)">
                        <i class="fa fa-search-plus text-muted"></i></a></td>
            @endif
            <td class="uppercase text-danger-dker">{{$demand->diagnostic->process->reference}}</td>
            <td class="uppercase text-danger-dker">{{$demand->reference}}</td>
            <td>{{number_format($demand->demand_piece->sum('quantity'))}}</td>
            <td>{{number_format($demand->demand_piece->sum('delivered'))}}</td>
            <td>{{$demand->diagnostic->process->state->bus->model->brand->name." ".$demand->diagnostic->process->state->bus->model->name}}</td>
            @if($id == "demand")
                <td>{{$demand->created_at->format('d/m/Y')}}</td>
                <td><a href="#" id="{{$demand->id}}" onclick="validate(this)"
                       data-car="{{$demand->diagnostic->process->state->bus->model->brand->name." ".$demand->diagnostic->process->state->bus->model->name}}"
                       data-demand="{{$demand->reference}}"
                       data-ot="{{$demand->diagnostic->process->reference}}" data-key="{{$key + 1}}">
                        <i class="fa fa-pencil"></i></a></td>
            @else
                <td>{{$demand->updated_at->format('d/m/Y')}}</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var $table = $('#demandTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
</script>
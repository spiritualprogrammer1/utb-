<table class="table table-striped m-b-none capitalize" id="demandTable">
    <thead>
    <tr>
        @if($id == "demand")
        @else
            <th></th>
            <th></th>
        @endif
        <th>Reference OT</th>
        <th>Réf. demande</th>
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
            @if($id == "demand")
            @else
                <td>{{$key + 1}}</td>
                <td><a href="#" id="{{$demand->id}}" onclick="information(this)">
                        <i class="fa fa-search-plus text-muted"></i></a></td>
            @endif
            <td class="uppercase text-danger-dker">{{$demand->diagnostic->statee->reference}}</td>
            <td class="uppercase text-danger-dker">{{$demand->reference}}</td>
            <td class="text-success-dk text-center font-bold">{{number_format($demand->demand_piece->sum('quantity'))}}</td>
            <td class="text-success-dk text-center font-bold">{{number_format($demand->demand_piece->sum('delivered'))}}</td>
            <td>{{$demand->diagnostic->statee->bus->model->brand->name." ".$demand->diagnostic->statee->bus->model->name}}</td>
            @if($id == "demand")
                <td>{{Jenssegers\Date\Date::parse($demand->created_at)->format('j M Y')}}</td>
                <td><a href="#" id="{{$demand->id}}" onclick="validate(this)"
                       data-car="{{$demand->diagnostic->statee->bus->model->brand->name." ".$demand->diagnostic->statee->bus->model->name}}"
                       data-demand="{{$demand->reference}}"
                       data-ot="{{$demand->diagnostic->statee->reference}}" data-key="{{$key + 1}}">
                        <i class="fa fa-pencil"></i></a></td>
            @else
                <td>{{Jenssegers\Date\Date::parse($demand->updated_at)->format('j M Y')}}</td>
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
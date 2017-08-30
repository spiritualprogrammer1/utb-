<table class="table table-striped m-b-none capitalize"
       id="vehicleTable">
    <thead>
    <tr>
        <th></th>
        <th>Immatriculation</th>
        <th>Chassis</th>
        <th>Marque</th>
        <th>Modele</th>
        <th><i class="i i-calendar"></i> Assurance</th>
        <th><i class="i i-calendar"></i> Visit T.</th>
    </tr>
    </thead>
    <tbody id="vehicleRow">
    @foreach($buses as $key=>$bus)
        <tr id="bus{{$bus->id}}" class="animated fadeInLeft">
            <td>{{$bus->designation}}</td>
            <td class="text-danger-dk uppercase">{{$bus->matriculation}}</td>
            <td class="text-danger-dk uppercase">{{$bus->chassis}}</td>
            <td>{{$bus->model->brand->name}}</td>
            <td>{{$bus->model->name}}</td>
            <td>{{\Jenssegers\Date\Date::parse($bus->assurance->date)->format('j M Y')}}</td>
            <td>{{\Jenssegers\Date\Date::parse($bus->visit->date)->format('j M Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var $table = $('#vehicleTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    });
</script>
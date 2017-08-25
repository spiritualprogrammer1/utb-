<table class="table table-responsive table-striped m-b-none animated fadeInLeft" id="stockTable">
    <thead>
    <tr>
        <th></th>
        <th>Reference</th>
        <th>Type</th>
        <th>Categorie</th>
        <th>Sous categorie</th>
        <th>Qté</th>
        <th>Fournisseur</th>
        <th><i class="i i-calendar"></i> Creation</th>
    </tr>
    </thead>
    <tbody style="text-transform: capitalize" id="stockRow">
    @foreach($stocks as $key => $stock)
        <tr id="stock{{$stock->id}}">
            <td><a href="#" id="{{$stock->id}}" onclick="loadInfo(this)"><i
                            class="fa fa-search-plus text-success-dker"></i></a></td>
            <td style="text-transform: uppercase">{{$stock->reference}}</td>
            <td>{{$stock->type->name}}</td>
            <td>{{$stock->sub_category->category->name}}</td>
            <td>{{$stock->sub_category->name}}</td>
            <td>{{$stock->quantity}}</td>
            <td>{{$stock->supplier->name}}</td>
            <td>{{$stock->created_at->format('d/m/Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    $('#stockTable').dataTable( {
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    } );
</script>
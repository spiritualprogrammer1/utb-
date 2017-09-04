<table class="table datatable table-striped b-t b-light" id="outputTable">
    <thead>
    <tr>
        <th width="10"></th>
        <th>Reference</th>
        <th>Ref. Demande</th>
        <th>Qté Sorties</th>
        <th><i class="i i-calendar"></i> Date</th>
    </tr>
    </thead>
    <tbody class="capitalize" id="outputRow">
    @foreach($movements as $key => $movement)
        <tr id="output{{$movement->id}}" class="animated fadeInDown">
            <td>
                <a href="#" id="{{$movement->id}}" onclick="information($(this))" class="info">
                    <i class="fa fa-search-plus text-muted"></i>
                </a>
            </td>
            <td class="uppercase">{{$movement->reference}}</td>
            <td class="uppercase">{{$movement->command}}</td>
            <td>{{$movement->item_stock->sum('quantity')}}</td>
            <td>{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var $table = $('#outputTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "{{asset('assets/js/datatables/French.json')}}"
        }
    });
</script>
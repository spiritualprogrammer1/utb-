<table class="table table-striped e b-info capitalize" id="deliveryTable">
    <thead>
    <tr>
        <th width="20"></th>
        <th>Référence Bon</th>
        <th>Référence Com</th>
        <th>Montant</th>
        <th>Fournisseur</th>
        <!--<th title="Date d'établissement">Date <i class="i i-dots"></i></th>-->
        <th title="Date d'enregistrement"><i class="i i-calendar"></i> Date</th>
    </tr>
    </thead>
    <tbody id="deliveryRow">
    @foreach($deliveries as $key=>$delivery)
        <tr id="delivery{{$delivery->ids}}" class="animated fadeInDown">
            <td>
                <a href="#" id="{{$delivery->ids}}" data-number="{{$delivery->number}}" class="preview"
                   data-toggle="modal">
                    <i class="fa fa-search-plus text-muted"></i>
                </a>
            </td>
            <td class="uppercase text-danger-dk">{{$delivery->number}}</td>
            <td class="uppercase text-danger-dk">{{$delivery->order}}</td>
            <td class="text-success-dker">{{number_format($delivery->amount)}} frs</td>
            <td>{{$delivery->supplier->name}}</td>
            <td>{{\Jenssegers\Date\Date::parse($delivery->delivered_at)->format('d/m/Y')}}</td>
        <!--<td>{{$delivery->created_at->format('d/m/Y')}}</td>-->
        </tr>
    @endforeach
    </tbody>
</table>
<script>
    var $table = $('#deliveryTable'),
        $preview = $('.preview');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
    $preview.on('click', function () {
        preview(this)
    });
</script>
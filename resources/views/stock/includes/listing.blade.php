<table class="table table-responsive table-striped b-primary capitalize" id="pieceTable">
    <thead>
    <tr>
        <th></th>

        <th>Reference</th>
        <th>Type</th>
        <th>Marque</th>
        <th>Modele</th>
        <th>Famille</th>
        <th>Sous famille</th>
        <th>Quantité</th>
        <th><i class="i i-calendar"></i> Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($stocks as $key=>$stock)
        <tr>
            <td>{{$key + 1}}</td>
            {{--<td>--}}
            {{--<a href="#" id="{{$stock->id}}" class="info">--}}
            {{--<i class="fa fa-search-plus text-muted"></i>--}}
            {{--</a>--}}
            {{--</td>--}}
            <td class="uppercase">{{$stock->reference}}</td>
            <td class="uppercase text-danger">
                @if($stock->stock_type==1)
                    MOTEUR

                @elseif($stock->stock_type==2)
                    PNEU
                @else
                    PIECE
                @endif


            </td>
            <td>{{$stock->Model->brand->name}}</td>
            <td>{{$stock->model->name}}</td>
            <td>{{$stock->sub_category->category->name}}</td>
            <td>{{$stock->sub_category->name}}</td>
            <td>{{number_format($stock->quantity)}}</td>
            <td>{{$stock->created_at->format('d/m/Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    var $table = $('#pieceTable');
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
</script>
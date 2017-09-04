<div class="panel-group m-b" id="accordion2">
    @foreach($movements as $key=>$movement)
        <div class="panel panel-default">
            <div class="panel-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse{{$key}}">
                    <span class="text-dark">Sortie du :
                        <span class="font-bold">{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M H:m:s')}}</span>
                    </span>, <span class="pull-right">Quantité sortie
                        <span class="badge bg-success">{{$movement->item_stock->sum('quantity')}}</span></span>
                </a>
            </div>
            <div id="collapse{{$key}}" class="panel-collapse">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="row row-sm">
                        <table class="table table-striped m-b-none b-dashed b-b" id="infoTable">
                            <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Modele</th>
                                <th>Sous Famille</th>
                                <th width="2">Stock</th>
                                <th width="2">Sortie</th>
                                <th width="2">Restant</th>
                            </tr>
                            </thead>
                            <tbody class="capitalize" id="outputRow">
                            @foreach($movement->item_stock as $key => $item)
                                <tr id="stock{{$item->id}}" class="animated fadeIn">
                                    <td class="uppercase text-danger-dker">{{$item->stock->reference}}</td>
                                    <td>{{$item->stock->model->name}}</td>
                                    <td>{{$item->stock->sub_category->name}}</td>
                                    <td class="alert alert-success">{{number_format($item->quantity_old)}}</td>
                                    <td class="alert alert-danger">{{number_format($item->quantity)}}</td>
                                    <td class="alert alert-info">{{number_format($item->quantity_old - $item->quantity)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    @endforeach
</div>


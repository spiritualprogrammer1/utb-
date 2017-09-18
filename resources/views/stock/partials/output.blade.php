<div class="modal-header">
    <section class="panel panel-info m-b-n-sm">
        <div class="panel-body">
            <a href="#" class="thumb-md pull-right m-l m-t-xs">
                <img src="{{asset('assets/images/car_wrench.png')}}"> <i
                        class="on md b-white bottom"></i>
            </a>
            <div class="clear font-bold"><a href="#" class="text-primary-dk uppercase">@<span></span></a>
                <small class="block  uppercase text-danger-dker" id="ot"></small>
                <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car"></a>
            </div>
            <h4 style="" class="text-center m-t-n-xl font-thin m-l-lg text-dark-dker">SORTIE DE
                <span class="font-bold">PIECES EFFECTUEE</span></h4>
        </div>
    </section>
</div>
<div class="panel-group m-b" id="accordionOutput">
    <?php $count = $movements->count() - 1 ?>
    @foreach($movements as $key=>$movement)
        <div class="panel panel-info">
            <div class="panel-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordionOutput" href="#dmd{{$key + 1}}">
                   <span class="text-dark">Sortie du :
                       <span class="font-bold">{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M H:m:s')}}</span>
                    </span>, <span class="pull-right">Quantité sortie
                        <span class="badge bg-success">{{$movement->item_stock->sum('quantity')}}</span></span>
                </a>
            </div>
            <div id="dmd{{$key + 1}}" class="panel-collapse collapse @if($key == 0) in @endif">
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
        </div>
    @endforeach
</div>



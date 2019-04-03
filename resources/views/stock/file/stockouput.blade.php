<style>
    body {
        color: #002D57;
    }
</style>

<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche">
    <div class="container-fluid ficheRepportOnes">
        <table class="table table-responsive">
            <tr class="row">
                <td class="text-center col-sm-4 pull-left">
                    <img src="{{asset('assets/uploads/logo/UTB.jpg')}}"
                         class="img-responsive center-block" width="80%">
                    <p style="font-size: 14px; font-weight: 600; font-family: 'Times New Roman'">
                        Union
                        des
                        Transports de Bouaké<br>
                        <span style="font-size: 12px; font-weight: 100">01 BP 4313 Abidjan 01</span><br>
                        <span style="font-size: 12px; font-weight: 100">Tél. / Fax :(225) 21 28 33 26</span>
                    </p>
                </td>
                <td class="text-center col-sm-8 pull-right" style="font-family: 'Times New Roman'">
                    <h3 style="padding-top: 18px"> SORTIE DE
                        <span class="font-bold"> <br>PIECES EFFECTUEES</span></h3>
                    <hr>
                </td>
            </tr>
        </table>
        <table class="table table-responsive">
            <tr>
                <td>ORDRE DE TRAVAIL :  <b class="uppercase">{{$demand->diagnostic->statee->reference}} </b></td>

            </tr>
        </table>

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


</section>

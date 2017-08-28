<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-black">RETOUR : <span class="uppercase"><u>{{$movement->reference}}</u></span>
        <span class="capitalize pull-right">{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M Y')}}</span></h4>
</div>
<div class="modal-body" id="print">
    <p>Liste des pieces retournées le {{$movement->created_at->format('d/m/Y')}}</p>
    <section class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped m-b-none" id="infoTable">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Marque</th>
                    <th>Modele</th>
                    <th>Sous Famille</th>
                    <th>Qté. Stock</th>
                    <th>Qté. Retournée</th>
                    <th>Qté. Add.</th>
                </tr>
                </thead>
                <tbody class="capitalize" id="outputRow">
                @foreach($items as $key => $item)
                    <tr id="stock{{$item->id}}" class="animated fadeIn">
                        <td class="uppercase">{{$item->stock->reference}}</td>
                        <td>{{$item->stock->model->brand->name}}</td>
                        <td>{{$item->stock->model->name}}</td>
                        <td>{{$item->stock->sub_category->name}}</td>
                        <td class="alert alert-success">{{number_format($item->quantity_old)}}</td>
                        <td class="alert alert-danger">{{number_format($item->quantity)}}</td>
                        <td class="alert alert-info">{{number_format($item->quantity_old + $item->quantity)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
<!--<div class="modal-footer">
    <a href="#" onclick="printThis('#print')" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-print"></i> IMPRIMER</a>
    <button type="button" onClick="$('#infoTable').tableExport({type:'pdf',escape:'false'});" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-download"></i></button>
</div>-->

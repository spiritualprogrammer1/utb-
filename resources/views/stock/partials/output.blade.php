<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title text-black">SORTIE : <span class="uppercase"><u>{{$movement->reference}}</u></span>
        <span class="capitalize pull-right">{{\Jenssegers\Date\Date::parse($movement->created_at)->format('j M Y')}}</span></h4>
</div>
<div class="modal-body">
    <p>Liste des pieces sortie le {{$movement->created_at->format('d/m/Y')}}, Reference commande:
        <a class="uppercase"><u>{{$movement->command}}</u></a></p>
    <section class="panel panel-default">
        <div class="table-responsive">
            <table class="table table-striped m-b-none" id="infoTable">
                <thead>
                <tr>
                    <th>Reference</th>
                    <th>Marque</th>
                    <th>Modele</th>
                    <th>Sous Famille</th>
                    <th>Stock</th>
                    <th>Sortie</th>
                </tr>
                </thead>
                <tbody class="capitalize" id="outputRow">
                @foreach($items as $key => $item)
                    <tr id="stock{{$item->id}}" class="animated fadeIn">
                        <td class="uppercase">{{$item->stock->reference}}</td>
                        <td>{{$item->stock->model->brand->name}}</td>
                        <td>{{$item->stock->model->name}}</td>
                        <td>{{$item->stock->sub_category->name}}</td>
                        <td>{{$item->quantity_old}}</td>
                        <td>{{$item->quantity}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-print"></i> IMPRIMER</button>
    <button type="button" class="btn btn-info btn-sm btn-rounded"><i class="fa fa-download"></i></button>
</div>

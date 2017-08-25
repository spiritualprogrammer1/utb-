<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche">
    <div class="container-fluid">
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
                    <h2 style="padding-top: 18px"> FICHE D'INVENTAIRE</h2>
                    <hr>
                </td>
            </tr>
        </table>
        <table class="col-sm-12 table table-responsive table-stripped" style="border: none">
            <thead>
            <tr>
                <th width="120"></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-right">
                    <h4>CASIER</h4>
                </td>
                <td>
                    <h5 class="text-u-c" style="font-family: 'Lucida Handwriting'; font-size: 20px"><span class="case">{{$stock->block->name}}</span></h5>
                    <div  style="border-bottom: 1px solid black; margin-top: -30px; ">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h4>DESIGNATION</h4></td>
                <td>
                    <h5 class="text-u-c" style="font-family: 'Lucida Handwriting'; font-size: 20px"><span class="category">{{$stock->sub_category->name}}</span></h5>
                    <div  style="border-bottom: 1px solid black; margin-top: -30px; ">&nbsp;</div>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h4>REFERENCE</h4></td>
                <td>
                    <h5 class="text-u-c" style="font-family: 'Lucida Handwriting'; font-size: 20px"><span class="reference">{{$stock->reference}}</span></h5>
                    <div  style="border-bottom: 1px solid black; margin-top: -30px; ">&nbsp;</div>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-responsive table-stripped">
            <thead>
            <tr>
                <th>Date</th><th>Rayon</th><th>Etagere</th><th>Casier</th><th>Quantité<sup> Ajusté</sup></th><th>Quantité <sup>stock</sup></th>
            </tr>
            </thead>
            <tbody>
            @forelse($inventories as $key=>$inventory)
                <tr class="capitalize">
                    <td>{{$inventory->created_at->format('d/m/Y')}}</td>
                    <td>{{$inventory->stock->block->shelf->ray->name}}</td>
                    <td>{{$inventory->stock->block->shelf->name}}</td>
                    <td>{{$inventory->stock->block->name}}</td>
                    <td>{{number_format($inventory->quantity)}}</td>
                    <td>{{number_format($inventory->old_quantity)}}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Aucun inventaire disponible</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="row">
            <div class="divider"></div>
            <div class="col-sm-12" style="">
            </div>
        </div>
</section>

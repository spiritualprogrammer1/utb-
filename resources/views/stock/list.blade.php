@section('title') Liste de Stock @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-list"></i> LISTE STOCK</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-stack"></i></a>
        <div class="btn-group pull-right" data-toggle="buttons">
            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
               onClick="$('#stockTable').tableExport({type:'excel',escape:'false'});">
                <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
            </a>
            <a href="#" class="btn btn-sm btn-bg btn-default"
               onClick="$('#stockTable').tableExport({type:'pdf',escape:'false'});">
                <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> Pdf
            </a>
            <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
               onClick="$('#stockTable').tableExport({type:'csv',escape:'false'});">
                <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
            </a>
        </div>
    </header>
    <section class="hbox stretch">

       <!--<aside class="aside-md bg-light dker b-r" id="subNav">
            <div class="wrapper b-b header">Afficher par Fournisseur</div>
            <ul class="nav">
                <li class="b-b"> <a href="#" id="" onclick="" style="text-transform: capitalize" class="suppliers">
                        <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Tous</a></li>
                @forelse($suppliers as $key=>$supplier)
                    <li class="b-b "> <a href="#" id="{{$supplier->id}}" style="text-transform: capitalize" class="supplier">
                            <i class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>{{$supplier->name}}
                        </a></li>
                @empty
                    <li class="b-b "><a href="#"><i
                                    class="fa fa-chevron-right pull-right m-t-xs text-xs icon-muted"></i>Aucun Fournisseur Disponible</a>
                    </li>
                @endforelse
            </ul>
        </aside>-->
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <section class="panel col-md-4 panel-danger">
                        <div class="panel-body">
                            <div class="b-b b-r">
                                <a href="#" class="block padder-v hover">
                                    <span class="i-s i-s-2x pull-left m-r-sm">
                                    <i class="i i-hexagon2 i-s-base text-danger hover-rotate"></i>
                                    <i class="i i-plus2 text-white"></i></span><span class="clear">
                                    <span class="h3 block m-t-xs text-danger">{{number_format(App\Stock::sum('total'))}} <sup>frs</sup></span>
                                    <small class="text-black text-u-c">Total acquisition</small></span>
                                </a>
                            </div>
                        </div>
                    </section>
                    <section class="panel col-md-4 panel-danger">
                        <div class="panel-body">
                            <div class="b-b b-r"><a href="#" class="block padder-v hover">
                                    <span class="i-s i-s-2x pull-left m-r-sm"><i class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
                                        <i class="i i-users2 text-white"></i></span><span class="clear">
                                            <span class="h3 block m-t-xs text-success">{{number_format(App\Supplier::count())}}</span>
                                            <small class="text-black text-u-c">Fournisseurs</small></span>
                                </a>
                            </div>
                        </div>
                    </section>
                    <section class="panel col-md-4 panel-danger">
                        <div class="panel-body">
                            <div class="b-b b-r"><a href="#" class="block padder-v hover">
                                        <span class="i-s i-s-2x pull-left m-r-sm">
                                            <i class="i i-hexagon2 i-s-base text-info hover-rotate"></i>
                                            <i class="i i-stack text-white"></i> </span>
                                    <span class="clear"><span class="h3 block m-t-xs text-info">{{number_format(App\Stock::sum('quantity'))}}</span></span>
                                    <small class="text-black text-u-c">Total pieces</small> </span>
                                </a>
                            </div>
                        </div>
                    </section>
                </header>

                <div class="scrollable wrapper w-f">
                    <section class="panel">
                        <div class="table-responsive" id="stockView">
                                <table class="table table-responsive table-striped m-b-none" id="stockTable">
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
                        </div>
                    </section>
                </div>
            </section>
        </aside>
    </section>

    <div class="modal fade" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title reference" style="text-transform: uppercase"></h4>
                </div>
                <div class="modal-body">
                    <p>Details sur le stock <span class="reference" style="text-transform: uppercase"></span></p>
                    <section class="panel panel-primary m-l-n-md  m-r-n-md m-b-none">
                        <header class="panel-heading">
                            <span class="label bg-danger pull-right quantity"></span>
                            Quantité
                        </header>
                        <table class="table table-striped m-b-none text-sm ">
                            <thead>
                            <tr>
                                <th width="200">Details</th>
                                <th>Valeurs</th>
                                <th width="20"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="item-1">
                                <td>Prix d'Acquisition HT</td>
                                <td><span class="price"></span> <sup>frs</sup> CFA</td>
                                <td class="text-right">
                                    <a href="#item-1" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id="item-2">
                                <td>Frais de Transport</td>
                                <td><span class="transport"></span> <sup>frs</sup> CFA</td>
                                <td class="text-right">
                                    <a href="#item-2" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id="item-3">
                                <td>Frais Annexes</td>
                                <td><span class="annex"></span> <sup>frs</sup> CFA</td>
                                <td class="text-right">
                                    <a href="#item-3" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id="item-4">
                                <td>Taxe sur Valeur Ajouter(TVA)</td>
                                <td><span class="tva"></span></td>
                                <td class="text-right">
                                    <a href="#item-4" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id="item-5">
                                <td>Prix d'Acquisition TTC</td>
                                <td><span class="total"></span> <sup>frs</sup> CFA</td>
                                <td class="text-right">
                                    <a href="#item-5" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id="item-6">
                                <td>Date d'enregistrement</td>
                                <td><span class="created_at"></span></td>
                                <td class="text-right">
                                    <a href="#item-6" data-dismiss="alert"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#stockTable').dataTable( {
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            } );
        });

        $('.supplier').on('click', function () {
            var id = $(this).attr('id');
            console.log(id);
            $.get('fetch_supplierStock?id=' + id, function (data) {
                $('#stockView').html("");
                $('#stockView').html(data);

            });
        });

        function test() {
            $.get('fetch_suppliersStock', function (data) {
                $('#stockView').html("");
                $('#stockView').html(data);
                console.log(data)
            });
        }
        $('.suppliers').on('click', function () {

        });

        function loadInfo(obj) {
            var id = $(obj).attr('id');
            console.log(id);
            $.get('fetch_stock?id=' + id, function (data) {
                $.each(data, function (index, modelObj) {
                    $('.reference').html(modelObj.reference);
                    $('.quantity').html(modelObj.quantity);
                    $('.price').html(modelObj.price);
                    $('.annex').html(modelObj.annex);
                    $('.total').html(modelObj.total);
                    $('.created_at').html(modelObj.created_at);
                    $('.transport').html(modelObj.transport);
                    if (modelObj.tva == 1) {
                        $('.tva').html("<span class='label label-danger'>OUI</span> Taux TVA = " + modelObj.tva_rate);
                    } else {
                        $('.tva').html("<span class='label label-primary'>NON</span>");
                    }
                });
                $('#infoModal').modal('show');
            });
        }
    </script>
@endsection
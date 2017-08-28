@section('title') Liste de Stock @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-list"></i> INVENTAIRE DU STOCK</p>
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
                                    <span class="h3 block m-t-xs text-danger">{{number_format(App\Stock::sum('total'))}}
                                        <sup>frs</sup></span>
                                    <small class="text-black text-u-c">Total acquisition</small></span>
                                </a>
                            </div>
                        </div>
                    </section>
                    <section class="panel col-md-4 panel-danger">
                        <div class="panel-body">
                            <div class="b-b b-r"><a href="#" class="block padder-v hover">
                                    <span class="i-s i-s-2x pull-left m-r-sm"><i
                                                class="i i-hexagon2 i-s-base text-success-lt hover-rotate"></i>
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
                                    <span class="clear"><span
                                                class="h3 block m-t-xs text-info">{{number_format(App\Stock::sum('quantity'))}}</span></span>
                                    <small class="text-black text-u-c">Total pieces</small>
                                    </span>
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
                                    <th>Rayon</th>
                                    <th>Etagere</th>
                                    <th>Casier</th>
                                    <th>Fournisseur</th>
                                    <th><i class="i i-calendar"></i> Creation</th>
                                    <th><i class="i i-cog2"></i></th>
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
                                        <td>{{$stock->block->shelf->ray->name}}</td>
                                        <td>{{$stock->block->shelf->name}}</td>
                                        <td>{{$stock->block->name}}</td>
                                        <td>{{$stock->supplier->name}}</td>
                                        <td>{{$stock->created_at->format('d/m/Y')}}</td>
                                        <td><a href="#" id="{{$stock->id}}" title="Ajuster le stock"
                                               class="text-primary-dk adjust" onclick="adjust(this)"><i class="i i-pencil2"></i></a></td>
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
            <div class="modal-content" id="file_content">

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="adjustModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="adjustForm" role="form" method="post" >
                <div class="modal-header">
                    <h5 class="modal-title" id="">Ajustement du stock <b><span id="stock_reference"
                                                                               class="uppercase text-danger-dker"></span></b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <h2 id="stock_category" class="uppercase text-primary"></h2>
                    <div class="form-group col-sm-3">
                        <label>Quantité du stock</label>
                        <input type="number" id="stock_quantity" class="form-control" readonly>
                    </div>
                    <div class="form-group col-sm-9">
                        <label>Quantité d'ajustement</label>
                        <input type="number" name="quantity" class="form-control">
                    </div>
                    <input id="stock_id" name="id" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">fermer</button>
                    <button type="submit" id="adjust_btn" class="btn btn-success"><i class="i i-checked"></i> AJUSTER</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var $modal = $('#infoModal');
        var $content = $('#file_content');
        function loadInfo(obj) {
            var id = $(obj).attr('id');
            $.get('fetch_inventory?id=' + id, function (data) {
                $content.html(data);
                $modal.modal('show');
            });
        }

        function adjust(obj) {
            var id = $(obj).attr('id');
            $.get('fetch_stock?id=' + id, function (data) {
                $.each(data, function (index, modelObj) {
                    $('#stock_reference').html(modelObj.reference);
                    $('#stock_category').html(modelObj['sub_category'].name);
                    $('#stock_id').val(modelObj.id);
                    $('#stock_quantity').val(modelObj.quantity)
                });
                $('#adjustModal').modal('show')
            });
        }

        $('#adjustForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var $this = $('#adjust_btn');
            $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
            $this.button('loading');
            $.ajax({
                url: '{{route('/adjust')}}',
                type: 'post',
                data: formData,
                success: function (data) {
                    $('#adjustForm').trigger('reset');
                    var row = '<tr id="stock' + data.id + '" class="alert alert-info text-danger-dk capitalize">' +
                        '<td> <a href="#" id="' + data.id + '" onclick="loadInfo(this)"><i class="fa fa-search-plus text-success"></i></a></td>' +
                        '<td style="text-transform: uppercase"><b>' + data.reference + '</b></td>' +
                        '<td><b>' + data.type + '</b></td>' +
                        '<td><b>' + data.category + '</b></td>' +
                        '<td><b>' + data.sub_category + '</b></td>' +
                        '<td><b>' + data.quantity + '</b></td>' +
                        '<td><b>' + data.ray + '</b></td>' +
                        '<td><b>' + data.shelf + '</b></td>' +
                        '<td><b>' + data.block + '</b></td>' +
                        '<td><b>' + data.supplier + '</b></td>' +
                        '<td><b>' + data.date + '</b></td>' +
                        '<td><a href="#" id="' + data.id + '" title="Ajuster le stock" class="text-primary-dk adjust" onclick="adjust(this)"><i class="i i-pencil2"></i></a></td>' +
                        '<tr>';
                        $('#stock' + data.id).replaceWith(row);
                    $('#adjustModal').modal('hide')
                },
                error: function (jqXhr) {
                    if (jqXhr.status === 401)
                        window.location.href = "/";
                    if (jqXhr.status === 422) {
                        $errors = jqXhr.responseJSON;
                        $.each($errors, function (key, value) {
                            $ferrors = value.name
                        });
                        toastr["error"]($ferrors, "Oups!");
                        toastr.options.preventDuplicates = true;
                    } else {
                    }
                }
            });
            $this.button('reset');
        });

        $(document).ready(function () {
            $('#stockTable').dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
        });
    </script>
@endsection
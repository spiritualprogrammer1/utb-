@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-xl bg-white lter b-r" id="subNav">
            <section class="scrollable ">
                <form method="post" id="stockForm" class="">
                    {{csrf_field()}}
                    <input name="stock_id" type="hidden" id="stock_id">
                    <div class="panel-body panel-danger" style="height:550px;position: relative;overflow: scroll">
                        <div class="row">
                            <div class="has-success form-group-sm col-md-7">
                                <label class="control-label">REFERENCE DU STOCK</label>
                                <input type="text" name="reference" id="reference" min="3"
                                       class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="Reference du stock" required>
                            </div>
                            <div class="form-group-sm col-md-5">
                                <label>Type de piece</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UN TYPE..." id="type" name="type">
                                    <option></option>
                                    @foreach($types as $key => $type)
                                        <option value="{{$type->id}}" class="uppercase">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-sm m-b-sm">
                            <div class="form-group-sm  col-sm-6">
                                <label>Marque de Piece</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UNE MARQUE..." id="brand" name="brand">
                                    <option></option>
                                    @forelse($brands as $key => $brand)
                                        <option value="{{$brand->id}}"
                                                class="uppercase">{{$brand->name}}</option>
                                    @empty
                                        <option>AUCUNE FAMILLE DISPONIBLE</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6">
                                <label class="control-label">Modele Piece</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UN MODELE..." id="model" name="model">
                                    <option selected disabled>......................................
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="form-group-sm col-sm-6">
                                <label class="control-label">Famille</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UNE FAMILLE..."
                                        id="category" name="category">
                                    <option></option>
                                    @forelse($categories as $key => $category)
                                        <option value="{{$category->id}}"
                                                class="uppercase">{{$category->name}}</option>
                                    @empty
                                        <option disabled>AUCUNE FAMILLE DISPONIBLE</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6">
                                <label class="control-label">Sous Famille</label>
                                <select class="chosen-select input-sm form-control parsley-validated"
                                        data-placeholder="CHOISISEZ UNE SOUS FAMILLE..." id="subcategory"
                                        name="sub_category">
                                    <option selected disabled>......................................
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-md m-b-sm uppercase">Entreposage</div>
                        <div class="row">
                            <div class="form-group-sm col-sm-10">
                                <label>Rayon de rangement</label>
                                <select class="chosen-select input-sm form-control" id="ray"
                                        data-placeholder="CHOISISEZ UN RAYON DE RANGEMENT...">
                                    <option></option>
                                    @foreach($rays as $key => $ray)
                                        <option value="{{$ray->id}}"
                                                class="uppercase">{{$ray->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6 m-t-sm">
                                <label>Etagere</label>
                                <select class="chosen-select input-sm form-control" id="shelf"
                                        data-placeholder="CHOISISEZ UNE ETAGERE...">
                                    <option value selected disabled>......................................
                                    </option>
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6 m-t-sm">
                                <label>Casier</label>
                                <select class="chosen-select input-sm form-control" id="block" name="block"
                                        data-placeholder="CHOISISEZ UN CASIER...">
                                    <option selected disabled>......................................
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-md m-b-sm uppercase">Bon de livraison
                        </div>
                        <div class="row">
                            <div class="form-group-sm col-sm-6">
                                <label class="text-center">Référence du bon</label>
                                <select class="chosen-select input-sm form-control" id="delivery" name="stock_delivery"
                                        data-placeholder="CHOISISEZ UNE REFERENCE DE BON...">
                                    <option></option>
                                    @foreach($deliveries as $key => $delivery)
                                        <option value="{{$delivery->ids}}"
                                                class="uppercase">{{$delivery->number}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group-sm col-sm-6">
                                <label>Fournisseur</label>
                                <input class="form-control input-sm text-center uppercase text-danger-dk delivery-info" readonly
                                       id="supplier">
                            </div>
                            <div class="form-group-sm col-sm-9 ">
                                <label>Référence Commande</label>
                                <input class="form-control input-sm text-center uppercase text-danger-dk delivery-info" readonly
                                       id="order">
                            </div>
                        </div>
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-md m-b-sm uppercase">Acquisition
                        </div>
                            <div class="row acquisition">
                                <div class="form-group form-group-sm col-sm-6">
                                    <label class="control-label">Prix Unitaire</label>
                                    <input type="text" name="price" id="price" min="3" maxlength="9" value="0"
                                           class="form-control input-sm input_numeric" placeholder="0"
                                           required>
                                </div>

                                <div class="form-group-sm col-sm-6">
                                    <label class="control-label">Quantité</label>
                                    <input type="text" name="quantity" id="quantity"
                                           class="form-control input-sm input_numeric" placeholder="0" required>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group form-group-sm col-sm-4">
                                    <label class="control-label"><sup>Frais</sup> annnexe</label>
                                    <input type="text" value="0" id="annex" maxlength="9" name="annex"
                                           class="form-control input-sm input_numeric"
                                           placeholder="0"
                                           required>
                                </div>
                                <div class="form-group col-sm-2">
                                    <div class="checkbox i-checks"><br>
                                        <label> <input type="checkbox" data-group="1" id="tva" value="1"
                                                       name="tva">
                                            <i></i>TVA</label></div>
                                    <input name="ttva" id="ttva" value="18" type="hidden">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="control-label">TOTAL</label>
                                    <input type="text" name="total" id="total" class="form-control input-sm"
                                           placeholder="0" required readonly>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group-sm col-sm-6 m-t-md">
                                    <button type="submit" value="save" id="submit"
                                            class="btn btn-success btn-group-justified uppercase">
                                        <i class="fa fa-floppy-o"></i> enregistrer
                                    </button>
                                </div>
                                <a href="#" class="btn btn-sm btn-icon btn-default pull-right btn_reset none"
                                   onclick="reset_btn($('#stock_btn'), $('#suppliers'), $('#brand'), $('#model'), $('#category'), $('#subcategory'), $('#type'),
                                           $('#ray'), $('#shelf'), $('#block'));">
                                    <i class="fa fa-refresh"></i>
                                </a>
                            </div>

                    </div>
                </form>
            </section>
        </aside>
        <aside>
            <section class="vbox">
                <header class="header bg-white b-b clearfix">
                    <div class="row m-t-sm">
                        <div class="col-sm-6 m-b-xs">
                            <a href="#subNav" data-toggle="class:hide"
                               class="btn btn-sm btn-default active pull-left m-r-md">
                                <i class="fa fa-caret-right text fa-lg"></i>
                                <i class="fa fa-caret-left text-active fa-lg"></i>
                            </a>
                            <h4><i class="i i-stack"></i> NOUVEAU STOCK</h4>
                        </div>
                        <div class="btn-group pull-right" data-toggle="buttons">
                            <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                               onClick="$('#stockTable').tableExport({type:'xlsx',escape:'false'});">
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
                    </div>
                </header>
                <section class="scrollable bg-light dk wrapper">
                        <div class="panel panel-default table-responsive">
                            <table class="table datatable table-responsive table-striped m-b-none capitalize"
                                   id="stockTable">
                                <thead>
                                <tr>
                                    <th>Reference</th>
                                    <th>Type</th>
                                    <th>Famille</th>
                                    <th>Sous Famille</th>
                                    <th>Qté</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                    <th width="1"><i class="i i-cog2"></i></th>
                                </tr>
                                </thead>
                                <tbody id="stockRow">
                                @foreach($stocks as $key => $stock)
                                    <tr id="stock{{$stock->id}}">
                                        <td class="uppercase text-danger-dker">{{$stock->reference}}</td>
                                        <td>{{$stock->type->name}}</td>
                                        <td>{{$stock->sub_category->category->name}}</td>
                                        <td>{{$stock->sub_category->name}}</td>
                                        <td class="text-success-dk font-bold">{{number_format($stock->quantity)}}</td>
                                        <td>{{Jenssegers\Date\Date::parse($stock->created_at)->format('j M Y')}}</td>
                                        <td>
                                            <a href="#" id="{{$stock->id}}" onclick="stockEdit(this)">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                </section>
                <div class="cssload-container m-t-n-lg none">
                    <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                        <div class="cssload-progress-item"></div>
                    </div>
                </div>
            </section>
        </aside>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/scripts/stock.create.js')}}"></script>
    <script>
        /*****************/


        $spinner =$('#spinner'),
            $brand = $('#brand'),
            $model = $('#model'),
            $family = $('#category'),
            $sub_family = $('#subcategory'),
            $ray = $('#ray'),
            $shelf = $('#shelf'),
            $block = $('#block'),
            $reference = $('#reference'),
            $form = $('#stockForm'),
            $submit = $('#submit'),
            $row = $('#stockRow'),
            $supplier = $('#supplier'),
            $order = $('#order'),
            $chosen = $('.chosen-select'),
            $delivery_info = $('.delivery-info'),
            $delivery=$('#delivery'),
            $reference=$('#reference'),
            $order=$('#order'),
            $quantity=$('#quantity'),
            $horse=$('#horse'),
            $vitesse=$('#vitesse'),
            $displacement=$('#displacement'),
            $power=$('#power'),
            $mileage=$('#mileage'),
            $type_pneu=$('#type_pneu'),
            $category=$('#category'),
            $subcategory=$('#subcategory'),
            $type=$('#type'),
            $libelle=$('#libelle'),
            $sens_tire=$('#sens_tire');



        /****************/
        var $tva=$('#tva');
        $tva.on("click", function () {
            var pric = $('input[name="price"]').val();

            var annex = $('input[name="annex"]').val();
            var tva = $('input[name="ttva"]').val();
            var total = $('input[name="total"]').val();
            var quantit = $('input[name="quantity"]').val();

            var check;
            check = $("#tva").is(":checked");
            if (check) {

                var prix = parseInt(pric) * parseInt(quantit);

                var ht = prix  + parseInt(annex);
                var tva_amount = (ht * (tva / 100));
                var ttc = (ht + tva_amount);
                $('input[name="total"]').val(ttc);
            } else {
                var prix = parseInt(pric) * parseInt(quantit);
                var ht = prix  + parseInt(annex);
                $('input[name="total"]').val(ht);
            }
        });
        $('.acquisition input').bind('keyup mouseup', calculate);
        function calculate(event) {
            var price = $('input[name="price"]').val();
            var annex = $('input[name="annex"]').val();
            var tva = $('input[name="ttva"]').val();
            var total = $('input[name="total"]').val();
            var quantity = $('input[name="quantity"]').val();
            var check;
            if (event.target.name == 'total') {
                /*var new_prix_ht = (total/(1+tva/100)).toFixed(2);
                 $('input[name="price"]').val(new_prix_ht);*/
            }
            else {
                check = $("#tva").is(":checked");
                if (check) {
                    var prix = parseInt(price) * parseInt(quantity);
                    var ht = prix  + parseInt(annex);
                    var tva_amount = (price * (tva / 100));
                    var ttc = (ht + tva_amount);
                    $('input[name="total"]').val(ttc);
                } else {
                    var prix = parseInt(price) * parseInt(quantity);
                    var ht = prix + parseInt(annex);
                    $('input[name="total"]').val(ht);
                }
            }
        }
        function stockEdit(obj) {

           // $spinner.show();
            $('.btn_reset').show();

            var $this = $submit;
            var id = $(obj).attr('id');
            $form.attr('action', '../stock/upatestock/' + id);
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('../../stock/editstock/' + id, function (data) {

                model(data.model_id);
                sub(data.sub_category_id);
                blocks(id, data.block_id);
                delivery(data.delivery_id)
                $mileage.val(data.mileage)
                $reference.val(data.reference)
                $('#stock_id').val(data.id);
                $('#suppliers').val(data.supplier_id);
                $brand.val(data.brand_id);
                $brand.trigger("chosen:updated");
                $model.val(data.model_id);
                $model.trigger("chosen:updated");
                $subcategory.val(data.sub_category_id);
                $subcategory.trigger("chosen:updated");
                $type.val(data.type_id);
                $type.trigger("chosen:updated");
                $power.val(data.power)
                $type_pneu.val(data.typtire_id)
                $type_pneu.trigger("chosen:updated")
                $displacement.val(data.displacement)

                $sens_tire.val(data.sens_tire);
                $sens_tire.trigger("chosen:updated");

                $horse.val(data.horse)
                $vitesse.val(data.vitesse)
                $libelle.val(data.libelle)
                $('#charge').val(data.charge)
                $('#dot').val(data.dot)
                $('#diametre').val(data.diametre)
                $('#hauteur').val(data.hauteur)
                $('#width').val(data.width)
                $('#typtire_id').val(data.typtire_id)
                $('#weight').val(data.weight)

                // $price.val(data.price);
                // $reference_invoice.val(data.reference_invoice);
                $quantity.val(data.quantity);
                // $total.val(data.total);
                // $annex.val(data.annex);
                // $transport.val(data.transport);
                $reference.val(data.reference);
                // $famillypiece_id.val(data.famillypiece_id);
                // $priceventeunitaire.val(data.priceventeunitaire);
                // $priceventemarge.val(data.priceventemarge);
                // $marge.val(data.marge);


                $spinner.hide()
            })
        }
        function blocks(id, block) {
            var type = "block";
            $.get('../../stock/shelving/' + id + '/' + type, function (data) {
                $block.empty();
                $.each(data, function (index, contractObj) {
                    $block.append('<option value="' + contractObj.id + '">' + contractObj.name + '</option>');
                    $block.trigger("chosen:updated");
                    shelve(block, contractObj.shelf_id);
                });
                $block.val(block);
                $block.trigger("chosen:updated");
            });
        }

        function model(id) {
            var type = "change";
            $.get('../../stock/brand_models/' + id + '/' + type, function (data) {
                $model.empty();
                $.each(data, function (index, contractObj) {
                    $model.append('<option value="' + contractObj.id + '">' + contractObj.name + '</option>');
                    $model.trigger("chosen:updated");
                    $brand.val(contractObj.brand_id);
                    $brand.trigger("chosen:updated");
                });
                $model.val(id);
                $model.trigger("chosen:updated");
            });
        }
        function sub(id) {
            var type = "change";
            $.get('../../stock/category_subcategories/' + id + '/' + type, function (data) {
                $subcategory.empty();
                $.each(data, function (index, contractObj) {
                    $subcategory.append('<option value="' + contractObj.id + '">' + contractObj.name + '</option>');
                    $subcategory.trigger("chosen:updated");
                    $category.val(contractObj.category_id);
                    $category.trigger("chosen:updated");
                });
                $subcategory.val(id);
                $subcategory.trigger("chosen:updated");
            });
        }
        function supplier(id) {
            var type = "change";
            $.get('../../stock/suppliers/' + id + '/' + type, function (data) {

                $supplier.val(data.name);
                $supplier.trigger("chosen:updated");
            });
        }
        function delivery(id) {
            var type = "change";
            $.get('../../stock/deliveryget/' + id + '/' + type, function (data) {
                $delivery.empty();
                $.each(data, function (index, contractObj) {
                    $delivery.append('<option selected value="' + contractObj.id + '">' + contractObj.number + '</option>');
                    $delivery.trigger("chosen:updated");
                    supplier(contractObj.supplier_id);
                    $order.val(contractObj.order)
                    // $delivery.val(contractObj.number);
                    // $delivery.trigger("chosen:updated");
                    // $supplier.val(contractObj.supplier_id);
                    // $supplier.trigger("chosen:updated");
                });

            });
        }
    </script>
@endsection
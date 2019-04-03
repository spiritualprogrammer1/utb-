@section('title') Nouveau Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="hbox stretch">
        <aside class="aside-xl bg-white lter b-r" id="subNav">
            <section class="scrollable ">
                <form method="post" id="stockForm" class="" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input name="stock_id" type="hidden" id="stock_id">
                    <div class="panel-body panel-danger" style="height:680px;position: relative;overflow: scroll">
                        <div class="row">
                            <div class="has-success form-group-sm col-md-8">
                                <label class="control-label">REFERENCE</label>
                                <input type="text" name="reference" id="reference" min="3"
                                       class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="Reference du moteur" required>
                            </div>
                        </div>
                        <div class="row m-t-sm m-b-sm">
                            <div class="has-success form-group-sm col-md-6">
                                <label class="control-label">Libelle</label>
                                <input type="text" name="libelle" id="libelle" min="2"
                                       class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="Libelle du moteur" required>
                            </div>
                            <div class="form-group-sm col-md-6">
                                <label>Etat de moteur</label>
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
                            <div class="form-group-sm  col-sm-12">
                                <label>Type du moteur</label>
                                <select class="chosen-select input-sm form-control"
                                        data-placeholder="CHOISISEZ UN TYPE..." id="type_moteur" name="type_moteur">
                                    <option></option>
                                    <option value="MOTEUR V"
                                            class="uppercase">MOTEUR V</option>
                                    <option value="MOTEUR W"
                                            class="uppercase">MOTEUR W</option>
                                    <option value="MOTEUR FLAT (À PLAT)"
                                            class="uppercase">MOTEUR FLAT (À PLAT)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-sm m-b-sm">
                            <div class="form-group-sm  col-sm-6">
                                <label>Marque du moteur</label>
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
                            <img src="{{asset('assets/images/loading.gif')}}" style="position: absolute"
                                 class="m-t-md m-l-n-sm none"
                                 id="loader_brand" width="20">
                            <div class="form-group-sm col-sm-6">
                                <label class="control-label">Modele Moteur</label>
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
                            <img src="{{asset('assets/images/loading.gif')}}" style="position: absolute"
                                 class="m-t-md m-l-n-sm none"
                                 id="loader_familly" width="20">
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
                        <div class="row">
                            <div class="has-info form-group-sm col-sm-6 m-t-sm m-b-sm">
                                <label class="control-label">Kilométrage</label>
                                <input type="text" name="mileage" id="mileage"  class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="Kilometrage" required >

                            </div>
                            <div class="has-info form-group-sm col-sm-6 m-t-sm m-b-sm">
                                <label class="control-label">Puissance</label>
                                <input type="text" name="power" id="power"  class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="puissance en KW" required >

                            </div>
                            <div class="has-danger form-group-sm col-sm-6 m-t-sm m-b-sm">
                                <label class="control-label">cylindrée</label>
                                <input type="text" name="displacement" id="displacement" class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="cylindrée en Litre" required >

                            </div>
                            <div class="has-danger form-group-sm col-sm-6 m-t-sm m-b-sm">
                                <label class="control-label">cheval </label>
                                <input type="text" name="horse" id="horse"  class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="le nombre de ch" required >

                            </div>

                            <div class="has-danger form-group-sm col-sm-9 m-t-sm m-b-sm">
                                    <label class="control-label">Vitesse Maximale</label>
                                    <input type="text" name="vitesse" id="vitesse" min="3" maxlength="9" value="0"
                                           class="form-control input-sm input_numeric text-danger" placeholder="0"
                                           required>


                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <label class="control-label col-sm-12 uppercase text-info">Image du moteur</label>
                            <br/>
                            <div class="form-group col-sm-12">
                                    <div >
                                        <div class="kv-avatar center-block text-center" style="width:200px">
                                            <input id="avatar-2" name="image_engine" type="file" class="file-loading" >
                                        </div>
                                    </div>
                                    <div id="kv-avatar-errors-2" class="center-block" style="width:700px;display:none"></div>

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
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-md m-b-sm uppercase">
                        </div>
                        <div class="row acquisition">
                            <div class="form-group form-group-sm col-sm-4">
                                <label class="control-label">Quantite</label>
                                <input type="text" name="quantity" id="quantity" min="3" maxlength="9" value="0"
                                       class="form-control input-sm input_numeric" placeholder="0"
                                       required>
                            </div>

                        </div>

    <input type="hidden" value="1" name="stock_type">

                        <div class="">
                            <div class="form-group-sm col-sm-6 m-t-md">
                                <button type="submit" value="save" id="submit"
                                        class="btn btn-success btn-group-justified uppercase">
                                    <i class="fa fa-floppy-o"></i> enregistrer
                                </button>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon btn-info pull-right btn_reset none"
                               onclick="reset_btn($('#submit'), $('#delivery'),$('#order'),$('#supplier'),$('#quantity'), $('#brand'), $('#model'), $('#category'), $('#subcategory'), $('#type'),
                                           $('#ray'), $('#shelf'), $('#block'),$('#vitesse'),$('#horse'),
                                           $('#displacement'),$('#power'),$('#mileage'),$('#type_moteur'),$('#reference'),$('#libelle'));">
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
                            <h4>  <img src='{{asset('assets/logo/moteurgood.png')}}' width="20"/> LISTE DES MOTEURS </h4>
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
                                <th>Etat</th>
                                <th>Famille</th>
                                <th>Sous Famille</th>
                                <th>Qté</th>
                                <th><i class="i i-calendar"></i> Date</th>
                                <th width="1"><i class="i i-cog2"></i></th>
                            </tr>
                            </thead>
                            <tbody id="stockRow">
                            @foreach($engine as $key => $engin)
                                <tr id="stock{{$engin->id}}">
                                    <td class="uppercase text-danger-dker">{{$engin->reference}}</td>
                                    <td>{{$engin->type->name}}</td>
                                    <td>{{$engin->sub_category->category->name}}</td>
                                    <td>{{$engin->sub_category->name}}</td>
                                    <td class="text-success-dk font-bold">{{number_format($engin->quantity)}}</td>
                                    <td>{{Jenssegers\Date\Date::parse($engin->created_at)->format('j M Y')}}</td>
                                    <td>
                                        <a href="#" id="{{$engin->id}}" onclick="stockEdit(this)">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                <div class="cssload-container m-t-n-lg none" id="spinner">
                    <div class="cssload-progress cssload-float cssload-shadow m-t-n-lg">
                        <div class="cssload-progress-item"></div>
                    </div>
                </div>
            </section>
        </aside>
    </section>
@endsection
@section('scripts')

    <script>

        var $table = $('#stockTable'),
                $model_spinner = $('#model_spinner'),
                $sub_spinner = $('#sub_spinner'),
                $shelf_spinner = $('#shelf_spinner'),
                $bloc_spinner = $('#bloc_spinner'),
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
            $type_moteur=$('#type_moteur'),
            $category=$('#category'),
            $subcategory=$('#subcategory'),
            $type=$('#type'),
            $libelle=$('#libelle'),



            /**loader**/
            $loader_brand=$('#loader_brand');





        $delivery = $('#delivery');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                //  "order": [[4, "desc"]],
                "language": {
                    "url": "../../assets/js/datatables/French.json"
                }
            });
            $brand.on('change', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('modelBy/' + id, function (data) {
                    if (data.length === 0) {
                        $model.empty();
                        $model.trigger("chosen:updated");
                    } else {
                        $model.empty();
                        $.each(data, function (index, modelObj) {
                            $model.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
                            $model.trigger("chosen:updated");
                        })
                    }
                    $spinner.hide()
                })
            });
            $family.on('change', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('subFamily/' + id, function (data) {
                    if (data.length === 0) {
                        $sub_family.empty();
                        $sub_family.trigger("chosen:updated");
                    } else {
                        $sub_family.empty();
                        $.each(data, function (index, modelObj) {
                            $sub_family.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
                            $sub_family.trigger("chosen:updated");
                        })
                    }
                    $spinner.hide()
                })
            });
            $ray.on('change', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('shelves/' + id, function (data) {
                    if (data.length === 0) {
                        $shelf.empty();
                        $shelf.trigger("chosen:updated");
                    } else {
                        $shelf.empty();
                        $shelf.append('<option></option>');
                        $.each(data, function (index, modelObj) {
                            $shelf.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
                            $shelf.trigger("chosen:updated");
                        })
                    }
                    $spinner.hide()
                })
            });
            $shelf.on('change', function () {
                $spinner.show();
                var id = $(this).val();
                $.get('blocs/' + id, function (data) {
                    if (data.length === 0) {
                        $block.empty();
                        $block.trigger("chosen:updated");
                    } else {
                        $block.empty();
                        $block.append('<option></option>');
                        $.each(data, function (index, modelObj) {
                            $block.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
                            $block.trigger("chosen:updated");
                        })
                    }
                    $spinner.hide()
                })
            });
            $form.on('submit', function (e) {
                e.preventDefault();
               // var formData = $(this).serialize();
                $spinner.show()
                var formData = new FormData($(this)[0]);
                var $this = $submit;
                var state = $this.val();
                var type = 'post';
                var url = 'saveengine';
                if (state == 'edit') {
                    // type = 'put';
                    url = $(this).attr('action');
                    msg = "le moteur a été mis à jour";
                }

                status = "success";
                var msg = "le moteur a bien été enregistrer";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $form.trigger('reset');
                        $chosen.trigger('chosen:updated');
                        $reference.focus();
                        toastr[status](msg, "<span class='uppercase'>" + data.reference + "</span>!");
                        toastr.options.preventDuplicates = true;
                        var row = '<tr id="stock' + data.id + '" class="alert alert-info text-danger-dk">' +
                                '<td style="text-transform: uppercase">' + data.reference + '</td>' +
                                '<td>' + data.type + '</td>' +
                                '<td>' + data.family + '</td>' +
                                '<td>' + data.sub + '</td>' +
                                '<td>' + data.quantity + '</td>' +
                                '<td>' + data.date + '</td>' +
                                '<td><a href="#" id="' + data.id + '" onclick="stockEdit(this)"><i class="fa fa-pencil"></i></a></td>' +
                                '<tr>';


                        if (state == 'save') {
                            $row.before(row);
                        } else {
                            $('#stock' + data.id).replaceWith(row);
                        }
                        $submit.button('reset');
                        $form.trigger('reset');
                        $this.button('reset');

                        $spinner.hide()
                        reset_btn($this, $delivery, $order, $supplier, $quantity, $brand, $model, $category, $subcategory, $block,$type,$ray,
                           $shelf,$block,$vitesse,$horse,$displacement,$power,$mileage,$type_moteur,$libelle);

                    },
                    error: function (jqXhr) {
                        if (jqXhr.status === 401)
                            window.location.href = "/";
                        if (jqXhr.status === 422) {
                            var errors = jqXhr.responseJSON.message;
                            var errorsHtml = '';
                            $.each(errors, function (key, value) {
                                errorsHtml += value[0] + '</br>';
                            });
                            swal(
                                    'Oops...',
                                    errorsHtml,
                                    'error'
                            );
                            $submit.button('reset');
                            $spinner.hide()
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $submit.button('reset');
                        }
                    }
                });
            });
            $delivery.on('change', function () {
                $delivery_info.addClass('loading-input');
                var id = $(this).val();
                $.get('deliveryBy/' + id, function (data) {
                    $supplier.val(data.supplier);
                    $order.val(data.order);
                    $delivery_info.removeClass('loading-input');
                })
            })
        });



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

        reset_btn($('#submit'), $('#delivery'),$('#order'),$('#supplier'),$('#quantity'), $('#brand'), $('#model'), $('#category'), $('#subcategory'), $('#type'),
            $('#ray'), $('#shelf'), $('#block'),$('#vitesse'),$('#horse'),
            $('#displacement'),$('#power'),$('#mileage'),$('#type_moteur'),$('#reference'))




        function reset_btn(obj,delivery,order,supplier,quantity, brand, model, category, subcategory, type,shelf,ray,block,vitesse,horse,displacement,power,mileage,type_moteur,reference,libelle) {
            supplier.val('');
            supplier.trigger("chosen:updated");
            brand.val('');
            brand.trigger("chosen:updated");
            model.empty();
            model.trigger("chosen:updated");
            category.val('');
            category.trigger("chosen:updated");
            subcategory.empty();
            subcategory.trigger("chosen:updated");
            horse.val('')
            order.val('')
            displacement.val('')

            quantity.val('')
            power.val('')
            mileage.val('')
            vitesse.val('')
            type_moteur.val('')
            reference.val('')
            // type.val('');
            // type.trigger("chosen:updated");
            ray.val('');
            ray.trigger("chosen:updated");
            shelf.val('');
            shelf.trigger("chosen:updated");
            block.val('');
            block.trigger("chosen:updated");
            type_moteur.val('');
            type_moteur.trigger("chosen:updated");
            delivery.val('');
            delivery.trigger("chosen:updated");


            // reference_invoice.val('');
            // reference_invoice.trigger("chosen:updated");
            // famillypiece_id.val('');
            // famillypiece_id.trigger("chosen:updated");

            obj.html('<i class="fa fa-floppy-o"></i> enregistrer');
            obj.val('save');
            $('.btn_reset').hide();
        }




        function stockEdit(obj) {
            $spinner.show();
            $('.btn_reset').show();
            var $this = $submit;
            var id = $(obj).attr('id');
            $form.attr('action', '../stock/upatestock/' + id);
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('../stock/editstock/' + id, function (data) {
                //
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
                $type_moteur.val(data.type_moteur)
                $type_moteur.trigger("chosen:updated")
                $displacement.val(data.displacement)
                $horse.val(data.horse)
                $vitesse.val(data.vitesse)
                $libelle.val(data.libelle)

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
        function shelve(id, selected) {
            var type = "change";
            $.get('../stock/shelving/' + id + '/' + type, function (data) {
                $shelf.empty();
                $.each(data, function (index, contractObj) {
                    $shelf.append('<option value="' + contractObj.id + '">' + contractObj.name + '</option>');
                    $shelf.trigger("chosen:updated");
                    $ray.val(contractObj.ray_id);
                    $ray.trigger("chosen:updated");
                });
                $shelf.val(selected);
                $shelf.trigger("chosen:updated");
            });
        }
        function blocks(id, block) {
            var type = "block";
            $.get('../stock/shelving/' + id + '/' + type, function (data) {
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
            $.get('../stock/brand_models/' + id + '/' + type, function (data) {
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
            $.get('../stock/category_subcategories/' + id + '/' + type, function (data) {
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
            $.get('../stock/suppliers/' + id + '/' + type, function (data) {

                $supplier.val(data.name);
                $supplier.trigger("chosen:updated");
            });
        }
        function delivery(id) {
            var type = "change";
            $.get('../stock/deliveryget/' + id + '/' + type, function (data) {
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

        var btnCust = '<button type="button" class="btn btn-default" title="" ' +
            'onclick="console(\'\')">' +
            '<i class="glyphicon glyphicon-tag"></i>' +
            '</button>';
        $("#avatar-2").fileinput({
            overwriteInitial: true,
            maxFileSize: 500000,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            browseOnZoneClick: true,
            removeLabel: '',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'supprimer le fichier ',
            elErrorContainer: '#kv-avatar-errors-2',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="{{asset('logo/moteure.jpg')}}" alt="Your Avatar" style="width:200px"><h6 class="text-muted"></h6>',
            layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
            allowedFileExtensions: ["docx","pdf","jpg", "png", "gif"]
        });
    </script>
@endsection
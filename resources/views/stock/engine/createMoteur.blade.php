@section('title') Nouveau Moteur @endsection
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
                            <div class="has-success form-group-sm col-md-8">
                                <label class="control-label">REFERENCE</label>
                                <input type="text" name="reference" id="reference" min="3"
                                       class="form-control input-sm text-danger-dk uppercase"
                                       placeholder="Reference du stock" required>
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
                                <label>Type de moteur</label>
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
                        <div class="text-muted text-sm hidden-nav-xs padder m-t-md m-b-sm uppercase">Caracteristique
                        </div>
                        <div class="row acquisition">
                            <div class="form-group form-group-sm col-sm-4">
                                <label class="control-label">Quantite</label>
                                <input type="text" name="quantity" id="quantity" min="3" maxlength="9" value="0"
                                       class="form-control input-sm input_numeric" placeholder="0"
                                       required>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label class="control-label">Kilometrage </label>
                                <input type="text" name="kilometrage" id="kilometrage" min="3" maxlength="9" value="0"
                                       class="form-control input-sm input_numeric" placeholder="0"
                                       required>
                            </div>
                            <div class="form-group form-group-sm col-sm-4">
                                <label class="control-label">Puissance</label>
                                <input type="text" name="puissance" id="puissance" min="3" maxlength="9" value="0"
                                       class="form-control input-sm input_numeric" placeholder="0"
                                       required>
                            </div>

                        </div>
                        <div class="row acquisition">
                            <div class="form-group form-group-sm col-sm-8">
                                <label class="control-label">Vitesse Maximale</label>
                                <input type="text" name="vitesse" id="vitesse" min="3" maxlength="9" value="0"
                                       class="form-control input-sm input_numeric" placeholder="0"
                                       required>
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
                                <th>Type</th>
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
                                        <a href="#" id="{{$engin->id}}">
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

    <script>

        var $table = $('#stockTable'),
                $model_spinner = $('#model_spinner'),
                $sub_spinner = $('#sub_spinner'),
                $shelf_spinner = $('#shelf_spinner'),
                $bloc_spinner = $('#bloc_spinner'),
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
                $model_spinner.show();
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
                    $model_spinner.hide()
                })
            });
            $family.on('change', function () {
                $sub_spinner.show();
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
                    $sub_spinner.hide()
                })
            });
            $ray.on('change', function () {
                $shelf_spinner.show();
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
                    $shelf_spinner.hide()
                })
            });
            $shelf.on('change', function () {
                $bloc_spinner.show();
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
                    $bloc_spinner.hide()
                })
            });
            $form.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var type = 'post';
                var url = 'saveengine';
                status = "success";
                var msg = "le moteur a bien été enregistrer";
                $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
                $submit.button('loading');
                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
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
                        $row.before(row);
                        $submit.button('reset');
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
    </script>
@endsection
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
    $tva=$('#tva'),
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
        $.get('../modelBy/' + id, function (data) {
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
        $.get('../subFamily/' + id, function (data) {
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
        $.get('../shelves/' + id, function (data) {
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
        $.get('../blocs/' + id, function (data) {
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
        var url = '../home';
        status = "success";
        var msg = "le stock a bien été enregistrer";
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
        $.get('../deliveryBy/' + id, function (data) {
            $supplier.val(data.supplier);
            $order.val(data.order);
            $delivery_info.removeClass('loading-input');
        })
    })




});






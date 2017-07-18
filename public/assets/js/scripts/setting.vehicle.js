var $table_1 = $('.table_1'),
    $table_2 = $('.table_2'),

    /*** BRAND ***/
    $brand_form = $('#brandForm'),
    $brand_submit = $('#brand_submit'),
    $brand_reset = $('#brand_reset'),
    $brand_name = $('#brand_name'),
    $brand_edit = $('.brand-edit'),
    $brand_id = $('#brand_id'),
    $brand_row = $('#brandRow'),
    /*** END ***/

    /*** MODEL ***/
    $model_brand = $('#brands'),
    $model_form = $('#modelForm'),
    $model_submit = $('#model_submit'),
    $model_reset = $('#model_reset'),
    $model_name = $('#model_name'),
    $model_row = $('#modelRow'),
    $model_edit = $('.model-edit'),
    $model_id = $('#model_id');
/*** END ***/

$(function () {
    $table_1.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "order": [[1, "desc"]],
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
    $table_2.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "order": [[2, "desc"]],
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });

    /*** BRAND ***/
    $brand_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $brand_submit.val(),
            type = 'post',
            url = 'vehicle_store',
            msg = "La Marque a bien été enregistré",
            status = "success";
        if (state === 'edit') {
            status = "info";
            url = $(this).attr('action');
            msg = "La modification a bien été effectuée";
            type = "put";
        }
        $brand_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $brand_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="brand' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="brand_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $brand_row.before(row);
                } else {
                    $('#brand' + data.id).replaceWith(row);
                }
                brands();
                $brand_submit.button('reset');
                brand_reset();
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
                    $brand_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $brand_submit.button('reset');
                }
            }
        });
    });
    $brand_edit.on('click', function () {
        brand_edit(this)
    });
    /*** END ***/

    /*** BRAND ***/
    $model_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $model_submit.val(),
            type = 'post',
            url = 'vehicle_store',
            msg = "Le Model a bien été enregistré",
            status = "success";
        if (state === 'edit') {
            status = "info";
            url = $(this).attr('action');
            msg = "La modification a bien été effectuée";
            type = "put";
        }
        $model_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $model_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="model' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.brand + '</td>' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="model_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $model_row.before(row);
                } else {
                    $('#model' + data.id).replaceWith(row);
                }
                $model_submit.button('reset');
                model_reset();
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
                    $model_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $model_submit.button('reset');
                }
            }
        });
    });
    $model_edit.on('click', function () {
        model_edit(this)
    });
    /*** END ***/
});

/*** BRAND ***/
function brand_reset() {
    $brand_form.trigger('reset');
    $brand_name.focus();
    $brand_submit.val('save');
    $brand_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $brand_submit.removeClass('btn-info');
    $brand_submit.addClass('btn-success');
    $brand_reset.hide()
}

function brand_edit(obj) {
    $brand_name.addClass('loading-input');
    var id = $(obj).attr('id'),
        type = "brand";
    $.get('vehicle_edit/' + type + '/' + id, function (data) {
        $brand_submit.val('edit');
        $brand_submit.html('<i class="fa fa-pencil"></i> modifier');
        $brand_form.attr('action', 'vehicle_update/' + id);
        $brand_submit.removeClass('btn-success');
        $brand_submit.addClass('btn-info');
        $brand_name.val(data.name);
        $brand_id.val(data.id);
        $brand_name.removeClass('loading-input');
        $brand_reset.show()
    })
}
/*** END ***/

/*** MODEL ***/
function brands() {
    $.get('brands', function (data) {
        $model_brand.empty();
        $model_brand.append('<option></option>');
        $.each(data, function (index, modelObj) {
            $model_brand.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
            $model_brand.trigger("chosen:updated");
        });
    })
}

function model_reset() {
    $model_form.trigger('reset');
    $model_name.focus();
    $model_submit.val('save');
    $model_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $model_submit.removeClass('btn-info');
    $model_submit.addClass('btn-success');
    $model_brand.val('');
    $model_brand.trigger("chosen:updated");
    $model_reset.hide()
}

function model_edit(obj) {
    $model_name.addClass('loading-input');
    var id = $(obj).attr('id'),
        type = "model";
    $.get('vehicle_edit/' + type + '/' + id, function (data) {
        $model_submit.val('edit');
        $model_submit.html('<i class="fa fa-pencil"></i> modifier');
        $model_form.attr('action', 'vehicle_update/' + id);
        $model_submit.removeClass('btn-success');
        $model_submit.addClass('btn-info');
        $model_name.val(data.name);
        $model_id.val(data.id);
        $model_brand.val(data.brand_id);
        $model_brand.trigger("chosen:updated");
        $model_name.removeClass('loading-input');
        $model_reset.show()
    })
}
/*** END ***/
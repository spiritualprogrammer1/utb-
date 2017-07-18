var $table_1 = $('.table_1'),
    $table_2 = $('.table_2'),
    $table_3 = $('.table_3'),

    /*** Ray ***/
    $ray_form = $('#rayForm'),
    $ray_name = $('#ray_name'),
    $ray_submit = $('#ray_submit'),
    $ray_row = $('#rayRow'),
    $ray_reset = $('#ray_reset'),
    $ray_edit = $('.ray-edit'),
    $ray_id = $('#ray_id'),
    /*** end ***/

    /*** Shelf ***/
    $shelf_rays = $('#rays'),
    $shelf_form = $('#shelfForm'),
    $shelf_name = $('#shelf_name'),
    $shelf_submit = $('#shelf_submit'),
    $shelf_reset = $('#shelf_reset'),
    $shelf_edit = $('.shelf-edit'),
    $shelf_id = $('#shelf_id'),
    $shelf_row = $('#shelfRow'),
    /*** end ***/

    /*** Shelf ***/
    $bloc_id = $('#bloc_id'),
    $bloc_name = $('#bloc_name'),
    $bloc_ray = $('#bloc_ray'),
    $bloc_shelf = $('#bloc_shelf'),
    $bloc_reset = $('#bloc_reset'),
    $bloc_edit = $('.bloc-edit'),
    $bloc_submit = $('#bloc_submit'),
    $shelves_spinner = $('#shelves_spinner'),
    $bloc_form = $('#blocForm'),
    $bloc_row = $('#blocRow');
/*** end ***/

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
    $table_3.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "order": [[3, "desc"]],
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });

    /*** Ray ***/
    $ray_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $ray_submit.val(),
            type = 'post',
            url = 'warehouse_store',
            msg = "le rayon a été enregistré",
            status = "success";
        if (state === 'edit') {
            status = "info";
            url = $(this).attr('action');
            msg = "La modification a bien été effectuée";
            type = "put";
        }
        $ray_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $ray_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                rays();
                toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="ray' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="ray_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $ray_row.before(row);
                } else {
                    $('#ray' + data.id).replaceWith(row);
                }
                $ray_submit.button('reset');
                ray_reset();
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
                    $ray_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $ray_submit.button('reset');
                }
            }
        });
    });
    $ray_edit.on('click', function () {
        ray_edit(this)
    });
    /*** end ***/

    /*** Shelf ***/
    $shelf_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $shelf_submit.val(),
            type = 'post',
            url = 'warehouse_store',
            msg = "l'Etagère a bien été enregistré",
            status = "success";
        if (state === 'edit') {
            status = "info";
            url = $(this).attr('action');
            msg = "La modification a bien été effectuée";
            type = "put";
        }
        $shelf_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $shelf_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="shelf' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.ray + '</td>' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="shelf_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $shelf_row.before(row);
                } else {
                    $('#shelf' + data.id).replaceWith(row);
                }
                $shelf_submit.button('reset');
                shelf_reset();
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
                    $shelf_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $shelf_submit.button('reset');
                }
            }
        });
    });
    $shelf_edit.on('click', function () {
        shelf_edit(this)
    });
    /*** end ***/

    /*** block ***/
    $bloc_ray.on('change', function () {
        $shelves_spinner.show();
        var id = $(this).val(),
            type = "all";
        $.get('shelves/' + type + '/' + id, function (data) {
            if (data.length === 0) {
                $bloc_shelf.empty();
                $bloc_shelf.trigger("chosen:updated");
            } else {
                $bloc_shelf.empty();
                $bloc_shelf.append('<option selected disabled>CHOISISSEZ UNE ETAGERE</option>');
                $.each(data, function (index, modelObj) {
                    $bloc_shelf.append('<option class="uppercase" value="' + modelObj.id + '">' + modelObj.name + '</option>');
                    $bloc_shelf.trigger("chosen:updated");
                });
            }
            $shelves_spinner.hide()
        })
    });
    $bloc_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $bloc_submit.val(),
            type = 'post',
            url = 'warehouse_store',
            msg = "Le Casier a bien été enregistré",
            status = "success";
        if (state === 'edit') {
            status = "info";
            url = $(this).attr('action');
            msg = "La modification a bien été effectuée";
            type = "put";
        }
        $bloc_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $bloc_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                toastr[status](msg, "<span class='uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="block' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.ray + '</td>' +
                    '<td>' + data.shelf + '</td>' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="bloc_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $bloc_row.before(row);
                } else {
                    $('#block' + data.id).replaceWith(row);
                }
                $bloc_submit.button('reset');
                bloc_reset();
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
                    $bloc_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $bloc_submit.button('reset');
                }
            }
        });
    });
    $bloc_edit.on('click', function () {
        bloc_edit(this)
    });
    /*** end ***/
});

/*** Ray ***/
function ray_reset() {
    $ray_form.trigger('reset');
    $ray_name.focus();
    $ray_submit.val('save');
    $ray_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $ray_submit.removeClass('btn-info');
    $ray_submit.addClass('btn-success');
    $ray_reset.hide()
}

function ray_edit(obj) {
    $ray_name.addClass('loading-input');
    var id = $(obj).attr('id'),
        type = "ray";
    $.get('warehouse_edit/' + type + '/' + id, function (data) {
        $ray_submit.val('edit');
        $ray_submit.html('<i class="fa fa-pencil"></i> modifier');
        $ray_form.attr('action', 'warehouse_update/' + id);
        $ray_submit.removeClass('btn-success');
        $ray_submit.addClass('btn-info');
        $ray_name.val(data.name);
        $ray_id.val(data.id);
        $ray_name.removeClass('loading-input');
        $ray_reset.show()
    })
}
/*** end ***/

/*** Shelf ***/
function rays() {
    var type = "all";
    $.get('rays/' + type, function (data) {
        $shelf_rays.empty();
        $shelf_rays.append('<option></option>');
        $bloc_ray.empty();
        $bloc_ray.append('<option></option>');
        $.each(data, function (index, modelObj) {
            $shelf_rays.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
            $shelf_rays.trigger("chosen:updated");
            $bloc_ray.append('<option value="' + modelObj.id + '" class="uppercase">' + modelObj.name + '</option>');
            $bloc_ray.trigger("chosen:updated");
        });
    })
}

function shelf_reset() {
    $shelf_rays.val('');
    $shelf_rays.trigger("chosen:updated");
    $shelf_form.trigger('reset');
    $shelf_name.focus();
    $shelf_submit.val('save');
    $shelf_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $shelf_submit.removeClass('btn-info');
    $shelf_submit.addClass('btn-success');
    $shelf_reset.hide()
}

function shelf_edit(obj) {
    $shelf_name.addClass('loading-input');
    var id = $(obj).attr('id'),
        type = "shelf";
    $.get('warehouse_edit/' + type + '/' + id, function (data) {
        $shelf_submit.val('edit');
        $shelf_submit.html('<i class="fa fa-pencil"></i> modifier');
        $shelf_form.attr('action', 'warehouse_update/' + id);
        $shelf_submit.removeClass('btn-success');
        $shelf_submit.addClass('btn-info');
        $shelf_name.val(data.name);
        $shelf_rays.val(data.ray_id);
        $shelf_rays.trigger("chosen:updated");
        $shelf_id.val(data.id);
        $shelf_name.removeClass('loading-input');
        $shelf_reset.show()
    })
}
/*** end ***/

/*** Bloc ***/
function bloc_reset() {
    $bloc_ray.val('');
    $bloc_ray.trigger("chosen:updated");
    $bloc_shelf.val('');
    $bloc_shelf.trigger("chosen:updated");
    $bloc_form.trigger('reset');
    $bloc_name.focus();
    $bloc_submit.val('save');
    $bloc_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $bloc_submit.removeClass('btn-info');
    $bloc_submit.addClass('btn-success');
    $bloc_reset.hide()
}

function bloc_edit(obj) {
    $bloc_name.addClass('loading-input');
    $shelves_spinner.show();
    $bloc_reset.show();
    var id = $(obj).attr('id'),
        type = "shelf";
    $.get('blocs/' + id, function (data) {
        $bloc_name.val(data.name);
        $bloc_id.val(data.id);
        $bloc_submit.val('edit');
        $bloc_submit.html('<i class="fa fa-pencil"></i> modifier');
        $bloc_submit.removeClass('btn-success');
        $bloc_submit.addClass('btn-info');
        $.get('shelves/' + type + '/' + data.shelf_id, function (data) {
            $bloc_shelf.empty();
            $.each(data, function (index, modelObj) {
                $bloc_shelf.append('<option class="uppercase" value="' + modelObj.id + '">' + modelObj.name + '</option>');
                $bloc_shelf.trigger("chosen:updated");
                $bloc_ray.val(modelObj.ray_id);
                $bloc_ray.trigger("chosen:updated");
                $shelves_spinner.hide()
            });
        });
        $bloc_form.attr('action', 'warehouse_update/' + id);
        $bloc_name.removeClass('loading-input');
    });
}
/*** end ***/
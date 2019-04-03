/**
 * Created by Segoor Developper on 14/07/2017.
 */
var $table_1 = $('.table_1'),
    $table_2 = $('.table_2'),

    /*** Family ***/
    $family_form = $('#familyForm'),
    $family_name = $('#family_name'),
    $family_id = $('#family_id'),
    $family_reset = $('#family_reset'),
    $family_submit = $('#family_submit'),
    $family_row = $('#familyRow'),
    $family_edit = $('.family-edit'),
    /*** end ***/

    /*** Suh Family ***/
    $sub_family_name = $('#sub_family_name'),
    $families = $('#families'),
    $sub_family_id = $('#sub_category_id'),
    $sub_family_submit = $('#sub_family_submit'),
    $sub_family_form = $('#sub_family_form'),
    $sub_family_reset = $('#sub_family_reset'),
    $sub_family_row = $('#sub_family_row'),
    $sub_family_edit = $('.sub-family-edit'),
    /*** end ***/

    /*** type ***/
    $type_form = $('#typeForm'),
    $type_name = $('#type_name'),
    $type_id = $('#type_id'),
    $type_description = $('#type_description'),
    $type_submit = $('#type_submit'),
    $type_reset = $('#type_reset'),
    $type_edit = $('.type-edit'),
    $type_row = $('#typeRow');
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

    /*** Family ***/
    $family_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            $this = $family_submit,
            state = $this.val(),
            type = 'post',
            url = 'stock_store',
            msg = "la categorie a été enregistrer",
            status = "success";
        if (state === 'edit') {
            url = $(this).attr('action');
            status = "info";
            type = 'put';
            msg = "la categorie a bien été modifier";
        }
        $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $this.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                $family_name.focus();
                toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="family' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td style="text-transform: capitalize">' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="family_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $family_row.before(row);
                } else {
                    $('#family' + data.id).replaceWith(row);
                }
                families();
                $this.button('reset');
                family_reset()
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
                    $this.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $this.button('reset');
                }
            }
        });
    });
    $family_edit.on('click', function () {
        $family_reset.show();
        $family_name.addClass('loading-input');
        var id = $(this).attr('id'),
            type = "family";
        $family_submit.val('edit');
        $family_submit.html('<i class="fa fa-pencil"></i> modifier');
        $family_submit.removeClass('btn-success');
        $family_submit.addClass('btn-info');
        $family_form.attr('action', 'stock_update/' + id);
        $.get('stock_edit/' + type + '/' + id, function (data) {
            $family_name.val(data.name);
            $family_id.val(data.id);
            $family_name.removeClass('loading-input');
        })
    });
    /*** end ***/

    /*** Sub Family ***/
    $sub_family_edit.on('click', function () {
        sub_family_edit(this)
    });
    $sub_family_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $sub_family_submit.val(),
            type = 'post',
            url = 'stock_store',
            msg = "La Sous Famille a été enregistrer",
            status = "success";
        if (state === 'edit') {
            url = $(this).attr('action');
            status = "info";
            type = 'put';
            msg = "La Modification a bien été effectuée";
        }
        $sub_family_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $sub_family_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                $sub_family_name.focus();
                toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="sub_family' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.category + '</td>' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="sub_family_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $sub_family_row.before(row);
                } else {
                    $('#sub_family' + data.id).replaceWith(row);
                }
                $sub_family_submit.button('reset');
                sub_family_reset();
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
                    $sub_family_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $sub_family_submit.button('reset');
                }
            }
        });
    });
    /*** end ***/

    /*** Type ***/
    $type_form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            state = $type_submit.val(),
            type = 'post',
            url = 'stock_store',
            msg = "le type a bien été enregistré",
            status = "success";
        if (state === 'edit') {
            url = $(this).attr('action');
            type ="put";
            status = "info";
            msg = "La Modification a bien été effectuée";
        }
        $type_submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $type_submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                $type_name.focus();
                toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="type' + data.id + '" class="alert alert-info text-danger-dk">' +
                    '<td>' + data.name + '</td>' +
                    '<td>' + data.description + '</td>' +
                    '<td>' + data.date + '</td>' +
                    '<td><a href="#" id="' + data.id + '" onclick="type_edit(this)"><i class="fa fa-pencil"></i></a></td>' +
                    '<tr>';
                if (state === 'save') {
                    $type_row.before(row);
                } else {
                    $('#type' + data.id).replaceWith(row);
                }
                $type_submit.button('reset');
                type_reset();
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
                    $type_submit.button('reset');
                } else {
                    alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                    $type_submit.button('reset');
                }
            }
        });
    });
    $type_reset.on('click', function () {
        type_reset();
    });
    $type_edit.on('click', function () {
        type_edit(this)
    });
    /*** end ***/
});
/*** Family ***/
function family_reset() {
    $family_form.trigger('reset');
    $family_submit.val('save');
    $family_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $family_submit.removeClass('btn-info');
    $family_submit.addClass('btn-success');
    $family_reset.hide()
}
function family_edit(obj) {
    $family_reset.show();
    $family_name.addClass('loading-input');
    var id = $(obj).attr('id'),
        type = "family";
    $.get('stock_edit/' + type + '/' + id, function (data) {
        $family_submit.val('edit');
        $family_form.attr('action', 'stock_update/' + id);
        $family_submit.html('<i class="fa fa-pencil"></i> modifier');
        $family_submit.removeClass('btn-success');
        $family_submit.addClass('btn-info');
        $family_name.val(data.name);
        $family_id.val(data.id);
        $family_name.removeClass('loading-input');
    })
}
/*** end ***/

/*** Suh Family ***/
function families() {
    $.get('families', function (data) {
        $families.empty();
        $families.append('<option selected disabled>CHOISISSEZ UNE FAMILLE</option>');
        $.each(data, function (index, modelObj) {
            $families.append('<option value="' + modelObj.id + '">' + modelObj.name + '</option>');
            $families.trigger("chosen:updated");
        });
    })
}
function sub_family_reset() {
    $sub_family_form.trigger('reset');
    $sub_family_submit.val('save');
    $sub_family_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $families.trigger("chosen:updated");
    $sub_family_submit.removeClass('btn-info');
    $sub_family_submit.addClass('btn-success');
    $sub_family_reset.hide();
}
function sub_family_edit(obj) {
    $sub_family_name.addClass('loading-input');
    $sub_family_reset.show();
    var id = $(obj).attr('id'),
        type = "sub_family";
    $.get('stock_edit/' + type + '/' + id, function (data) {
        $sub_family_submit.val('edit');
        $sub_family_submit.html('<i class="fa fa-pencil"></i> modifier');
        $sub_family_form.attr('action', 'stock_update/' + id);
        $sub_family_name.val(data.name);
        $sub_family_id.val(data.id);
        $families.val(data.category_id);
        $families.trigger("chosen:updated");
        $sub_family_submit.removeClass('btn-success');
        $sub_family_submit.addClass('btn-info');
        $sub_family_name.removeClass('loading-input');
    })
}
/*** end ***/

/*** Type ***/
function type_reset() {
    $type_form.trigger('reset');
    $type_submit.val('save');
    $type_submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $type_submit.removeClass('btn-info');
    $type_submit.addClass('btn-success');
    $type_reset.hide();
}
function type_edit(obj) {
    $type_name.addClass('loading-input');
    $type_description.addClass('loading-input');
    $type_reset.show();
    var id = $(obj).attr('id'),
        type = "type";
    $.get('stock_edit/' + type + '/' + id, function (data) {
        $type_name.val(data.name);
        $type_id.val(data.id);
        $type_description.val(data.description);
        $type_form.attr('action', 'stock_update/' + id);
        $type_submit.val('edit');
        $type_submit.html('<i class="fa fa-pencil"></i> modifier');
        $type_submit.removeClass('btn-success');
        $type_submit.addClass('btn-info');
        $type_name.removeClass('loading-input');
        $type_description.removeClass('loading-input');
    })
}
/*** end ***/

var $form = $('#deliveryForm'),
    $supplier = $('#supplier'),
    $amount = $('#amount'),
    $number = $('#number'),
    $delivery_row = $('#deliveryRow'),
    $preview = $('.preview'),
    $spinner = $('.cssload-container'),
    $delivery_preview = $('#delivery_preview'),
    $modal = $('#modal'),
    $delivery_number = $('#delivery_number'),
    $submit = $('#submit'),
    $table = $('#deliveryTable'),
    $form_search = $('#searchForm'),
    $submit_search = $('#submit_search'),
    $view = $('#view');
$(function () {
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "language": {
            "url": "../assets/js/datatables/French.json"
        }
    });
    $form.on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]),
            type = 'post',
            url ='home.store',
            msg = "le Bon de Livraison a bien été enregistré",
            status = "success";
        $submit.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $submit.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                $number.focus();
                toastr[status](msg, "<span style='text-transform: uppercase'>" + data.number + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="delivery' + data.ids + '" class="alert alert-info text-danger-dk">' +
                    '<td><a href="#" id="' + data.ids + '" data-number="' + data.number + '" onclick="preview(this)" data-toggle="modal"><i class="fa fa-search-plus text-muted"></i></a></td>' +
                    '<td class="uppercase">' + data.number + '</td>' +
                    '<td class="uppercase">' + data.order + '</td>' +
                    '<td>' + data.amount + '</td>' +
                    '<td>' + data.supplier + '</td>' +
                    '<td>' + data.delivered + '</td>' +
                    '<tr>';
                $delivery_row.before(row);
                $form.trigger('reset');
                $supplier.val('');
                $supplier.trigger("chosen:updated");
                $submit.button('reset');
            },
            cache: false,
            contentType: false,
            processData: false,
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
    $preview.on('click', function () {
        preview(this)
    });
    $form_search.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $submit_search.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>'});
        $submit_search.button('loading');
        $.get('search?' + formData, function (data) {
            $view.html(data);
            $submit_search.button('reset');
        });
    })
});
function preview(obj) {
    $spinner.show();
    var id = $(obj).attr('id'),
        number = $(obj).attr('data-number');
    $.get('preview/' + id, function (data) {
        $delivery_number.html(number);
        $delivery_preview.attr('src', data);
        $spinner.hide();
        $modal.modal('show')
    });
}

var $form = $('#supplierForm'),
    $submit = $('#submit'),
    $table = $('#supplierTable'),
    $btn_reset = $('#btn_reset'),
    $country = $('#country'),
    $phonecode = $('.phonecode'),
    $supplier = $('.supplier'),
    $a_supplier = $('.supplier-select'),
    $label = $("#lblName"),
    $name = $('#name'),
    $divrccm = $('#divRccm'),
    $rccm = $('#rccm'),
    $btn_edit = $('.supplier-edit'),
    $id = $('#supplier_id'),
    $email = $('#email'),
    $address = $('#address'),
    $phone = $('#phone'),
    $mobile = $('#mobile'),
    $row = $('#supplierRow'),
    $score = $('#count_supplier'),
    $input = $('.input'),
    $suppliers = $('.suppliers'),
    $list = $('#supplierList'),
    $search = $('#search'),
    $progress = $('.progress-container'),
    $spinner = $('.cssload-container'),
    $cname = $('.name'),
    $emailto = $('#emailto'),
    $type = $('#type'),
    $cemail = $('.email');
$(function () {
    /*** create ***/
    $table.dataTable({
        "sPaginationType": "full_numbers",
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "iDisplayLength": 50,
        "order": [[4, "desc"]],
        "language": {
            "url": "../../assets/js/datatables/French.json"
        }
    });
    $country.chosen().change(function (e) {
        var id = e.target.value;
        $phonecode.addClass('loading-input');
        $.get('phonecode/' + id, function (data) {
            $phonecode.empty();
            $phonecode.val("+" + data.phonecode);
            $phonecode.removeClass('loading-input');
        })
    });
    $supplier.on('click', function () {
        var id = $(this).val();
        if (id === '1') {
            $label.fadeOut('slow', function () {
                $(this).html("<i class='i i-user2'></i> Nom");
                $name.attr("placeholder", "Entrer le nom");
            }).fadeIn("slow");
            $divrccm.hide("slow");
            $rccm.val("");
        }
        else {
            $label.fadeOut('slow', function () {
                $(this).html("<i class='i i-cube'></i> Raison sociale");
                $name.attr("placeholder", "Entrer la raison social");
            }).fadeIn("slow");
            $divrccm.show("slow");
        }
    });
    $btn_edit.on('click', function () {
        $input.addClass('loading-input');
        var $this = $submit;
        var id = $(this).attr('id');
        $this.val('edit');
        $this.html('<i class="fa fa-pencil"></i> modifier');
        $form.attr('action', id);
        $.get(id + '/edit', function (data) {
            $id.val(data.id);
            $rccm.val(data.rccm);
            $name.val(data.name);
            $country.val(data.country_id);
            $country.trigger("chosen:updated");
            $email.val(data.email);
            $address.val(data.address);
            $phone.val(data.phone);
            $mobile.val(data.mobile);
            if (data.type === '0') {
                $("input[name=type][value='0']").prop("checked", true);
                $("input[name=type][value='1']").prop("checked", false);
                $label.fadeOut('slow', function () {
                    $(this).html("<i class='i i-cube'></i> Raison sociale");
                    $name.attr("placeholder", "Entrer la raison social");
                }).fadeIn("slow");
                $divrccm.show("slow");
            } else {
                $("input[name=type][value='1']").prop("checked", true);
                $("input[name=type][value='0']").prop("checked", false);
                $label.fadeOut('slow', function () {
                    $(this).html("<i class='i i-user2'></i> Nom");
                    $name.attr("placeholder", "Entrer le nom");
                }).fadeIn("slow");
                $divrccm.hide("slow");
                $rccm.val("");
            }
            $.get('phonecode/' + data.country_id, function (data) {
                $phonecode.empty();
                $phonecode.val("+" + data.phonecode);
            });
            $submit.removeClass('btn-success');
            $submit.addClass('btn-info');
            $input.removeClass('loading-input');
            $btn_reset.removeClass('disabled');
        })
    });
    $form.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize(),
            $this = $submit,
            state = $this.val(),
            type = 'post',
            url = '../supplier',
            msg = "Le Fournisseur a été enregistrer!",
            status = "success";
        if (state === 'edit') {
            url = $(this).attr('action');
            type = 'put';
            status = "info";
            msg = "La Modification a bien été effectuée";
        }
        $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> traitement en cours...'});
        $this.button('loading');
        $.ajax({
            url: url,
            type: type,
            data: formData,
            success: function (data) {
                $rccm.focus();
                score();
                toastr[status](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                toastr.options.preventDuplicates = true;
                var row = '<tr id="supplier' + data.id + '" class="alert alert-info text-danger-dk" style="text-transform: capitalize">' +
                    '<td>' + data.name + '</td>' +
                    '<td class="text-lowercase">' + data.email + '</td>' +
                    '<td>' + data.country + '</td>' +
                    '<td>' + data.mobile + '</td>' +
                    '<td>' + data.phone + '</td>' +
                    '<td class="text-center"><button type="button" id="' + data.id + '"  onclick="supplierEdit(this)" class="btn btn-sm btn-default btn-rounded">' +
                    '<i class="fa fa-pencil text-danger-dker"></i></button></td><tr>';
                if (state === 'save') {
                    $row.before(row);
                } else {
                    $('#supplier' + data.id).replaceWith(row);
                }
                $this.button('reset');
                cleaner()
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
    /*** end ***/

    /*** information ***/
    $suppliers.on('click', function () {
        $spinner.show();
        var id = $(this).attr('id');
        $.get('listing/' + id, function (data) {
            $list.empty();
            $.each(data, function (index, modelObj) {
                $list.append("<tr><td class='list-group-item'><a href='#' id='" + modelObj.id + "' onclick='selected(this)' class='supplier capitalize'>" + modelObj.name + "</a></td></tr>");
            });
            $spinner.hide()
        })
    });
    $search.on('keyup', function () {
        var searchTerm = $(this).val().toLowerCase();
        $('#supplierList tbody tr').each(function () {
            var lineStr = $(this).text().toLowerCase();
            if (lineStr.indexOf(searchTerm) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
    $a_supplier.on('click', function () {
        $progress.show();
        var id = $(this).attr('id');
        $.get('supplier/' + id, function (data) {
            if (data.type === '0') {
                $type.html(" entreprise");
                $divrccm.show()
            } else {
                $type.html(" particulier");
                $divrccm.hide()
            }
            $cname.html(data.name);
            $cemail.html(data.email);
            $emailto.prop("href", "mailto:" + data.email);
            $phone.html("+" + data.phone);
            $mobile.html("+" + data.mobile);
            $address.html(data.address);
            $rccm.html(data.rccm);
            $progress.hide();
        })
    });
    /*** end ***/
});
/*** create ***/
function cleaner() {
    $form.trigger('reset');
    $country.val('53');
    $divrccm.show();
    $country.trigger("chosen:updated");
    $btn_reset.addClass('disabled');
    $submit.val('save');
    $submit.html('<i class="fa fa-floppy-o"></i> enregistrer');
    $submit.removeClass('btn-info');
    $submit.addClass('btn-success');
    $label.fadeOut('slow', function () {
        $(this).html("<i class='i i-cube'></i> Raison sociale");
        $name.attr("placeholder", "Entrer la raison social");
    }).fadeIn("slow");
    $divrccm.show("slow");
}
function supplierEdit(obg) {
    var $this = $submit;
    var id = $(obg).attr('id');
    $this.val('edit');
    $this.html('<i class="fa fa-pencil"></i> modifier');
    $form.attr('action', '/supplier/supplier/' + id);
    $.get('/supplier/suppliers/' + id + '/edit', function (data) {
        $input.addClass('loading-input');
        $id.val(data.id);
        $rccm.val(data.rccm);
        $name.val(data.name);
        $country.val(data.country_id);
        $country.trigger("chosen:updated");
        $email.val(data.email);
        $address.val(data.address);
        $phone.val(data.phone);
        $mobile.val(data.mobile);
        if (data.type === 0) {
            $("input[name=type][value='0']").prop("checked", true);
            $("input[name=type][value='1']").prop("checked", false);
            $label.fadeOut('slow', function () {
                $(this).html("<i class='i i-cube'></i> Raison sociale");
                $name.attr("placeholder", "Entrer la raison social");
            }).fadeIn("slow");
            $divrccm.show("slow");
        } else {
            $("input[name=type][value='1']").prop("checked", true);
            $("input[name=type][value='0']").prop("checked", false);
            $label.fadeOut('slow', function () {
                $(this).html("<i class='i i-user2'></i> Nom");
                $name.attr("placeholder", "Entrer le nom");
            }).fadeIn("slow");
            $divrccm.hide("slow");
            $rccm.val("");
        }
        $.get('phonecode/' + data.country_id, function (data) {
            $phonecode.empty();
            $phonecode.val("+" + data.phonecode);
        });
        $input.removeClass('loading-input');
        $btn_reset.removeClass('disabled');
    });
    $submit.removeClass('btn-success');
    $submit.addClass('btn-info');
}
function score() {
    $.get('../score', function (data) {
        $score.html(data)
    })
}
/*** create ***/

/*** information ***/
function selected(obj) {
    $progress.show();
    var id = $(obj).attr('id');
    $.get('supplier/' + id, function (data) {
        if (data.type === '0') {
            $type.html(" entreprise");
            $divrccm.show()
        } else {
            $type.html(" particulier");
            $divrccm.hide()
        }
        $cname.html(data.name);
        $cemail.html(data.email);
        $emailto.prop("href", "mailto:" + data.email);
        $phone.html("+" + data.phone);
        $mobile.html("+" + data.mobile);
        $address.html(data.address);
        $rccm.html(data.rccm);
        $progress.hide();
    })
}
/*** end ***/
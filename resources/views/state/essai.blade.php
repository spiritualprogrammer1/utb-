@section('title') Etat du Car @endsection
@section('styles')
@endsection
@extends('layouts.master')
@section('content')

    <div class="" id="">
    {{$state_kilometer}}
    </div>

@endsection
@section('scripts')
    <script src="{{asset('assets/js/parsley/parsley.min.js')}}"></script>
    <script src="{{asset('assets/js/wizard/jquery.bootstrap.wizard.js')}}"></script>
    <script src="{{asset('assets/js/wizard/demo.js')}}"></script>
    <script>
        var $table = $('#vehicleTable'),
                $form = $('#wizardform'),
                $first = $('.first'),
                $file = $('#file'),
                $modal=$('#stateModal'),
                $count_diagnostique =$('#count_diagnostique');
        $file_loader = $('#file_loader'),
                $file_content = $('#file_content'),
                $submit = $('#submit');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 5,
                "language": {
                    "url": "../assets/js/datatables/French.json"
                }
            });

            $form.on('submit', function (e) {
                e.preventDefault();
//                var formData = $(this).serialize(),
                var formData = new FormData($(this)[0]);
                type = 'post',
                        url = 'home',
                        status = "success",
                        msg = "LA RECEPTION A ETE ENREGISTRE";
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
                        score();
                        $file.attr('data-value', data.id);
                        $file.addClass('btn-danger');
                        $file.removeClass('btn-defauld disabled');
                        $first.click();
                        toastr[status](msg, "<span class='uppercase'>" + data.matriculation + "</span>!");
                        toastr.options.preventDuplicates = true;

                        $submit.button('reset');
                        $file.show();
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


            $file.on('click', function () {
                $file_loader.show();

                var id = $(this).attr('data-value');
                $.ajax({
                    url: '{{url('state/filestate')}}/'+id,
                    type: 'get',
                    data: id,
                    success: function (data) {
                        $file_content.html(data);
                        $modal.modal('show');
                        $file_loader.hide();
                    },
                });


            });

            function score()
            {
                $.get('score',function (data) {
                    $count_diagnostique.html(data)
                })
            }
        })

        $(document).ready(function() {

            // enable fileuploader plugin
            $('input[name="image_voi[]"]').fileuploader({
                extensions: ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
                changeInput: ' ',
                theme: 'thumbnails',
                enableApi: true,
                addMore: true,
                thumbnails: {
                    box: '<div  class="fileuploader-items"  >' +
                    '<ul class="fileuploader-items-list">' +
                    '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner" style="width: 300px;height: 110px" style="font-size: 10px">image</div></li>' +
                    '</ul>' +
                    '</div>',
                    item: '<li class="fileuploader-item" >' +
                    '<div class="fileuploader-item-inner" >' +
                    '<div class="thumbnail-holder" >${image}</div>' +
                    '<div class="actions-holder" >' +
                    '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                    '</div>' +
                    '<div class="progress-holder">${progressBar}</div>' +
                    '</div>' +
                    '</li>',
                    item2: '<li class="fileuploader-item"   >' +
                    '<div class="fileuploader-item-inner" >' +
                    '<div class="thumbnail-holder" >${image}</div>' +
                    '<div class="actions-holder">' +
                    '<a class="fileuploader-action fileuploader-action-remove" title="Remove"><i class="remove"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</li>',
                    startImageRenderer: true,
                    canvasImage: false,
                    _selectors: {
                        list: '.fileuploader-items-list',
                        item: '.fileuploader-item',
                        start: '.fileuploader-action-start',
                        retry: '.fileuploader-action-retry',
                        remove: '.fileuploader-action-remove'
                    },
                    onItemShow: function(item, listEl) {
                        var plusInput = listEl.find('.fileuploader-thumbnails-input');

                        plusInput.insertAfter(item.html);

                        if(item.format == 'image') {
                            item.html.find('.fileuploader-item-icon').hide();
                        }
                    }
                },
                afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                            api = $.fileuploader.getInstance(inputEl.get(0));

                    plusInput.on('click', function() {
                        api.open();
                    });
                },
            });

        });
    </script>
@endsection
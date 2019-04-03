
        <!-- Modal content-->

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gestion des  Permission </h4>

            <div class="modal-body">
                <div class="row">
                    {!! Form::open(array('route' => 'post_permission','method'=>'POST','id'=>'roleform')) !!}
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$role->id}}">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong style="color: #0d5e92">Permission:</strong>
                                <br/>

                                @foreach($permission as $value)
                                    <label>{!! Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions->toArray()) ? true : false, array('class' => 'name'),'required') !!}
                                        {{ $value->display_name }}</label>
                                    <br/>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="rolesend" class="btn btn-primary" value="enregistrer"><i class="fa fa-floppy-o"></i>Enregistrer</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <script>
            $form_validate=$('#roleform');
            $btn_validate=$('#rolesend');
            $validate_modal   =  $('#newModal');
            $form_validate.on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var $this = $btn_validate;
                var msg = 'Mise à jour effectuée';
                var types = "info";
                $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Traitement en cours...'});
                $this.button('loading');
                $.ajax({
                    url: '{{route('post_permission')}}',
                    data: formData,
                    type: "POST",
                    success: function (data) {
                        toastr[types](msg);
                        toastr.options.preventDuplicates = true;
                        $validate_modal.modal('hide');
                        $this.button('reset');
                    },
                    error: function (jqXhr) {
                        if (jqXhr.status === 401)
                            window.location.href = "/";
                        if (jqXhr.status === 422) {
                            $errors = jqXhr.responseJSON;
                            $.each($errors, function (key, value) {
                                $ferrors = value.name
                            });
                            toastr["error"]("Veuillez bien remplir le formulaire SVP", "Oups!");
                            toastr.options.preventDuplicates = true;
                        } else {
                            alert("Une erreur s'est produite, Recharger la page, puis réesayer SVP \nSi l'erreur persiste veullez contactez l'administrateur \nErreur: " + jqXhr.statusText);
                            $this.button('reset');
                        }
                    }
                });
            });
        </script>
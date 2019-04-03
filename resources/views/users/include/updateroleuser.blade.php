<section class="panel panel-default "  id="view" >
    <div class="table-responsive">

        <div class="row" style="margin-left: 1%">

            <div class="col-md-4">
                <label class="control-label col-md-2"> <strong style="font-size: 15px;font-family: Helvetica"><i>Nom</i></strong></label>
                <input  type="text" name="name" id="name"
                        class="form-control col-md-4 text-danger" value="{{$user->employee->last_name}}" readonly >

            </div>
            <div class="form-group col-md-4 pull-right">
                <label class="control-label"> <strong style="font-size: 15px;font-family: Helvetica"><i> Prenom </i></strong> </label>
                <input type="text" name="username" id="username"
                       class="form-control text-danger" value="{{$user->employee->first_name}}" readonly>

            </div>

        </div>
        <div class="row " style="margin-left: 1%">

            <div class="form-group col-md-4 pull-right">
                <label class="control-label"> <strong style="font-size: 15px;font-family: Helvetica"><i>  Email </i></strong> </label>
                <input type="text" name="email" id="email"
                       class="form-control text-danger" value="{{$user->email}}" readonly>

            </div>
            <div class="form-group col-md-4">
                <label class="control-label"> <strong style="font-size: 15px;font-family: Helvetica"><i> Service </i></strong>  </label>
                <input type="text" name="Service" id="Service"
                       class="form-control date text-danger" value="{{$user->employee->service->display_name}}" readonly>

            </div>

        </div>
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title" style="margin-left: 35%">
                        <strong class="btn btn-info text-danger text-center"> <a data-toggle="collapse" href="#collapse1"> <i>VOIR LES PERMISSIONS</i> </a></strong>
                    </h4>
                </div>


                <div id="collapse1" class="panel-collapse collapse" style="margin-left: 3%">
                    <form id="form_valid" method="post">
                        <div class="row col-md-11 text-center">
                            {!! Form::open(array('route' => 'post_permission','method'=>'POST','id'=>'roleform')) !!}
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$role[0]->id}}">
                            <div class="row">
                                <div class="row-sm row-col-8 text-center">
                                    <div class="">
                                        <strong style="color: #0d5e92">Permission:</strong>
                                        <br/>
                                        <br/><hr/>
<!--                                        --><?php //dd($rolePermissions->toArray());?>


                                        @foreach($permission as $value)
                                            <strong>
                                            <label>{!! Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions->toArray()) ? true : false, array('class' => 'name'),'required') !!}
                                                {{ $value->display_name }}</label>  || </strong>
                                        @endforeach
                                    </div>
                                </div>
                                <br/>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" id="rolesend" class="btn btn-success" value="enregistrer"><i class="fa fa-pencil-square-o"></i>MODIFIER</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</section>
<script>
    $form_validate=$('#form_valid');
    $btn_validate =$('#rolesend');

    $form_validate.on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var $this = $btn_validate;
        var msg = 'Mise à jour effectuée';
        var types = "info";
        $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i>&nbsp;Traitement en cours...'});
        $this.button('loading');
        $.ajax({
            url: '{{route('post_permission_user')}}',
            data: formData,
            type: "POST",
            success: function (data) {
                toastr[types](msg);
                toastr.options.preventDuplicates = true;
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
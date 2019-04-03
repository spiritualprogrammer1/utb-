<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <form id="formuser" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <i class="fa fa-user"></i> <h5 class="modal-title text-black" style="text-transform: uppercase;color:#1f648b" >Modifier l'acces du compte</h5>
            </div>
            <div class="modal-body">


                <section class="panel panel-info" >
                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="hidden" name="id" id="user_id" value="{{$user->id}}">
                                <strong>Nom:</strong>
                                <input type="text" value="{{$user->username}}" placeholder="Name" name="username" class ='form-control' id="username">

                            </div>

                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="hidden" id="user_id" value="{{$user->id}}">
                                <strong>email:</strong>
                                <input type="text" value="{{$user->employee->email}}" placeholder="Name" name="email" class ='form-control' id="email" required>
                                {{--<input type="hidden" name="_token" value="{{csrf_token()}}" id="token">--}}

                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Password:</strong>
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password')) !!}
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <strong>Confirm Password:</strong>
                                {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control','id'=>'password_confirmation')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            {{--<div class="form-group col-xs-7 col-sm-7 col-md-7">--}}
                                {{--<strong>Poste(role):</strong>--}}

                                {{--{!! Form::select('roles[]', $roles,$userRole,array('class' => 'form-control','multiple','id'=>'roles')) !!}--}}
                            {{--</div>--}}
                            <div class="form-group col-xs-5 col-sm-5 col-md-5">
                                <strong>Site</strong>
                                <select class="chosen-select input-sm form-control" name="newsite_id">
                                    <option selected disabled>choississez un site</option>
                                    @foreach($sites as $site)
                                        <option value="{{$site->id}}">{{$site->name}}</option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="kv-avatar center-block text-center" style="width:200px">
                                    <input id="avatar-2" value="{{$user->employee->image}}"   name="image" type="file" class="file-loading" >
                                </div>
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                        </div>

                    </div>



                </section>
            </div>
            <div class="modal-footer">

                <button class="btn btn-success" value="save" type="submit" style="text-transform: uppercase"><i
                            class="fa fa-pencil"></i> Modifier
                </button>

            </div>

        </form>
    </div>
</div>
<script>

    $('#formuser').on('submit',function (e) {
        e.preventDefault();

        var formData = new FormData($(this)[0]);
        var data =$(this).serialize();
        var id =$('#user_id').val();
        var username=$('#username').val();
        var password=$('#password').val();
        var email=$('#email').val();
        var   roles =$('#roles').val();
        var token=$('#token').val();
        var password_confirmation=$('#password_confirmation').val();
        $.ajax({
            url:"{{url('user/updateuser')}}",
            type:'post',
            data:formData,
            dataType:'json',
            cache: false,
            contentType: false,
            processData: false,
            success:function(data)
            {
                if(data.reponse=="ok")
                {
                    toastr["success"]('compte modifié');
                    $('#edituser').modal("hide")
                }

            },
            error:function (data) {
                var tab=[];
                var errors =data.responseJSON;
//                $.each(errors.message,function(index,value)
//                {
//                    toastr["error"](value);
//                });
            }
        })

    })

    var btnCust = '<button type="button" class="btn btn-default" title="" ' +
        'onclick="console(\'\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>';
    $("#avatar-2").fileinput({
        overwriteInitial: true,
        maxFileSize: 500000,
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'supprimer le fichier ',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img  @if(!empty($user->employee->image)) src=" {{asset('public/picture_employe/'.$user->employee->image)}}" @else src=" {{asset('picture_employe/pcture_user.png')}}" @endif  alt="Ton image" style="width:125px"><h6 class="text-muted"></h6>',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["docx","pdf","jpg", "png", "gif"]
    });
</script>
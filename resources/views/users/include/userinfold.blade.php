<section  class="panel vbox panel-default" id="view">
    <div class="table-responsive">
        <div class="row">

            <div class="form-group col-md-6">
                <label class="control-label"> Nom </label>
                <input type="text" name="name" id="name"
                       class="form-control date" placeholder="Entrer le nom" >

            </div>
            <div class="form-group col-md-6">
                <label class="control-label"> Prenom </label>
                <input type="text" name="username" id="username"
                       class="form-control date" placeholder="Entrer le nom" >

            </div>

        </div>
        <div class="row">

            <div class="form-group col-md-6">
                <label class="control-label"> Nom </label>
                <input type="text" name="name" id="name"
                       class="form-control date" placeholder="Entrer le nom" >

            </div>
            <div class="form-group col-md-6">
                <label class="control-label"> Prenom </label>
                <input type="text" name="username" id="username"
                       class="form-control date" placeholder="Entrer le nom" >

            </div>

        </div>

    </div>
</section>
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
            @if(empty($user->employee->image))
        <?php $image="pcture_user.png"; ?>
            @else
        <?php  $image=$user->employee->image; ?>
            @endif

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
        defaultPreviewContent: '<img src="{{asset('picture_employe/'.$image)}}" alt="Ton image" style="width:125px"><h6 class="text-muted"></h6>',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["docx","pdf","jpg", "png", "gif"]
    });
</script>
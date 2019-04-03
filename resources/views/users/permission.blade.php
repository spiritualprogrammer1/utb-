@section('title') Gestion des Roles @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-users2"></i> Gestion des Roles</p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-users2"></i></a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#permissionTabl').tableExport({type:'excel',escape:'false'});">
                    <img src='{{asset('assets/images/icons/xls.png')}}' width="20"/> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onClick="$('#permissionTabl').tableExport({type:'pdf',escape:'false'});">
                    <img src='{{asset('assets/images/icons/pdf.png')}}' width="20"/> Pdf
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#permissionTabl').tableExport({type:'csv',escape:'false'});">
                    <img src='{{asset('assets/images/icons/csv.png')}}' width="20"/> CSV
                </a>
            </div>
        </header>
        <section class="scrollable">
            <section class="hbox">
                <aside class="wrapper bg-light dker">
                    <section class="panel panel-default">
                        <header class="panel-heading"> Liste des postes</header>
                        <table class="table  table-responsive table-striped b-t b-light" id="permissionTabl">
                            <thead>
                            <tr>
                                <th>Libelle</th>
                                <th><i class="i i-calendar"></i> Date</th>
                                <th><i class="" style="color:#411c0e ">action</i></th>
                            </tr>
                            </thead>
                            <tbody style="text-transform: capitalize" id="employeeRow">
                            @foreach($roles as $key=>$roles)
                                @if($roles->state !=1)
                                <tr id="userdata{{$roles->id}}" class="usera">
                                    <td>{{$roles->name}}</td>
                                    <td>{{$roles->created_at->format('d/m/Y')}}</td>
                                    <td><a href="#" onclick="infopermission(this)" id="{{$roles->id}}"><i
                                                    class="fa fa-pencil-square-o text-info-dk"></i></a></td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                </aside>
                <!-- /.aside -->
            </section>
        </section>
    </section>
    <div class="modal fade" id="newModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="datapermission">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    <script>
        var  $table=$('#permissionTabl'),
                $createModal=$('#newModal'),
                $roleform=$('#roleform');
        $datapermission=$('.datapermission');
        $table.DataTable({
            "sPaginationType": "full_numbers",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "iDisplayLength": 50,
            "language": {
                "url": "{{asset('assets/js/datatables/french.json')}}"
            },
            "order": [[4, "asc"]]
        });

        function infopermission(obj)
        {

            var id_permission=$(obj).attr('id');

            $.ajax({
                type:'get',
                url:"edit_permission",
                data:{id_permission:id_permission},
                dataType:'html',
                success:function (data) {

                    $datapermission.html(data);

                    $createModal.modal('show');

                }
            })
        }

        $roleform.on('submit',function() {
            alert('eded');
        });

    </script>
@endsection
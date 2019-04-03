@section('title') Comptes utilisateurs @endsection
@extends('layouts.master')
@section('content')
    <section class="">
    <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-users2"></i> COMPTES UTILISATEURS</p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-users2"></i></a>
            <div class="btn-group pull-right" data-toggle="buttons">
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#userTable').tableExport({type:'excel',escape:'false'});">
                    <img src='{{asset('assets/images/icons/xls.png')}}' width="20"/> Excel
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default"
                   onClick="$('#userTable').tableExport({type:'pdf',escape:'false'});">
                    <img src='{{asset('assets/images/icons/pdf.png')}}' width="20"/> Pdf
                </a>
                <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                   onClick="$('#userTable').tableExport({type:'csv',escape:'false'});">
                    <img src='{{asset('assets/images/icons/csv.png')}}' width="20"/> CSV
                </a>
            </div>
        </header>
        <section class="scrollable">
            <section class="hbox">
                <aside class="wrapper bg-light dker">
                    <section class="panel panel-default">
                        <header class="panel-heading"> Liste des comptes</header>
                        <table class="table  table-responsive table-striped b-t b-light" id="userTable">
                            <thead>
                            <tr>
                                <th>Nom & prenom</th>
                                <th>email</th>
                                <th>Mobile</th>
                                <th>Service</th>
                                <th>Poste</th>
                                <th><i class="i i-calendar"></i> Date</th>
                                <th><i class="i i-cog2"></i></th>
                            </tr>
                            </thead>
                            <tbody style="text-transform: capitalize" id="employeeRow">
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{$user->username}}</td>
                                    <td style="text-transform: lowercase">{{$user->email}}</td>
                                    <td>{{$user->employee->mobile}}</td>
                                    <td>{{$user->employee->service->display_name}}</td>
                                    <td>{{$user->employee->post->name}}</td>
                                    <td>{{$user->created_at->format('d/m/Y')}}</td>
                                    <td><a href="#" class="active" data-toggle="class"><i
                                                    class="fa fa-check text-success text-active"></i><i
                                                    class="fa fa-times text-danger text"></i></a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </section>
                </aside>
                <!-- /.aside -->
            </section>
        </section>
    </section>
    </section>
@endsection

@section('scripts')
    <script>
        $('#userTable').DataTable( {
            "sPaginationType": "full_numbers",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "iDisplayLength": 50,
            "language": {
                "url": "{{asset('assets/js/datatables/french.json')}}"
            },
            "order": [[ 5, "asc" ]]
        } );
    </script>
@endsection
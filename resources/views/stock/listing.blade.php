@section('title') Listing de Stock @endsection
@extends('layouts.master')
@section('content')
    <section class="vbox">
        <header class="header bg-light lter b-b b-light">
            <p class="h4 font-thin pull-left m-r m-b-sm">Liste des <span id="list_type">Pieces</span></p>
            <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cloud-upload"></i></a>
            <form class="form-inline m-t-sm pull-right pull-none-xs m-b-sm has-success" role="form">
                <div class="form-group">
                    <input type="text" class="form-control input-sm datepicker" name="begin"
                           placeholder="Date de debut">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control input-sm datepicker" name="end" placeholder="Date de fin">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-success m-t-n-xxs" id="submit_search" type="submit">
                        <i class="i i-search2"></i></button>
                </div>
            </form>
        </header>
        <section class="scrollable wrapper">
            <div class="row">
                <div class="col-md-3 col-md-push-9">
                    <div class="panel">
                        <div class="panel-heading b-b">Filtre</div>
                        <div class="panel-body">
                            <ul class="list-unstyled">
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter" checked><i></i> Pieces
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter"><i></i> Pneux
                                    </label>
                                </li>
                                <li class="radio i-checks">
                                    <label>
                                        <input type="radio" name="filter"><i></i> Last Month
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group m-l-md" data-toggle="buttons">
                        <a href="#" class="btn btn-sm btn-bg btn-rounded btn-default"
                           onClick="$('#pieceTable').tableExport({type:'xlsx',escape:'false'});">
                            <img src='{{asset('assets/images/icons/xls.png')}}' width="18"/> Excel
                        </a>
                        <a href="#" class="btn btn-sm btn-bg btn-default"
                           onClick="$('#pieceTable').tableExport({type:'pdf',escape:'false'});">
                            <img src='{{asset('assets/images/icons/pdf.png')}}' width="18"/> PDF
                        </a>
                        <a href="#" class="btn btn-sm btn-bg btn-default btn-rounded"
                           onClick="$('#pieceTable').tableExport({type:'csv',escape:'false'});">
                            <img src='{{asset('assets/images/icons/csv.png')}}' width="18"/> CSV
                        </a>
                    </div>
                </div>
                <div class="col-md-9 col-md-pull-3">
                    <div class="row-sm">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped b-primary capitalize" id="pieceTable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Reference</th>
                                    <th>Marque</th>
                                    <th>Modele</th>
                                    <th>Famille</th>
                                    <th>Sous famille</th>
                                    <th>Quantité</th>
                                    <th><i class="i i-calendar"></i> Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stocks as $key=>$stock)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>
                                            <a href="#" id="{{$stock->id}}" class="info">
                                                <i class="fa fa-search-plus text-muted"></i>
                                            </a>
                                        </td>
                                        <td class="uppercase">{{$stock->reference}}</td>
                                        <td>{{$stock->Model->brand->name}}</td>
                                        <td>{{$stock->model->name}}</td>
                                        <td>{{$stock->sub_category->category->name}}</td>
                                        <td>{{$stock->sub_category->name}}</td>
                                        <td>{{number_format($stock->quantity)}}</td>
                                        <td>{{$stock->created_at->format('d/m/Y')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </section>
@endsection
@section('scripts')
    <script>
        var $table = $('#pieceTable');
        $(function () {
            $table.dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
        })
    </script>
@endsection
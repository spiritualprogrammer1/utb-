@section('title')Historiques techniques @endsection
@section('styles')
    <style>
        .datepicker {
            z-index: 1151 !important;
        }
    </style>
@endsection
@extends('layouts.master')
@section('content')
    <section class="vbox bg-white">
        <section id="page" class="scrollable wrapper bg-light dker">
            <div class="page-title kkk">
                <div class="col-md-5">
                    <h2><span class="fa fa-arrow-circle-o-left" id="bwrgatbac" style="cursor: pointer;"></span> <span id="bwrtitlt" style="font-size: 25px;"> Historique techniques </span>  </h2>
                </div>
                <div class="col-md-2" style="text-align: center;">
                    <img src="{{asset('assets/images/patientegif5.gif')}}"
                         id="search_loader" style="height: 50px; width: 50px;" class="none">
                </div>
                <div class="col-md-5">

                </div>

            </div>
            <!-- END PAGE TITLE -->
            <!-- PAGE CONTENT WRAPPER -->
            <div class="page-content-wrap">
                <div class="row">
                    <div class="col-md-12">
                        <!-- START DATATABLE EXPORT -->
                        <div class="panel panel-default">
                            <div class="panel-body" id="homespace">
                                <div class="col-md-12">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-3">
                                        <label class="col-md-12 control-label" style="text-align: center;"><i class="fa fa-truck" style="font-size: 16px"></i> <b style="font-size: 16px">Immatriculation</b></label>
                                        <div class="form-group input-group">
                                            <select class="form-control chosen-select" id="vehicule">
                                                @foreach($buses as $buse)
                                                    <option class="uppercase"  style="font-weight: bold" value="{{$buse->id}}" >{{$buse->matriculation}}</option>
                                                @endforeach
                                            </select>
                                            <span class="input-group-btn">
                                                     <button onclick="byVehicule($('#vehicule').val());" class="btn btn-primary" style="height: 30px" type="button"><i class="fa fa-fw fa-search"></i></button>
                                                     </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5"></div>

                                </div>

                            </div>
                        </div>
                        <!-- END DATATABLE EXPORT -->


                    </div>
                </div>

            </div>
        </section>
    </section>
    <!-- END PAGE CONTENT WRAPPER -->
    <style>
        @media print {
            #impression{
                display: none;
            }
            #page{
                display: none;
            }
            #close
            {
                display: none;
            }

        }

    </style>
    <div class="modal fade" id="fileModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">


                <div class="fileModal">
                </div>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/datepicker/bootstrap-datepicker.js')}}"></script>

    <script>

        var  $homespace = $('#homespace'),$bwrgatbac = $('#bwrgatbac'),
                $search_loader = $('#search_loader'),$home;
        $bwrgatbac.hide();

        /* ##### Nouvelle configuration des historiques #####*/
        function byVehicule(val) {
            var id = val;
            $search_loader.show();
            $.get('histobyvehicle/' + id, function (data) {
                $home = $homespace.html();
                $homespace.html(data);
                $search_loader.hide();
                $bwrgatbac.show();
            });
        }
        function byClient(val) {
            var id = val;
            $search_loader.show();
            $.get('histobyclient/' + id, function (data) {
                $home = $homespace.html();
                $homespace.html(data);
                $search_loader.hide();
                $bwrgatbac.show();
            });
        }
        $bwrgatbac.on('click',function () {
            location.reload();
        });



    </script>
@endsection
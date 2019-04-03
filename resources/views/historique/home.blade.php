@extends('layouts.master')
@section('styles')
    <link href="{{asset('assets/js/jstree/src/themes/default/style.min.css')}}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Merriweather' rel='stylesheet' type='text/css'>
    <link href="{{asset('assets/js/videojs/video.css')}}" rel="stylesheet">
@endsection
@section('content')



    <section  style="margin-left: 25px;">
    {{--<div class="container">--}}
        <div class="row">
            <div class="row">
                <div class="col-md-3" style="position: relative;height: 750px;overflow-y: auto">
                    <div class="panel" >
                        <div class="panel-header">
                            <h3><i class="icon-bulb"></i> <strong>Historique</strong> </h3>
                            <input type="text" id="search" value="" class="form-control text-center " placeholder="Recherche...">
                            <div class="panel-content">
                                <div class="row">
                                    <div id="tree-client"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-9" style="margin-top: 5px">
                    <div class="timeline-btn-day"> <i class="icon-custom-left"></i>
                        <button id="name" class="btn btn-primary f-16 uppercase text-center center-block"> Historique </button>

                    </div>
                    <section  id="timeline" style="position: relative;height: 700px;overflow-y: scroll;margin-top: 19px;margin-right: 38px" >

                    </section>
                </div>






            </div>
        </div>
        <div class="cssload-container m-t-n-md none" id="spinner">
            <div class="cssload-progress cssload-float cssload-shadow m-t-n-md">
                <div class="cssload-progress-item"></div>
            </div>
        </div>

    </section>

@endsection

@section('scripts')

    <script src="{{asset('assets/js/jstree/jstree.min.js')}}"></script>

    <script>
        var $tree = $('#tree-client'),
            $search = $('#search'),
            $name = $('#name'),
            $spinner = $('#spinner'),
            $historic = $('#timeline');



        $(function () {
            $tree.jstree({
                'core': {
                    'data': {
                        "url": "index/create",
                        'state': {
                            'selected': false
                        }
                    }
                },
                "plugins" : [
                    "search", "wholerow"
                ]
            });
            var to = false;
            $search.keyup(function () {
                if(to) { clearTimeout(to); }
                to = setTimeout(function () {
                    var v = $search.val();
                    $tree.jstree(true).search(v);
                }, 250);
            });
            $tree.on("changed.jstree", function (e, data) {
                $spinner.show();
                //console.log(data.instance.get_node(data.selected[0]).text);
                var id = data.instance.get_node(data.selected[0]).text;
                $.get('index/' + id , function (data) {
                    $name.html(id);
                    $historic.html(data)
                    $spinner.hide();
                })
            });
        })



    </script>
    @endsection
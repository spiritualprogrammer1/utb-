@section('title') Parametrage @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DU SITE</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#brand" data-toggle="tab">SITE</a></li>
                </ul>
                <div class="panel panel-default tab-content">

                    <!----------  Brand tab ------------->
                    <ul class="list-group tab-pane  panel-primary active panel" id="brand">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r" id="aside">
                                <div class="wrapper">
                                    <h4 class="m-t-none">Gestion des sites</h4>
                                    <form id="siteForm"  method="POST" role="form">
                                        {{csrf_field()}}
                                        <input id="site_id" type="hidden" name="site_id">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" id="site_name" minlength="2"
                                                   placeholder="Nom du site"
                                                   class="input-sm form-control "
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label>Ville</label>
                                            <input type="text" name="ville" id="ville" minlength="3"

                                                   class="input-sm form-control "
                                                   required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="site_btn"
                                                    class="btn btn-sm btn-success" style="text-transform: uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                            <a href="#" class="btn btn-sm btn-icon btn-default pull-right btn_reset"
                                               onclick="reset_btn($('#site_btn'), $('#site_id'), $('#site_name'),$('#ville')); $(this).hide()">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8  panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped m-b-none table_1" id="brand_table">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        {{--<th>Ville</th>--}}
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                        <th> activer</th>
                                    </tr>
                                    </thead>
                                    <tbody style="text-transform: capitalize" id="siteRow">
                                    @foreach($site as $key=>$site)
                                        <tr id="site{{$site->id}}"
                                            class="@if($site->active==0) text-info @endif @if (Session::has('id')) @if($site->id == Session::get('id')) alert alert-info text-danger-dk @endif @endif">

                                            <td class="">{{$site->name}}</td>
                                            {{--<td>{{$site->ville}}</td>--}}
                                            <td>{{$site->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$site->id}}" onclick="siteEdit(this)"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            <td>
                                                <a href="#"  class="active" >
                                                    <i id="checked" id-site="{{$site->id}}"    @if($site->active==1) onclick="activesite(this)" data-comp="1" class="fa fa-check text-active text-success" @elseif($site->active==0) onclick="activesite(this)" data-comp="0" class="fa fa-times text-active text-danger" @endif ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->


                </div>
            </div>
        </aside>



    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
       data-target="#nav,html"></a>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.btn_reset').hide();
            $('.table_1').dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[1, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            $('.table_2').dataTable({
                "sPaginationType": "full_numbers",
                "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
                "iDisplayLength": 50,
                "order": [[2, "desc"]],
                "language": {
                    "url": "{{asset('assets/js/datatables/French.json')}}"
                }
            });
            loadBrands();
        });

        /*************active site********/


        function activesite (obj) {
            var datacompte=$(obj).attr("data-comp");
            id_site=$(obj).attr("id-site")
            if(datacompte==1)
            {
                $(obj).attr({"data-comp": 0});
                $(obj).removeClass('fa fa-check  text-success').addClass('fa fa-times text-active text-danger text');
                datacompte=$(obj).attr("data-comp");

                $.ajax({
                    url: 'activesite',
                    type: 'get',
                    dataType: 'json',
                    data:{datacompte:datacompte,id_site:id_site},
                    success: function (data) {
                        toastr["error"]('est inactif', "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;

                    },

                })

            }
            else if(datacompte==0){
                $(obj).attr({"data-comp": 1});
                $(obj).removeClass('fa fa-times text-danger text').addClass('fa fa-check text-active text-success');

                datacompte=$(obj).attr("data-comp");
                $.ajax({
                    url: 'activesite',
                    type: 'get',
                    dataType: 'json',
                    data:{datacompte:datacompte,id_site:id_site},
                    success: function (data) {
                        toastr["success"]('est actif ', "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                        toastr.options.preventDuplicates = true;
                    },
                })
            }
        }

        /*******************
         *  Brand JS BEGIN *
         ******************/
        function loadBrands() {
            $.get('fetch_brands', function (data) {
                var $this = $('#brands');
                $this.empty();
                $this.append('<option value selected disabled>Choisissez une marque</option>');
                $.each(data, function (index, modelObj) {
                    $this.append('<option style="text-transform: uppercase" value="' + modelObj.id + '">' + modelObj.name + '</option>');
                    $this.trigger("chosen:updated");
                });
            })
        }

        function reset_btn(obj, id, name,ville) {
            id.val('');
            name.val('');
            ville.val('');
            obj.val('save');
            obj.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $('.btn_reset').hide();
        }

        function reset_btn_2(obj, id, name, selected) {
            id.val('');
            name.val('');
            obj.val('save');
            selected.val('');
            selected.trigger("chosen:updated");
            obj.html('<i class="fa fa-floppy-o"></i> enregistrer');
            $('.btn_reset').hide();
        }

        /*******************
         *  Brand JS BEGIN *
         ******************/


        function siteEdit(obj) {
            $('.btn_reset').show();
            var $this = $('#site_btn');
            var id = $(obj).attr('id');
            $this.val('edit');
            $this.html('<i class="fa fa-pencil"></i> modifier');
            $.get('site_get?id=' + id, function (data) {
                $('#site_name').val(data.name);
                $('#ville').val(data.ville);
                $('#site_id').val(data.id);
            })
        }

        $('#siteForm').on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var $this = $('#site_btn');
            var state = $this.val();
            var type = 'post';
            var url = '{{route('/siteCreate')}}';
            var msg = "le site a été enregistrer";
            if (state == 'edit') {
                url = '{{route('/site_update')}}';
                msg = "le site a été modifier";
            }
            $this.button({loadingText: '<i class="fa fa-spinner fa-spin"></i> en cours...'});
            $this.button('loading');
            $.ajax({
                url: url,
                type: type,
                data: formData,
                success: function (data) {
                    loadBrands();
                    $('#siteForm').trigger('reset');
                    $('#site_name').focus();
                    toastr["success"](msg, "<span style='text-transform: uppercase'>" + data.name + "</span>!");
                    toastr.options.preventDuplicates = true;
                    var row = '<tr id="site' + data.id + '" class="alert alert-info text-danger-dk">' +
                        '<td style="text-transform: capitalize">' + data.name + '</td>' +
//                        '<td>' + data.ville + '</td>' +
                        '<td>' + data.date + '</td>' +
                        '<td><a href="#" id="' + data.id + '" onclick="siteEdit(this)"><i class="fa fa-pencil"></i></a></td>' +
                            '<td>' + '<a href="#"  class="active" >'
                            +'<i id="checked" id-site="'+data.id+'"     if(data.active==1) onclick="activecompte(this)" data-comp="1" class="fa fa-check text-active text-success" elseif(data.active==0) onclick="activesite(this)" data-comp="0" class="fa fa-times text-active text-danger" endif >'+'</i>'
                            +'</a>' + '</td>' +
                        '<tr>';
                    if (state == 'save') {
                        $('#siteRow').before(row);
                    } else {
                        $('#site' + data.id).replaceWith(row);
                    }
                },
                error: function (jqXhr) {
                    if (jqXhr.status === 401)
                        window.location.href = "/";
                    if (jqXhr.status === 422) {
                        $errors = jqXhr.responseJSON;
                        $.each($errors, function (key, value) {
                            $ferrors = value.name
                        });
                        toastr["error"]($ferrors, "Oups!");
                        toastr.options.preventDuplicates = true;
                    } else {
                    }
                }
            });
            $this.button('reset');
            reset_btn($this, $('#site_id'), $('#site_name'));
        });
        /******** END **********/


        /*******************
         *  Model JS BEGIN *
         ******************/


        /******** END **********/
    </script>
@endsection
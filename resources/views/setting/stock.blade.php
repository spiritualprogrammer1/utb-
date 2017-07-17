@section('title') Parametrage du stock @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DU STOCK</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#category" class="" data-toggle="tab">FAMILLE DES PIECES</a></li>
                    <li class=""><a href="#sub" data-toggle="tab">SOUS FAMILLE DES PIECES</a></li>
                    <li class=""><a href="#type" data-toggle="tab">TYPE DE PIECE</a></li>
                </ul>
                <div class="panel panel-default tab-content">
                    <!---------- Category tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel active" id="category">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">FAMILLE DES PIECES</h4>
                                    <form id="familyForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="family_id" type="hidden" name="family_id">
                                        <input type="hidden" name="family" value="1">
                                        <div class="form-group m-t-lg">
                                            <label>Nom de la famille:</label>
                                            <a href="#" id="family_reset" onclick="family_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="family_name" minlength="3"
                                                   placeholder="Intitulé de la famille"
                                                   class="input-sm form-control input_text" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="family_submit"
                                                    class="btn btn-sm btn-success btn-group-justified btn-rounded uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none table_1 capitalize">
                                    <thead>
                                    <tr>
                                        <th>Famille</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="familyRow">
                                    @foreach($categories as $key=>$category)
                                        <tr id="family{{$category->id}}">
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$category->id}}" class="family-edit">
                                                    <i class="fa fa-pencil text-success-dker"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->

                    <!---------- Sub Category tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel" id="sub">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">SOUS FAMILLE</h4>
                                    <form id="sub_family_form" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="sub_family_id" type="hidden" name="sub_family_id">
                                        <input name="sub_family" type="hidden" value="1">
                                        <div class="form-group">
                                            <label>Famille</label>
                                            <select class="chosen-select form-control" data-placeholder="CHOISISEZ UNE FAMILLE..." id="families" name="category">
                                                <option></option>
                                                @forelse($categories as $key=>$category)
                                                    <option value="{{$category->id}}" class="uppercase">{{$category->name}}</option>
                                                @empty
                                                    <option disabled>AUCUNE FAMILLE DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nom de sous famille</label>
                                            <a href="#" id="sub_family_reset" onclick="sub_family_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="sub_family_name" minlength="3"
                                                   placeholder="Intitulé de sous famille"
                                                   class="input-sm form-control input_text" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="sub_family_submit"
                                                    class="btn btn-sm btn-success btn-group-justified btn-rounded uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none table_2 capitalize">
                                    <thead>
                                    <tr>
                                        <th>Famille</th>
                                        <th>Sous famille</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="sub_family_row">
                                    @foreach($subs as $key => $sub)
                                        <tr id="sub_family{{$sub->id}}">
                                            <td>{{$sub->category->name}}</td>
                                            <td>{{$sub->name}}</td>
                                            <td>{{$sub->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$sub->id}}" class="sub-family-edit">
                                                    <i class="fa fa-pencil text-success-dker"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!------------- End ------------->

                    <!---------- Type tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel" id="type">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker">TYPE DE PIECES</h4>
                                    <form id="typeForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="type_id" type="hidden" name="type_id">
                                        <input type="hidden" name="type">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="name" id="type_name" minlength="3"
                                                   placeholder="Nom du type" class="input-sm form-control input_text"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <a href="#" id="type_reset" style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <textarea rows="3" name="description" id="type_description"
                                                      placeholder="Description du type"
                                                      class="input-sm form-control input_text"></textarea>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="type_submit"
                                                    class="btn btn-sm btn-success btn-rounded btn-group-justified uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped capitalize m-b-none table_2">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="typeRow">
                                    @foreach($types as $key=>$type)
                                        <tr id="type{{$type->id}}">
                                            <td>{{$type->name}}</td>
                                            <td>{{$type->description}}</td>
                                            <td>{{$type->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$type->id}}" class="type-edit"><i
                                                            class="fa fa-pencil text-success-dker"></i></a>
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
        <!--<section class="aside-md">
            <section class="vbox bg-white">

            </section>
        </section>-->
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open"
       data-target="#nav,html"></a>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/scripts/setting.stock.js')}}"></script>
@endsection
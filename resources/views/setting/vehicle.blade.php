@section('title') Parametrage des cars @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DES CARS</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#brand" data-toggle="tab">MARQUE DES CARS</a></li>
                    <li class=""><a href="#model" class="" data-toggle="tab">MODELE DES CARS</a></li>
                </ul>
                <div class="panel panel-default tab-content">
                    <!----------  Brand tab ------------->
                    <ul class="list-group tab-pane  panel-primary active panel" id="brand">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r" id="aside">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dk uppercase">Gestion des marques</h4>
                                    <form id="brandForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="brand" value="1">
                                        <input id="brand_id" type="hidden" name="brand_id">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <a href="#" id="brand_reset" onclick="brand_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="brand_name" minlength="3"
                                                   placeholder="Nom de la marque"
                                                   class="input-sm form-control input_text" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="brand_submit"
                                                    class="btn btn-sm btn-success btn-rounded btn-group-justified uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8  panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped m-b-none table_1 capitalize"
                                       id="brand_table">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="brandRow">
                                    @foreach($brands as $key=>$brand)
                                        <tr id="brand{{$brand->id}}">
                                            <td>{{$brand->name}}</td>
                                            <td>{{$brand->created_at->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="#" id="{{$brand->id}}" class="brand-edit"><i
                                                            class="fa fa-pencil text-success-dk"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->
                    <!---------- Model tab -------------->
                    <ul class="list-group tab-pane list-group-alt list-group-lg panel-primary panel" id="model">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none">Gestion des modeles</h4>
                                    <form id="modelForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input id="model_id" type="hidden" name="model_id">
                                        <input type="hidden" name="model">
                                        <div class="form-group">
                                            <label>Marque</label>
                                            <select class="chosen-select form-control"
                                                    data-placeholder="CHOISISSEZ UNE MARQUE..." id="brands"
                                                    name="model_brand">
                                                <option></option>
                                                @forelse($brands as $key=>$brand)
                                                    <option value="{{$brand->id}}" class="uppercase">{{$brand->name}}</option>
                                                @empty
                                                    <option disabled>AUCUNE MARQUE DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <a href="#" id="model_reset" onclick="model_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="model_name" minlength="2"
                                                   placeholder="Nom du modele" class="input-sm form-control input_alpha"
                                                   required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="model_submit"
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
                                        <th>Marque</th>
                                        <th>Modele</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="modelRow">
                                    @foreach($models as $key => $model)
                                        <tr id="model{{$model->id}}">
                                            <td>{{$model->brand->name}}</td>
                                            <td>{{$model->name}}</td>
                                            <td>{{$model->created_at->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="#" id="{{$model->id}}" class="model-edit"><i
                                                            class="fa fa-pencil text-success-dk"></i></a>
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
    <script src="{{asset('assets/js/scripts/setting.vehicle.js')}}"></script>
@endsection
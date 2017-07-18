@section('title') Parametrage du magasin @endsection
@extends('layouts.master')
@section('content')
    <header class="header bg-light lt b-b b-light">
        <p class="h4 font-thin pull-left m-r m-b-sm"><i class="i i-cog2"></i> PARAMETRAGE DU MAGASIN</p>
        <a class="btn btn-sm btn-info btn-rounded btn-icon"><i class="i i-cog2"></i></a>
    </header>
    <section class="hbox stretch bg-light dker">
        <aside class="b-r ">
            <div class="wrapper container-fluid">
                <ul class="nav nav-tabs m-b-n-xxs">
                    <li class="active"><a href="#ray" data-toggle="tab">RAYONS</a></li>
                    <li class=""><a href="#shelf" class="" data-toggle="tab">ETAGERES</a></li>
                    <li class=""><a href="#block" class="" data-toggle="tab">CASIER</a></li>
                </ul>
                <div class="panel panel-default tab-content">

                    <!----------  Ray tab ------------->
                    <ul class="list-group tab-pane  panel-primary active panel" id="ray">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r" id="aside">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dker uppercase">Gestion des rayons</h4>
                                    <form id="rayForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="ray" value="1">
                                        <input id="ray_id" type="hidden" name="ray_id">
                                        <div class="form-group m-t-md">
                                            <label>Designation</label>
                                            <a href="#" id="ray_reset" onclick="ray_reset()"
                                               style="position: relative"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="ray_name" minlength="3"
                                                   placeholder="Nom du rayon"
                                                   class="input-sm form-control input_alpha"
                                                   required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="ray_submit"
                                                    class="btn btn-sm btn-success btn-group-justified btn-rounded"
                                                    style="text-transform: uppercase">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8  panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive">
                                <table class="table table-responsive table-striped m-b-none capitalize table_1">
                                    <thead>
                                    <tr>
                                        <th>Designation</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="rayRow">
                                    @foreach($rays as $key=>$ray)
                                        <tr id="ray{{$ray->id}}">
                                            <td>{{$ray->name}}</td>
                                            <td>{{$ray->created_at->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="#" id="{{$ray->id}}" class="text-success-dk ray-edit">
                                                    <i class="fa fa-pencil"></i>
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

                    <!---------- Shelf tab -------------->
                    <ul class="list-group tab-pane list-group-alt list-group-lg panel-primary panel" id="shelf">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none text-success-dk uppercase">Gestion des etageres</h4>
                                    <form id="shelfForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="shelf" value="1">
                                        <input id="shelf_id" type="hidden" name="shelf_id">
                                        <div class="form-group m-t-md">
                                            <label>Rayon</label>
                                            <select class="chosen-select form-control input-sm" id="rays"
                                                    data-placeholder="CHOISISSEZ UN RAYON..." name="rays">
                                                <option></option>
                                                @forelse($rays as $key=>$ray)
                                                    <option value="{{$ray->id}}"
                                                            class="uppercase">{{$ray->name}}</option>
                                                @empty
                                                    <option disabled>AUCUN RAYON DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <a href="#" id="shelf_reset" style="position: relative"
                                               onclick="shelf_reset()"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="shelf_name" minlength="3"
                                                   placeholder="Designation de l'etagere"
                                                   class="input-sm form-control input_alpha" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="shelf_submit"
                                                    class="btn btn-sm btn-success uppercase btn-group-justified btn-rounded">
                                                <i class="fa fa-floppy-o"></i> enregistrer
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </aside>
                        </div>

                        <div class="col-sm-8 panel-default panel" style="overflow: scroll; max-height: 80vh">
                            <div class="table-responsive ">
                                <table class="table table-responsive table-striped m-b-none capitalize table_2">
                                    <thead>
                                    <tr>
                                        <th>Rayon</th>
                                        <th>Etagère</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="shelfRow">
                                    @foreach($shelves as $key => $shelf)
                                        <tr id="shelf{{$shelf->id}}">
                                            <td>{{$shelf->ray->name}}</td>
                                            <td>{{$shelf->name}}</td>
                                            <td>{{$shelf->created_at->format('d/m/Y H:i:s')}}</td>
                                            <td>
                                                <a href="#" id="{{$shelf->id}}" class="shelf-edit"><i
                                                            class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </ul>
                    <!--------------- End --------------->

                    <!---------- Bloc tab ----------->
                    <ul class="list-group tab-pane list-group-lg panel-primary panel" id="block">
                        <div class="col-sm-4">
                            <aside class="aside-md bg-white b-r">
                                <div class="wrapper">
                                    <h4 class="m-t-none">Gestion des casier</h4>
                                    <form id="blocForm" method="post" role="form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="bloc" value="1">
                                        <input id="bloc_id" type="hidden" name="bloc_id">
                                        <div class="form-group m-t-md">
                                            <label>Rayon</label>
                                            <select class="chosen-select form-control input-sm"
                                                    data-placeholder="CHOISISSEZ UN RAYON..."
                                                    id="bloc_ray">
                                                <option></option>
                                                @forelse($rays as $key=>$ray)
                                                    <option value="{{$ray->id}}"
                                                            class="uppercase">{{$ray->name}}</option>
                                                @empty
                                                    <option disabled>AUCUN RAYON DISPONIBLE</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Etagere</label>
                                            <span href="#" id="shelves_spinner" style="position: relative"
                                                  class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-spin fa-spinner"></i>
                                            </span>
                                            <select class="chosen-select form-control" id="bloc_shelf" name="bloc_shelf"
                                                    data-placeholder=".............................................">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <a href="#" id="bloc_reset" style="position: relative"
                                               onclick="bloc_reset()"
                                               class="btn btn-sm btn-icon btn-default btn-rounded pull-right none m-t-n-sm">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                            <input type="text" name="name" id="bloc_name" minlength="3"
                                                   placeholder="Designation du casier"
                                                   class="input-sm form-control input_alpha" required>
                                        </div>
                                        <div class="m-t-lg">
                                            <button type="submit" value="save" id="bloc_submit"
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
                                <table class="table table-responsive table-striped m-b-none capitalize table_3">
                                    <thead>
                                    <tr>
                                        <th>Rayon</th>
                                        <th>Etagere</th>
                                        <th>Casier</th>
                                        <th><i class="i i-calendar"></i> Date</th>
                                        <th><i class="i i-cog2"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="blocRow">
                                    @foreach($blocks as $key => $block)
                                        <tr id="block{{$block->id}}">
                                            <td>{{$block->shelf->ray->name}}</td>
                                            <td>{{$block->shelf->name}}</td>
                                            <td>{{$block->name}}</td>
                                            <td>{{$block->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                <a href="#" id="{{$block->id}}" class="bloc-edit"><i
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
    <script src="{{asset('assets/js/scripts/setting.warehouse.js')}}"></script>
@endsection
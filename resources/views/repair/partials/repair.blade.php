<header class="panel-heading text-right bg-light">
    <ul class="nav nav-tabs nav-justified  uppercase">
        <li class="dropdown @if($repair->state == 4) @else active @endif">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-comments text-muted"></i> Details <b class="caret"></b></a>
            <ul class="dropdown-menu text-left">
                <li><a href="#repair-description" data-toggle="tab">
                        <i class="i i-list"></i> Detail des réparations</a>
                </li>
                <li><a href="#repair-new" data-toggle="tab">
                        <i class="i i-add-to-list"></i> Ajouter les details</a>
                </li>
            </ul>
        </li>
        <li><a href="#technicians" data-toggle="tab">
                <i class="i i-users2 text-muted"></i> Techniciens</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-cog text-muted"></i> Pieces de réparation <b class="caret"></b></a>
            <ul class="dropdown-menu text-left">
                <li><a href="#repair-pieces" data-toggle="tab"><i class="i i-stack"></i> Liste des piéces attribuées</a>
                </li>
                <li><a href="#repair-piece" data-toggle="tab"><i class="i i-stack2"></i> Demande des pieces</a></li>
                @if(isset($item_stock))
                <li><a href="#repair-moteur" data-toggle="tab"><i class="i i-stack2"></i> Gestion de moteur</a></li>
                @endif
                <li><a href="#repair-pneu" data-toggle="tab"><i class="i i-stack2"></i> Gestion de pneu</a></li>
            </ul>
        </li>
        @if($repair->state == 4)
            <li class="active"><a href="#afterworks" data-toggle="tab" class="uppercase text-danger-dker">
                    <i class="fa fa-warning"></i> Remarques Apres test
                </a>
            </li>
        @endif
    </ul>

</header>
<div class="panel-body">
    <div class="tab-content">
        <div class="tab-pane fade @if($repair->state == 4) @else active in @endif" id="repair-description">
            <div class="panel-group m-b" id="accordionDescription">
                <?php $count = $repair->diagnostic->service_description->count() ?>
                @foreach($repair->diagnostic->service_description->sortByDesc('created_at') as $key=>$description)
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <a class="accordion-toggle @if($key < $count - 1) collapsed @endif" data-toggle="collapse"
                               data-parent="#accordionDescription" href="#description{{$key}}">
                                <span class="capitalize">{{$description->title}}</span>
                                <span class="pull-right">
                                       {{\Jenssegers\Date\Date::parse($description->created_at)->format('j M Y')}}
                                   </span>
                            </a>
                        </div>
                        <div id="description{{$key}}" class="panel-collapse collapse @if($key == $count - 1) in @endif"
                             style="height: auto;">
                            <div class="panel-body">
                                {{$description->description}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="tab-pane fade" id="repair-new">
            <a href="#"
               class="btn btn-sm btn-info pull-right uppercase"
               id="detail_add">
                <i class="fa fa-plus-circle"></i>
                Ajouter un detail
            </a>
            <table class="table" id="detail_table">
                <tbody></tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="repair-pieces">
            <table class="table table-striped m-b-none">
                <thead>
                <tr>
                    <th width="90%">Piéces</th>
                    <th>Demandé</th>
                    <th>Attribué</th>

                </tr>
                </thead>
                <tbody>
                <?php $count = '' ?>
                @forelse($repair->diagnostic->demand as $demand)
                    @if($repair->diagnostic->demand )
                        @if($demand->state == '0')
                            <?php $count = '1' ?>
                        @endif
                    @endif
                    @if($demand->state == '2' or $demand->state == '3')
                        @forelse($demand->demand_piece as $piece)
                            <tr>
                                <td class="capitalize">{{$piece->piece}}</td>
                                <td class="text-center">{{$piece->quantity}}</td>
                                <td class="text-center">{{$piece->delivered}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    Aucune demande de piece en effectuée
                                </td>
                            </tr>
                        @endforelse
                    @endif
                @empty
                    <tr>
                        <td colspan="3" class="text-center capitalize">Aucune demande de pieces effectuée</td>
                    </tr>
                @endforelse
                @if($count)
                    <span class="text-center" style="margin-left: 40%;">
                        <span class="badge bg-danger badge-sm">{{$repair->diagnostic->demand->where('state','0')->count()}}</span>
                        Demande de piece en attente
                    </span>
                @endif
                </tbody>
            </table>
        </div>
        @if($item_stock)
        <div class="tab-pane fade" id="repair-moteur">
            <div class="panel-heading panel-danger alert-danger text-center">
              GESTION DE MOTEUR
            </div>
            <div class="panel-body">
                <div class="row form-group-sm">
                    <div class="col-md-4">
                        {{--{{$item_stock}}--}}
                        <label class="text-info-dk"><b>REFERENCE</b> :  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_stock->stock->reference}}</a></label>
                    </div>
                    {{--<div class="col-md-3 ">--}}
                        {{--<input type="text" name="" class="form-control text-info" value="{{$item_stock->stock->reference}}" readonly>--}}
                    {{--</div>--}}
                    <div class="col-md-4">
                        <label class="text-info-dk text-right"> <b>LIBELLE :</b>  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_stock->stock->libelle}}</a> </label>
                    </div>
                    {{--<div class="col-md-3">--}}
                        {{--<input type="text" name="" class="form-control text-danger" value="{{$item_stock->stock->libelle}}" readonly>--}}

                    {{--</div>--}}
                    <div class="col-md-4">
                        <label class="text-info-dk text-right"> <b>km/s Initiale :</b>  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_stock->stock->mileage}}</a>  </label>
                    </div>

                </div>
                </br>

                <div class="row form-group-sm">

                    <div class="col-md-5">
                        <label class="text-info-dker-dk text-right"> <b>km/s du moteur dans le véhicule :</b> <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$repair->diagnostic->statee->kilometer_engine}}</a>  </label>
                    </div>
                    <div class="col-md-3">
                        <label class="text-info-dker-dk text-right"> <b>km/s nouveau km moteur :</b> </label>

                    </div>
                    <div class="col-md-4">


                        @if(isset($engine) and !empty($engine))

                        <input type="text" name="new_kilometer"  @if($engine) value="{{$engine->kilometer ? $engine->kilometer : 0}}"  @endif placeholder="entrer le nouveau kilometrage" class="form-control text-danger">
                            <input type="hidden" name="level_engine" value="{{$engine->level}}">
                            @else
                            <input type="text" name="new_kilometer"  value="0"   placeholder="entrer le nouveau kilometrage" class="form-control text-danger">

                        @endif


                    </div>


                </div>
                </br>
                <div class="row form-group-sm">

               <input type="hidden" name="item_stock_id" value="{{$item_stock->id}}" >
                </div>


            </div>
        </div>
        @endif
        <div class="tab-pane fade" id="repair-pneu">


            @foreach($item_tire_stock as $key=> $item_tire_stoc)
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}">
                            <span class="text-info">Pneu n° {{$key+1}} </span>   ||    <u>Reference :  <strong class="text-danger"> {{$item_tire_stoc->stock->reference}}</strong> </u>  </a>
                    </h4>
                </div>
                <div id="collapse{{$key}}" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="row form-group-sm">
                            <div class="col-md-4">
                                <label class="text-info-dk"><b>DOT</b> :  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_tire_stoc->stock->dot}}</a></label>
                            </div>
                            <div class="col-md-4">
                                <label class="text-info-dk text-right"> <b>LIBELLE :</b>  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_tire_stoc->stock->libelle}}</a> </label>
                            </div>
                            <div class="col-md-4">
                                <label class="text-info-dk text-right"> <b>km/s Initiale :</b>  <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_tire_stoc->stock->mileage}}</a>  </label>
                            </div>

                        </div>
                        </br>

                        <div class="row form-group-sm">

                            <div class="col-md-5">
                                <label class="text-info-dk text-right"> <b> placement:</b> <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car">{{$item_tire_stoc->stock->sens_tire}}</a>  </label>
                            </div>
                            <div class="col-md-3">
                                <label class="text-info-dker-dk text-right"> <b>km/s du pneu :</b> </label>

                            </div>
                            <div class="col-md-4">
                                @if(count($engine_tire)!=0)
                                    @for($k=0;$k<count($engine_tire) ;$k++)



                                    @if(count($engine_tire[$k]) !=0)

                                        @if($engine_tire[$k][0]->item_stock_id==$item_tire_stoc->id)
                                            <input type="text" name="new_kilometer_tire[]"
                                       value="{{$engine_tire[$k][0]->kilometer}}" placeholder="entrer le nouveau kilometrage" class="form-control text-danger">

                                            <input type="hidden" name="engine_tire_id[]" value="{{$engine_tire[$k][0]->id}}">
                                            <input type="hidden" name="engine_tire_idd" value="1">

                                        @else
                                            <input type="text" name="new_kilometer_tire[]"
                                                   value="0" placeholder="entrer le nouveau kilometrage" class="form-control text-danger">

                                        @endif
                                            @endif

                                    @endfor
                                    @else
                                    <input type="text" name="new_kilometer_tire[]"
                                           value="0" placeholder="entrer le nouveau kilometrage" class="form-control text-danger">


                                @endif


                            </div>


                        </div>
                        </br>
                        <div class="row form-group-sm">

                            <input type="hidden" name="item_stock_tire_id[]" value="{{$item_tire_stoc->id}}" >

                        </div>


                    </div>
                </div>
            </div>
        </div>
                @endforeach


        </div>


        <div class="tab-pane fade" id="repair-piece">

            <div class="row">
                <a href="#"
                   class="btn btn-sm btn-info pull-right uppercase"
                   id="piece_add">
                    <i class="fa fa-plus-circle"></i>
                    Demande des pieces
                </a>
                <table class="table"
                       id="pieceTable">
                    <thead>
                    <tr>
                        <th>Pieces demandées</th>
                        <th width="80">Qtés</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            {{--<div class="row">--}}

                {{--<table class="table table-striped m-b-none">--}}
                    {{--<thead>--}}
                        {{--<th width="10">Pièces demandées</th>--}}
                        {{--<th width="10">Libellé</th>--}}
                        {{--<th width="10">Qté</th>--}}
                        {{--<th width="10">Km initiale</th>--}}
                        {{--<th width="10">Km final</th>--}}
                        {{--<th width="2">Dispo.</th>--}}
                        {{--<th width="2">Quantité</th>--}}
                    {{--</thead>--}}
                    {{--<tr>--}}
                        {{--<td>--}}
                            {{--<select class="custom-select form-control input-sm uppercase col-md-6" name="diagnostic"--}}
                                    {{--id="diagnostic" data-placeholder="la reference de la piece">--}}
                                {{--<option></option>--}}
                                {{--xxx--}}
                                {{--@foreach($diagnostics as $diagnostic)--}}
                                {{--<option value="{{$diagnostic->id}}" name="diagnostic"--}}
                                {{--id="diagnostic{{$diagnostic->id}}"--}}
                                {{--data-bus="{{$diagnostic->statee->bus->model->brand->name." ".$diagnostic->statee->bus->model->brand->name}}"--}}
                                {{--data-matriculation="{{$diagnostic->statee->bus->matriculation}}">--}}
                                {{--{{strtoupper($diagnostic->statee->reference)}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</td>--}}

                    {{--</tr>--}}

                {{--</table>--}}
                {{--<div class="col-md-4">--}}

                {{--</div>--}}
                {{--<div class="col-md-8">--}}
                {{--</div>--}}


            {{--</div>--}}

        </div>
        <div class="tab-pane fade" id="technicians">
            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group alt">
                        @foreach($repair->diagnostic->service_employee as $key=>$technician)
                            <li class="list-group-item">
                                <div class="media">
                        <span class="pull-left thumb-sm"><img src="{{asset('assets/images/a0.png')}}" alt="John said"
                                                              class="img-circle"></span>
                                    <div class="pull-right text-success m-t-sm">
                                        <i class="fa fa-circle"></i>
                                    </div>
                                    <div class="media-body">
                                        <div><a href="#" class="capitalize">{{$technician->employee->username}}</a>
                                        </div>
                                        <small class="text-muted">{{\Jenssegers\Date\Date::parse($technician->created_at)->diffForHumans()}}</small>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6 pull-right">
                    <label class="control-label">Ajouter des techniciens</label>
                    <p>
                        <small>Maintenez la touche CTRL enfoncée et selectionner les nouveaux technicien à affecter a la
                            réparation
                        </small>
                    </p>
                    <select class="chosen-select form-control input-sm"
                            data-placeholder="Choissisez les technicien"
                            name="technician[]"
                            id="technician" multiple>
                        @foreach($employees as $key=>$item)
                            <option class="capitalize"
                                    value="{{$item->id}}">{{$item->username}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="tab-pane fade @if($repair->state == 4) active in @endif" id="afterworks">
            <div class="panel-group m-b" id="accordionRemark">
                <?php $count = $repair->diagnostic->work->where('state', '4')->count() ?>
                @foreach($repair->diagnostic->work->where('state','4')->sortByDesc('created_at') as $key=>$item)
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <a class="accordion-toggle @if($key < $count) collapsed @endif" data-toggle="collapse"
                               data-parent="#accordionRemark" href="#remark{{$key}}">
                                <span class="capitalize">{{$item->employee->username}}</span>
                                <span class="pull-right">
                                       {{\Jenssegers\Date\Date::parse($item->created_at)->format('j M Y')}}
                                   </span>
                            </a>
                        </div>
                        <div id="remark{{$key}}" class="panel-collapse collapse @if($key == $count) in @endif"
                             style="height: auto;">
                            <div class="panel-body text-danger-dker">
                                {{$item->description}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    var $piece_add = $('#piece_add'),
        $detail_new = $('#detail_add');
    $piece_add.on('click', function () {
        var $table = $('#pieceTable tbody');
        $table.append($('#pieceAdd tbody tr:last').clone());
        var rows = $('#pieceTable tr');

        var count = rows.length,
            lastRow = rows[count - 1],
            text_area = $(lastRow).find('textarea'),
            text_input = $(lastRow).find('input');

        text_area.eq(0).attr('id', 'piece' + count);
        text_input.eq(0).attr('id', 'quantity' + count);
        $('#quantity' + count).val('');
        $('#piece' + count).val('');
    });
    $detail_new.on('click', function () {
        var $table = $('#detail_table tbody');
        $table.append($('#reference_table tbody tr:last').clone());
        var rows = $('#detail_table tr');

        var count = rows.length,
            lastRow = rows[count - 1],
            text_area = $(lastRow).find('textarea'),
            text_input = $(lastRow).find('input');

        text_area.eq(0).attr('id', 'reference_description' + count);
        text_input.eq(0).attr('id', 'reference_title' + count);
        $('#reference_title' + count).val('');
        $('#reference_description' + count).val('');
    });

    $(".custom-select").chosen({
        disable_search_threshold: 10,
        no_results_text: "Oops, rien n'a été trouvé!",
        width: "80%",
    });

</script>
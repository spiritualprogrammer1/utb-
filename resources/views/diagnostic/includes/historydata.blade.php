<header class="panel-heading text-right bg-light">
    <ul class="nav nav-tabs nav-justified  uppercase">

        <li><a href="#repair-description" data-toggle="tab">
                <i class="i i-users2 text-muted"></i> Detail des réparations</a>
        </li>
        <li><a href="#technicians" data-toggle="tab">
                <i class="i i-users2 text-muted"></i> Techniciens</a>
        </li>
        <li><a href="#repair-pieces" data-toggle="tab">
                <i class="fa fa-cog text-muted"></i> Liste des piéces  de réparation</a>
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
        <div class="tab-pane fade" id="repair-piece">
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
        <div class="tab-pane fade" id="technicians">
            <div class="row">
                <div class="col-md-8">
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
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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
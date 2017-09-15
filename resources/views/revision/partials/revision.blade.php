<header class="panel-heading text-right bg-light">
    <ul class="nav nav-tabs nav-justified  uppercase">
        <li class="dropdown @if($revision->state == 4) @else active @endif">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-comments text-muted"></i> Details <b class="caret"></b></a>
            <ul class="dropdown-menu text-left">
                <li><a href="#revision-description" data-toggle="tab">
                        <i class="i i-list"></i> Detail des révisions</a>
                </li>
                <li><a href="#revision-new" data-toggle="tab">
                        <i class="i i-add-to-list"></i> Ajouter les details</a>
                </li>
            </ul>
        </li>
        <li><a href="#technicians" data-toggle="tab">
                <i class="i i-users2 text-muted"></i> Techniciens</a>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-cog text-muted"></i> Pieces de révision <b class="caret"></b></a>
            <ul class="dropdown-menu text-left">
                <li><a href="#revision-pieces" data-toggle="tab"><i class="i i-stack"></i> Liste des piéces attribuées</a>
                </li>
                <li><a href="#revision-piece" data-toggle="tab"><i class="i i-stack2"></i> Demande des pieces</a></li>
            </ul>
        </li>
        @if($revision->state == 4)
            <li class="active"><a href="#afterworks" data-toggle="tab" class="uppercase text-danger-dker">
                    <i class="fa fa-warning"></i> Remarques Apres test
                </a>
            </li>
        @endif
    </ul>

</header>
<div class="panel-body">
    <div class="tab-content">
        <div class="tab-pane fade @if($revision->state == 4) @else active in @endif" id="revision-description">
            <div class="panel-group m-b" id="accordionDescription">
                <?php $count = $revision->diagnostic->service_description->count() ?>
                @foreach($revision->diagnostic->service_description->sortByDesc('created_at') as $key=>$description)
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
        <div class="tab-pane fade" id="revision-new">
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
        <div class="tab-pane fade" id="revision-pieces">
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
                @forelse($revision->diagnostic->demand as $demand)
                    @if($revision->diagnostic->demand )
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
                        <span class="badge bg-danger badge-sm">{{$revision->diagnostic->demand->where('state','0')->count()}}</span>
                        Demande de piece en attente
                    </span>
                @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="revision-piece">
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
                <div class="col-md-4">
                    <ul class="list-group alt">
                        @foreach($revision->diagnostic->service_employee as $key=>$technician)
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
        <div class="tab-pane fade @if($revision->state == 4) active in @endif" id="afterworks">
            <div class="panel-group m-b" id="accordionRemark">
                <?php $count = $revision->diagnostic->work->where('state', '4')->count() ?>
                @foreach($revision->diagnostic->work->where('state','4')->sortByDesc('created_at') as $key=>$item)
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
</script>
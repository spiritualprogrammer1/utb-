
<div class="timeline">
    <article class="timeline-item">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow left"></span>
                    <span class="timeline-icon"><i class="fa fa-eye time-icon bg-primary"></i></span>
                    <span class="timeline-date">

                    {{$states->first()->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->first()->created_at)->format('F Y')}}

                        <span class="text-muted m-l-sm pull-right">
                            <i class="fa fa-clock-o"></i>
                        </span>
                    </span>
                    <div class="text-sm"><h3>Reception du véhicule : <strong class="text-success">{{$states->first()->bus->model->name.' '.$states->first()->bus->model->brand->name}}</strong></h3> </div>
                    <h1 class="text-info-dker">

                        <p style="font-size: 18px"><strong>Remarque: &nbsp;</strong>{{$states->first()->remark}}</p>


                        <p style="font-size: 18px" ><strong>Incident : &nbsp;</strong>{{$states->first()->incident}}</p>


                    </h1>
                    <h3 class="text-danger-dker">
                        <div class="row">
                            <div class="col-md-6">
                                <p style="font-size: 15px"><strong>Kilometrage:</strong>&nbsp;&nbsp; {{$states->first()->kilometer}} Km/h</p>

                            </div>
                            <div class="col-md-6">
                                <p style="font-size: 15px"><strong>Kilometrage/moteur:</strong> &nbsp;&nbsp; {{$states->first()->kilometer_engine}} Km/h</p>

                            </div>

                        </div>

                    </h3>
                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="state">
                </div>
            </div>
        </div>
    </article>
    <article class="timeline-item alt">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow right"></span>
                    <span class="timeline-icon"><i class="fa fa-magic time-icon bg-success"></i></span>
                    <span class="timeline-date">

                    {{$states->first()->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->first()->created_at)->format('F Y')}}

                        <br>
                                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>

                            </span>

                    </span>
                    <h4 class="text-danger">ETAT DU VEHICULE</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size: 20px" class="text-info">Niveau du carburant :

                                @foreach($states->first()->field_state as $field_states)
                                    @if($field_states->field->type==2)
                                        {{$field_states->field->name}}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p style="font-size: 20px" class="text-success">Enjoliveur :

                                @foreach($states->first()->field_state as $field_states)
                                    @if($field_states->field->type==1)
                                        {{$field_states->field->name}}
                                    @endif
                                @endforeach
                            </p>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 20px" class="text-dk">Compatiment :

                                @foreach($states->first()->field_state as $field_states)
                                    @if($field_states->field->type==0)
                                        {{$field_states->field->name}} ,
                                    @endif
                                @endforeach
                            </p>
                        </div>


                    </div>
                    @if($states->first()->accident==1)

                        ---------------------------------------------------------------------------------------------------------------------------
                        <div class="row">
                            <div class="col-md-12">
                                <p style="font-size: 18px" class="text-dk text-center">Accident  le  {{$states->first()->date_accident}}
                                </p>

                                <div class="col-md-12" style="font-size: 17px">
                                    Lieu : <strong>{{$states->first()->lieu}}</strong>
                                </div>


                                <span style="font-size: 17px">Description : <strong class="text-info">{{$states->first()->description_accident}}</strong></span>


                            </div>


                        </div>
                    @endif




                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnosticload">
                </div>

            </div>
        </div>
    </article>

    @if($states->first()->work)
        @if($states->first()->work->type==1)
            <article class="timeline-item">
                <div class="timeline-caption">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <span class="arrow left"></span>
                            <span class="timeline-icon"><i class="fa fa-eye time-icon bg-primary"></i></span>
                            <span class="timeline-date">

                    {{$states->first()->work->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->first()->work->created_at)->format('F Y')}}


                                <span class="text-muted m-l-sm pull-right">
                            <i class="fa fa-clock-o"></i>
                        </span>
                    </span>
                            <div class="text-sm"><h3>Essai avant travaux : </h3> </div>
                            <h1 class="text-info-dker">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="font-size: 18px" ><strong>Arrivé : &nbsp;</strong>{{$states->first()->work->arrive}} km/h</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="font-size: 18px"><strong>Distance: &nbsp;</strong>{{$states->first()->work->distance}} km/h</p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <p style="font-size: 18px" ><strong>Lieu : &nbsp;</strong>{{$states->first()->work->place}}</p>
                                    </div>
                                </div>



                            </h1>
                            <h3 class="text-danger-dker">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p style="font-size: 15px"><strong>description:</strong>&nbsp;&nbsp; {{$states->first()->work->description}} </p>

                                    </div>


                                </div>

                            </h3>
                            <img src="{{asset('assets/images/loading.gif')}}" class="none" id="state">
                        </div>

                    </div>
                </div>
            </article>
        @endif
    @endif
    @if($states->first()->diagnostic)

        <article class="timeline-item alt">
            <div class="timeline-caption">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <span class="arrow right"></span>
                        <span class="timeline-icon"><i class="fa fa-magic time-icon bg-success"></i></span>
                        <span class="timeline-date">

                    {{$states->first()->diagnostic->first()->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->first()->diagnostic->first()->created_at)->format('F Y')}}

                            <br>
                                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>

                            </span>

                    </span>
                        <h4 class="text-danger">Diagnostique</h4>



                        <div class="row">

                            <table class="table table-responsive">
                                <tbody>
                                <tr>

                                    <td>
                                        @if($states->first()->diagnostic->first()->type==1)

                                            <p><span style="font-size: 20px;">prestation</span>&nbsp;&nbsp; <span class="uppercase text-success" style="font-size: 14px">:<b>reparation</b> &nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>



                                        @elseif($states->first()->diagnostic->first()->type==3)


                                            <p><span style="font-size: 20px;">prestation</span><i class="i i-checked i-2x"></i> <span class="uppercase text-success" style="font-size: 14px">:<b>visite technique</b>&nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>

                                        @elseif($states->first()->diagnostic->first()->type==2)

                                            <p><span style="font-size: 20px;">prestation</span> <span class="uppercase text-success" style="font-size: 14px">:<b>revision</b>&nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>

                                        @endif


                                    </td>
                                </tr>
                                </tbody>
                            </table>


                            <table class="table table-responsive col-sm-12">
                                <thead>
                                <tr>
                                    <td style="width: 60%">
                                        <table width="100%" style="position: relative;left: 0;width: 90%;height: auto;border-width:1px;">
                                            <tr><th width="40%" class="text-left" style="font-size: 17px;font-family: 'Harlow Solid Italic'">Technicien</th></tr>
                                            @forelse($states->first()->diagnostic->first()->diagnostic_employee as $key=>$item)
                                                <tr class="capitalize" style="font-size: 16px">
                                                    <td class="text-left">{{$item->employee->username}}</td>

                                                </tr>
                                            @empty
                                                <tr style="font-size: 16px">
                                                    <td colspan="2" class="text-center">Aucun Technicien n'a été Selectionner</td>
                                                </tr>
                                            @endforelse
                                        </table>
                                    </td>
                                    <td style="width: 40%" >
                                        <table width="100%">
                                            <tr>
                                                <td width="60%" class="text-left" style="font-size: 19px;font-family: 'Harlow Solid Italic'">Piece</td>
                                                <td width="30%" class="text-right" style="font-size: 19px;font-family: 'Harlow Solid Italic'">Quantité</td>
                                            </tr>
                                            @foreach($states->first()->diagnostic->first()->demand as $key=> $piece)
                                                @forelse($piece->demand_piece as $demand_piec)
                                                    <tr class="capitalize">
                                                        <td class="text-left text-info" style="font-size: 19px;font-family: 'Harlow Solid Italic'">{{$demand_piec->piece}}</td>
                                                        <td class="text-right text-danger " style="font-size: 19px;font-family: 'Harlow Solid Italic'">{{$demand_piec->quantity}}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">Aucune Pièce n'a été Ajouter</td>
                                                    </tr>
                                                @endforelse

                                            @endforeach
                                        </table></td>

                                </tr>
                                </thead>
                            </table>
                        </div>

                        <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnosticload">
                    </div>
                </div>
            </div>
        </article>
    @endif

    @if($states->first()->diagnostic)
        <article class="timeline-item ">
            <div class="timeline-caption">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <span class="arrow right"></span>
                        <span class="timeline-icon"><i class="fa fa-magic time-icon bg-success"></i></span>
                        <span class="timeline-date">



                                                <br>
                                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>

                            </span>
                    </span>
                        <table class="table table-responsive">
                            <tbody>
                            <tr>



                                <td>

                                    @if($states->first()->diagnostic)
                                        @if($states->first()->diagnostic->first()->type==1)

                                            <p><span style="font-size: 20px;">prestation</span>&nbsp;&nbsp; <span style="font-size: 15px;font-family: 'Harlow Solid Italic'" class="uppercase text-success" >:<b>reparation</b> &nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>



                                        @elseif($states->first()->diagnostic->first()->type==3)


                                            <p><span style="font-size: 20px;">prestation</span><i class="i i-checked i-2x"></i> <span class="uppercase text-success" style="font-size: 15px;font-family: 'Harlow Solid Italic'">:<b>visite technique</b>&nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>

                                        @elseif($states->first()->diagnostic->first()->type==2)

                                            <p><span style="font-size: 20px;">prestation</span> <span class="uppercase text-success" style="font-size: 14px;font-family: 'Harlow Solid Italic'">:<b>revision</b>&nbsp;&nbsp;&nbsp;<i class="i i-checked i-2x"></i></span>
                                            </p>

                                        @endif
                                    @endif


                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <h5>

                            <table class="table table-responsive">
                                <header class="panel-heading text-right bg-light">
                                    <ul class="nav nav-tabs nav-justified  uppercase">
                                        <li class="dropdown  active ">
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



                                            </ul>
                                        </li>


                                    </ul>

                                </header>

                                @if($states->first()->diagnostic)

                                    @if($states->first()->diagnostic->first()->type==1)

                                        @if(count($states->first()->diagnostic->first()->repair) !=0)

                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade @if($states->first()->diagnostic->first()->repair->first()->state == 4) @else active in @endif" id="repair-description">
                                                    <div class="panel-group m-b" id="accordionDescription">
                                                        <?php $count = $states->first()->diagnostic->first()->repair->first()->diagnostic->service_description->count() ?>

                                                        @if($states->first()->diagnostic)
                                                            @foreach($states->first()->diagnostic->first()->repair->first()->diagnostic->service_description->sortByDesc('created_at') as $key=>$description)
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
                                                        @endif




                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="technicians">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <ul class="list-group alt">
                                                                @foreach($states->first()->diagnostic->first()->service_employee as $key=>$technician)
                                                                    <li class="list-group-item">
                                                                        <div class="media">
                        <span class="pull-left thumb-sm"><img src="{{asset('assets/images/a0.png')}}" alt="John said"
                                                              class="img-circle"></span>
                                                                            <div class="pull-right text-success m-t-sm">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <div><a href="#" class="capitalize">  {{$technician->employee->username}}</a>
                                                                                </div>
                                                                                <small class="text-muted">{{\Jenssegers\Date\Date::parse($technician->created_at)->diffForHumans()}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
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

                                                        @forelse($states->first()->diagnostic->first()->repair->first()->diagnostic->demand as $demand)
                                                            @if($states->first()->diagnostic->first()->repair->first()->diagnostic->demand )
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

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>



               @endif


                                    @elseif($states->first()->diagnostic->first()->type==2)

                                        @if(count($states->first()->diagnostic->first()->revision) !=0)


                                        <div class="panel-body">
                                            <div class="tab-content">


                                                <div class="tab-pane fade @if($states->first()->diagnostic->first()->revision->first()->state == 4) @else active in @endif" id="repair-description">
                                                    <div class="panel-group m-b" id="accordionDescription">


                                                        <?php $count = $states->first()->diagnostic->first()->revision->first()->diagnostic->service_description->count() ?>

                                                        @foreach($states->first()->diagnostic->first()->revision->first()->diagnostic->service_description->sortByDesc('created_at') as $key=>$description)
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

                                                <div class="tab-pane fade" id="technicians">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <ul class="list-group alt">

                                                                @foreach($states->first()->diagnostic->first()->service_employee as $key=>$technician)
                                                                    <li class="list-group-item">
                                                                        <div class="media">
                        <span class="pull-left thumb-sm"><img src="{{asset('assets/images/a0.png')}}" alt="John said"
                                                              class="img-circle"></span>
                                                                            <div class="pull-right text-success m-t-sm">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <div><a href="#" class="capitalize">  {{$technician->employee->username}}</a>
                                                                                </div>
                                                                                <small class="text-muted">{{\Jenssegers\Date\Date::parse($technician->created_at)->diffForHumans()}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
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

                                                        @forelse($states->first()->diagnostic->first()->revision->first()->diagnostic->demand as $demand)
                                                            @if($states->first()->diagnostic->first()->revision->first()->diagnostic->demand )
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

                                                        </tbody>
                                                    </table>
                                                </div>






                                            </div>
                                        </div>




                                        @endif




                                    @elseif($states->first()->diagnostic->first()->type==3)
                                        @if(count($states->first()->diagnostic->first()->visit_technique) !=0)

                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade @if($states->first()->diagnostic->first()->visit_technique->first()->state == 4) @else active in @endif" id="repair-description">
                                                    <div class="panel-group m-b" id="accordionDescription">
                                                        <?php $count = $states->first()->diagnostic->first()->visit_technique->first()->diagnostic->service_description->count() ?>

                                                        @foreach($states->first()->diagnostic->first()->visit_technique->first()->diagnostic->service_description->sortByDesc('created_at') as $key=>$description)
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

                                                <div class="tab-pane fade" id="technicians">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <ul class="list-group alt">

                                                                @foreach($states->first()->diagnostic->first()->service_employee as $key=>$technician)
                                                                    <li class="list-group-item">
                                                                        <div class="media">
                        <span class="pull-left thumb-sm"><img src="{{asset('assets/images/a0.png')}}" alt="John said"
                                                              class="img-circle"></span>
                                                                            <div class="pull-right text-success m-t-sm">
                                                                                <i class="fa fa-circle"></i>
                                                                            </div>
                                                                            <div class="media-body">
                                                                                <div><a href="#" class="capitalize">  {{$technician->employee->username}}</a>
                                                                                </div>
                                                                                <small class="text-muted">{{\Jenssegers\Date\Date::parse($technician->created_at)->diffForHumans()}}</small>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
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

                                                        @forelse($states->first()->diagnostic->first()->visit_technique->first()->diagnostic->demand as $demand)
                                                            @if($states->first()->diagnostic->first()->visit_technique->first()->diagnostic->demand )
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

                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>


                                        @endif
                                    @endif
                                @endif
                            </table>
                        </h5>

                        <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnostic">
                    </div>
                </div>
            </div>
        </article>
    @endif





    @if(count($states->first()->work) != 0)

        @if($states->first()->work->type==2)
            <article class="timeline-item alt">
                <div class="timeline-caption">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <span class="arrow right"></span>
                            <span class="timeline-icon"><i class="fa fa-eye time-icon bg-warning"></i></span>
                            <span class="timeline-date">
                    {{$states->first()->work->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->last()->work->created_at)->format('F Y')}}
                                <span class="text-muted m-l-sm pull-right">
                            <i class="fa fa-clock-o"></i>
                        </span>
                    </span>
                            <div class="text-sm"><h3>Essai apres travaux : </h3> </div>
                            <h1 class="text-info-dker">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p style="font-size: 18px" ><strong>Arrivé : &nbsp;</strong>{{$states->last()->work->arrive}} km/h</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p style="font-size: 18px"><strong>Distance: &nbsp;</strong>{{$states->last()->work->distance}} km/h</p>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <p style="font-size: 18px" ><strong>Lieu : &nbsp;</strong>{{$states->last()->work->place}}</p>
                                    </div>
                                </div>



                            </h1>
                            <h3 class="text-danger-dker">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p style="font-size: 15px"><strong>description:</strong>&nbsp;&nbsp; {{$states->first()->work->description}} </p>

                                    </div>


                                </div>

                            </h3>
                            <img src="{{asset('assets/images/loading.gif')}}" class="none" id="state">
                        </div>

                    </div>
                </div>
            </article>
        @endif
    @endif


    @if($states->first()->diagnostic)

        @if(count($states->first()->diagnostic->first()->approval) !=0)

            <article class="timeline-item">
                <div class="timeline-caption">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <span class="arrow left"></span>
                            <span class="timeline-icon"><i class="fa fa-eye time-icon bg-primary"></i></span>





                            <div class="text-sm"><h3>Authentification de sortie  :   {{$states->first()->diagnostic->first()->approval->last()->created_at->format('d')}}  {{\Jenssegers\Date\Date::parse($states->first()->diagnostic->first()->approval->last()->created_at)->format('F Y')}}
                                </h3> </div>


                            <h1 class="text-info-dker">

                                <p style="font-size: 18px"><strong>Remarque: &nbsp;</strong>

                                    @if(isset($states->first()->diagnostic->first()->approval->last()->remark) and !empty($states->first()->diagnostic->first()->approval->last()->remark))

                                        {{$states->first()->diagnostic->first()->approval->last()->remark}}

                                    @else
                                        R.A.S

                                    @endif

                                </p>




                            </h1>

                            <img src="{{asset('assets/images/loading.gif')}}" class="none" id="state">
                        </div>
                    </div>
                </div>
            </article>


        @endif
    @endif

</div>

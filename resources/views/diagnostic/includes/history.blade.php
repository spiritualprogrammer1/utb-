
<span class="uppercase text-center center-block"> Historique des dernieres operations du vehicule</span>
<div class="timeline">
    <article class="timeline-item">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow left"></span>
                    <span class="timeline-icon"><i class="fa fa-eye time-icon bg-primary"></i></span>
                    <span class="timeline-date">
                        {{$bus->state->last()->created_at->format('d/m/Y')}}<br>
                        <span class="text-muted m-l-sm pull-right">
                            <i class="fa fa-clock-o"></i>
                            {{$bus->state->last()->created_at}}
                        </span>
                    </span>
                    <div class="text-sm">Etat du vehicule</div>
                    <h5 class="text-info-dker">
                        <a href="#" id="{{$bus->state->last()->id}}" type="state"
                           class="filepdf">{{strtoupper($bus->state->last()->reference)}}</a>
                    </h5>
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

                            <?php $tab=[];  $i=0;?>

                        @foreach($bus->state as $state)
                            <?php
                            if($state->diagnostic !=null)
                            {
                                $tab[$i]=$state->diagnostic;
                                $i++;
                            }
                            ?>
                        @endforeach


                        @if(count($tab)!=0)

                            @if($tab[$i-1]!=null)

                                    {{--{{$tab[$i-1]->created_at->format('d/m/Y')}}--}}
                                    @if(count($tab[$i-1]) !=0)
                                {{$tab[$i-1][0]->created_at->format('d/m/Y')}}
                                        @endif
                                <br>
                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>
                                    @if(count($tab[$i-1]) !=0)
                                    {{$tab[$i-1][0]->created_at->format('d/m/Y  H:m')}}
                                    @endif
                            </span>
                            @else
                                NEANT
                            @endif
                        @endif

                    </span>
                    <div class="text-sm">Diagnostique</div>
                    <h5>

                        @if(count($tab)!=0)


                            @if(count($tab[$i-1])!=0)
                                <a href="#" type="diagnostic" class="filediagnostic"
                                   id="{{$tab[$i-1][0]->id}}">{{strtoupper($tab[$i-1][0]->statee->reference)}}</a>
                            @else
                                <small>Aucun diagnostique effectué</small>
                            @endif
                        @endif
                    </h5>
                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnosticload">
                </div>

            </div>
        </div>
    </article>
    <article class="timeline-item">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow right"></span>
                    <span class="timeline-icon"><i class="fa fa-magic time-icon bg-success"></i></span>
                    <span class="timeline-date">

   <?php $tabs = []; $x=0; $tabrepair=[]; ?>

                        @foreach($bus->state as $state)

                            <?php  $tabs[$x]=$state->diagnostic; $x++;  ?>
                        @endforeach

                        <?php
                        $repairtab=[];
                        $taa=[];
                        ?>

                        @for($b=0;$b<$x;$b++)


                            @if(!empty($tabs[$b][0]['id']))
                                <?php

                                $repairtab[$b]= App\Repair::where('diagnostic_id',$tabs[$b][0]['id'])->OrderBy('id','desc')->get() ;
                                $taa[$b]=$tabs[$b][0]['id'];
                                ?>
                            @endif


                        @endfor



                        @if(isset($repairtab[$x-1][0]))

                            @if(isset($repairtab[$x-1][0]) && !empty($repairtab[$x-1][0]))
                                {{$repairtab[$x-1][0]->created_at->format('d/m/Y')}}
                                <br>
                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>
                                    {{$repairtab[$x-1][0]->created_at->format('H:m:s')}}
                            </span>
                            @endif
                        @else
                            NEANT
                        @endif

                        {{--@if($tab[$i-1]!=null)--}}
                        {{--@if(count($tab[$i-1]->repair)!=0)--}}
                        {{--{{$tab[$i-1]->repair[0]->created_at->format('d/m/Y')}}--}}
                        {{--<br>--}}
                        {{--<span class="text-muted m-l-sm pull-left">--}}
                        {{--<i class="fa fa-clock-o"></i>--}}
                        {{--{{$tab[$i-1]->repair[0]->created_at->format('H:m:s')}}--}}
                        {{--</span>--}}
                        {{--@endif--}}
                        {{--@else--}}
                        {{--NEANT--}}
                        {{--@endif--}}

                    </span>
                    <div class="text-sm">Reparation</div>
                    {{--<h5>--}}
                    {{--@if($tab[$i-1]!=null)--}}
                    {{--@if(count($tab[$i-1]->repair)!=0)--}}
                    {{--<a href="#" type="repaire" class="file"--}}
                    {{--id="{{$tab[$i-1]->repair[0]->id}}">{{strtoupper($tab[$i-1]->id)}}</a>--}}
                    {{--@else--}}
                    {{--<small class="text-info">Aucune Reparation n'a été effectuée</small>--}}
                    {{--@endif--}}


                    {{--@endif--}}
                    {{--</h5>--}}
                    <h5>
                        @if(isset($repairtab[$x-1][0]))
                            @if(isset($repairtab[$x-1][0]) && !empty($repairtab[$x-1][0]))

                                <a href="#" type="repaire" class="file"
                                   id="{{$repairtab[$x-1][0]->id}}">{{strtoupper($repairtab[$x-1][0]->diagnostic->statee->reference)}}</a>
                            @else
                                <small class="text-info">Aucune Reparation n'a été effectuée</small>
                            @endif


                        @endif
                    </h5>
                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnostic">
                </div>

            </div>
        </div>
    </article>
    <article class="timeline-item alt">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow right"></span>
                    <span class="timeline-icon"><i class="fa fa-cog time-icon bg-info"></i></span>
                    <span class="timeline-date">

                        <?php $tabs = []; $x=0;?>

                        @foreach($bus->state as $state)

                            <?php  $tabs[$x]=$state->diagnostic; $x++;  ?>
                        @endforeach

                        <?php
                        $revisiontab=[]; $k=0;
                        $tabrev=[];
                        ?>
                        @for($b=0;$b<$x;$b++)
                            @if(!empty($tabs[$b]->first()->id))
                            <?php


                            $revisiontab[$b]= App\Revision::where('diagnostic_id',$tabs[$b]->first()->id)->OrderBy('id','desc')->get();

                            ?>
                                @endif
                        @endfor

                            {{--mise en commentaire--}}


                        @for($b=0;$b<$x;$b++)
                            @if(isset($revisiontab[$b][0]) && !empty($revisiontab[$b][0]))
                                <?php $k++;  $tabrev[$k]= $revisiontab[$b][0] ; ?>
                            @endif
                        @endfor

                        @if(isset($tabrev[$k-1]))
                            @if(!empty($tabrev[$k-1]))
                                {{$tabrev[$k-1]->created_at->format('d/m/Y')}}
                                <br>
                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>
                                    {{$tabrev[$k-1]->created_at->format('d/m/Y')}}
                            </span>
                            @endif
                        @else
                            NEANT
                        @endif
                    </span>

                    <div class="text-sm">Revision</div>
                    <h5>
                        @if(isset($tabrev[$k-1]))
                            @if(!empty($tabrev[$k-1]))
                                <a href="#" type="revision" class="file"
                                   id="{{$tabrev[$k-1]->id}}">{{strtoupper($tabrev[$k-1]->diagnostic->statee->reference)}}</a>

                            @else
                                <small>Aucune Revision n'a été effectuée</small>
                            @endif

                        @endif
                    </h5>


                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnostic">
                </div>
            </div>
        </div>
    </article>
    <article class="timeline-item ">
        <div class="timeline-caption">
            <div class="panel panel-default">
                <div class="panel-body">
                    <span class="arrow right"></span>
                    <span class="timeline-icon"><i class="fa fa-magic time-icon bg-success"></i></span>
                    <span class="timeline-date">

                         <?php $tabs = []; $x=0;?>

                        @foreach($bus->state as $state)

                            <?php  $tabs[$x]=$state->diagnostic; $x++;  ?>
                        @endforeach

                        <?php
                        $visittab=[]; $k=0;
                        $tabvisit=[];
                        ?>
                        @for($b=0;$b<=$x;$b++)
                                 @if(!empty($tabs[$b][0]['id']))
                            <?php




                            $visittab[$b]= App\Visit_technique::where('diagnostic_id',$tabs[$b][0]['id'])->get();

                            ?>
                                 @endif
                        @endfor


                        <?php  ?>

                        @for($b=0;$b<$x;$b++)
                            @if(isset($visittab[$b][0]) && !empty($visittab[$b][0]))
                                <?php $k++;  $tabvisit[$k]= $visittab[$b][0] ; ?>
                            @endif
                        @endfor
                        @if(isset($tabvisit[1]))
                            @if(!empty($tabvisit[1]))
                                {{$tabvisit[1]->created_at->format('d/m/Y')}}
                                <br>
                                <span class="text-muted m-l-sm pull-left">
                                <i class="fa fa-clock-o"></i>
                                    {{$tabvisit[1]->created_at->format('d/m/Y')}}
                            </span>
                            @endif
                        @else
                            NEANT
                        @endif
                    </span>
                    <div class="text-sm">Visite </div>
                    <h5>
                        @if(isset($tabvisit[1]))
                            @if(!empty($tabvisit[1]))
                                <a href="#" type="visit" class="file"
                                   id="{{$tabvisit[1]->id}}">{{strtoupper($tabvisit[1]->diagnostic->statee->reference)}}</a>

                            @else
                                <small class="text-info">Aucune Visite n'a été effectuée</small>
                            @endif

                        @endif
                    </h5>

                    <img src="{{asset('assets/images/loading.gif')}}" class="none" id="diagnostic">
                </div>
            </div>
        </div>
    </article>
</div>

<div class="modal fade" id="otModal">
    <div class="modal-dialog modal-lg">
        <form id="validateForm" class="modal-content">
            {{csrf_field()}}
            <input name="reference" id="ot_reference" type="hidden">
            <div class="modal-header">
                <section class="panel panel-info m-b-n-sm">
                    <div class="panel-body">
                        <a href="#" class="thumb-md pull-right m-l m-t-xs">
                            <img src="{{asset('assets/images/car_wrench.png')}}"> <i
                                    class="on md b-white bottom"></i>
                        </a>
                        <div class="clear font-bold"><a href="#" class="text-primary-dk uppercase"><i class="fa fa-info" aria-hidden="true"></i><span
                                        id="matriculation"></span></a>
                            <small class="block  uppercase text-danger-dker" id="ot"></small>
                            <a href="#" class="btn btn-xs btn-success m-t-xs capitalize" id="car"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </div>
                        <h4 style="" class="text-center m-t-n-xl font-thin m-l-lg text-dark-dker text-danger">
                            <span class="font-bold text-danger" id="historyda">HISTORIQUE</span></h4>
                    </div>
                </section>
            </div>
            <div class="modal-body m-b-n-lg">
                <section class="panel panel-info" id="otcontent">
                </section>
            </div>

        </form><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="stateModal">
    <div class="modal-dialog modal-lfg" style="width: 700px;">
        <div class="modal-content" id="file_contentpdf">
        </div>
    </div><!-- /.modal-dialog -->
</div>

<script>
    var $file = $('.file'),
        $pdf=$('.filepdf');
    var $otModal=$('#otModal'),
        $otcontent=$('#otcontent'),
        $filediagnostic=$('.filediagnostic');
    var $stateModal=$('#stateModal'),
        $diagnosticload=$('#diagnosticload'),
        $file_contentpdf=$('#file_contentpdf');
    $historyda=$('#historyda');
    $(document).ready(function () {
        $file.on('click', function () {
            var id = $(this).attr('id');
            var type = $(this).attr('type');

            $('#'+type).show();
            $.get('historiqueot/' + id, {type: type}, function (data) {
                $otcontent.html(data);
                $otModal.modal('show')
                $('#'+type).hide();
            })
        });
    });
    $pdf.on('click', function () {
        $diagnosticload.removeClass('none');
        var id = $(this).attr('id');
        $.ajax({
            url: '{{url('state/filestate')}}/'+id,
            type: 'get',
            data: id,
            success: function (data) {
                $file_contentpdf.html(data);
                $stateModal.modal('show');
                $diagnosticload.addClass('none');


            },
        });


    });
    $filediagnostic.on('click', function () {
        $diagnosticload.removeClass('none');
        var id = $(this).attr('id');
        $.get('filesdiagnostique/' + id, function (data) {
            $file_contentpdf.html(data);
            $stateModal.modal('show');
            $file_load.hide();
            $diagnosticload.addClass('none');
        })


    });

</script>
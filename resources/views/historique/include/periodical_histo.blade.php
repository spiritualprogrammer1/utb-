@foreach($diags as $states)
    <div class="panel panel-default">
        <div class="panel-heading">
            <a class="accordion-toggle uppercase" data-toggle="collapse" data-parent="#accordion2" href="#pieces"><i class="fa fa-folder"></i> {{$states->reference}}</a>
            <ul class="nav nav-pills pull-right">
                <li><a href="#" class="panel-toggle text-muted active"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a></li>
            </ul>
        </div>
        <i class="hidden"><?php  $diagnn=$states->diagnostic ;

            $diagnostic= App\Diagnostic::where('state_id',$states->id)->get();
            ?> </i>
        <div id="pieces" class="panel-collapse collapse in" style="">
            <div class="panel-body row collapse">
                <section class="panel panel-info">

                    <header class="panel-heading font-bold">
                        @if(isset($diagnostic[0]) && !empty($diagnostic[0]))
                            @if($diagnostic[0]->type=='1')
                                <h3 class="panel-title uppercase">REPARATION</h3>
                            @elseif($diagnostic[0]->type=='2')
                                <h3 class="panel-title uppercase">REVISION</h3>
                            @else
                                <h3 class="panel-title uppercase">VISITE TECHNIQUE</h3>

                            @endif
                        @endif
                    </header>

                    @if(isset($diagnostic[0]) && !empty($diagnostic[0]))
                        <div class="panel-body  panel hbox stretch none" id="detect" style="display: block;">
                            <div class="col-md-7">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Intervenant</th>
                                    </thead>
                                    <tbody style="font-size: 15px;">

                                    @foreach($diagnostic[0]->diagnostic_employee as $compt=>$diog)
                                        <tr>
                                            <td style="width: 50%;">
                                                <b> <i class="fa fa-user"></i> &nbsp;{{$diog->employee->first_name}} {{$diog->employee->last_name}}<br/></b>
                                                <span style="border: 1px dotted grey;border-radius: 5px;background-color: lightgrey;max-width: 99%">
                                                                                   &nbsp; {{$diog->title}} &nbsp;
                                                                               </span>

                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Résources Utilisées</th>
                                    </thead>
                                    <tbody style="font-size: 15px;">
                                    @foreach($diagnostic[0]->demand as $demande)
                                        @foreach($demande->demand_piece as $demande_piece)
                                            <tr>
                                                <td  style="width: 50%;">
                                                    @if(isset($demande_piece->piece) && !empty($demande_piece->piece))
                                                        <span>
                                                                                       <i class="fa fa-share"></i>
                                                            {{$demande_piece->piece}} (<b class="text-success">{{$demande_piece->delivered}}</b>)
                                                                                   </span><br/>
                                                    @else
                                                        <span>
                                                                                       <i class="fa fa-share"></i>
                                                                                 <b class="text-success alert-info"> Aucune pièce utilisée!</b>
                                                                                   </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    </tbody>
                                    </tr>
                                </table>
                            </div>

                        </div>

                    @endif

                </section>

            </div>
        </div>
    </div>
@endforeach

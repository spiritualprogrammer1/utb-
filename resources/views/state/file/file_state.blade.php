<style>
    body {
        color: #002D57;
    }
    .divider{
        height: 10px;
    }
</style>

<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche" style="cursor: auto">
    <div class="container-fluid ficheRepportOnes">
        <table class="table table-responsive">
            <tr class="row" style="width: 100%">
                <td class="text-center col-sm-4 pull-left">
                    <img src="{{asset('assets/uploads/logo/UTB.jpg')}}"
                         class="img-responsive center-block" width="80%">
                    <p style="font-size: 14px; font-weight: 600; font-family: 'Times New Roman'">
                        Union
                        des
                        Transports de Bouaké<br>
                        <span style="font-size: 12px; font-weight: 100">01 BP 4313 Abidjan 01</span><br>
                        <span style="font-size: 12px; font-weight: 100">Tél. / Fax :(225) 21 28 33 26</span>
                    </p>
                </td>
                <td class="text-center col-sm-8 pull-right" style="font-family: 'Times New Roman'">
                    <h2 style="padding-top: 18px"> FICHE DE <br>RECEPTION</h2>
                </td>
            </tr>
        </table>
        <table class="table table-responsive" >
            <tr>
                <td>ORDRE DE TRAVAIL : <b class="uppercase">{{$states->reference}}</b></td>
            </tr>
        </table>

        <div class="row">
            <div class="divider"></div>
            <div class="col-sm-12" style="">
                <table class="table table-responsive table-stripped table-collapse" style="width: 100%">
                    <tbody>
                    <td style="width: 50%">
                        <table style="position: relative;left: 0;width: 90%;height: auto;border-width:1px;">
                            <tr style="width: 100%">
                                <td style="width: 40%;padding-left: 5px;" class="text-right">Date</td>
                                <td style="width: 60%">  {{$states->created_at->format('d-m-Y')}}  </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;padding-left: 5px;" class="text-right">V.I.N</td>
                                <td style="width: 60%">
                                    @if(count($states->bus->visit) !=0)
                                    {{$states->bus->visit->first()->date}}

                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 40%;padding-left: 5px;" class="text-right">Date SICTA</td>
                                <td style="width: 60%">
                                    @if(count($states->bus->assurance) !=0)
                                    {{$states->bus->assurance->first()->date}}
                                    @endif

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%">
                        <table style="position: relative;left: 0;width: 100%;height: auto;border-width:1px;">
                            <tr>
                                <td style="width: 40%">Immatriculation</td>
                                <td style="width: 60%">{{strtoupper($states->bus->matriculation)}}</td>
                            </tr>
                            <tr style="width: 100%">
                                <td style="width: 40%">Marque</td>
                                <td style="width: 60%"> {{strtoupper($marque)}}  </td>
                            </tr>
                            <tr>
                                <td>Modele</td>
                                <td> {{strtoupper($model)}}  </td>
                            </tr>
                            <tr>
                                <td>P.M.C</td>
                                <td>{{strtoupper($states->bus->first_circulation)}}</td>
                            </tr>
                            <tr>
                                <td>Kilometrage</td>
                                <td> {{number_format($states->kilometer)}} km </td>
                            </tr>
                            <tr>
                                <td>Kilomet/ Moteur</td>
                                <td> {{number_format($states->kilometer_engine)}} km </td>
                            </tr>
                        </table>

                    </td>
                    </tbody>
                </table>
            </div>

            <div class="divider" style="height: 10px"></div>
            <div style="position: relative;left: 0;width: 100%;height: auto">
                <table style="width: 100%;border-width:1px;font-size: 14px">
                    <tr >
                        <td style="width: 20%;"></td>
                        <td style="width: 5%;text-align: center;border:1px solid ;">O</td>
                        <td style="width: 5%;text-align: center;border:1px solid ;">N</td>
                        <td style="width: 5%;"></td>
                        <td colspan="2" style="width: 65%;text-align: center;border:1px solid black">REMARQUES EVENTUELLES</td>
                    </tr>
                    <tr style="border-width:1px;">
                        <td style="border:1px solid black;padding-left: 5px;">   &nbsp; &nbsp;  Allume cigare</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tdw=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==1)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tdw=$piece->idd ?>
                                @endif
                            @endforeach

                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tdw)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                        <td rowspan="8" style=""></td>
                        <td colspan="2" rowspan="8" style="border:1px solid transparent;">{{$states->remark}}</td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp; &nbsp; Rk7</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tde=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==2)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tde=$piece->idd ?>
                                @endif
                            @endforeach

                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tde) ==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp; &nbsp; RCD</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tdz=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==20)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tdz=$piece->idd ?>
                                @endif
                            @endforeach
                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tdz) ==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;  Essuie Glace AV</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tds=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==4)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tds=$piece->idd ?>
                                @endif
                            @endforeach


                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tds) ==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Essuie Glace AR</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tab=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==3)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tab=$piece->idd;?>
                                @endif
                            @endforeach


                        </td>

                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tab) ==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td id="td1" style="border:1px solid black;padding-left: 5px;">&nbsp; &nbsp;&nbsp;&nbsp;Retro ext</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $ta=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==5)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $ta=$piece->idd ?>
                                @endif
                            @endforeach

                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($ta)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td id="td1" style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Retro int</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tb=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==21)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tb=$piece->idd ?>
                                @endif
                            @endforeach
                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tb)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Cric </td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tx=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==6)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tx=$piece->idd ?>
                                @endif
                            @endforeach


                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tx)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Manivellle</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $td=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==22)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $td=$piece->idd ?>
                                @endif
                            @endforeach
                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($td)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Roue secours</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $tq=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==7)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $tq=$piece->idd ?>
                                @endif
                            @endforeach

                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($tq)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Trousse</td>
                        <td style="text-align: center;border:1px solid black;">
                            <?php $ta=[] ?>
                            @foreach($opera as $piece)
                                @if($piece->idd==8)
                                        <i class="fa fa-check fa-1x"></i>
                                    <?php $ta=$piece->idd ?>
                                @endif
                            @endforeach

                        </td>
                        <td style="text-align: center;border:1px solid black;">
                            @if(count($ta)==0)
                                <i class="fa fa-check fa-1x"></i>
                            @endif
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Enjoliveurs</td>
                        <td style="text-align: center;border:1px solid black;">
                            @foreach($opera as $piece)
                                @if($piece->idd==9)
                                    <i class="fa fa-check fa-1x"></i>
                                @endif
                            @endforeach
                        </td>
                        <td style="text-align: center;border:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;AVG</td>
                        <td style="border:1px solid black;text-align: center;">
                            @foreach($opera as $piece)
                                @if($piece->idd==10)
                                    <i class="fa fa-check fa-1x"></i>
                                @endif
                            @endforeach
                        </td>
                        <td style="border: 1px solid black;width: 30%">
                            <table style="width: 100%;border:1px solid black;height: 100%;">
                                <tr style="border:1px solid black;">
                                    <td style="border:1px solid black;width: 20%;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;AVD</td>
                                    <td style="border:1px solid black;width: 20%;text-align: center">
                                        @foreach($opera as $piece)
                                            @if($piece->idd==11)
                                                <i class="fa fa-check fa-1x"></i>
                                            @endif
                                        @endforeach

                                    </td>
                                    <td style="border:1px solid black;width: 20%;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;ARG</td>
                                    <td style="border:1px solid black;width: 20%;text-align: center">
                                        @foreach($opera as $piece)
                                            @if($piece->idd==12)
                                                <i class="fa fa-check fa-1x"></i>
                                            @endif
                                        @endforeach

                                    </td>
                                    <td style="border:1px solid black;width: 20%;text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;ARD</td>

                                </tr>
                            </table>
                        </td>
                        <td style="border: 1px solid white;"></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="border:1px solid transparent;">
                            <div style="height: 8px"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="">
                            <div style="position: relative;height: 100%;width: 100%;border:1px solid black;padding-left: 5px;">&nbsp;&nbsp;&nbsp;&nbsp;Niveau carburant</div>
                        </td>
                        <td style=""></td>
                        <td style="text-align: center;">
                            <div style="position: relative;height: 100%;width: 100%;border:1px solid black;">0</div>
                        </td>

                        <td style="">
                            <div style="position: relative;height: 100%;width: 100%;border:1px solid black;">
                                @foreach($states->field_state as $key=>$fuels)
                                    @if($fuels->field_id==14)
                                        <i class="fa fa-check fa-1x"></i>
                                    @else
                                        &nbsp;
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td colspan="2" style="">
                            <table style="width: 70%;border:1px solid black;">

                                <tr style="border:1px solid black;">
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">1/4</td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">
                                        @foreach($states->field_state as $key=>$fuels)
                                            @if($fuels->field_id==15)
                                                <i class="fa fa-check fa-1x"></i>
                                            @else
                                            @endif
                                        @endforeach

                                    </td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">1/2</td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">
                                        @foreach($states->field_state as $key=>$fuels)
                                            @if($fuels->field_id==16)
                                                <i class="fa fa-check fa-1x"></i>
                                            @else
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">3/4</td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">
                                        @foreach($states->field_state as $key=>$fuels)
                                            @if($fuels->field_id==17)
                                                <i class="fa fa-check fa-1x"></i>
                                            @else
                                            @endif
                                        @endforeach

                                    </td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">1</td>
                                    <td style="border:1px solid black;width: 12.33%;text-align: center">
                                        @foreach($states->field_state as $key=>$fuels)
                                            @if($fuels->fuel_id==18)
                                                <i class="fa fa-check fa-1x"></i>
                                            @endif
                                        @endforeach

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="divider" style="height: 10px"></div>
            <div style="position: relative;left: 0;width: 100%;height: auto">
                <table style="width: 100%;">
                    <tr>
                        <td style="text-align: center;border:1px solid black;">DESCRIPTION DE L'INCIDENT</td>
                    </tr>
                    <tr>
                        <td>
                            <div style="position: relative;top: 0;left: 0;width: 100%;height: 150px;">
                                {{$states->incident}}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</section>

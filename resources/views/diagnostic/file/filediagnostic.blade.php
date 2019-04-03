<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche">
    <div class="container-fluid ficheRepportOnes">
        <table class="table table-responsive">
            <tr class="row">
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
                    <h2 style="padding-top: 18px"> FICHE DE <br>DIAGNOSTIQUE</h2>
                    <hr>
                </td>
            </tr>
        </table>
        <table class="table table-responsive">
            <tr>
                <td>ORDRE DE TRAVAIL : <b class="uppercase">{{$diagnostic->statee->reference}}</b></td>
            </tr>
        </table>

        <div class="row">
            <div class="divider"></div>
            <div class="col-sm-12" style="">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Date / Heure</th>
                        <th>Immatriculation</th>
                        <th>N° Chassis</th>
                        <th>Vehicule</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$diagnostic->created_at->format('d/m/Y H:i:s')}}</td>
                        <td class="uppercase">{{$bus->matriculation}}</td>
                        <td>{{$bus->chassis}}</td>
                        <td class="capitalize">{{$bus->model->brand->name}} {{$bus->model->name}}</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2" class="uppercase text-center">prochainne</th>
                        <th colspan="2" class="uppercase text-center">Kilometrage</th>
                    </tr>
                    <tr>
                        <th class="text-center">Revision</th>
                        <th class="text-center">Visite</th>
                        <th class="text-center">Vehicule</th>
                        <th class="text-center">Moteur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center">
                            {{number_format($diagnostic->statee->kilometer)}} km/h
                        </td>
                        <td class="text-center">{{number_format($diagnostic->statee->kilometer_engine)}} km/h</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-responsive">
                    <tbody>
                    <tr>
                        <td class="uppercase text-right" rowspan="3" style="font-size: 20px;">prestation</td>
                        <td>
                            @if($diagnostic->type==1)

                                <p><i class="i i-checked i-2x"></i> <span class="uppercase" style="font-size: 14px"><b>reparation</b></span>
                                </p>
                                <p><i class="i i-check i-1x"></i> Revision</p>
                                <p><i class="i i-check i-1x"></i> Visite technique</p>

                           @elseif($diagnostic->type==3)


                                <p><i class="i i-checked i-2x"></i> <span class="uppercase" style="font-size: 14px"><b>visite technique</b></span>
                                </p>
                                <p><i class="i i-check i-1x"></i> Revision</p>
                                <p><i class="i i-check i-1x"></i>Reparation</p>
                            @elseif($diagnostic->type==2)

                                <p><i class="i i-checked i-2x"></i> <span class="uppercase" style="font-size: 14px"><b>revision</b></span>
                                </p>
                                <p><i class="i i-check i-1x"></i> Reparation</p>
                                <p><i class="i i-check i-1x"></i> Visite technique</p>


                            @endif


                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="col-sm-12">
                    <table class="table table-responsive col-sm-12">
                        <thead>
                        <tr>
                           <td style="width: 60%">
                               <table width="100%" style="position: relative;left: 0;width: 90%;height: auto;border-width:1px;">
                                   <tr><th width="40%" class="text-left">Technicien</th></tr>
                                   @forelse($diagnostic->diagnostic_employee as $key=>$item)
                                       <tr class="capitalize">
                                           <td class="text-left">{{$item->employee->username}}</td>

                                       </tr>
                                   @empty
                                       <tr>
                                           <td colspan="2" class="text-center">Aucun Technicien n'a été Selectionner</td>
                                       </tr>
                                   @endforelse
                               </table>
                           </td>
                            <td style="width: 40%">
                                <table width="100%">
                                    <tr>
                                        <td width="60%" class="text-left">Piece</td>
                                        <td width="30%" class="text-right">Quantité</td>
                                    </tr>
                                    @foreach($diagnostic->demand as $key=> $piece)
                                        @forelse($piece->demand_piece as $demand_piec)
                                            <tr class="capitalize">
                                                <td class="text-left">{{$demand_piec->piece}}</td>
                                                <td class="text-right ">{{$demand_piec->quantity}}</td>
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


            </div>
        </div>
    </div>
</section>

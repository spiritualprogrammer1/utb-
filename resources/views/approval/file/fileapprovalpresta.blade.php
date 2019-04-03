<style>
    body {
        color: #002D57;
    }
</style>
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
                    <h2 style="padding-top: 18px"> BON DE SORTIE <br>
                        @if($releases->diagnostic->type==1)
                            REPARATION
                        @elseif($releases->diagnostic->type==2)
                            REVISION
                        @elseif($releases->diagnostic->type==3)
                            VISITE TECHNIQUE

                        @endif
                    </h2>
                    <hr>
                </td>
            </tr>
        </table>
        <table class="table table-responsive">
            <tr>
                <td>ORDRE DE TRAVAIL : <b
                            class="uppercase">{{$releases->diagnostic->statee->reference}}</b></td>
            </tr>
        </table>

        <div class="row">
            <div class="divider"></div>
            <div class="col-sm-6" style="">
                <table class="table table-responsive table-stripped table-collapse">
                    <tr>
                        <td>Date d'arrivé</td>
                        <td> {{$releases->diagnostic->statee->created_at}}</td>
                    </tr>
                    <tr>
                        <td>Type de prestation</td>
                        <td>
                            @if($releases->diagnostic->type==1)
                                <i class="i i-checked"></i> REPARATION
                            @elseif($releases->diagnostic->type==2)
                                <i class="i i-checked"></i> REVISION
                            @else
                                <i class="i i-checked"></i>  VISITE TECHNIQUE
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Date de sortie</td>
                        <td>{{$releases->created_at}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6" style="">
                <table class="table table-responsive table-stripped">
                    <tr>
                        <td>Immatriculation</td>
                        <td>{{strtoupper($releases->diagnostic->statee->bus->matriculation)}}</td>
                    </tr>
                    <tr>
                        <td>Marque</td>
                        <td>{{strtoupper($releases->diagnostic->statee->bus->model->brand->name)}}</td>
                    </tr>
                    <tr>
                        <td>Modele</td>
                        <td>{{strtoupper($releases->diagnostic->statee->bus->model->name)}}</td>
                    </tr>
                    <tr>
                        <?php $i=0; ?>
                        @foreach($releases->diagnostic->work as $work)
                            @if($work->type==2 )
                                <?php $distance=$work->arrive?>
                                @endif
                            @endforeach

                        <td>Kilom&eacute;trage</td>
                        <td>{{$distance}}</td>
                    </tr>
                    <tr>
                        <td>Date  visite</td>
                        <td>

                            @if( count($releases->diagnostic->statee->bus->visit) !=0)
                            {{$releases->diagnostic->statee->bus->visit[0]->date}}

                                @endif

                        </td>
                    </tr>
                    <tr>
                        <td>Date assurance</td>
                        <td>
                            @if( count($releases->diagnostic->statee->bus->assurance) !=0)
                            {{$releases->diagnostic->statee->bus->assurance[0]->date}}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="divider"></div>
            <br/><br/>
            <table class="table table-responsive table-stripped" style="height: 150px">
                <thead><tr><th class="text-center">COMMENTAIRE</th></tr></thead>
                <tbody>
                <tr>
                    <td>
                        {{$releases->remark}}
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="divider"></div>
            <div class="col-sm-12" style="height: 200px">
                <span><u><b>SIGNATURE DU CHEF DE SECTION</b></u></span>
            </div>
        </div>
</section>


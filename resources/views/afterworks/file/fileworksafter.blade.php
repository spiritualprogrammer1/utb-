<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche">
    <div class="container-fluid">
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
                    <h2 style="padding-top: 18px"> FICHE D'ESSAI <br>APRES TRAVAUX</h2>
                    <hr>
                </td>
            </tr>
        </table>

        <table class="table table-responsive">
            <tr>
                <td>ORDRE DE TRAVAIL : <b class="uppercase">{{$before_test[0]->diagnostic->statee->reference}}</b></td>
            </tr>
        </table>


        <div class="row">
            <div class="divider"></div>
            <div class="col-sm-12" style="">
                <table class="table table-responsive table-bordered">
                    <tbody>
                    <tr>
                        <td>DATE</td>
                        <td style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{$before_test[0]->created_at->format('d/m/Y')}}</td>
                        <td>MARQUE</td>
                        <td class="capitalize" style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{$before_test[0]->diagnostic->statee->bus->model->brand->name}}</td>
                    </tr>
                    <tr>
                        <td>IMMATRICULATION</td>
                        <td class="uppercase" style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{$before_test[0]->diagnostic->statee->bus->matriculation}}</td>
                        <td>MODELE</td>
                        <td class="capitalize" style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{$before_test[0]->diagnostic->statee->bus->model->name}}</td>
                    </tr>
                    <tr>
                        <td>KILOMETRAGE<br>Vehicule</td><td style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{number_format($before_test[0]->arrive)}}<br>km/h</td>
                        <td>KILOMETRAGE<br>Moteur</td><td style="font-family: 'Times New Roman'; font-size: 15px; font-weight: 600">{{number_format($before_test[0]->diagnostic->statee->kilometer_engine)}}<br> km/h</td>
                    </tr>
                    </tbody>
                </table>
                <div class="col-sm-12 text-center uppercase" style="font-size: 18px"><u><b>Remarques :</b></u></div>
                <div class="divider"></div>
                <table class="table">
                    <div class="col-sm-12 form-control">
                        {{$before_test[0]->description}}
                    </div>
                </table>
            </div>
        </div>
</section>

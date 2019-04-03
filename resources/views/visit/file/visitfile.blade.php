
<a href="#" class="btn btn-sm btn-icon btn-info" onclick="$('.fiche').printThis({ });"
   style="position: absolute; right: 10px; z-index: 1151"><i
            class="fa fa-print fa-2x"></i></a>
<section class="panel m-l-n-md  m-r-n-md m-b-none fiche">
    <div class="container-fluid" style="margin-top: 15px">
        <table class="table table-responsive table-bordered" style="border: 2px solid; border-collapse:collapse;">
            <tr style="border-bottom: 2pt solid;">
                <td class="text-center uppercase"> N° OT <br>
                    {{$visit->diagnostic->statee->reference}}
                </td>
                <td class="text-center" colspan="2" style="border-left: 2pt solid;border-right: 2pt solid; background-color: rgba(0, 8, 0, 0.2); "><b>FICHE DE VISIT<br>CAR<b></b></td>
                <td class="text-center uppercase">N° VEHICULE<br>
                    {{$visit->diagnostic->statee->bus->matriculation}}
                </td>
            </tr>
            <tr style="border-bottom: 2pt solid">
                <td rowspan="3" class="border_bottom_2" >
                    <p>
                        <small>Kilometrage vehicule</small>
                        <br>
                        {{number_format($visit->diagnostic->statee->kilometer)}}</p>
                    <p>
                        <small>Kilometrage moteur</small>
                        <br>
                        {{number_format($visit->diagnostic->statee->kilometer)}}</p>
                </td>
                <td colspan="1" class="text-center" style="border-left: 2px solid; border-right: 2px solid">
                    <small>DATE DERNIERE VISIT</small>
                </td>
                <td colspan="1" class="text-center" style="border-right: 2px solid">
                    <small>KILOMETRAGE</small>
                </td>
                <td rowspan="3" >
                    <p>Date<br>
                        <small> {{\Jenssegers\Date\Date::parse($visit->created_at)->format('j M Y')}}</small>
                    </p>
                    <p>Garage<br>UTB</p>
                </td>
            </tr>
            <tr style="border-top: 1px solid; border-bottom: 1px solid">
                @foreach($deniervist as  $deniervis)
                    <td>{{$deniervis->date}}</td>
                @endforeach
            </tr>
            <tr style="border-top: 1px solid; border-bottom: 1px solid">
                @foreach($deniervist as  $deniervis)
                    <td>{{$deniervis->kilometer}}</td>
                @endforeach
            </tr>
            <tr class="border_bottom" style="border-bottom: 2px solid">
                <td style="border-right: 2px solid"></td>
                <td colspan="3" class="text-center" >OPERATION COMPLEMANTAIRE</td>
            </tr>

            @foreach ($visit->diagnostic->service_description as $description)
                <tr style="height: 10vh">
                    <td colspan="4">
                        {{$description->description}}
                    </td>
                </tr>
            @endforeach

            <tr style="border-top: 2px solid; border-bottom: 2px solid; border-right: 2px solid">
                <td colspan="2" style="border-right: 2px solid">VISAS CHEFS D'EQUIPE</td>
                <td rowspan="2" colspan="2" class="text-center">VISAS CHEF GARAGE</td>
            </tr>
            <tr style="border-bottom: 1px solid">
                <td style="border-bottom: 1px solid; border-right: 2px solid">Mécanique</td>
                <td style="border-bottom: 1px solid; border-right: 2px solid"></td>

            </tr>
            <tr>
                <td style="border-bottom: 1px solid; border-right: 2px solid">Electricité</td>
                <td style="border-bottom: 1px solid;border-right: 2px solid"></td>
            </tr>
            <tr>
                <td style="border-bottom: 1px solid; border-right: 2px solid">Tôlerie</td>
                <td style="border-right: 2px solid"></td>
            </tr>


        </table>
    </div>
</section>








































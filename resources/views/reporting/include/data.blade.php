


<table class="table table-striped m-b-none capitalize" id="approvalTable">
    <thead>
    <tr>
        <th >#</th>
        <th>Société</th>
        <th>Car</th>
        <th>Chassis</th>
        <th>Réference OT</th>
        <th>Prestation</th>
        <th>Technicien intervenant</th>
        <th>Pièce utilisée</th>
        <th>Sortie</th>
        <th>Date Entrée</th>
    </tr>
    </thead>
    <tbody>
    @foreach($diagnostics as $key=>$diagnostic)
        <tr id="approval{{$diagnostic->id}}" class="animated fadeInDown">
            <td>{{$key + 1}}</td>
            <td class="uppercase text-danger-dker">{{$diagnostic->statee->bus->societe}}</td>
            <td class="uppercase text-danger-dker">{{$diagnostic->statee->bus->model->brand->name." ".$diagnostic->statee->bus->model->name}}</td>
            <td class="uppercase text-danger-dker">{{$diagnostic->statee->bus->chassis}}</td>
            <td class="uppercase text-danger-dker">{{$diagnostic->statee->reference}}</td>
            <td class="uppercase text-danger-dker">

                @if($diagnostic->type==1)

                    Reparation

                    @elseif($diagnostic->type==2)
                     Visite technique
                @elseif($diagnostic->type==3)
                      Revision
                    @endif

            </td>






            <td class="uppercase text-danger-dker">

                @if($diagnostic->type==1)


                    @forelse($diagnostic->service_employee as $key=>$technician)

                        {{$technician->employee->username}} <br/> &nbsp;&nbsp;

                        @empty
                    Aucun technicien ayant intervenu

                    @endforelse

                @elseif($diagnostic->type==2)

                    @forelse($diagnostic->service_employee as $key=>$technician)

                        {{$technician->employee->username}} &nbsp;&nbsp;

                    @empty
                        Aucun technicien ayant intervenu


                    @endforelse

                @elseif($diagnostic->type==3)
                    @forelse($diagnostic->service_employee as $key=>$technician)

                        {{$technician->employee->username}} &nbsp;&nbsp;

                    @empty
                        Aucun technicien ayant intervenu


                    @endforelse

                @endif


            </td>

            <td>

                <table class="table table-striped m-b-none">
                    <thead>
                    <tr>
                        <th width="90%">Piéces</th>
                        <th>Attribué</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = '' ?>
                    @forelse($diagnostic->demand as $demand)
                        @if($diagnostic->demand )
                            @if($demand->state == '0')
                                <?php $count = '1' ?>
                            @endif
                        @endif
                        @if($demand->state == '2' or $demand->state == '3')
                            @forelse($demand->demand_piece as $piece)
                                <tr>
                                    <td class="capitalize">{{$piece->piece}}</td>
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


            </td>

            <td>
                <?php
                    $approval = App\Approval::where('diagnostic_id',$diagnostic->id)->get();
                ?>

                        @if(isset($approval) and (count($approval) != 0))
                        {{Jenssegers\Date\Date::parse($approval->first()->created_at)->format('j M Y')}}
                        @else
                        <strong class="text-success"><i>Pas encore sortie</i></strong>

                            @endif




            </td>
            <td>{{Jenssegers\Date\Date::parse($diagnostic->statee->update_at)->format('j M Y')}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $table=$('#approvalTable');
    $(function () {

        $table.dataTable({
            "sPaginationType": "full_numbers",
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "iDisplayLength": 50,
            "language": {
                "url": "../assets/js/datatables/French.json"
            }
        });



    })


</script>
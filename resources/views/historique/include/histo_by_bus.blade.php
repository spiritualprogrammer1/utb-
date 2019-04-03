<div class="col-sm-12">
    <section class="panel panel-info clearfix">
        <header class="panel-heading">
            <div class="row">
                <div class="col-sm-5 m-t-sm" style="font-weight: bold;font-size: 20px">
                    <b class="text-success">{{$buses->matriculation}}</b>  ({{$buses->model->name}},{{$buses->model->brand->name}})
                </div>

                <div class="col-sm-3 m-t-sm">
                    <div class="" style="float: right">
                        <input class="input-sm  form-control col-sm-3" placeholder="Date debut" name="begin" id="begin" style="width: 87px">
                        <input class="input-sm col-sm-3 form-control"  placeholder="Date fin" name="end" id="end" style="width: 87px">
                        <a href="#" data-id="{{$buses->id}}" class="btn btn-sm col-sm-3 btn-icon btn-info"  id="periodehisto"><i class="fa fa-search"></i></a>
                        <!--<a href="#nav, #sidebar" class="btn btn-icon b-2x btn-info btn-rounded" data-toggle="class:nav-xs, show"><i class="fa fa-bars"></i></a>-->

                    </div>
                </div>
            </div>
        </header>
        <div class="panel-body clearfix scrollable">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="panel-group m-b" id="accordion2">
                            @foreach($buses->state as $states)
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    var $periodehisto = $('#periodehisto'),$accordion2 = $('#accordion2');
    $periodehisto.on('click',function () {
        var begin_d = $('#begin').val(),end_d = $('#end').val(), car = $periodehisto.attr('data-id');
        $search_loader.show();
        $.ajax({
            url:'periodicalhisto',
            type:'GET',
            data:{'begin':begin_d,'end':end_d,'car':car},
            success:function (data) {
                console.log(data);
                $accordion2.html(data);
                $search_loader.hide();
            },
            error:function () {}
        });
    });

    /*******Date calendar*****/
    $('#begin').datepicker({
        format: "yyyy-mm-dd",
    });

    $('#end').datepicker({
        format: "yyyy-mm-dd",
    });

    $('#end').datepicker().on('changeDate', function(e) {
        var inputdate=$("#end").val();
        var d = new Date();
        var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
        if(Date.parse(inputdate) > Date.parse(currentdate)){
            $("#end").val('');
            toastr["error"]("Veuillez rentrer une date antérieur", "Oups!");

            //Mettez ici tous vos actions et messages d'erreur...
            //Mettez ici tous vos actions et messages d'erreur...
        }
    });

    $('#begin').datepicker().on('changeDate', function(e) {
        var inputdate=$("#begin").val();
        var d = new Date();
        var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
        if(Date.parse(inputdate) > Date.parse(currentdate)){
            $("#begin").val('');
            toastr["error"]("Veuillez rentrer une date antérieur", "Oups!");

            //Mettez ici tous vos actions et messages d'erreur...
            //Mettez ici tous vos actions et messages d'erreur...
        }
    });

    function dateController(val){
        var inputdate=$(val).val();
        var d = new Date();
        var currentdate = addZero(d.getFullYear())+'-'+(addZero(d.getMonth()+1))+'-'+addZero(d.getDate());
        if(Date.parse(inputdate) > Date.parse(currentdate)){
            $(val).val('');
            //Mettez ici toutes vos actions et messages d'erreur...
            //Mettez ici toutes vos actions et messages d'erreur...
        }
    }

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    /*******End date calendar*****/
</script>
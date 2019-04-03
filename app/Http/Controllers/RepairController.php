<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Demand_piece;
use App\Enginebus;
use App\Item_stock;
use App\Service_description;
use App\Repairdescription;
use App\Diagnostic;
use App\Diagnostic_employee;
use App\Employee;
use App\Repair;
use App\Service_employee;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Validator;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {

                //$technicians = Employee::where('site_id',$site_id)->where('post_id', '1')->get();
                $technicians = Employee::where('post_id', '1')->get();

                $diagnostics=Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('site_id',$site_id);

                })->whereBetween('active', ['1','2'])->where('type','1')->orderBy('updated_at', 'desc')->get();
                $active = '';
                if ($diagnostics->count() == '0') {
                    $active = '0';
                }
                $repairs = Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();


            }
            else{
                $technicians = Employee::where('post_id', '1')->get();
//        $diagnostics = Diagnostic::where('active', '1')
//            ->orWhere('active','2')->where('type', '1')->orderBy('updated_at', 'desc')->get();
//        $diagnostics = Diagnostic::whereBetween('active', [1,2])->where('type', '1')->orderBy('updated_at', 'desc')->get();
                $diagnostics=Diagnostic::whereBetween('active', ['1','2'])->where('type','1')->orderBy('updated_at', 'desc')->get();
                $active = '';
                if ($diagnostics->count() == '0') {
                    $active = '0';
                }
                $repairs = Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();


            }
        }
        else{
          //  $technicians = Employee::where('site_id',$site_id)->where('post_id', '1')->get();

            $technicians = Employee::where('post_id', '1')->get();

            $diagnostics=Diagnostic::whereHas('statee',function ($query){
             $site_id=Auth::user()->employee->site_id;
             $query->where('site_id',$site_id);

         })->whereBetween('active', ['1','2'])->where('type','1')->orderBy('updated_at', 'desc')->get();
            $active = '';
            if ($diagnostics->count() == '0') {
                $active = '0';
            }
            $repairs = Repair::where('site_id',$site_id)
                ->where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
                ->get();

        }

       return view('repair.home', ['diagnostics' => $diagnostics, 'technicians' => $technicians,
            'repairs' => $repairs, 'active' => $active]);
    }

    public function create()
    {
        //
    }

    public function score()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $reparationencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $reparationattente=Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('site_id',$site_id);

                })->whereBetween('active', ['1','2'])->where('type','1')->count();
            }
            else{

                $reparationencours=Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $reparationattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','1')->count();
            }
        }
        else{

            $reparationencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
            $reparationattente=Diagnostic::whereHas('statee',function ($query){
                $site_id=Auth::user()->employee->site_id;
                $query->where('site_id',$site_id);

            })->whereBetween('active', ['1','2'])->where('type','1')->count();
        }

        return response()->json(['reparationencours'=>$reparationencours,'reparationattente'=>$reparationattente]);
    }

    public function scoree()
    {

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $reparationencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $essaaprestravauxeepair=Repair::where('site_id',$site_id)->where('state', '3')->count();

            }
            else{

                $reparationencours=Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $essaaprestravauxeepair=Repair::where('state', '3')->count();

            }
        }
        else{
            $reparationencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
            $essaaprestravauxeepair=Repair::where('site_id',$site_id)->where('state', '3')->count();
        }

        return response()->json(['reparationencours'=>$reparationencours,'essaaprestravauxeepair'=>$essaaprestravauxeepair]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
                'diagnostic.required' => "Choissisez l'ordre de travail",
                'technician.required' => "Selectionnez les techniciens affectés",
                'title.required' => "Entrez l'inititulé de la réparation",
                'description.required' => "Saissisez les details de la réparation",
            );
            $rules = array(
                'diagnostic' => 'bail|required|min:1|max:255',
                'technician' => 'bail|required|min:1|max:255|',
                'title' => 'bail|required|min:1',
                'description' => 'bail|required|min:1',
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $diagnostic = Diagnostic::findOrFail($request->diagnostic)->update(['active' => '0']);
               $repair = Repair::create([
                    'ids' => Carbon::now()->timestamp,
                    'diagnostic_id' => $request->diagnostic,
                    // state = 1 : repair create
                    'state' => '1',
                    'site_id' => Auth::user()->id,
                    'user_id' => Auth::user()->id,
                ]);
                for ($i = 0; $i < count($request->technician); $i++) {
                    $technician = Service_employee::create([
                        'diagnostic_id' => $request->diagnostic,
                        'employee_id' => $request->technician[$i],
                    ]);

                }
                for ($i = 0; $i < count($request->title); $i++) {
                    $description = Service_description::create([
                        'diagnostic_id' => $request->diagnostic,
                        'description' => $request->description[$i],
                        'title' => $request->title[$i],
                    ]);
                }

                /*****enregistrer le moteur****/
//                $engineBus=Enginebus::create([
//                    'item_stock_id'=>$request->item_stock_id,
//                       'state_id'=>$diagnostic->statee->id,
//                       'kilometer'=>$request->new_kilometer,
//                       'bus_id'=>$diagnostic->statee->bus_id,
//
//                ]);



                return response()->json(['id' => $repair->id, 'matriculation' => $repair->diagnostic->statee->bus->matriculation,
                    'chassis' => $repair->diagnostic->statee->bus->chassis, 'date' => Date::parse($repair->created_at)->format('j M Y'),
                    'bus' => $repair->diagnostic->statee->bus->model->brand->name . " " . $repair->diagnostic->statee->bus->model->name,
                    'reference' => $repair->diagnostic->statee->reference,
                    'count' => $repair->where('state','1')->orWhere('state','2')->orWhere('state','4')->count('id'),
                    'diagnostic' => $request->diagnostic]);
            }
        }

        else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id == "0") {


                $site_id=Auth::user()->employee->site_id;
                if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                    if (Auth::user()->employee->action_site == 2) {
                        $diagnostics = Diagnostic::whereHas('statee',function ($query){
                            $site_id=Auth::user()->employee->site_id;
                            $query->where('site_id',$site_id);

                        })->where('type', '1')->where('active', '1')
                            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                    }
                    else{

                        $diagnostics = Diagnostic::where('type', '1')->where('active', '1')
                            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                    }
                }
                else{

                    $diagnostics = Diagnostic::whereHas('statee',function ($query){
                        $site_id=Auth::user()->employee->site_id;
                        $query->where('site_id',$site_id);

                    })->where('type', '1')->where('active', '1')
                        ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();

                }


                return response()->json($diagnostics);
            } else {
                $repair = Repair::findOrFail($id);
                $employees = Employee::where('post_id', '1')->get();

                $state_id=$repair->diagnostic->statee->id;


                /*************recuperation de pneu*****/

                $k=0;
                $engine_tire=array();
                $item_stock_tire=Item_stock::whereHas('stock',function ($query){
                    $query->where('stock_type',2);

                })->where('state_id',$state_id)->get();

             foreach ($item_stock_tire as $item_stock_tir)
             {
                 $engine_tire[$k]=Enginebus::where('item_stock_id',$item_stock_tir->id)->where('state',2)->get();
                 $k++;
             }


                  /***************instance state***************/
                  $states = State::findOrFail($state_id);

                /***recuperation du moteur si il existe**/

                $item_stock=Item_stock::whereHas('stock',function ($query){
                    $query->where('stock_type',1);

                })->where('state_id',$state_id)->first();
                if(isset($item_stock->id) and !empty($item_stock->id))
                {
                    $engine=Enginebus::where('item_stock_id',$item_stock->id)->first();
                    /*********si le moteur existe state_kilometer =1******/
                    $states->state_kilometer=1;
                    $states->save();

                }
                else{
                    $engine="";
                }
                /*****recuperation des pneus***/
                $item_tire_stock = Item_stock::whereHas('stock',function ($query){
                    $query->where('stock_type',2);

                })->where('state_id',$state_id)->get();



                return view('repair.partials.repair', ['engine_tire'=>$engine_tire,'item_tire_stock'=>$item_tire_stock,'repair' => $repair, 'employees' => $employees,'item_stock'=>$item_stock,'engine'=>$engine]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {


            $site_id=Auth::user()->employee->site_id;
            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $demands = Demand::where('diagnostic_id', $id)->get();
                    foreach ($demands as $demand) {
                        $pieces [] = Demand_piece::where('demand_id', $demand->id)->get();
                    }
                }
                else{
                    $demands = Demand::where('diagnostic_id', $id)->get();
                    foreach ($demands as $demand) {
                        $pieces [] = Demand_piece::where('demand_id', $demand->id)->get();
                    }

                }
            }
            else{
                $demands = Demand::where('diagnostic_id', $id)->get();
                foreach ($demands as $demand) {
                    $pieces [] = Demand_piece::where('demand_id', $demand->id)->get();
                }
            }

            return response()->json($pieces);
        }

        else {
            return view('errors.500');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $messages = array(
                'tester.required' => "Le choix du technicien de l'essai est obligatoire",
                'technician.required' => "Le choix du technicien du diagnostic est obligatoire",
                'service.required' => "Choisissez une Prestation SVP!",
                'title.required' => "Entrez l'inititulé de la réparation",
                'description.required' => "Saissisez les details de la réparation",
            );
            if ($request->has('piece')) {
                $rules = array(
                    'piece' => 'bail|required|min:1',
                    'quantity' => 'bail|required|min:1',
                );
            } else {
                $rules = array();
            }

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {




                $diagnostic = Repair::findOrFail($id)->diagnostic_id;
                $diagnosti= Repair::findOrFail($id)->diagnostic;
                $repair =Repair::findOrFail($id);



                /*******state =2 pour les pneus et level pour le niveau*******************/
                /********recuperation des pneux ******/
                    /********level=1 pour la creation*********/

                    if($request->engine_tire_idd==1)
                    {
                        for($i=0;$i<count($request->engine_tire_id);$i++)
                        {
                            $engineBus_tire[$i]=Enginebus::findOrFail($request->engine_tire_idd[$i]);
                            $engineBus_tire[$i]->kilometer=$request->new_kilometer_tire[$i];
                            $engineBus_tire[$i]->save();

                        }

                    }
                    else
                    {
                        for($i=0;$i<count($request->item_stock_tire_id);$i++)
                        {


                            $engineBus=Enginebus::create([
                                'item_stock_id'=>$request->item_stock_tire_id[$i],
                                'state_id'=>$repair->diagnostic->statee->id,
                                'kilometer'=>$request->new_kilometer_tire[$i],
                                'bus_id'=>$repair->diagnostic->statee->bus->id,
                                'state'=>2,
                                'level'=>1,
                            ]);

                        }
                    }


                /*****enregistrer le moteur****/
                /*******state=1 pour les moteurs et level pour ne niveau******/

                if($request->level_engine==1)
                {
                    $engineBus=Enginebus::where('state_id',$diagnosti->statee->id)->first();

                    $engineBus->kilometer=$request->new_kilometer;
                    $engineBus->save();
                }
                else{
                    $engineBus=Enginebus::create([
                        'item_stock_id'=>$request->item_stock_id,
                        'state_id'=>$repair->diagnostic->statee->id,
                        'kilometer'=>$request->new_kilometer,
                        'bus_id'=>$repair->diagnostic->statee->bus_id,
                        'state'=>1,
                        'level'=>1,

                    ]);
                }


                for ($i = 0; $i < count($request->technician); $i++) {
                    $technicians = service_employee::where('employee_id', $request->technician[$i])->get();
                    //if ($technicians) {

                    //} else {
                    $technician = service_employee::create([
                        'diagnostic_id' => $diagnostic,
                        'employee_id' => $request->technician[$i],
                    ]);
                    //}
                };
                for ($i = 0; $i < count($request->title); $i++) {
                    $description = Service_description::create([
                        'diagnostic_id' => $diagnostic,
                        'description' => $request->description[$i],
                        'title' => $request->title[$i],
                    ]);
                }
                if ($request->has('piece')) {
                    $demand = Demand::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => 'dmd-' . Carbon::now()->timestamp,
                        'diagnostic_id' => $diagnostic,
                    ]);
                    for ($i = 0; $i < count($request->piece); $i++) {
                        $demand_piece = Demand_piece::create([
                            'demand_id' => $demand->id,
                            'piece' => $request->piece[$i],
                            'quantity' => $request->quantity[$i],
                        ]);
                    }
                }
                $finish = '';
                if ($request->has('finish')) {
                    $repair = Repair::findOrFail($id)->update(['state' => '3']);
                    $finish = '1';
                }
                return response()->json(['id' => $id, 'reference' => $request->reference, 'finish' => $finish]);
            }
       }
 else {
            return view('errors.500');
        }
    }

    public function descriptions(Request $request, $id)
    {
        if ($request->ajax()) {
            $descriptions = Service_description::where('repair_id', $id)->get();
            return response()->json($descriptions);
        } else {
            return view('errors.500');
        }
    }

    public function filesrepaire(Request $request,$id)
    {
        $repair=Repair::findOrFail($id);
        $bus_id= $repair->diagnostic->statee->bus_id;

        $denierrepair=Repair::join('diagnostics','diagnostics.id','=','repairs.diagnostic_id')
            ->join('works','works.diagnostic_id','=','diagnostics.id')
            ->join('states','states.id','=','diagnostics.state_id')
            ->join('buses','buses.id','=','states.bus_id')
            ->select('repairs.created_at as date','states.kilometer as kilometer')
            ->where('buses.id',$bus_id)
            ->where('works.type','2')
            ->where('repairs.state','5')
            ->orderBy('repairs.id','desc')
            ->take(3)
            ->get();
        return view('repair.file.repairfile',compact('denierrepair','repair'));
    }
    function destroy($id)
    {
        //
    }
}

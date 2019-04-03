<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Repair;
use App\Revision;
use App\Visit_technique;
use App\Work;
use App\Demand;
use App\Diagnostic;
use App\Diagnostic_employee;
use App\Demand_piece;
use App\Employee;
use App\Process;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Validator;

class DiagnosticController extends Controller
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
                $technicians = Employee::where('post_id', '1')->where('site_id',$site_id)->get();
                $states = State::where('site_id',$site_id)->where('state', '1')->orderBy('created_at', 'desc')->get();
            }
            else{

                $technicians = Employee::where('post_id', '1')->get();
                $states = State::where('state', '1')->orderBy('created_at', 'desc')->get();
            }
        }
        else{

            $technicians = Employee::where('post_id', '1')->where('site_id',$site_id)->get();
            $states = State::where('site_id',$site_id)->where('state', '1')->orderBy('created_at', 'desc')->get();
        }


        $technicians = Employee::where('post_id', '1')->get();
        $states = State::where('state', '1')->orderBy('created_at', 'desc')->get();

        return view('diagnostic.home', ['states' => $states, 'technicians' => $technicians]);
    }

public function historiqueot(Request $request,$id)
{
if($request->ajax())
{
    if($request->type=="repaire")
    {
        $repair=Repair::findOrFail($id);
        $employees = Employee::where('post_id', '1')->get();

        return view('diagnostic.includes.historydata',compact('repair','employees'));
    }
    if($request->type=="revision")
    {
        $revision=Revision::findOrFail($id);
        $employees = Employee::where('post_id', '1')->get();

        return view('diagnostic.includes.historyrevision',compact('revision','employees'));

    }
    if($request->type=="visit")
    {
        $visit=Visit_technique::findOrFail($id);
        $employees = Employee::where('post_id', '1')->get();

        return view('diagnostic.includes.historyvisit',compact('visit','employees'));

    }



}
}

    public function create()
    {
        //
    }


    public function bus_history(Request $request,$id)
    {
     $bus =Bus::find($id);
        return view('diagnostic.includes.history',compact('bus'));
    }
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
               // 'tester.required' => "Le choix du technicien de l'essai est obligatoire",
                'technician.required' => "Le choix du technicien du diagnostic est obligatoire",
                'service.required' => "Choisissez une Prestation SVP!",
            );
            if ($request->has('piece')) {
                $rules = array(
                    'state' => 'bail|required|min:1',
                  //  'tester' => 'bail|required|min:1',
                    'distance' => 'bail|required|min:1',
                    'place' => 'bail|required|min:3',
                    'description' => 'bail|required|min:6',
                    'technician' => 'bail|required|min:1',
                    //'title' => 'bail|required|min:3',
                    //'diagnostic' => 'bail|required|min:6',
                    'piece' => 'bail|required|min:1',
                    'quantity' => 'bail|required|min:1',
                    'service' => 'bail|required|min:1',
                );
            } else {

            }
            $rules = array(
                'state' => 'bail|required|min:1',
               // 'tester' => 'bail|required|min:1',
                'distance' => 'bail|required|min:1',
                'place' => 'bail|required|min:3',
                'description' => 'bail|required|min:6',
                'technician' => 'bail|required|min:1',
                //'title' => 'bail|required|min:3',
                //'diagnostic' => 'bail|required|min:6',
                'service' => 'bail|required|min:1',
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
                $state = State::findOrFail($request->state)->update(['state' => '0']);

                $statee = State::find($request->state);
                $diagnostic = Diagnostic::create([
                    'ids' => Carbon::now()->timestamp,
                    'reference' => 'DIAG-' . Carbon::now()->timestamp,
                    'state_id' => $request->state,
                    'type' => $request->service,
                    'user_id' => Auth::user()->id,
                ]);


                if(isset($statee->work))
                {
                    $works=$statee->work;
                    $works->diagnostic_id=$diagnostic->id;
                    $works->save();

                }
                else{
                    $works = Work::create([
                        'type' => '1',
                        'ids' => Carbon::now()->timestamp,
                        'distance' => $request->distance,
                        'place' => $request->place,
                        'description' => $request->description,
                        'employee_id' => $request->tester,
                        'diagnostic_id' => $diagnostic->id,
                        'user_id' => Auth::user()->id,
                        'site_id' => Auth::user()->id,
                        'state_id' => $statee->id
                    ]);

                }




                for ($i = 0; $i < count($request->technician); $i++) {
                    $diagnostic_employee = Diagnostic_employee::create([
                        'diagnostic_id' => $diagnostic->id,
                        'employee_id' => $request->technician[$i],
                        'title' => $request->title[$i],
                        'description' => $request->description[$i],
                    ]);
                }
                if ($request->has('piece')) {
                    $demand = Demand::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => 'dmd-' . Carbon::now()->timestamp,
                        'diagnostic_id' => $diagnostic->id,
                    ]);
                    for ($i = 0; $i < count($request->piece); $i++) {
                        $demand_piece = Demand_piece::create([
                            'demand_id' => $demand->id,
                            'piece' => $request->piece[$i],
                            'quantity' => $request->quantity[$i],
                        ]);
                    }
                } else {
                    //active = 2 : no demand
                    $diagnostic->update(['active' => '1']);
                }
                return response()->json(['id' => $request->state, 'ot' => $diagnostic->statee->reference,
                    'matriculation' => $diagnostic->statee->bus->matriculation,'diagnostic_id'=>$diagnostic->id,'work_id'=>$works->id]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $state = State::findOrFail($id);

           // $state->work->description;

            if(isset($state->work))
            {
                return response()->json(['description'=>$state->work->description,'place'=>$state->work->place,'employee'=>$state->work->employee->username,'arrive'=>$state->work->arrive,'distance'=>$state->work->distance,'matriculation' => $state->bus->matriculation, 'ot' => $state->reference,
                    'bus' => $state->bus->model->brand->name . ' ' . $state->bus->model->name,
                    'bus_id'=>$state->bus->id ,'incident' => $state->incident, 'remark' => $state->remark, 'depart' => $state->kilometer]);


            }
            else{
                return response()->json(['matriculation' => $state->bus->matriculation, 'ot' => $state->reference,
                    'bus' => $state->bus->model->brand->name . ' ' . $state->bus->model->name,
                    'bus_id'=>$state->bus->id ,'incident' => $state->incident, 'remark' => $state->remark, 'depart' => $state->kilometer]);

            }







        } else {
            return view('errors.500');
        }
    }


    public function savetest(Request $request,$state_id,$leaving,$distance,$lieu,$tester,$descrip,$arrive)
    {
        if($request->ajax())
        {


            $works = Work::create([
                'type' => '1',
                'ids' => Carbon::now()->timestamp,
                'distance' => $distance,
                'place' => $lieu,
                'arrive'=>$arrive,
                'description' => $descrip,
                'employee_id' => $tester,
                'user_id' => Auth::user()->id,
                'site_id' => Auth::user()->id,
                'state_id'=>$state_id
            ]);



            return response()->json(['before_test'=>$works->id]);
        }
    }

    public function score()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $diagnostic_count = State::where('state', '1')->where('site_id',$site_id)->count();
                $demans=Demand::whereHas('diagnostic',function ($query){
                    $query->whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);
                    });

                })->where('state', '0')->count() ;
            }
            else{
                $diagnostic_count = State::where('state', '1')->count();
                $demans=Demand::where('state', '0')->count() ;
            }
        }
        else{
            $diagnostic_count = State::where('state', '1')->where('site_id',$site_id)->count();
            $demans=Demand::whereHas('diagnostic',function ($query){
                $query->whereHas('statee',function ($q){
                    $site_id=Auth::user()->employee->site_id;
                    $q->where('site_id',$site_id);
                });

            })->where('state', '0')->count() ;

        }




      return  Response::json(['diagnostic_count'=>$diagnostic_count,'demans'=>$demans]);
    }

    public function filesdiagnostique(Request $request,$id)
    {
//        if ($request->ajax()) {
//            if ($request->type == 'before_test') {
//                $before_test = Before_test::findOrFail($id);
//                return view('diagnostic.files.before_test', compact('before_test'));
//            } elseif ($request->type == 'state') {
//                $process = Process::findOrFail($id);
//                $fuels = Fuel::all();
//                return view('state.files.state', compact('process', 'fuels'));
//            } else {



                $diagnostic = Diagnostic::findOrFail($id);

                $vehicle_id = $diagnostic->statee->bus_id;
                $bus = Bus::findOrFail($vehicle_id);
               // return view('diagnostic.files.diagnostic', compact('diagnostic'));
//            }
//        } else {
//            return view('errors.404');
//        }


        return view('diagnostic.file.filediagnostic',compact('diagnostic','bus'));
    }

    public function filesworks(Request $request,$id)
    {
        $before_test=Work::where('type','1')->where('id',$id)->get();
return view('diagnostic.file.work_befor',compact('before_test'));
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

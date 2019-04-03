<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Demand_piece;
use App\Diagnostic;
use App\Employee;
use App\Service_description;
use App\Service_employee;
use App\Visit_technique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Validator;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function filesvisit(Request $request,$id)
    {
        $visit=Visit_technique::findOrFail($id);
        $bus_id= $visit->diagnostic->statee->bus_id;

        $deniervist=Visit_technique::join('diagnostics','diagnostics.id','=','visit_techniques.diagnostic_id')
            ->join('works','works.diagnostic_id','=','diagnostics.id')
            ->join('states','states.id','=','diagnostics.state_id')
            ->join('buses','buses.id','=','states.bus_id')
            ->select('visit_techniques.created_at as date','states.kilometer as kilometer')
            ->where('buses.id',$bus_id)
            ->where('works.type','2')
            ->where('visit_techniques.state','5')
            ->orderBy('visit_techniques.id','desc')
            ->take(3)
            ->get();
        return view('visit.file.visitfile',compact('deniervist','visit'));
    }

    public function index()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {

            //    $technicians = Employee::where('post_id', '1')->where('site_id',$site_id)->get();
                $technicians = Employee::where('post_id', '1')->get();


//        $diagnostics = Diagnostic::where('type', '3')->where('active', '1')
//            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                $diagnostics = Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('site_id',$site_id);

                })->whereBetween('active', ['1','2'])->where('type', '3')->orderBy('updated_at', 'desc')->get();
                $active = '';
                if ($diagnostics->count() == '0') {
                    $active = '0';
                }
                $visits = Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();


            }
            else{

                $technicians = Employee::where('post_id', '1')->get();
//        $diagnostics = Diagnostic::where('type', '3')->where('active', '1')
//            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                $diagnostics = Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')->orderBy('updated_at', 'desc')->get();
                $active = '';
                if ($diagnostics->count() == '0') {
                    $active = '0';
                }
                $visits = Visit_technique::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();

            }
        }
        else{

        //    $technicians = Employee::where('post_id', '1')->where('site_id',$site_id)->get();
            $technicians = Employee::where('post_id', '1')->where('site_id',$site_id)->get();

//        $diagnostics = Diagnostic::where('type', '3')->where('active', '1')
//            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
            $diagnostics = Diagnostic::whereHas('statee',function ($query){
                $site_id=Auth::user()->employee->site_id;
                $query->where('site_id',$site_id);

            })->whereBetween('active', ['1','2'])->where('type', '3')->orderBy('updated_at', 'desc')->get();
            $active = '';
            if ($diagnostics->count() == '0') {
                $active = '0';
            }
            $visits = Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();


        }


        return view('visit.home', ['diagnostics' => $diagnostics, 'technicians' => $technicians,
            'visits' => $visits, 'active' => $active]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //if ($request->ajax()) {
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
            $visit = Visit_technique::create([
                'ids' => uniqid(),
                'diagnostic_id' => $request->diagnostic,
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
            return response()->json(['id' => $visit->id, 'matriculation' => $visit->diagnostic->statee->bus->matriculation,
                'chassis' => $visit->diagnostic->statee->bus->chassis, 'date' => Date::parse($visit->created_at)->format('j M Y'),
                'bus' => $visit->diagnostic->statee->bus->model->brand->name . " " . $visit->diagnostic->statee->bus->model->name,
                'reference' => $visit->diagnostic->statee->reference,
                'count' => $visit->where('state','1')->orWhere('state','2')->orWhere('state','4')->count('id'),
                'diagnostic' => $request->diagnostic]);
        }
        /*} else {
            return view('errors.500');
        }*/
    }

    public function show(Request $request,$id)
    {
        if ($request->ajax()) {
            if ($id == "0") {
                $site_id=Auth::user()->employee->site_id;
                if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                    if (Auth::user()->employee->action_site == 2) {
                        $diagnostics = Diagnostic::whereHas('statee',function ($q){
                            $site_id=Auth::user()->employee->site_id;
                            $q->where('site_id',$site_id);

                        })->with('state')->where('type', '3')->where('active', '1')
                            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                    }
                    else{
                        $diagnostics = Diagnostic::with('state')->where('type', '3')->where('active', '1')
                            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();


                    }
                }
                else{
                    $diagnostics = Diagnostic::whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);

                    })->with('state')->where('type', '3')->where('active', '1')
                        ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                }

                return response()->json($diagnostics);
            } else {
                $visit = Visit_technique::findOrFail($id);

                $site_id=Auth::user()->employee->site_id;
                if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                    if (Auth::user()->employee->action_site == 2) {
                    //    $employees = Employee::where('post_id', '1')->where('site_id',$site_id)->get();

                        $employees = Employee::where('post_id', '1')->get();

                    }
                    else{
                        $employees = Employee::where('post_id', '1')->get();
                    }
                    }
                    else{
                      //  $employees = Employee::where('post_id', '1')->where('site_id',$site_id)->get();

                        $employees = Employee::where('post_id', '1')->get();

                    }

                return view('visit.partials.visit', ['visit' => $visit, 'employees' => $employees]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function edit($id)
    {
        //
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
                $diagnostic = Visit_technique::findOrFail($id)->diagnostic_id;
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
                        'ids' => uniqid(),
                        'reference' => 'dmd-' . uniqid(),
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
                    $visit = Visit_technique::findOrFail($id)->update(['state' => '3']);
                    $finish = '1';
                }
                return response()->json(['id' => $id, 'reference' => $request->reference, 'finish' => $finish]);
            }
        } else {
            return view('errors.500');
        }
    }
public function score()
{

    $site_id=Auth::user()->employee->site_id;
    if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
        if (Auth::user()->employee->action_site == 2) {
            $count_attentvist= Diagnostic::whereHas('statee',function ($q){
                $site_id=Auth::user()->employee->site_id;
                $q->where('site_id',$site_id);

            })->whereBetween('active', ['1','2'])->where('type', '3')->count();
            $count_visitatcours=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();

        }
        else{
            $count_attentvist= Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')->count();
            $count_visitatcours=Visit_technique::where('state', '1')->orWhere('state', '2')->count();

        }
    }else{
        $count_attentvist= Diagnostic::whereHas('statee',function ($q){
            $site_id=Auth::user()->employee->site_id;
            $q->where('site_id',$site_id);

        })->whereBetween('active', ['1','2'])->where('type', '3')->count();
        $count_visitatcours=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();

    }



    return response()->json(['count_attentvist'=>$count_attentvist,'count_visitatcours'=>$count_visitatcours]);
}

public function scoree()
{
    $site_id=Auth::user()->employee->site_id;
    if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
        if (Auth::user()->employee->action_site == 2) {
            $testVist=Visit_technique::where('site_id',$site_id)->where('state', '3')->count();
            $count_visitcour=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();
        }
        else{
            $testVist=Visit_technique::where('state', '3')->count();
            $count_visitcour=Visit_technique::where('state', '1')->orWhere('state', '2')->count();

        }
    }
    else{
        $testVist=Visit_technique::where('site_id',$site_id)->where('state', '3')->count();
        $count_visitcour=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();

    }


    return response()->json(['testVist'=>$testVist,'count_visitcour'=>$count_visitcour]);

}
    public function destroy($id)
    {
        //
    }
}

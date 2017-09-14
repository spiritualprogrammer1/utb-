<?php

namespace App\Http\Controllers;

use App\Before_work;
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
use Validator;

class DiagnosticController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Employee::where('post_id', '1')->get();
        $states = State::where('state', '1')->orderBy('created_at', 'desc')->get();
        return view('diagnostic.home', ['states' => $states, 'technicians' => $technicians]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
                'tester.required' => "Le choix du technicien de l'essai est obligatoire",
                'technician.required' => "Le choix du technicien du diagnostic est obligatoire",
                'service.required' => "Choisissez une Prestation SVP!",
            );
            if ($request->has('piece')){
                $rules = array(
                    'state' => 'bail|required|min:1',
                    'tester' => 'bail|required|min:1',
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
            }else{

            }
            $rules = array(
                'state' => 'bail|required|min:1',
                'tester' => 'bail|required|min:1',
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
                $state = State::findOrFail($request->state)->update(['state'=>'0']);
                $diagnostic = Diagnostic::create([
                    'ids' => Carbon::now()->timestamp,
                    'reference' => 'DIAG-' . Carbon::now()->timestamp,
                    'state_id' => $request->state,
                    'type' => $request->service,
                    'user_id' => Auth::user()->id,
                ]);
                $before_works = Before_work::create([
                    'ids' => Carbon::now()->timestamp,
                    'distance' => $request->distance,
                    'place' => $request->place,
                    'description' => $request->description,
                    'employee_id' => $request->tester,
                    'diagnostic_id' => $diagnostic->id,
                    'user_id' => Auth::user()->id,
                    'site_id' => Auth::user()->id,
                ]);
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
                return response()->json(['id' => $request->state, 'ot' => $diagnostic->state->reference,
                    'matriculation' => $diagnostic->state->bus->matriculation]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $state = State::findOrFail($id);
            return response()->json(['matriculation' => $state->bus->matriculation, 'ot' => $state->reference,
                'bus' => $state->bus->model->brand->name . ' ' . $state->bus->model->name,
                'incident' => $state->incident, 'remark' => $state->remark, 'depart' => $state->kilometer]);
        } else {
            return view('errors.500');
        }
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

<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Demand_piece;
use App\Service_description;
use App\Repairdescription;
use App\Diagnostic;
use App\Diagnostic_employee;
use App\Employee;
use App\Repair;
use App\service_employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Employee::where('post_id', '1')->get();
        $diagnostics = Diagnostic::where('type', '1')->where('active', '1')
            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
        $active = '';
        if ($diagnostics->count() == '0') {
            $active = '0';
        }
        $repairs = Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();
        return view('repair.home', ['diagnostics' => $diagnostics, 'technicians' => $technicians,
            'repairs' => $repairs, 'active' => $active]);
    }

    public function create()
    {
        //
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

                return response()->json(['id' => $repair->id, 'matriculation' => $repair->diagnostic->state->bus->matriculation,
                    'chassis' => $repair->diagnostic->state->bus->chassis, 'date' => $repair->created_at->format('d/m/Y'),
                    'bus' => $repair->diagnostic->state->bus->model->brand->name . " " . $repair->diagnostic->state->bus->model->name,
                    'reference' => $repair->diagnostic->state->reference,
                    'count' => $repair->where('state','1')->orWhere('state','2')->orWhere('state','4')->count('id'),
                    'diagnostic' => $request->diagnostic]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id == "0") {
                $diagnostics = Diagnostic::where('type', '1')->where('active', '1')
                    ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                return response()->json($diagnostics);
            } else {
                $repair = Repair::findOrFail($id);
                $employees = Employee::where('post_id', '1')->get();
                return view('repair.partials.repair', ['repair' => $repair, 'employees' => $employees]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $demands = Demand::where('diagnostic_id', $id)->get();
            foreach ($demands as $demand) {
                $pieces [] = Demand_piece::where('demand_id', $demand->id)->get();
            }
            return response()->json($pieces);
        } else {
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
        } else {
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

    public
    function destroy($id)
    {
        //
    }
}

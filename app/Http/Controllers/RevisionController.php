<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Demand_piece;
use App\Diagnostic;
use App\Employee;
use App\Revision;
use App\Service_description;
use App\Service_employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class RevisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Employee::where('post_id', '1')->get();
        $diagnostics = Diagnostic::where('type', '2')->where('active', '1')
            ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
        $active = '';
        if ($diagnostics->count() == '0') {
            $active = '0';
        }
        $revisions = Revision::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->get();
        return view('revision.home', ['diagnostics' => $diagnostics, 'technicians' => $technicians,
            'revisions' => $revisions, 'active' => $active]);
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
                $revision = Revision::create([
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

                return response()->json(['id' => $revision->id, 'matriculation' => $revision->diagnostic->state->bus->matriculation,
                    'chassis' => $revision->diagnostic->state->bus->chassis, 'date' => $revision->created_at->format('d/m/Y'),
                    'bus' => $revision->diagnostic->state->bus->model->brand->name . " " . $revision->diagnostic->state->bus->model->name,
                    'reference' => $revision->diagnostic->state->reference,
                    'count' => $revision->where('state','1')->orWhere('state','2')->orWhere('state','4')->count('id'),
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
                $diagnostics = Diagnostic::with('state')->where('type', '2')->where('active', '1')
                    ->orWhere('active','2')->orderBy('updated_at', 'desc')->get();
                return response()->json($diagnostics);
            } else {
                $revision = Revision::findOrFail($id);
                $employees = Employee::where('post_id', '1')->get();
                return view('revision.partials.revision', ['revision' => $revision, 'employees' => $employees]);
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
                $diagnostic = Revision::findOrFail($id)->diagnostic_id;
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
                    $revision = Revision::findOrFail($id)->update(['state' => '3']);
                    $finish = '1';
                }
                return response()->json(['id' => $id, 'reference' => $request->reference, 'finish' => $finish]);
            }
        } else {
            return view('errors.500');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

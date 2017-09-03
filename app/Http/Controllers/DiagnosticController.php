<?php

namespace App\Http\Controllers;

use App\Before_work;
use App\Diagnostic;
use App\Diagnostic_employee;
use App\Diagnostic_piece;
use App\Employee;
use App\Process;
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
        $processes = Process::where('type', '1')->orderBy('created_at', 'desc')->get();
        return view('diagnostic.home', ['processes' => $processes, 'technicians' => $technicians]);
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
            $rules = array(
                'process' => 'bail|required|min:1',
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
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $diagnostic = Diagnostic::create([
                    'ids' => Carbon::now()->timestamp,
                    'reference' => 'diag|' . Carbon::now()->timestamp,
                    'process_id' => $request->process,
                    'user_id' => Auth::user()->id,
                ]);
                $before_works = Before_work::create([
                    'ids' => Carbon::now()->timestamp,
                    'distance' => $request->distance,
                    'place' => $request->place,
                    'description' => $request->description,
                    'employee_id' => $request->tester,
                    'diagnostic_id' => $diagnostic->id,
                ]);

                for ($i = 0; $i < count($request->technician); $i++) {
                    $diagnostic_employee = Diagnostic_employee::create([
                        'diagnostic_id' => $diagnostic->id,
                        'employee_id' => $request->technician[$i],
                        'title' => $request->title[$i],
                        'description' => $request->description[$i],
                    ]);
                }
                for ($i = 0; $i < count($request->piece); $i++) {
                    $diagnostic_piece = Diagnostic_piece::create([
                        'diagnostic_id' => $diagnostic->id,
                        'piece' => $request->piece[$i],
                        'quantity' => $request->quantity[$i],
                    ]);
                }
                $process = Process::findOrFail($request->process)->update(['type' => $request->service]);
                $process = Process::findOrFail($request->process);
                return response()->json(['id' => $process->id, 'ot' => $process->reference,
                    'matriculation' => $process->state->bus->matriculation]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $processes = Process::where('type', '1')->orderBy('created_at', 'desc')->get();
            return view('diagnostic.includes.home', ['processes' => $processes]);
        } else {
            return view('errors.500');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $process = Process::findOrFail($id);
            return response()->json(['matriculation' => $process->state->bus->matriculation, 'ot' => $process->reference,
                'bus' => $process->state->bus->model->brand->name . ' ' . $process->state->bus->model->name,
                'incident' => $process->state->incident, 'remark' => $process->state->remark, 'depart' => $process->state->kilometer]);
        } else {
            return view('errors.500');
        }
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

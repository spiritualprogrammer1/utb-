<?php

namespace App\Http\Controllers;

use App\After_work;
use App\Work;
use App\Employee;
use App\Repair;
use App\Service_description;
use App\Revision;
use App\Visit_technique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AfterWorksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Employee::where('post_id', '1')->get();
        $repairs = Repair::where('state', '3')->get();
        return view('afterworks.home', ['repairs' => $repairs, 'technicians' => $technicians]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $descriptions = Repair::findOrFail($id)->diagnostic->service_description;
            return response()->json($descriptions);
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
        //if ($request->ajax()) {
        $messages = array(
            'tester.required' => "Le choix du technicien de l'essai est obligatoire",
            'service.required' => "Choisissez une Prestation SVP!",
            'valid.required' => "La Decision est obligatoire",
            //'description.required' => "La Remarque est obligatoire",
        );
        $rules = array(
            'tester' => 'bail|required|min:1',
            'distance' => 'bail|required|min:1',
            'place' => 'bail|required|min:3',
            'valid' => 'bail|required|min:1',
            //'description' => 'bail|required|min:3|max:10000',
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
            $repair = Repair::findOrFail($id);
            $diagnostic = $repair->diagnostic;
            if ($request->has('repair')) {
                $repair = Repair::findOrFail($id)->update(['state' => $request->valid]);
            }
            $works = Work::create([
                'ids' => Carbon::now()->timestamp,
                'type' => '2',
                'state' => $request->valid,
                'distance' => $request->distance,
                'place' => $request->place,
                'description' => $request->description,
                'employee_id' => $request->tester,
                'diagnostic_id' => $diagnostic->id,
                'user_id' => Auth::user()->id,
                'site_id' => Auth::user()->id,
            ]);
            return response()->json(['id' => $id, 'reference' => $diagnostic->state->reference]);
        }
        /*} else {
            return view('errors.500');
        }*/
    }

    public function destroy($id)
    {
        //
    }
}

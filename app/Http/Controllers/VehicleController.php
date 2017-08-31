<?php

namespace App\Http\Controllers;

use App\Assurance;
use App\Brand;
use App\Bus;
use App\Models;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Validator;

class VehicleController extends Controller
{
    public function __construct()
    {
        Date::setLocale('fr');
        $this->middleware('auth');
    }

    public function index()
    {
        $brands = Brand::select('id', 'name')->orderBy('updated_at', 'desc')->get();
        $buses = Bus::all()->sortByDesc('created_at');
        return view('vehicle.home', ['brands' => $brands, 'buses' => $buses]);
    }

    public function create()
    {
        $brands = Brand::select('id', 'name')->orderBy('updated_at', 'desc')->get();
        $buses = Bus::all()->sortByDesc('created_at');
        return view('vehicle.create', ['brands' => $brands, 'buses' => $buses]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
                'matriculation.required' => "L'Immatriculation du bus est obligatoire",
                'chassis.required' => "Le Chassis du bus est obligatoire",
                'model.required' => "Le Model du bus est obligatoire",
                'first_circulation.required' => "La Date de la premiere mise en circulation du bus est obligatoire",
                'assurance.required' => "La date d'expiration de l'Assurance est obligatoire",
                'visit.required' => "La date d'expiration de la Visite Technique est obligatoire",
            );
            $rules = array(
                'designation' => 'bail|required|min:3|max:255',
                'matriculation' => 'bail|required|min:2|max:255|unique:buses',
                'chassis' => 'bail|required|min:1|max:255|unique:buses',
                'model' => 'bail|required|min:1|max:255',
                'first_circulation' => 'bail|required|min:1|max:255',
                'assurance' => 'bail|required|min:1|max:255',
                'visit' => 'bail|required|min:1|max:255',
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
                $assurance = Assurance::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->assurance,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                $visit = Visit::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->visit,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                $bus = Bus::create([
                    'ids' => Carbon::now()->timestamp,
                    'designation' => $request->designation,
                    'matriculation' => $request->matriculation,
                    'chassis' => $request->chassis,
                    'first_circulation' => $request->first_circulation,
                    'assurance_id' => $assurance->id,
                    'visit_id' => $visit->id,
                    'model_id' => $request->model,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                return response()->json(['id' => $bus->id, 'matriculation' => $bus->matriculation, 'chassis' => $bus->chassis, 'brand' => $bus->model->brand->name,
                    'model' => $bus->model->name, 'date' => $bus->created_at->format('d/m/Y')]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $models[] = Models::where('brand_id', $id)->first();
            foreach ($models as $key => $model) {
                $buses = Bus::where('model_id', $model->id)->orderBy('updated_at', 'desc')->get();
            }
            return view('vehicle.includes.home', ['buses' => $buses]);
        } else {
            return view('errors.500');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $bus = Bus::findOrFail($id);
            return response()->json(['designation' => $bus->designation, 'matriculation' => $bus->matriculation,
                'chassis' => $bus->chassis, 'circulation' => Date::parse($bus->first_circulation)->format('j M Y'), 'assurance' => $bus->assurance->date,
                'visit' => $bus->visit->date, 'model' => $bus->model_id, 'brand' => $bus->model->brand->id]);
        } else {
            return view('errors.500');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $messages = array(
                'matriculation.required' => "L'Immatriculation du bus est obligatoire",
                'chassis.required' => "Le Chassis du bus est obligatoire",
                'model.required' => "Le Model du bus est obligatoire",
                //'first_circulation.required' => "La Date de la premiere mise en circulation du bus est obligatoire",
            );
            $rules = array(
                'designation' => 'bail|required|min:3|max:255',
                'matriculation' => 'bail|required|min:2|max:255',
                'chassis' => 'bail|required|min:1|max:255',
                'model' => 'bail|required|min:1|max:255',
                //'first_circulation' => 'bail|required|min:1|max:255',
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
                $bus = Bus::findOrFail($id)->update([
                    'designation' => $request->designation,
                    'matriculation' => $request->matriculation,
                    'chassis' => $request->chassis,
                    //'first_circulation' => $request->first_circulation,
                    'model_id' => $request->model,
                    'user_id' => Auth::user()->id,
                ]);
                $bus = Bus::findOrFail($id);
                return response()->json(['id' => $bus->id, 'matriculation' => $bus->matriculation, 'chassis' => $bus->chassis, 'brand' => $bus->model->brand->name,
                    'model' => $bus->model->name, 'date' => $bus->created_at->format('d/m/Y')]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function destroy($id)
    {
        //
    }

    public function models(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id == '0') {
                $buses = Bus::all()->sortByDesc('updated_at');
                return view('vehicle.includes.home', ['buses' => $buses]);
            } else {
                $models = Models::where('brand_id', $id)->get();
                return response($models);
            }
        } else {
            return view('errors.500');
        }
    }
}

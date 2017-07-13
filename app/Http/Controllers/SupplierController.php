<?php

namespace App\Http\Controllers;

use App\Country;
use App\Supplier;
use Validator;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:stock');
    }

    public function index()
    {
        $countries = Country::all();
        $suppliers = Supplier::with('country')->get();
        return view('supplier.home', compact('countries', 'suppliers'));
    }

    public function create()
    {
        $countries = Country::all();
        $suppliers = Supplier::with('country')->get();
        return view('supplier.create', compact('countries', 'suppliers'));
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
                'name.required' => "Le nom ou raison social est requis",
                'email.required' => "L'adresse email est obligatoire",
                'mobile.required' => "Le numero mobile est obligatoire",
                'indicatif.required' => "L'indicatif est obligatoire",
                'mobile.unique' => "La valeur du champ Mobile est déjà utilisée.",
            );
            $rules = array(
                'name' => 'bail|required|min:3|max:255',
                'email' => 'bail|required|max:255|unique:suppliers',
                'mobile' => 'bail|required|min:8|max:255|unique:suppliers',
                'phone' => 'unique:suppliers',
                'indicatif' => 'bail|required|min:1|max:255',
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
                $supplier = Supplier::create([
                    'name' => $request->name,
                    'rccm' => $request->rccm,
                    'phone' => $request->phone,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'type' => $request->type,
                    'country_id' => $request->country,
                ]);

                return response()->json(['id' => $supplier->id, 'name' => $supplier->name, 'email' => $supplier->email, 'country' => $supplier->country->nicename,
                    'mobile' => "+" . $supplier->country->phonecode . " " . $supplier->mobile, 'phone' => "+" . $supplier->country->phonecode . " " . $supplier->phone,]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $messages = array(
                'name.required' => "Le nom du fournisseur est requis",
                'email.required' => "L'adresse email du fournisseur est obligatoire",
                'mobile.required' => 'Le numéro mobile est obligatoire',
            );
            $rules = array(
                'name' => 'bail|required|min:3|max:255',
                'email' => 'bail|required|min:8',
                'mobile' => 'bail|required|min:3',
                'indicatif' => 'bail|required|min:1|max:255',
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
                $supplier = Supplier::find($request->supplier_id);
                $supplier->name = strtolower($request->name);
                $supplier->rccm = strtolower($request->rccm);
                $supplier->phone = strtolower($request->phone);
                $supplier->mobile = strtolower($request->mobile);
                $supplier->email = strtolower($request->email);
                $supplier->address = strtolower($request->address);
                $supplier->type = strtolower($request->type);
                $supplier->country_id = $request->country;
                $supplier->save();

                return response()->json(['id' => $supplier->id, 'name' => $supplier->name, 'email' => $supplier->email, 'country' => $supplier->country->nicename,
                    'mobile' => "+" . $supplier->country->phonecode . " " . $supplier->mobile, 'phone' => "+" . $supplier->country->phonecode . " " . $supplier->phone]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->ajax()) {
            $supplier = Supplier::findOrFail($id);
            return response()->json(['name' => $supplier->name, 'type' => $supplier->type, 'email' => $supplier->email,
                'phone' => $supplier->country->phonecode . " " . $supplier->phone
                , 'mobile' => $supplier->country->phonecode . " " . $supplier->mobile, 'rccm' => $supplier->rccm,
                'address' => $supplier->address]);
        } else {
            return view('errors.500');
        }
    }

    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $supplier = Supplier::findOrFail($id);
            return response()->json($supplier);
        } else {
            return view('errors.500');
        }
    }

    public function listing(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id == 0) {
                $suppliers = Supplier::select('id', 'name')->where('type', $id)->get();
                return response()->json($suppliers);
            } elseif ($id == 1) {
                $suppliers = Supplier::select('id', 'name')->where('type', $id)->get();
                return response()->json($suppliers);
            } else {
                $suppliers = Supplier::select('id', 'name')->get();
                return response()->json($suppliers);
            }
        } else {
            return view('errors.500');
        }
    }

    public function phonecode(Request $request, $id)
    {
        if ($request->ajax()) {
            $country = Country::findOrFail($id);
            return response()->json($country);
        } else {
            return view('errors.500');
        }
    }

    public function score(Request $request){
      if ($request->ajax()) {
            $count = Supplier::count();
            return response()->json($count);
        } else {
            return view('errors.500');
        }
    }

    public function destroy($id)
    {

    }
}

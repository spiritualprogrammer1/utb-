<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Diagnostic;
use App\Demand_piece;
use Illuminate\Http\Request;
use Validator;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function create()
    {
        $demands = Demand::where('state', '0')->orderBy('created_at', 'desc')->get();
        return view('approval.piece', ['demands' => $demands]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $id)
    {
        if ($id == "waiting") {
            $demands = Demand::where('state', '0')->orderBy('created_at', 'desc')->get();
            return view('approval.includes.piece', ['demands' => $demands])->with(['id' => $id]);
        } elseif ($id == "validated") {
            $demands = Demand::where('state', '1')->orWhere('state', '2')->orWhere('state', '3')->orderBy('created_at', 'desc')->get();
            return view('approval.includes.piece', ['demands' => $demands])->with(['id' => $id]);
        } else {
            $pieces = Demand_piece::where('demand_id', $id)->get();
            return response()->json($pieces);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
       if ($request->ajax()){
           if ($request->has('piece')){
               $messages = array(
                   'piece.required' => "Les information de la Pièce à ajouter sont obligatoire",
                   'quantity.required' => "La Quantité est obligatoire",
               );
               $rules = array(
                   'piece' => 'bail|required|min:1',
                   'quantity' => 'bail|required|min:1',
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
                   $demand = Demand::findOrFail($id)->update(['state' => '1']);
                   for ($i = 0; $i < count($request->piece); $i++) {
                       $demand_piece = Demand_piece::create([
                           'demand_id' => $id,
                           'piece' => $request->piece[$i],
                           'quantity' => $request->quantity[$i],
                       ]);
                   }
               }
           }else{
               $demand = Demand::findOrFail($id)->update(['state' => '1']);
           }
           return response()->json(['id' => $id, 'reference' => $request->reference]);
       }else{
           return view('errors.500');
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

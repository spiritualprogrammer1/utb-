<?php

namespace App\Http\Controllers;

use App\Approval;
use App\Demand;
use App\Diagnostic;
use App\Demand_piece;
use App\Repair;
use App\Revision;
use App\Service_description;
use App\Visit_technique;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $repairs = Repair::where('state', '5')->orderBy('updated_at', 'desc')->get();
        return view('approval.home', ['repairs' => $repairs]);
    }

    public function create()
    {
        $demands = Demand::where('state', '0')->orderBy('created_at', 'desc')->get();
        return view('approval.piece', ['demands' => $demands]);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array();
            $rules = array(
                //'diagnostic' => 'bail|required|min:1|max:255',
                'id' => 'bail|required|min:1|max:255|',
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
                if ($request->has('repair')) {
                    $repair = Repair::findOrFail($request->id)->update(['state' => '0']);
                    $diagnostic = Repair::findOrFail($request->id)->diagnostic_id;
                }elseif ($request->has('revision')){
                    $revision = Revision::findOrFail($request->id)->update(['state' => '0']);
                    $diagnostic = Revision::findOrFail($request->id)->diagnostic_id;
                }else{
                    $visit = Visit_technique::findOrFail($request->id)->update(['state' => '0']);
                    $diagnostic = Visit_technique::findOrFail($request->id)->diagnostic_id;
                }

                $approval = Approval::create([
                    'ids' => Carbon::now()->timestamp,
                    'remark' => $request->remark,
                    'diagnostic_id' => $diagnostic,
                    'user_id' => Auth::user()->id,
                    'site_id' => Auth::user()->id,
                ]);
            }
            return response()->json(['id' => $request->id, 'reference' => $approval->diagnostic->state->reference]);
        } else {
            return view('errors.500');
        }

    }

    public
    function show(Request $request, $id)
    {
        if ($id == "waiting") {
            $demands = Demand::where('state', '0')->orderBy('created_at', 'desc')->get();
            return view('approval.includes.piece', ['demands' => $demands])->with(['id' => $id]);
        } elseif ($id == "validated") {
            $demands = Demand::where('state', '1')->orWhere('state', '2')->orWhere('state', '3')->orderBy('created_at', 'desc')->get();
            return view('approval.includes.piece', ['demands' => $demands])->with(['id' => $id]);
        } elseif ($id == "revision") {
            $revisions = Revision::where('state', '5')->orderBy('updated_at', 'desc')->get();
            return view('approval.includes.revision', ['revisions' => $revisions]);
        } elseif ($id == "repair") {
            $repairs = Repair::where('state', '5')->orderBy('updated_at', 'desc')->get();
            return view('approval.includes.repair', ['repairs' => $repairs]);
        } elseif ($id == "visit") {
            $visits = Visit_technique::where('state', '5')->orderBy('updated_at', 'desc')->get();
            return view('approval.includes.visit', ['visits' => $visits]);
        } else {
            $pieces = Demand_piece::where('demand_id', $id)->get();
            return response()->json($pieces);
        }
    }

    public function descriptions(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == 'repair') {
                $descriptions = Repair::findOrFail($id)->diagnostic->service_description->sortByDesc('created_at');
                return response()->json($descriptions);
            } elseif ($type == 'revision') {
                $descriptions = Revision::findOrFail($id)->diagnostic->service_description->sortByDesc('created_at');
                return response()->json($descriptions);
            } else {
                $descriptions = Visit_technique::findOrFail($id)->diagnostic->service_description->sortByDesc('created_at');
                return response()->json($descriptions);
            }
        } else {
            return view('errors.500');
        }
    }

    public
    function edit($id)
    {
        //
    }

    public
    function update(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->has('piece')) {
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
            } else {
                $demand = Demand::findOrFail($id)->update(['state' => '1']);
            }
            return response()->json(['id' => $id, 'reference' => $request->reference]);
        } else {
            return view('errors.500');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}

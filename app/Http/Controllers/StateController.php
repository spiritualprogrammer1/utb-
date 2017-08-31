<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Field;
use App\Field_state;
use App\Process;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Date\Date;
use Validator;

class StateController extends Controller
{
    public function __construct()
    {
        Date::setLocale('fr');
        $this->middleware('auth');
    }

    public function index()
    {
        $buses = Bus::all();
        $fields = Field::select('id', 'name')->where('type', '0')->get();
        $trims = Field::select('id', 'name')->where('type', '1')->get();
        $fuels = Field::select('id', 'name')->where('type', '2')->get();
        return view('state.home', ['buses' => $buses, 'fields' => $fields, 'trims' => $trims, 'fuels' => $fuels]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $messages = array(
                'bus.required' => "Choisissez un Car SVP",
                'incident.required' => "La description de l'incident est obligatoire",
                'remark.required' => "Les remarques eventuelles sont obligatoire",
                'kilometer.required' => "Entrez le kilometre",
                'fuel.required' => "Choisissez le niveau d'essence",
            );
            $rules = array(
                'bus' => 'bail|required|min:1|max:255',
                'incident' => 'bail|required|min:6',
                'remark' => 'bail|required|min:6',
                'kilometer' => 'bail|required|min:2|max:255|',
                'fuel' => 'bail|required|min:1|max:255|',
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
                $state = State::create([
                    'ids' => Carbon::now()->timestamp,
                    'bus_id' => $request->bus,
                    'incident' => $request->incident,
                    'remark' => $request->remark,
                    'kilometer' => $request->kilometer,
                    'type' => '1',
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                $process = Process::create([
                    'ids' => Carbon::now()->timestamp,
                    'reference' => 'ot-' . Carbon::now()->timestamp,
                    'state_id' => $state->id,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                for ($i = 0; $i < count($request->field); $i++) {
                    $field = Field_state::create([
                        'state_id' => $state->id,
                        'field_id' => $request->field[$i],
                    ]);
                }
                for ($i = 0; $i < count($request->trim); $i++) {
                    $field = Field_state::create([
                        'state_id' => $state->id,
                        'field_id' => $request->trim[$i],
                    ]);
                }
                return response()->json(['id' => $state->id, 'matriculation' => $state->bus->matriculation]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
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

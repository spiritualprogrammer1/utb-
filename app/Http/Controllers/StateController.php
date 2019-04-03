<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Field;
use App\Field_state;
use App\Picture;
use App\Process;
use App\State;
use App\Vehicle;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
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
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $buses = Bus::where('site_id',$site_id)->get();
            }
            else{
                $buses = Bus::all();
            }
        }
        else{

            $buses = Bus::where('site_id',$site_id)->get();
        }

        $fields = Field::select('id', 'name')->where('type', '0')->get();
        $trims = Field::select('id', 'name')->where('type', '1')->get();
        $fuels = Field::select('id', 'name')->where('type', '2')->get();


        return view('state.home', ['buses' => $buses, 'fields' => $fields, 'trims' => $trims, 'fuels' => $fuels]);
    }

    public function create()
    {
        //
    }

    public function data_car(Request $request,$id)
    {
        if($request->ajax())
        {
            $car= Bus::findOrFail($id);
            $state=$car->state->last();

            if($state->state_kilometer==1)
            {

                $kilometer_engine = $state->kilometer_engine;
            }
            else{
                $kilometer_engine= null;
            }



            return   response()->json(['state_id'=>$state->id,'kilometer_engine'=>$kilometer_engine]);

        }

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
              //  'kilometer_engine.required'=> "Entrez le kilometrage moteur",
            );
            $rules = array(
                'bus' => 'bail|required|min:1|max:255',
                'incident' => 'bail|required|min:6',
                'remark' => 'bail|required|min:6',
                'kilometer' => 'bail|required|',
                'fuel' => 'bail|required|min:1|max:255|',
               // 'kilometer_engine'=>'bail|required|'
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            }
            else {


                if($request->has('accident'))
                {
                    if($request->has("panne_gar")){
                        $request->panne_gar=1;
                    }
                    else{
                        $request->panne_gar=0;
                    }

                    $state = State::create([
                        'ids' => uniqid(),
                        'reference' => "OT-".uniqid(),
                        'bus_id' => $request->bus,
                        'incident' => $request->incident,
                        'remark' => $request->remark,
                        'kilometer' => $request->kilometer,
                       // 'kilometer_engine'=> $request->kilometer_engine,
                        'state' => '1',
                        'site_id' => '1',
                        'user_id' => Auth::user()->id,
                        'panne_gar'=>$request->panne_gar,
                        'accident'=>1,
                        'description_accident'=>$request->description_accident,
                        'lieu'=>$request->lieu,
                        'date_accident'=>$request->date_accident,
                        'driver_name'=>$request->driver_name,


                    ]);

                    if($request->hasFile('image_voi')) {
                        $image = $request->file('image_voi');

                        foreach ($image as $imag) {
                            $input['imagename'] = uniqid().'.'. $imag->getClientOriginalExtension();
                            $destinationPath = public_path('/picture');
                            $imag->move($destinationPath, $input['imagename']);

                            $imagee = Picture::create([
                                'name' => $input['imagename'],
                                'state_id'=>$state->id,
                            ]);
                        }
                    }


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
                    for ($i = 0; $i < count($request->fuel); $i++) {
                        $field = Field_state::create([
                            'state_id' => $state->id,
                            'field_id' => $request->fuel[$i],
                        ]);
                    }
                }
                else{

                    if($request->has("panne_gar")){
                        $request->panne_gar=1;
                    }
                    else{
                        $request->panne_gar=0;
                    }


                    $state = State::create([
                        'ids' => uniqid(),
                        'reference' => "OT-".uniqid(),
                        'bus_id' => $request->bus,
                        'incident' => $request->incident,
                        'remark' => $request->remark,
                        'kilometer' => $request->kilometer,
                       // 'kilometer_engine'=> $request->kilometer_engine,
                        'state' => '1',
                        'site_id' => '1',
                        'accident'=>0,
                        'panne_gar'=>$request->panne_gar,
                        'user_id' => Auth::user()->id,

                    ]);

                    if($request->hasFile('image_voi')) {
                        $image = $request->file('image_voi');

                        foreach ($image as $imag) {
                            $input['imagename'] = uniqid().'.'. $imag->getClientOriginalExtension();
                            $destinationPath = public_path('/picture');
                            $imag->move($destinationPath, $input['imagename']);

                            $imagee = Picture::create([
                                'name' => $input['imagename'],
                                'state_id'=>$state->id,
                            ]);
                        }
                    }


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
                    for ($i = 0; $i < count($request->fuel); $i++) {
                        $field = Field_state::create([
                            'state_id' => $state->id,
                            'field_id' => $request->fuel[$i],
                        ]);
                    }


                }

                return response()->json(['id' => $state->id, 'matriculation' => $state->bus->matriculation]);
            }
        } else {
            return view('errors.500');
        }
    }
public function filestate(Request $request,$id)
{
if($request->ajax())
{
    //$process=State::findOrFail($request->id);
    $id=Input::get('id');
     $fields=Field::all();

    $states=State::find($request->id);

    $bus = $states->bus_id;
    $bus = Bus::find($bus);

    $model = $bus->model->name;
    $marque = $bus->model->brand->name;



    $compteur=Bus::join('states','states.bus_id','=','buses.id')
        ->get();


    $opera= DB::table('fields')
        ->join('field_states','field_states.field_id','=','fields.id')
        ->join('states','states.id','=','field_states.state_id')
        ->select('fields.name as libellee','fields.id as idd')
        ->where('field_states.state_id',$states->id)
        ->distinct()
        ->get();


    return view('state.file.file_state',compact('states','bus','model','marque','fields','process','opera','compteur'));

}
}

    public function score()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $site =Auth::user()->employee->site_id;
                $diagnostic = State::where('state', '1')->count();
            }
            else{

                $diagnostic = State::count();
            }
        }
        else{
            $site =Auth::user()->employee->site_id;
            $diagnostic = State::where('state', '1')->count();

        }
        return response()->json($diagnostic);
    }

    public function stateFile()
    {

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

    public function test_essai()
    {
        $state_kilometer = State::where("kilometer",'=','100000')->count();
        return view('state.essai',compact('state_kilometer'));
    }
}

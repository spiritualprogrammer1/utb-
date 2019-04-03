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
use Illuminate\Support\Facades\DB;
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
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('created_at');

            }
            else{
                $buses = Bus::all()->sortByDesc('created_at');

            }
        }
        else{

            $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('created_at');

        }
        $brands = Brand::select('id', 'name')->orderBy('updated_at', 'desc')->get();

        return view('vehicle.home', ['brands' => $brands, 'buses' => $buses]);
    }

    public function score()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $totalbus=Bus::where('site_id',$site_id)->count();


                $datee=new Date();
                $dated= $datee->format('Y-m-d');
                $startdate= $datee->format('Y-m-d 00:00:00');
                $enddate= $datee->format('Y-m-d 23:59:59');
                $busess =DB::table('buses')->where('site_id',$site_id)->get();
                $num_visite_expiration=0;
                $visit_expiration=[];
                $assuran=[];
                foreach ($busess as $bu)
                {
                    $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $datevisit=date('Y-m-d', strtotime($visits['date']));
                    $dateinsurance = explode("-"  , $datevisit);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $visit_expiration[$num_visite_expiration]=$bu;
                        $num_visite_expiration+=1;
                    }
                }



                /***/
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $buss =DB::table('buses')->where('site_id',$site_id)->get();
                $num_insurance_expiration=0;
                $insurance_expiration=[];

                $assuran=[];
                foreach ($buss as $bu)
                {
                    $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                    $dateinsurance = explode("-"  , $dateinsur);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $insurance_expiration[$num_insurance_expiration]=$bu;
                        $num_insurance_expiration+=1;
                    }
                }


            }
            else{


                $totalbus=Bus::count();


                $datee=new Date();
                $dated= $datee->format('Y-m-d');
                $startdate= $datee->format('Y-m-d 00:00:00');
                $enddate= $datee->format('Y-m-d 23:59:59');
                $busess =DB::table('buses')->get();
                $num_visite_expiration=0;
                $visit_expiration=[];
                $assuran=[];
                foreach ($busess as $bu)
                {
                    $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $datevisit=date('Y-m-d', strtotime($visits['date']));
                    $dateinsurance = explode("-"  , $datevisit);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $visit_expiration[$num_visite_expiration]=$bu;
                        $num_visite_expiration+=1;
                    }
                }



                /***/
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $buss =DB::table('buses')->get();
                $num_insurance_expiration=0;
                $insurance_expiration=[];

                $assuran=[];
                foreach ($buss as $bu)
                {
                    $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                    $dateinsurance = explode("-"  , $dateinsur);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $insurance_expiration[$num_insurance_expiration]=$bu;
                        $num_insurance_expiration+=1;
                    }
                }

            }
        }
        else{


            $totalbus=Bus::where('site_id',$site_id)->count();


            $datee=new Date();
            $dated= $datee->format('Y-m-d');
            $startdate= $datee->format('Y-m-d 00:00:00');
            $enddate= $datee->format('Y-m-d 23:59:59');
            $busess =DB::table('buses')->where('site_id',$site_id)->get();
            $num_visite_expiration=0;
            $visit_expiration=[];
            $assuran=[];
            foreach ($busess as $bu)
            {
                $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                $datevisit=date('Y-m-d', strtotime($visits['date']));
                $dateinsurance = explode("-"  , $datevisit);
                $datnow = explode("-"  , $dated);
                $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                $nbredays=($diffe/86400);

                if($nbredays<=60  and $nbredays>=0)
                {
                    $visit_expiration[$num_visite_expiration]=$bu;
                    $num_visite_expiration+=1;
                }
            }



            /***/
            $date=new Date();
            $dated=$date->format('Y-m-d');
            $startdate= $date->format('Y-m-d 00:00:00');
            $enddate= $date->format('Y-m-d 23:59:59');
            $buss =DB::table('buses')->where('site_id',$site_id)->get();
            $num_insurance_expiration=0;
            $insurance_expiration=[];

            $assuran=[];
            foreach ($buss as $bu)
            {
                $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                $dateinsurance = explode("-"  , $dateinsur);
                $datnow = explode("-"  , $dated);
                $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                $nbredays=($diffe/86400);

                if($nbredays<=60  and $nbredays>=0)
                {
                    $insurance_expiration[$num_insurance_expiration]=$bu;
                    $num_insurance_expiration+=1;
                }
            }

        }





        return response()->json(['totalbus'=>$totalbus,'totalvisitexip'=>$num_visite_expiration,'totassurance'=>$num_insurance_expiration]);
    }



    public function create()
    {
        $brands = Brand::select('id', 'name')->orderBy('updated_at', 'desc')->get();

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('created_at');

            }
            else{
                $buses = Bus::all()->sortByDesc('created_at');

            }
        }
        else{
            $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('created_at');

        }
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


                $bus = Bus::create([
                    'ids' => Carbon::now()->timestamp,
                    'designation' => $request->designation,
                    'matriculation' => $request->matriculation,
                    'chassis' => $request->chassis,
                    'first_circulation' => $request->first_circulation,
                    'model_id' => $request->model,
                    'societe'=> $request->societe,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                ]);
                $assurance = Assurance::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->assurance,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                    'bus_id'=> $bus->id
                ]);
                $visit = Visit::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->visit,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                    'bus_id'=> $bus->id
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
                'societe'=>$bus->societe,'chassis' => $bus->chassis, 'circulation' => Date::parse($bus->first_circulation)->format('j M Y'),
                 'model' => $bus->model_id, 'brand' => $bus->model->brand->id]);
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
                    'societe'=> $request->societe,
                    'user_id' => Auth::user()->id,
                ]);
                $bus = Bus::findOrFail($id);
                $assurance = Assurance::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->assurance,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                    'bus_id'=> $bus->id
                ]);
                $visit = Visit::create([
                    'ids' => Carbon::now()->timestamp,
                    'date' => $request->visit,
                    'site_id' => '1',
                    'user_id' => Auth::user()->id,
                    'bus_id'=> $bus->id
                ]);
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
                $site_id=Auth::user()->employee->site_id;
                if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                    if (Auth::user()->employee->action_site == 2) {
                        $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('updated_at');

                    }
                    else{
                        $buses = Bus::all()->sortByDesc('updated_at');

                    }
                }else{
                    $buses = Bus::where('site_id',$site_id)->get()->sortByDesc('updated_at');

                }
                return view('vehicle.includes.home', ['buses' => $buses]);
            } else {
                $models = Models::where('brand_id', $id)->get();
                return response($models);
            }
        } else {
            return view('errors.500');
        }
    }

    /**********expiration assurance*********/

    public function assurance_expire()
    {


        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $bus =Bus::where('site_id',$site_id)->get();
                $num_insurance_expiration=0;
                $insurance_expiration=[];
                $assuran=[];
                foreach ($bus as $bu)
                {
                    $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                    $dateinsurance = explode("-"  , $dateinsur);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $insurance_expiration[$num_insurance_expiration]=$bu;
                        $num_insurance_expiration+=1;
                    }
                }

            }
            else{
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $bus =Bus::all();
                $num_insurance_expiration=0;
                $insurance_expiration=[];
                $assuran=[];
                foreach ($bus as $bu)
                {
                    $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                    $dateinsurance = explode("-"  , $dateinsur);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $insurance_expiration[$num_insurance_expiration]=$bu;
                        $num_insurance_expiration+=1;
                    }
                }
            }
        }
        else{
            $date=new Date();
            $dated=$date->format('Y-m-d');
            $startdate= $date->format('Y-m-d 00:00:00');
            $enddate= $date->format('Y-m-d 23:59:59');
            $bus =Bus::where('site_id',$site_id)->get();
            $num_insurance_expiration=0;
            $insurance_expiration=[];
            $assuran=[];
            foreach ($bus as $bu)
            {
                $assuran=Assurance::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                $dateinsur=date('Y-m-d', strtotime($assuran['date']));
                $dateinsurance = explode("-"  , $dateinsur);
                $datnow = explode("-"  , $dated);
                $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                $nbredays=($diffe/86400);

                if($nbredays<=60  and $nbredays>=0)
                {
                    $insurance_expiration[$num_insurance_expiration]=$bu;
                    $num_insurance_expiration+=1;
                }
            }
        }




            return view('assurances.assurance_expired',compact('bus','assuran','insurance_expiration'));
    }

    public function viste_expire()
    {

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $bus =Bus::where('site_id',$site_id)->get();
                $num_visite_expiration=0;
                $visit_expiration=[];
                $assuran=[];
                foreach ($bus as $bu)
                {
                    $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $datevisit=date('Y-m-d', strtotime($visits['date']));
                    $dateinsurance = explode("-"  , $datevisit);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $visit_expiration[$num_visite_expiration]=$bu;
                        $num_visite_expiration+=1;
                    }
                }

            }
            else{
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $bus =Bus::all();
                $num_visite_expiration=0;
                $visit_expiration=[];
                $assuran=[];
                foreach ($bus as $bu)
                {
                    $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                    $datevisit=date('Y-m-d', strtotime($visits['date']));
                    $dateinsurance = explode("-"  , $datevisit);
                    $datnow = explode("-"  , $dated);
                    $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                    $nbredays=($diffe/86400);

                    if($nbredays<=60  and $nbredays>=0)
                    {
                        $visit_expiration[$num_visite_expiration]=$bu;
                        $num_visite_expiration+=1;
                    }
                }
            }
        }
        else{
            $date=new Date();
            $dated=$date->format('Y-m-d');
            $startdate= $date->format('Y-m-d 00:00:00');
            $enddate= $date->format('Y-m-d 23:59:59');
            $bus =Bus::where('site_id',$site_id)->get();
            $num_visite_expiration=0;
            $visit_expiration=[];
            $assuran=[];
            foreach ($bus as $bu)
            {
                $visits=Visit::where('bus_id',$bu->id)->orderBy('id','DESC')->first();

                $datevisit=date('Y-m-d', strtotime($visits['date']));
                $dateinsurance = explode("-"  , $datevisit);
                $datnow = explode("-"  , $dated);
                $diffe =(mktime(0, 0, 0, $dateinsurance[1], $dateinsurance[2], $dateinsurance[0]) - mktime(0, 0, 0, $datnow[1], $datnow[2], $datnow[0]));
                $nbredays=($diffe/86400);

                if($nbredays<=60  and $nbredays>=0)
                {
                    $visit_expiration[$num_visite_expiration]=$bu;
                    $num_visite_expiration+=1;
                }
            }
        }





        return view('visit.visit_expire',compact('bus','visit_expiration'));

    }
}

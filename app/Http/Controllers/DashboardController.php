<?php

namespace App\Http\Controllers;

use App\Approval;
use App\Assurance;
use App\Before_test;
use App\Bus;
use App\Demand;
use App\Diagnostic;
use App\Repair;
use App\Revision;
use App\State;
use App\Stock;
use App\Supplier;
use App\User;
use App\Visit;
use App\Visit_technique;
use App\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use Jenssegers\Date\Date;
use Carbon\Carbon;
use Jenssegers\Date\Date;
use phpDocumentor\Reflection\DocBlockFactory;

class DashboardController extends Controller
{

    public function bondesortievalide(Request $request)
    {


        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {
              $data=Approval::whereBetween('created_at',[$request->datedebu,$request->datefin])
                  // ->where('site_id',$request->site)
                   ->get();
                return view('dashboard.include.bondesortievalid',compact('data'));
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=Approval::get();
                    return view('dashboard.include.bondesortievalid',compact('data'));

                }
                else{
                    $data=Approval::where('site_id',$request->site)
                        ->get();
                    return view('dashboard.include.bondesortievalid',compact('data'));

                }
            }
            else{
                $data=Approval::get();
                return view('dashboard.include.bondesortievalid',compact('data'));
            }
        }
    }
    public function totaldiagnostic(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin))
            {
                $data=DB::table('diagnostics')
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
//                    ->where('site_id',$request->site)
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {

                    $data=DB::table('diagnostics')
                        ->get();
                }
                else{
                    $data=DB::table('diagnostics')
                        ->where('site_id',$request->site)
                        ->get();
                }
            }
            else{
                $data=Diagnostic::get();

            }
            return view('dashboard.include.totaldiagnostique',compact('data'));

        }


    }

    public function totalbefor_test(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if ($request->ajax()) {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {

                $data = Work::where('type','1')
                    ->where('site_id',$request->site)
                    ->whereBetween('before_tests.created_at', [$request->datedebu, $request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data = Work::where('type','1')
                        ->get();
                }
                else{
                    $data = Work::where('type','1')
                         ->where('site_id',$site)
                        ->get();
                }
            }
                else {
                $data = Work::where('type','1')
                   // ->where('site_id',$site)
                    ->get();
            }
            return view('dashboard.datadashboard', compact('data'));
        }
    }

    public function nbrepairattent(Request $request)
    {

        $site = Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)  )
            {
                /*===reparation effectuer en attente d'essai=======*/
                $data=Repair::where('state', '3')
//                    ->where('site_id',$request->site)
                    ->whereBetween('created',[$request->datedebu,$request->datefin])
                    ->get();
            }

            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=Repair::where('state', '3')
                        ->get();
                }
                else{
                    $data=Repair::where('state', '3')
                        ->where('site_id',$request->site)
                        ->get();
                }
            }
            else{
                $data=Repair::where('state', '3')
                   // ->where('site_id',$site)
                    ->get();
            }

            return view('dashboard.datadashboardcours',compact('data'));

        }


    }

    public function nbrevisitattente(Request $request)
    {

        if($request->ajax()) {
          $site=Auth::user()->employee->site_id;
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /* =======visite en attente d'essai==========*/
                $data = Visit_technique::where('state', '3')
//                    ->where('site_id',$request->site)
                    ->whereBetween('created_at', [$request->datedebu, $request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data = Visit_technique::where('state', '3')
                        ->get();
                }
                else{
                    $data = Visit_technique::where('state', '3')
                        ->where('site_id',$request->site)
                        ->get();
                }
            }
            else{
                /* =======visite en attente d'essai==========*/
                $data = Visit_technique::where('state', '3')
                    ->get();

            }


            return view('dashboard.datadashboardcours', compact('data'));
        }

    }

    public function releasattente(Request $request)
    {
        if($request->ajax())
        {
            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)  ) {
                $data=DB::table('after_tests')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'after_tests.created_at as  date')
                    ->where('after_tests.state',1)
                    ->whereBetween('after_tests.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }

            else{
                $data=Demand::where('state', '1')->orWhere('state', '2')
                    ->get();
            }


            return view('dashboard.releasedata',compact('data'));
        }

    }

    public function releaseattentepair(Request $request)
    {

        if ($request->ajax())
        {

            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)  ) {
                /* bon de sortie en attente de validation pour la reparation*/

                $data=DB::table('after_tests')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                 //   ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'after_tests.created_at as  date')
                    ->where('diagnostics.prestation',1)
                    ->where('after_tests.state',1)
                    ->whereBetween('after_tests.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            else{
                $data=DB::table('after_tests')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'after_tests.created_at as  date')
                    ->where('diagnostics.state',1)
                    ->where('after_tests.state',1)
                    ->get();
            }

            return view('dashboard.datadashboard',compact('data'));

        }

    }

    public function releasevisiatten(Request $request)
    {
        if($request->ajax()) {

            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*total bon de sortie en attente de validation pour la visite technique*/
                $data = DB::table('after_tests')
                    ->join('diagnostics', 'diagnostics.id', '=', 'after_tests.diagnostic_id')
                   // ->join('processes', 'processes.id', '=', 'diagnostics.process_id')
                    ->join('states', 'states.id', '=', 'processes.state_id')
                    ->join('vehicles', 'vehicles.id', '=', 'states.vehicle_id')
                    ->join('models', 'models.id', '=', 'vehicles.model_id')
                    ->join('brands', 'brands.id', '=', 'models.brand_id')
                    ->select('vehicles.matriculation as matriculation', 'models.name as model', 'brands.name as name', 'vehicles.chassis as numero_chassis', 'after_tests.created_at as  date')
                    ->where('diagnostics.prestation', 2)
                    ->whereBetween('after_tests.created_at', [$request->datedebu, $request->datefin])
                    ->where('after_tests.state', 1)
                    ->get();
            } else {
                /*total bon de sortie en attente de validation pour la visite technique*/
                $data = DB::table('after_tests')
                    ->join('diagnostics', 'diagnostics.id', '=', 'after_tests.diagnostic_id')
                 //   ->join('processes', 'processes.id', '=', 'diagnostics.process_id')
                    ->join('states', 'states.id', '=', 'processes.state_id')
                    ->join('vehicles', 'vehicles.id', '=', 'states.vehicle_id')
                    ->join('models', 'models.id', '=', 'vehicles.model_id')
                    ->join('brands', 'brands.id', '=', 'models.brand_id')
                    ->select('vehicles.matriculation as matriculation', 'models.name as model', 'brands.name as name', 'vehicles.chassis as numero_chassis', 'after_tests.created_at as  date')
                    ->where('diagnostics.prestation', 2)
                    ->where('after_tests.state', 1)
                    ->get();
            }

            return view('dashboard.datadashboard', compact('data'));
        }
    }

    public function releasevhicrepair(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*total véhicule sortie apres reparation*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                  //  ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->whereBetween('releases.date',[$request->datedebu,$request->datefin])
                    ->where('releases.type','repair')
                    ->get();
            }
            else{
                /*total véhicule sortie apres reparation*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                  //  ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->where('releases.type','repair')
                    ->get();
            }


            return view('dashboard.datadashboard',compact('data'));
        }
    }

    public function releasevhicvisit(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*total véhicule sortie apres visite technique*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->whereBetween('releases.date',[$request->datedebu,$request->datefin])
                    ->where('releases.type','visit')
                    ->get();
            }
            else{
                /*total véhicule sortie apres visite technique*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                  //  ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->where('releases.type','visit')
                    ->get();
            }

            return view('dashboard.datadashboard',compact('data'));

        }
    }

    public function releasevhicRevision(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*total véhicule sortie apres revision*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->whereBetween('releases.date',[$request->datedebu,$request->datefin])
                    ->where('releases.type','revision')
                    ->get();
            }
            else{
                /*total véhicule sortie apres revision*/
                $data=DB::table('releases')
                    ->join('after_tests','releases.after_test_id','=','after_tests.id')
                    ->join('diagnostics','diagnostics.id','=','after_tests.diagnostic_id')
                  //  ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'releases.created_at as  date')
                    ->where('after_tests.state',2)
                    ->where('releases.type','revision')
                    ->get();
            }



            return view('dashboard.datadashboard',compact('data'));
        }
    }

    public function nbrevehic(Request $request)
    {
        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {

                $data=Bus::whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('site_id',$request->site)
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=Bus::get();
                }
                else{
                    $data=Bus::where('site_id',$request->site)->get();

                }
            }
            else{
                $data=Bus::all();
            }

            return view('dashboard.include.databuses',compact('data'));
        }
    }

    public function pieceAvaliderr(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*======total piece a valider=========*/
                $data=DB::table('diagnostics')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'diagnostics.created_at as  date')
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                    ->where('diagnostics.state',1)
                    ->get();
            }
            else{
                /*======total piece a valider=========*/
                $data=DB::table('diagnostics')
                  //  ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'diagnostics.created_at as  date')
                    ->where('diagnostics.state',1)
                    ->get();
            }


            return view('dashboard.datadashboard',compact('data'));
        }
    }

    public function pieceValider(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*======total piece a valider=========*/
                /*=========total piece valider==========*/
                $data=DB::table('diagnostics')
                   // ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'diagnostics.created_at as  date')
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                    ->where('diagnostics.state',2)
                    ->get();
            }
            else{
                /*======total piece a valider=========*/
                /*=========total piece valider==========*/
                $data=DB::table('diagnostics')
                //    ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('vehicles.matriculation as matriculation','models.name as model','brands.name as name','vehicles.chassis as numero_chassis' ,'diagnostics.created_at as  date')
                    ->where('diagnostics.state',2)
                    ->get();
            }


            return view('dashboard.datadashboard',compact('data'));

        }

    }

    public function repaittent(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*attente de reparation*/
                $data= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
//                    ->where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
                        ->get();

                }
                else{
                    $data= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
                        ->where('site_id',$request->site)
                        ->get();
                }
            }
            else{
                /*attente de reparation*/
                $data= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
                    ->get();
            }
            return view('dashboard.datadashboard',compact('data'));

        }
    }

    public function repairEffectuer(Request $request)
    {
        if($request->ajax())
        {
            $site=Auth::user()->employee->site_id;

            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*=====total reparation effectuer============*/
                $data=Repair::where('state', '3')
//                    ->where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=Repair::where('state', '3')
                        ->get();

                }
                else{
                    $data=Repair::where('state', '3')
                        ->where('site_id',$request->site)
                        ->get();
                }
            }
            else{
                /*=====total reparation effectuer============*/
                $data=Repair::where('state', '3')
                    ->get();
            }


            return view('dashboard.datadashboardcours',compact('data'));

        }
    }

    public function repairencours(Request $request)
    {
        if($request->ajax())
        {
            $site=Auth::user()->employee->site_id;
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*=== Total encours de reparation===========*/
                $data=Repair::where('site_id',$request->site)
                    ->where(function($q){
                        $q->where('state', '1')
                            ->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }

            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=Repair::where('state', '1')
                        ->orWhere('state', '2')
                        ->orWhere('state', '4')
                        ->get();

                }
                else{
                    $data=Repair::where('site_id',$request->site)
                        ->where(function($q){
                            $q->where('state', '1')
                                ->orWhere('state', '2')
                                ->orWhere('state', '4');
                        })
                        ->get();
                }
            }
            else{
                /*=== Total encours de reparation===========*/
                $data=Repair::where('state', '1')
                    ->orWhere('state', '2')
                    ->orWhere('state', '4')
//                    ->where('site_id',$site)
                    ->get();
            }

            return view('dashboard.datadashboardcours',compact('data'));
        }
    }

    public function revisionattente(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*======attent de revision==========*/
                $data=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
//                    ->where('site_id',$request->site)
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif(isset($request->site))
            {
                if ($request->site == "all_site") {
                    $data=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
                        ->get();
                }
                else{
                    $data=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
                        ->where('site_id',$request->site)
                        ->get();
                }

            }
            else{
                /*======attent de revision==========*/
                $data=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
                    ->get();

            }

            return view('dashboard.datadashboard',compact('data'));

        }
    }

    public function revisionencours(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                $data= Revision::where('site_id',$request->site)
                    ->where(function ($q){
                        $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                    })
//                    ->
                    ->whereBetween('revisionns.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif ($request->site)
            {
                if ($request->site == "all_site") {
                    $data= Revision::where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4')
                        ->get();
                }
                else{
                    $data= Revision::where('site_id',$request->site)
                        ->where(function ($q){
                            $q->where('state', '1')->orWhere('state', '2')
                                ->orWhere('state', '4');
                        })
                        ->get();
                }
            }
            else{
                $data=Revision::where('state', '1')->orWhere('state', '2')
                    ->orWhere('state', '4')
//                    ->where('site_id',$site)
                    ->get();
            }

            /*======total revision en cours=========*/

            return view('dashboard.datadashboardcours',compact('data'));

        }

    }


    public function visitecheffetc (Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
            /*===========total visite effectuer==============*/
            $data=Visit_technique::where('state', '3')
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
        }
        elseif (isset($request->site))
        {
            if ($request->site == "all_site") {
                $data=Visit_technique::where('state', '3')
                    ->get();
            }
            else{
                $data=Visit_technique::where('state', '3')
                    ->where('site_id',$site)
                    ->get();
            }

        }
        else{
            $data=Visit_technique::where('state', '3')
                ->get();
        }

        return view('dashboard.datadashboardcours',compact('data'));

    }

    public function releaserevisionattent(Request $request)
    {
        if($request->ajax())
        {
            $site_id = Auth::user()->employee->site_id;
            if (isset($request->datedebu)  or isset($request->datefin) and ($request->site)) {

                $data=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                    ->where('diagnostics.site_id',$request->site)
                    ->where('demands.state', '1')
                    ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and !empty($request->site))
            {
                if($request->site=="all_site")
                {
                    $data=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                        ->where('demands.state', '1')->orWhere('demands.state', '2')
                        ->get();
                }
                else{
                    $data=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                        ->where('diagnostics.site_id',$request->site)
                        ->where('demands.state', '1')->orWhere('demands.state', '2')
                        ->get();
                }

            }
            else{

                $data=Demand::where('state', '1')->orWhere('state', '2')
                    ->get();

            }

            return view('dashboard.releasedata',compact('data'));


        }
    }




    public function visitechencours(Request $request)
    {
        $site=Auth::user()->employee->site_id;

        if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {

            /*en cours de  visite Technique*/
            $data=Visit_technique::where('site_id',$request->site)
                ->where(function ($q){
                $q->where('state', '1')->orWhere('state', '2')
                    ->orWhere('state', '4');
                })
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();

        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=Visit_technique::where('state', '1')->orWhere('state', '2')
                    ->orWhere('state', '4')
                    ->get();

            }
            else{
                $data=Visit_technique::where('site_id',$request->site)
                    ->where(function ($q){
                        $q->where('state', '1')->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
                    ->get();

            }
        }
        else
        {
            /*en cours de  visite Technique*/
            $data=Visit_technique::where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
//                ->where('site_id',$site)
                ->get();

        }

        return view('dashboard.datadashboardcours',compact('data'));



    }



    public function visiteTechnattente(Request $request)
    {
        $site=Auth::user()->employee->site_id;

        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            /*========Total visite technique en attente========*/
            $data=Diagnostic::where('type', '3')->whereBetween('active', ['1','2'])
//                ->where('site_id',$request->site)
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                ->get();
        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=Diagnostic::where('type', '3')->whereBetween('active', ['1','2'])
                    ->get();

            }
            else{
                $data=Diagnostic::where('type', '3')->whereBetween('active', ['1','2'])
                    ->where('site_id',$request->site)
                    ->get();

            }
        }

        else
        {
            /*========Total visite technique en attente========*/
            $data=Diagnostic::where('type', '3')->whereBetween('active', ['1','2'])
//                ->where('site_id',$site)
                ->get();
        }
        return view('dashboard.datadashboard',compact('data'));


    }

    public function approbationattente(Request $request)
    {

        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) and isset($request->datefin) and !empty($request->datefin)) {
            $data=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                ->join('buses','buses.id','=','states.bus_id')
                ->join('models','models.id','=','buses.model_id')
                ->join('brands','brands.id','=','models.brand_id')
                ->select('states.reference as reference','buses.matriculation as matriculation','models.name as model','brands.name as brandname','buses.chassis as numero_chassis' ,'demands.created_at as  date')
              //  ->where('diagnostics.site_id',$request->site)
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('demands.state','0')
                ->get();
        }

        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=DB::table('demands')
                    ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                    ->join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->join('models','models.id','=','buses.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('states.reference as reference','buses.matriculation as matriculation','models.name as model','brands.name as brandname','buses.chassis as numero_chassis' ,'demands.created_at as  date')
                    ->where('demands.state','0')
                    ->get();

            }else{
                $data=DB::table('demands')
                    ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                    ->join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->join('models','models.id','=','buses.model_id')
                    ->join('brands','brands.id','=','models.brand_id')
                    ->select('states.reference as reference','buses.matriculation as matriculation','models.name as model','brands.name as brandname','buses.chassis as numero_chassis' ,'demands.created_at as  date')
                    ->where('diagnostics.site_id',$request->site)
                    ->where('demands.state','0')
                    ->get();

            }
        }
        else{
            $data=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                ->join('buses','buses.id','=','states.bus_id')
                ->join('models','models.id','=','buses.model_id')
                ->join('brands','brands.id','=','models.brand_id')
                ->select('states.reference as reference','buses.matriculation as matriculation','models.name as model','brands.name as brandname','buses.chassis as numero_chassis' ,'demands.created_at as  date')
               // ->where('diagnostics.site_id',$request->site)
                ->where('demands.state','0')
                ->get();
        }
        return view('dashboard.include.appropieceaten',compact('data'));

    }
    public function totaluser(Request $request)
    {

        $site=Auth::user()->employee->site_id;
        if(isset($request->site))
        {
            $userTotal=User::join('employees','employees.id','=','users.employee_id')
                ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
              ->where('employees.site_id',$request->site)
                ->get();
            return view('dashboard.totaluser',compact('userTotal'));
        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {

                $userTotal=User::join('employees','employees.id','=','users.employee_id')
                    ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
//                ->where('employees.site_id',$site)
                    ->get();

            }
            else{
                $userTotal=User::join('employees','employees.id','=','users.employee_id')
                    ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
                ->where('employees.site_id',$request->site)
                    ->get();

            }
        }

        else{
            $userTotal=User::join('employees','employees.id','=','users.employee_id')
                ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
//                ->where('employees.site_id',$site)
                ->get();
            return view('dashboard.totaluser',compact('userTotal'));

        }

    }

    public function userconnected(Request $request)
    {

        $site=Auth::user()->employee->site_id;
        if(isset($request->site) and !empty($request->site))
        {

            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
                ->where('users.connected',1)
               ->where('employees.site_id',$request->site)
                ->get();
            return view('dashboard.userconnected',compact('userconnect'));

        }

        else{
            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->select('users.first_name as first_name','users.last_name as last_name','users.email as email')
                ->where('users.connected',1)
               ->get();
            return view('dashboard.userconnected',compact('userconnect'));

        }


    }
    public function fournisseur(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) and isset($request->datefin) and !empty($request->datefin)) {
            $data=Supplier::whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->get();
        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=Supplier::get();
            }
            else{
                $data=Supplier::where('site_id',$request->site)
                    ->get();
            }
        }
        else{
            $data=Supplier::where('site_id',$site)->get();
        }
        return view('dashboard.include.supplier',compact('data'));
    }

    public function revisionattentessai(Request $request)
    {
        $site=Auth::user()->employee->sited_id;

        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            /* revision en attente d'essai apres travo*/
            $data=Revision::where('state', '3')
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=Revision::where('state', '3')
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));

            }
            else{
                $data=Revision::where('state', '3')
                    ->where('site_id',$request->site)
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));
            }
        }

        else{

            /* revision en attente d'essai apres travo*/
            $data=Revision::where('state', '3')
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }

    }


    public function aftertestattent(Request $request)
    {
        $site=Auth::user()->employee->sited_id;
        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            /*Essai apres travo en attente*/
            $data=Work::where('type','2')
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboard',compact('data'));

        }
        elseif(isset($request->site) and !empty($request->site)) {
            if ($request->site == "all_site") {
                $data=Work::where('type','2')
                    ->get();
                return view('dashboard.datadashboard',compact('data'));

            }
            else{
                $data=Work::where('type','2')
                    ->where('site_id',$request->site)
                    ->get();
                return view('dashboard.datadashboard',compact('data'));

            }
        }
        else{
            /*Essai apres travo en attente*/
            $data=Work::where('type','2')
                ->get();
            return view('dashboard.datadashboard',compact('data'));


        }



    }

    public function revisioneffectuer(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            $data=Revision::where('state', '3')
//                ->where('site_id',$request->site)
                ->whereBetween('revisionns.created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }
        elseif (isset($request->site))
        {
            if ($request->site == "all_site") {
                $data=Revision::where('state', '3')
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));
            }
            else{
                $data=Revision::where('state', '3')
                    ->where('site_id',$request->site)
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));
            }

        }
        else{
            $data=Revision::where('state', '3')
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }


    }

    public function expirassurane(Request $request)
    {
        if($request->ajax()){
            if (isset($request->site) ) {



                if ($request->site == "all_site") {


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
                else{
                    $date=new Date();
                    $dated=$date->format('Y-m-d');
                    $startdate= $date->format('Y-m-d 00:00:00');
                    $enddate= $date->format('Y-m-d 23:59:59');
                    $buss =DB::table('buses')->where('site_id',$request->site)->get();
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


                return view('dashboard.includes.dataexpiration',compact('insurance_expiration','num_insurance_expiration'));
            }

            else{
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $buss =DB::table('buses')->where('site_id',$request->site)->get();
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

                return view('dashboard.includes.dataexpiration',compact('insurance_expiration','num_insurance_expiration'));
            }
        }

    }



    public function expirationvisi(Request $request)
    {
        if($request->ajax())
        {
          if($request->site)
          {


                if ($request->site == "all_site") {

                    $datee=new Date();
                    $dated=$datee->format('Y-m-d');
                    $startdate= $dated->format('Y-m-d 00:00:00');
                    $enddate= $dated->format('Y-m-d 23:59:59');
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

                }
                else{

                    $datee=new Date();
                    $dated=$datee->format('Y-m-d');
                    $startdate= $dated->format('Y-m-d 00:00:00');
                    $enddate= $dated->format('Y-m-d 23:59:59');
                    $busess =DB::table('buses')->where('site_id',$request->site)->get();
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

                }


              return view('dashboard.include.datavisiexpir',compact('visit_expiration','num_visite_expiration'));
          }
          else {

              $datee=new Date();
              $dated=$datee->format('Y-m-d');
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

              return view('dashboard.include.datavisiexpir',compact('visit_expiration','num_visite_expiration'));
          }
        }
    }
    public function assuranceexpired(Request $request)
    {
        if($request->ajax()){
            if (isset($request->site) ) {
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $buss =DB::table('buses')->where('site_id',$request->site)->get();
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
                return view('dashboard.include.dataexpiration',compact('insurance_expiration','num_insurance_expiration'));
            }

            else{
                $date=new Date();
                $dated=$date->format('Y-m-d');
                $startdate= $date->format('Y-m-d 00:00:00');
                $enddate= $date->format('Y-m-d 23:59:59');
                $buss =DB::table('buses')->where('site_id',$request->site)->get();
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

                return view('dashboard.include.dataexpiration',compact('insurance_expiration','num_insurance_expiration'));
            }
        }
    }

    public function releaserevisionattmanager(Request $request)
    {
        if($request->ajax())
        {
            $site_id = Auth::user()->employee->site_id;
            if (isset($request->datedebu)  or isset($request->datefin) and ($request->site)) {

                $data=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                    ->where('diagnostics.site_id',$site_id)
                    ->where('demands.state', '1')->orWhere('demands.state', '2')->orWhere('demands.state', '3')
                    ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                    ->orderBy('diagnostics.created_at','desc')
                    ->get();
            }
            else{

                $data=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                    ->where('demands.state', '1')->orWhere('demands.state', '2')->orWhere('demands.state', '3')
                    ->where('diagnostics.site_id',$site_id)
                    ->orderBy('diagnostics.created_at','desc')
                    ->get();

            }

            return view('dashboard.include.demandeattente',compact('data'));


        }
    }

    public function totaldiagnosticManager(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin))
            {
                $data=DB::table('diagnostics')
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
//                    ->where('site_id',$site)
                    ->get();
            }
            else{
                $data=Diagnostic::all();

            }


            return view('dashboard.include.totaldiagnostique',compact('data'));

        }
    }

    public function nbrevehicmanager(Request $request)
    {
        $site_id=Auth::user()->employee->site_id;

        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                $data=DB::table('buses')
                   // ->where('site_id',$site_id)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            elseif(isset($request->site) and ! empty($request->site)) {
                $data=DB::table('buses')
                     ->where('site_id',$site_id)
                    ->get();
            }
            else{
                $data=Bus::all();
            }

            return view('dashboard.include.databuses',compact('data'));
        }
    }


    public function bondesortievalideManag(Request $request)
    {
        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {
//                $data=Approval::join('diagnostics','diagnostics.id','=','approvals.diagnostic_id')
//                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
//                    ->get();

                $data=Approval::whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('site_id',$request->site)
                    ->get();
                return view('dashboard.include.bondesortievalid',compact('data'));
            }
            elseif($request->site)
            {

                $data=Approval::where('site_id',$request->site)
                    ->get();
            }
            else{
                $data=Approval::where('site_id',$request->site)
                    ->get();
//                $data=Approval::where('site_id',$site_id)->get();
                return view('dashboard.include.bondesortievalid',compact('data'));
            }
        }
    }

    public function nbrepairattentManage(Request $request)
    {
        $site = Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if(isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)  )
            {
                /*===reparation effectuer en attente d'essai=======*/
                $data=Repair::where('state', '3')
                    ->where('site_id',$site)
                    ->whereBetween('created',[$request->datedebu,$request->datefin])
                    ->get();
            }
            else{
                $data=Repair::where('state', '3')
                    ->where('site_id',$site)
                    ->get();
            }

            return view('dashboard.datadashboardcours',compact('data'));

        }


    }

    public function revisionattentessaiManag(Request $request)
    {
        $site=Auth::user()->employee->sited_id;

        if (isset($request->datedebu) and !empty($request->datedebu) )
        {
            /* revision en attente d'essai apres travo*/
            $data=Revision::where('state', '3')
                ->where('site_id',$site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }else{

            /* revision en attente d'essai apres travo*/
            $data=Revision::where('state', '3')
                ->where('site_id',$site)
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }
    }

    public function nbrevisitattenteManage(Request $request)
    {

        if($request->ajax()) {
            $site=Auth::user()->employee->site_id;
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /* =======visite en attente d'essai==========*/
                $data = Visit_technique::where('state', '3')
                    ->where('site_id',$site)
                    ->whereBetween('created_at', [$request->datedebu, $request->datefin])
                    ->get();
            }
            elseif (isset($request->site))
            {
                $data = Visit_technique::where('state', '3')
                    ->where('site_id',$site)
                    ->get();
            }

            else{
                /* =======visite en attente d'essai==========*/
                $data = Visit_technique::where('state', '3')
                    ->where('site_id',$site)
                    ->get();

            }


            return view('dashboard.datadashboardcours', compact('data'));
        }
    }

    public function totalbefortestManager(Request $request)
    {
        $site=Auth::user()->employee->site_id;

        if ($request->ajax()) {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {

                $data = Work::where('type','1')
                    ->where('site_id',$site)
                    ->whereBetween('before_tests.created_at', [$request->datedebu, $request->datefin])
                    ->get();
            } else {
                $data = Work::where('type','1')
                   ->where('site_id',$site)
                    ->get();
            }
            return view('dashboard.datadashboard', compact('data'));
        }
    }

    public function aftertestattentManager(Request $request)
    {
        $site=Auth::user()->employee->sited_id;
        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            /*Essai apres travo en attente*/
            $data=Work::where('type','2')
               ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboard',compact('data'));

        }
        else{
            /*Essai apres travo en attente*/
            $data=Work::where('type','2')
                ->where('site_id',$site)
                ->get();
            return view('dashboard.datadashboard',compact('data'));


        }

    }

    public function repairencoursMang(Request $request)
    {
        if($request->ajax())
        {
            $site=Auth::user()->employee->site_id;
            if (isset($request->datedebu)  or isset($request->datefin) ) {
                /*=== Total encours de reparation===========*/
                $data=Repair::where('site_id',$site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where(function ($q){
                        $q->where('state', '1')
                            ->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
//                    ->where('state', '1')
//                    ->orWhere('state', '2')
//                    ->orWhere('state', '4')
                    ->get();
               return view('dashboard.datadashboardcours',compact('data'));
            }
            else{
                /*=== Total encours de reparation===========*/
                $data=Repair::where('site_id',$site)
                    ->where(function ($q){
                        $q->where('state', '1')
                            ->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
//                    ->where('state', '1')
//                    ->orWhere('state', '2')
//                    ->orWhere('state', '4')
//                    ->
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));
            }


        }
    }

    public function repaittentManager(Request $request)
    {
        if($request->ajax())
        {
            $site=Auth::user()->employee->site_id;
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*attente de reparation*/
                $data= Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type','1')
                    ->where('states.site_id',$site)
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            else{
                /*attente de reparation*/
                $data= Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->where('states.site_id',$site)
                    ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type','1')
                    ->get();
            }
            return view('dashboard.datadashboard',compact('data'));

        }
    }

    public function repairEffectuerManager(Request $request)
    {
        if($request->ajax())
        {
            $site=Auth::user()->employee->site_id;

            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*=====total reparation effectuer============*/
                $data=Repair::where('state', '3')
                   ->where('site_id',$site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();
            }
            else{
                /*=====total reparation effectuer============*/
                $data=Repair::where('state', '3')
                    ->where('site_id',$site)

                    ->get();
            }


            return view('dashboard.datadashboardcours',compact('data'));

        }
    }

    public function visitechencoursMang(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {

            /*en cours de  visite Technique*/
            $data=Visit_technique::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })
//                ->where('state', '1')->orWhere('state', '2')
//                ->orWhere('state', '4')
//
              //  ->
                ->get();

        }
        else
        {
            /*en cours de  visite Technique*/
            $data=Visit_technique::where('site_id',$site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })

//                ->where('state', '1')->orWhere('state', '2')
//                ->orWhere('state', '4')
//                ->
                ->get();

        }

        return view('dashboard.datadashboardcours',compact('data'));
    }

    public function visiteTechnattenteMang(Request $request)
    {
        $site=Auth::user()->employee->site_id;

        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            /*========Total visite technique en attente========*/
            $data=Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->where('states.site_id',$site)
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
            ->where('diagnostics.type', '3')->whereBetween('diagnostics.active', ['1','2'])
//                ->
                ->get();
        }
        else
        {
            /*========Total visite technique en attente========*/

            $data= Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->where('states.site_id',$site)
                ->where('diagnostics.type', '3')->whereBetween('diagnostics.active', ['1','2'])
                ->get();
        }
        return view('dashboard.datadashboard',compact('data'));

    }

    public function visitecheffetcManag (Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
            /*===========total visite effectuer==============*/
            $data=Visit_technique::where('state', '3')
                ->where('site_id',$site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
        }
        elseif (isset($request->site))
        {
            $data=Visit_technique::where('state', '3')
               ->where('site_id',$site)
                ->get();
        }
        else{
            $data=Visit_technique::where('state', '3')
                ->where('site_id',$site)
                ->get();
        }

        return view('dashboard.datadashboardcours',compact('data'));
    }

    public function revisionencoursManag(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                $data= Revision::whereBetween('revisionns.created_at',[$request->datedebu,$request->datefin])
                    ->where('site_id',$site)
                    ->where(function ($q){
                        $q->where('state', '1')
                            ->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
//                    ->where('state', '1')->orWhere('state', '2')
//                    ->orWhere('state', '4')
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));

            }

            else{
                $data=Revision::where('site_id',$site)
                    ->where(function ($q){
                        $q->where('state', '1')
                            ->orWhere('state', '2')
                            ->orWhere('state', '4');
                    })
//                  ->where('state', '1')->orWhere('state', '2')
//                    ->orWhere('state', '4')
                    ->get();
                return view('dashboard.datadashboardcours',compact('data'));
            }

            /*======total revision en cours=========*/



        }

    }
    public function revisionattenteManag(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu) and !empty($request->datedebu) || isset($request->datefin) and !empty($request->datefin)) {
                /*======attent de revision==========*/
                $data=Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->where('diagnostics.type', '2')->whereBetween('diagnostics.active', ['1','2'])
                    ->where('states.site_id',$site)
                    ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                    ->get();


            }
            else{
                /*======attent de revision==========*/
                $data=Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->where('states.site_id',$site)
                    ->where('diagnostics.type', '2')->whereBetween('diagnostics.active', ['1','2'])
                    ->get();
            }

            return view('dashboard.datadashboard',compact('data'));

        }
    }

    public function revisioneffectuerManag(Request $request)
    {
        $site=Auth::user()->employee->site_id;
        if (isset($request->datedebu) and !empty($request->datedebu) ) {
            $data=Revision::where('state', '3')
                ->where('site_id',$site)
                ->whereBetween('revisionns.created_at',[$request->datedebu,$request->datefin])
                ->get();
            return view('dashboard.datadashboard',compact('data'));
        }
        else{
            $data=Revision::where('state', '5')
                 ->where('site_id',$site)
                ->get();
            return view('dashboard.datadashboardcours',compact('data'));
        }


    }

    public function stockminimal()
    {
        $stock=Stock::whereBetween('quantity',[0,10])->get();
        return view('dashboard.include.stockminimal',compact('stock'));

    }

    public function fournisseurMagasini(Request $request)
    {
        $site=Auth::user()->employee->site_id;

            $data=Supplier::where('site_id',$site)->get();
        $data=Supplier::get();

        return view('dashboard.include.supplier',compact('data'));
    }

    public function approbationattenteStock(Request $request)
    {
        $site=Auth::user()->employee->site_id;

            $data=Demand::where('state', '0')
//                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->get();
        return view('dashboard.include.appropieceaten',compact('data'));

    }
    /*************nombre de véhicule étant dans le garage*******/
    public function vehic_garage(Request $request)
    {
        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin)  and isset($request->site)) {

                $states= State::where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])->get();
                $releases = Approval::all();

                $data=[];
                $k=0;
                foreach ($states as $key=>$state)
                {
                    $existe=false;
                    //$process_id = $proces->id;
                    foreach ($releases as $keyr=>$release)
                    {
                        if($state->id == $release->diagnostic->statee->id)
                        {
                            $existe=true;
                        }
//                        if($proces->id == $release->after_test->diagnostic->process->id)
//                        {
//                            $existe=true;
//                        }

                    }


                    if(!$existe)
                    {
                        $data[$k++]=$state->id;
                    }
                }

                $processes=[];
                $p=0;
                $id_site=Auth::user()->employee->site_id;
                $nbrevei=0;
                for ($q=0;$q<count($data);$q++)
                {
                    if(State::findOrFail($data[$q]))
                    {
                        $processes[$p++] = State::whereBetween('created_at',[$request->datedebu,$request->datefin])->where('site_id',$request->site)->where('id',$data[$q])->get();
                        $nbrevei++;
                    }

                }

                return view('dashboard.include.bus_garage',compact('processes'));
            }
            elseif (isset($request->site) and  !empty($request->site)) {

                if($request->site=="all_site")
                {

                    $states= State::all();
                    $releases = Approval::all();


                    $data=[];
                    $k=0;
                    foreach ($states as $key=>$state)
                    {
                        $existe=false;
                        //$process_id = $proces->id;
                        foreach ($releases as $keyr=>$release)
                        {
                            if($state->id == $release->diagnostic->statee->id)
                            {
                                $existe=true;
                            }

                        }


                        if(!$existe)
                        {
                            $data[$k++]=$state->id;
                        }
                    }

                    $processes=[];
                    $p=0;
                    $nbrevei=0;
                    for ($q=0;$q<count($data);$q++)
                    {
                        if(State::findOrFail($data[$q]))
                        {
                            $processes[$p++] = State::where('id',$data[$q])->get();
                            $nbrevei++;

                        }

                    }

                    return view('dashboard.include.bus_garage',compact('processes'));
                }
                else{

                    $process= State::where('site_id',$request->site)
                            ->get();
                    $releases = Approval::all();

                    $data=[];
                    $k=0;
                    foreach ($process as $key=>$proces)
                    {
                        $existe=false;
                        //$process_id = $proces->id;
                        foreach ($releases as $keyr=>$release)
                        {
                            if($proces->id == $release->diagnostic->statee->id)
                            {
                                $existe=true;
                            }
//                        if($proces->id == $release->after_test->diagnostic->process->id)
//                        {
//                            $existe=true;
//                        }

                        }


                        if(!$existe)
                        {
                            $data[$k++]=$proces->id;
                        }
                    }

                    $processes=[];
                    $p=0;
                    $nbrevei=0;
                    for ($q=0;$q<count($data);$q++)
                    {
                        if(State::findOrFail($data[$q]))
                        {

                            $processes[$p++] = State::where('site_id',$request->site)->where('id',$data[$q])->get();
                            $nbrevei++;

                            //        $processes[$p++] = ¨Process::where('site_id',$id_site)->where('id',$data[$q])->get();

                        }

                    }

                    return view('dashboard.include.bus_garage',compact('processes'));
                }

            }

            elseif (!isset($request->site) and empty($request->site)  and isset($request->datedebu)  or isset($request->datefin))
            {

                $states= State::all();
                $releases = Approval::all();


                $data=[];
                $k=0;
                foreach ($states as $key=>$state)
                {
                    $existe=false;
                    //$process_id = $proces->id;
                    foreach ($releases as $keyr=>$release)
                    {
                        if($state->id == $release->diagnostic->statee->id)
                        {
                            $existe=true;
                        }

                    }


                    if(!$existe)
                    {
                        $data[$k++]=$state->id;
                    }
                }

                $processes=[];
                $p=0;
                $id_site=Auth::user()->employee->site_id;
                $nbrevei=0;
                for ($q=0;$q<count($data);$q++)
                {
                    if(State::findOrFail($data[$q]))
                    {
                        $processes[$p++] = State::whereBetween('created_at',[$request->datedebu,$request->datefin])->where('id',$data[$q])->get();
                        $nbrevei++;

                    }

                }



                return view('dashboard.include.bus_garage',compact('processes'));
            }
            else{


                $states= State::all();
                $releases = Approval::all();

                $data=[];
                $k=0;
                foreach ($states as $key=>$state)
                {
                    $existe=false;
                    foreach ($releases as $keyr=>$release)
                    {
                        if($state->id == $release->diagnostic->statee->id)
                        {
                            $existe=true;
                        }
                    }


                    if(!$existe)
                    {
                        $data[$k++]=$state->id;
                    }
                }

                $processes=[];
                $p=0;
                $id_site=Auth::user()->employee->site_id;
                $nbrevei=0;
                for ($q=0;$q<count($data);$q++)
                {
                    if(State::findOrFail($data[$q]))
                    {
                        $processes[$p++] = State::where('id',$data[$q])->get();
                        $nbrevei++;

                    }

                }

                return view('dashboard.include.bus_garage',compact('processes'));
            }

        }
    }

    /*******total accident******/

    public function totalaccident(Request $request)
    {

        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {

                $data = State::whereBetween('created_at',[$request->datedebu,$request->datefin])->where('accident',1)
                    ->where('site_id',$request->site)->get();

                return view('dashboard.include.totalaccident',compact('data'));
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data =  State::where('accident',1)->get();
                    return view('dashboard.include.totalaccident',compact('data'));

                }
                else{
                    $data = State::where('accident',1)
                        ->where('site_id',$request->site)->get();
                    return view('dashboard.include.totalaccident',compact('data'));

                }
            }
            else{
                $data = State::where('accident',1)
                         ->get();
                return view('dashboard.include.totalaccident',compact('data'));
            }
        }

    }

    public function totalaccidentkilometrage(Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {
                $data = State::where('accident',1)
                    ->where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('kilometer','>',100000)->get();

                return view('dashboard.include.totalaccidentkilometrag',compact('data'));
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data = State::where('accident',1)
                        ->where('kilometer','>',100000)->get();

                    return view('dashboard.include.totalaccidentkilometrag',compact('data'));

                }
                else{

                    $data = State::where('accident',1)
                        ->where('site_id',$request->site)
                        ->where('kilometer','>',100000)->get();


                    return view('dashboard.include.totalaccidentkilometrag',compact('data'));

                }
            }
            else{

                $data = State::where('accident',1)
                    ->where('kilometer','>',100000)->get();


                return view('dashboard.include.totalaccidentkilometrag',compact('data'));
            }
        }

    }




    public function pannekmtechn(Request $request)
    {
        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {

                $data=State::where('accident','!=',1)
                    ->where('site_id',$site_id)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('kilometer','>',100000)->get();
                return view('dashboard.include.pannekm',compact('data'));
            }
            else{

                $data=State::where('accident','!=',1)
                    ->where('kilometer','>',100000)
                    ->where('site_id',$site_id)
                    ->get();

                return view('dashboard.include.pannekm',compact('data'));
            }
        }



    }




    public function pannekm(Request $request)
    {

        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {

                $data=State::where('accident','!=',1)
                    ->where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('kilometer','>',100000)->get();
                return view('dashboard.include.pannekm',compact('data'));
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data=State::where('accident','!=',1)
                        ->where('kilometer','>',100000)->get();
                    return view('dashboard.include.pannekm',compact('data'));

                }
                else{
                    $data=State::where('accident','!=',1)
                        ->where('site_id',$request->site)
                        ->where('kilometer','>',100000)->get();


                    return view('dashboard.include.pannekm',compact('data'));

                }
            }
            else{

                $data=State::where('accident','!=',1)
                    ->where('kilometer','>',100000)->get();

                return view('dashboard.include.pannekm',compact('data'));
            }
        }



    }

    public function nbr_panne_garage (Request $request)
    {
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {

                $data = State::where('panne_gar','=',1)
                    ->where('site_id',$request->site)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('dashboard.include.panne_garage',compact('data'));
            }
            elseif(isset($request->site) and !empty($request->site)) {
                if ($request->site == "all_site") {
                    $data = State::where('panne_gar','=',1)
                              ->get();
                    return view('dashboard.include.panne_garage',compact('data'));

                }
                else{
                    $data = State::where('panne_gar','=',1)
                        ->where('site_id',$request->site)
                        ->get();


                    return view('dashboard.include.panne_garage',compact('data'));

                }
            }
            else{

                $data = State::where('panne_gar','=',1)
                          ->get();

                return view('dashboard.include.panne_garage',compact('data'));
            }
        }
    }


    /**********/

    public function nbr_panne_garagetech (Request $request)
    {
        if($request->ajax())
        {
            $site_id = Auth::user()->employee->site_id;

            if (isset($request->datedebu)  or isset($request->datefin) ) {

                $data = State::where('panne_gar','=',1)
                    ->where('site_id',$site_id)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('dashboard.include.panne_garage',compact('data'));
            }

            else{

                $data = State::where('panne_gar','=',1)
                    ->where('site_id',$site_id)
                        ->get();

                return view('dashboard.include.panne_garage',compact('data'));
            }
        }
    }

    /************/



    public function totalaccidentkilometech(Request $request)
    {
        if($request->ajax())
        {
            $site_id = Auth::user()->employee->site_id;

            if (isset($request->datedebu)  or isset($request->datefin) and isset($request->site)) {
                $data = State::where('accident',1)
                    ->where('site_id',$site_id)
                    ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                    ->where('kilometer','>',100000)->get();

                return view('dashboard.include.totalaccidentkilometrag',compact('data'));
            }

            else{

                $data = State::where('accident',1)
                    ->where('site_id',$site_id)
                    ->where('kilometer','>',100000)->get();


                return view('dashboard.include.totalaccidentkilometrag',compact('data'));
            }
        }

    }

    public function totalaccidentech(Request $request)
    {

        $site_id=Auth::user()->employee->site_id;
        if($request->ajax())
        {
            if (isset($request->datedebu)  or isset($request->datefin) ) {

                $data = State::whereBetween('created_at',[$request->datedebu,$request->datefin])->where('accident',1)
                   ->orderBy("created_at","desc")
                    ->where('site_id',$site_id)->get();

                return view('dashboard.include.totalaccident',compact('data'));
            }

            else{
                $data = State::where('accident',1)
                    ->where('site_id',$site_id)
                    ->orderBy("created_at","desc")
                    ->get();
                return view('dashboard.include.totalaccident',compact('data'));
            }
        }

    }
}

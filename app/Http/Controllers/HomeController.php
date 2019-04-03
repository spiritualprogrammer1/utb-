<?php

namespace App\Http\Controllers;

use App\Approval;
use App\Assurance;
use App\Before_test;
use App\Brand;
use App\Demand;
use App\Diagnostic;
use App\Employee;
use App\Entreprise;
use App\Models;
use App\Post;
use App\Process;
use App\Release;
use App\Repair;
use App\Revision;
use App\Role;
use App\Service;
use App\Site;
use App\State;
use App\Stock;
use App\Sub_category;
use App\Supplier;
use App\User;
use App\After_test;
use App\Vehicle;
use App\Visit;
use App\Visit_technique;
use App\Work;
use Illuminate\Http\Request;
use Charts;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Jenssegers\Date\Date;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       //

        if (Auth::user()->can(['tableau de bord administration générale','tableau de bord admin']))
        {
            /*total diagnostique*/

            $site=Auth::user()->employee->site_id;

            /*Essai apres travaux effectuer*/
            $totalbefor_test=Work::where('type','1')->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')->count();

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Revision::where('state', '3')->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type','2')->count();

            /* bon de sortie en attente de validation*/
            $releasattente=Demand::where('state', '1')->orWhere('state', '2')->count();


            /*======nbre total de véhicule===========*/
            $nbbus=DB::table('buses')->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state','0')
               // ->where('diagnostics.site_id',$site)
                ->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
              //  ->where('diagnostics.site_id',$site)
                ->where('demands.state','3')
                ->count();
            /*=======taux============== */
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent=  Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
               ->count();

            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')
               // ->where('site_id',$site)
                ->count();



            /*======Total reparation==========*/
            $repairs=Repair::count();

            /*=== Total encours de reparation===========*/
            $repairencours= Repair::where('state', '1')->orWhere('state', '2')
                     ->orWhere('state', '4')
                    ->count();

            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairencours+$repairEffectuer;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente = Diagnostic::whereBetween('active', ['1','2'])->where('type','2')->count();
            /*======total revision en cours=========*/
            $revisionencours= Revision::where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
              //  ->where('site_id',$site)
                ->count();

            /*=========Total revision==========*/
            $revisionn=Revision::count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '5')->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
               // ->where('site_id',$site)
                ->count();

            /*Total Visite Technique*/

            $visitetechni=Visit_technique::count();
            //where('site_id',$site)->


            /*===========total visite effectuer==============*/
            $visitecheffetc= Visit_technique::where('state', '3')->count();

            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }
            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));






            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->where('users.connected',1)
//               -> where('employees.site_id',$site)
                ->count();
            $userTotal=User::join('employees','employees.id','=','users.employee_id')
//                ->where('employees.site_id',$site)
                ->count();
            /*****Expiration visite technique**********/

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

            /*********expiration visite technique********/

            $datee=new Date();
            $dated=$date->format('Y-m-d');
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
            /***diagnostique total**/

            $totaldiagnostique= Diagnostic::count();
//            $totaldiagnostique= Diagnostic::where('site_id',$site)->count();
            /*****approbation de piece en attente****/
//            $approbationenattente=DB::table('demands')
//                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
////                ->where('diagnostics.site_id',$site)
//                ->where('demands.state',0)->count();
            $approbationenattente=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
               // ->where('diagnostics.site_id',$request->site)
                ->where('demands.state','0')->count();


            /********bon de sortie validé*****/
            $bondesortievalide= Approval::count();
            $sites=Site::all();


            /*********nombre car dans le garage*****/

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

            $nbr_car_garage=0;
            for ($q=0;$q<count($data);$q++)
            {
                if(State::findOrFail($data[$q]))
                {
                    $processes[$p++] = State::where('id',$data[$q])->get();
                    $nbr_car_garage++;
                }

            }

            $nbreaccident = State::where('accident',1)->count();
            /**total accident kilometrage >100 0000***/

            $totalaccidentkilometrage = State::where('accident',1)
                ->where('kilometer','>',100000)->count();

            /********/
            $pannekm=State::where('accident','!=',1)
                ->where('kilometer','>',100000)->count();
            /***********panne  garage******/
            $nbr_panne_garage = State::where('panne_gar','=',1)
                                        ->count();



            return view('dashboard.administrator',compact('nbr_panne_garage','pannekm','totalaccidentkilometrage','nbreaccident','nbr_car_garage','bondesortievalide','approbationenattente','totaldiagnostique','num_visite_expiration','num_insurance_expiration','userTotal','userconnect','nbbus','sites','tableau_vehvitTech','taupiecevalider','pieceValider','pieceAvaliderr','taupieceAvalider','taupieceAvalider','nbrevehic','releasattente','releasevisiatten','releaserevisionattent','releasevhicrepair','releasevhicvisit','releasevhicRevision','releaseattentepair','repaittent','repairencours','repairEffectuer','repairs','tauxreparationoneffectuer','tauxreparationencours','tauxrevisioneffectuer','revisioneffectuer','revisionencours','revisionn','revisionattente','visitetechni','visitechencours','visiteTechnattente','tauxrevisionencours','tauxvisiteonecours','visitecheffetc','tauxvisiteoneffectuer','nbrepairattent','nbrevisitattente','nbrevisionattent','afterTestAttent','totaldiagnostique','totalbefor_test','tableau_proch','compteur_vt'));

        }

        elseif (Auth::user()->can('tableau de bord chef technicien'))
        {
            /*total diagnostique*/

            $site=Auth::user()->employee->site_id;

            /*Essai apres travaux effectuer*/
            $totalbefor_test=Work::where('type','1')
                ->where('site_id',$site)
                ->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')
             ->where('site_id',$site)
                ->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')
              ->where('site_id',$site)
                ->count();

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->whereBetween('diagnostics.active', ['1','2'])
                ->where('states.site_id',$site)
                ->where('diagnostics.type','2')->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type','2')
                 ->where('site_id',$site)
                ->count();

            /* bon de sortie en attente de validation*/
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state', '1')->orWhere('demands.state', '2')
              ->where('diagnostics.site_id',$site)
                ->count();




            /*======nbre total de véhicule===========*/
            $nbbus=DB::table('buses')
                 ->where('site_id',$site)
                ->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                ->where('demands.state','0')
                 ->where('states.site_id',$site)
                ->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                 ->where('states.site_id',$site)
                ->where('demands.state','3')
                ->count();
            /*=======taux============== */
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
                 ->where('diagnostics.site_id',$site)
                ->count();

            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')
                ->where('site_id',$site)
                ->count();



            /*======Total reparation==========*/
         //   $repairs=Repair::count();
           $repairs=Repair::where('site_id',$site)->count();

            /*=== Total encours de reparation===========*/
            $repairencours= Repair::where('site_id',$site)
                ->where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
                ->count();

            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairs;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente = Diagnostic::join('states','states.id','=','diagnostics.state_id')
            ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type','2')
                  ->where('states.site_id',$site)
                ->count();
            /*======total revision en cours=========*/
            $revisionencours= Revision::where('site_id',$site)
                ->where('state', '1')
                ->orWhere('state', '2')
                ->orWhere('state', '4')
                ->count();

            /*=========Total revision==========*/
            $revisionn=Revision::where('site_id',$site)->count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '3')
                ->where('site_id',$site)
                ->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::where('site_id',$site)->whereBetween('active', ['1','2'])->where('type', '3')
//                ->where('site_id',$site)
                ->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::where('site_id',$site)->where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
//                ->where('site_id',$site)
                ->count();

            /*Total Visite Technique*/

            $visitetechni=Visit_technique::where('site_id',$site)->count();
//            Visit_technique::where('site_id',$site)->count();


            /*===========total visite effectuer==============*/
            $visitecheffetc= Visit_technique::where('site_id',$site)->where('state', '3')->count();

            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }
            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));






            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->where('users.connected',1)
               // -> where('employees.site_id',$site)
                ->count();
            $userTotal=User::join('employees','employees.id','=','users.employee_id')
              //  ->where('employees.site_id',$site)
                ->count();
            /*****Expiration visite technique**********/

            $date=new Date();
            $dated=$date->format('Y-m-d');
            $startdate= $date->format('Y-m-d 00:00:00');
            $enddate= $date->format('Y-m-d 23:59:59');
            $buss =DB::table('buses')->where('site_id',$site)->get();
            $num_insurance_expiration=0;
            $insurance_expiration=[];

            $assuran=[];
            foreach ($buss as $bu)
            {

                $assuran=Assurance::where('site_id',$site)->where('bus_id',$bu->id)->orderBy('id','DESC')->first();

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

            /*********expiration visite technique********/

            $datee=new Date();
            $dated=$date->format('Y-m-d');
            $startdate= $datee->format('Y-m-d 00:00:00');
            $enddate= $datee->format('Y-m-d 23:59:59');
            $busess =DB::table('buses')->where('site_id',$site)->get();
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
            /***diagnostique total**/

            $totaldiagnostique= Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->where('states.site_id',$site)->count();
//            Diagnostic::where('site_id',$site)->count();
            /*****approbation de piece en attente****/
            $approbationenattente=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                ->where('states.site_id',$site)
                ->where('demands.state','0')->count();
            /********bon de sortie validé*****/
            $bondesortievalide= Approval::where('site_id',$site)->count();
            $sites=Site::all();



            /***********************/


            $nbreaccident = State::where('accident',1)
                                ->where('site_id',$site)
                                ->count();
            /**total accident kilometrage >100 0000***/

            $totalaccidentkilometrage = State::where('accident',1)
                ->where('site_id',$site)
                ->where('kilometer','>',100000)->count();

            /********/
            $pannekm=State::where('accident','!=',1)
                ->where('site_id',$site)
                ->where('kilometer','>',100000)->count();
            /***********panne  garage******/
            $nbr_panne_garage = State::where('panne_gar','=',1)
                ->where('site_id',$site)
                ->count();









            return view('dashboard.technical_Manager',compact('nbreaccident','totalaccidentkilometrage','pannekm','nbr_panne_garage','bondesortievalide','approbationenattente','totaldiagnostique','num_visite_expiration','num_insurance_expiration','userTotal','userconnect','nbbus','sites','tableau_vehvitTech','taupiecevalider','pieceValider','pieceAvaliderr','taupieceAvalider','taupieceAvalider','nbrevehic','releasattente','releasevisiatten','releaserevisionattent','releasevhicrepair','releasevhicvisit','releasevhicRevision','releaseattentepair','repaittent','repairencours','repairEffectuer','repairs','tauxreparationoneffectuer','tauxreparationencours','tauxrevisioneffectuer','revisioneffectuer','revisionencours','revisionn','revisionattente','visitetechni','visitechencours','visiteTechnattente','tauxrevisionencours','tauxvisiteonecours','visitecheffetc','tauxvisiteoneffectuer','nbrepairattent','nbrevisitattente','nbrevisionattent','afterTestAttent','totaldiagnostique','totalbefor_test','tableau_proch','compteur_vt'));

        }
        elseif (Auth::user()->can('tableau de bord stock'))
        {
            $site=Auth::user()->employee->site_id;

            $demands = Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
//                         ->where('diagnostics.site_id',$site)
            ->where('demands.state', '1')->orWhere('demands.state', '2')->count();


            $stockminimal = Stock::whereBetween('quantity',[0,10])->count();

            return view('dashboard.magasinier',compact('demands','stockminimal'));

        }
        elseif (Auth::user()->can('tableau de bord reception'))
        {
            return view('dashboard.magasinier');

        }


        else{
            return view('dashboard.reception');
        }

    }




public function technicaldashboardsite(Request $request)
{
    if($request->ajax())
    {
        if($request->site=='all_site')
        {
            $id = Auth::user()->employee->site_id;

            $employee_id=  Auth::user()->employee->id;
            $employee= Employee::findOrFail($employee_id);

            $employee->action_site=1;
            $employee->save();

            /*******************/
            $nbr_panne_garage = State::where('panne_gar','=',1)
                ->count();

            /************************/
            $pannekm=State::where('accident','!=',1)
                ->where('kilometer','>',100000)->count();
            /****nombre accident kilometrage >100000*****/
            $totalaccidentkilometrage = State::where('accident',1)
                ->where('kilometer','>',100000)->count();



            /***********************nombre car dans le garage*********/


            $process= State::all();
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

                    $processes[$p++] = State::where('site_id',$request->site)
                        ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                        ->where('id',$data[$q])->get();
                    $nbrevei++;



                    //        $processes[$p++] = ¨Process::where('site_id',$id_site)->where('id',$data[$q])->get();

                }

            }


            /**************/
            $nbreaccident = State::where('accident',1)
                                  ->count();


            /*****Total diagnostique***/
            $totaldiagnostique=DB::table('diagnostics')->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')->count() ;

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Revision::where('state', '3')->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type',2) ->count();



            /* bon de sortie en attente de validation*/
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                -> where('demands.state', '1')->orWhere('demands.state', '2')
                ->count();

            /* bon de sortie en attente de validation pour la reparation*/

            /*======nbre total de véhicule===========*/
            $nbrevehic=DB::table('buses')
                ->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state','0')
                ->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state','3')->count();
            /*=======taux============== */
            /********B.S validé*******/
            $bsvalide=Approval::count();
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')

                ->count();
            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')->count();



            /*======Total reparation==========*/
            $repairs=Repair::count();


            /*=== Total encours de reparation===========*/
            $repairencours=Repair::where('state', '1')->orWhere('state', '2')
                ->orWhere('state', '4')
                ->count();


            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairs;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')

                ->count();
            /*======total revision en cours=========*/
            $revisionencours=Revision::where('state', '1')
                ->orWhere('state', '2')->orWhere('state', '4')->count();


            /*=========Total revision==========*/
            $revisionn=Revision::count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '3')
                                  ->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')
                ->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')
                ->count();


            /*Total Visite Technique*/

            $visitetechni=Visit_technique::count();
            /*===========total visite effectuer==============*/
            $visitecheffetc=Visit_technique::where('state', '3')
               ->count();


            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }

            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));

            $approbationenattente=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state','0')->count();
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state', '1')->orWhere('demands.state', '2')
                ->count();

            $totalbefor_test=Work::where('type','1')
                ->count();
            $totalfournisseur=Supplier::count();

            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->where('users.connected',1)
                ->count();

            $userTotal=User::join('employees','employees.id','=','users.employee_id')
                ->count();


            /*********expiration visite technique********/

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

            /*********Assurance*/
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

            /***********bus dans le garage*******/
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
                    $processes[$p++] = State::where('id',$data[$q])->get();
                    $nbrevei++;

                }

            }






        }
        else{

            $id = Auth::user()->employee->site_id;
            $employee_id=  Auth::user()->employee->id;
            $employee= Employee::findOrFail($employee_id);

            $employee->site_id=$request->site;
            $employee->action_site=2;
            $employee->save();
            /*********************/

            $nbr_panne_garage = State::where('panne_gar','=',1)
                                  ->where('site_id',$request->site)
                                    ->count();


            /************************/
            $pannekm=State::where('accident','!=',1)
                ->where('kilometer','>',100000)
                        ->where('site_id',$request->site)
                       ->count();

            /****nombre accident kilometrage >100000*****/
            $totalaccidentkilometrage = State::where('accident',1)
                ->where('site_id',$request->site)
                ->where('kilometer','>',100000)->count();
            /***********************nombre car dans le garage*********/


            $process= State::where('site_id',$id)
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

                    $processes[$p++] = State::where('site_id',$request->site)
                        ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                        ->where('id',$data[$q])->get();
                    $nbrevei++;



                    //        $processes[$p++] = ¨Process::where('site_id',$id_site)->where('id',$data[$q])->get();

                }

            }
            /****nombre accident****/
            $nbreaccident = State::where('accident',1)
                ->where('site_id',$request->site)->count();

            /*****Total diagnostique***/
            $totaldiagnostique=DB::table('diagnostics')
                ->where('site_id',$request->site)->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')
                ->where('site_id',$request->site)
                ->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')
                ->where('site_id',$request->site)
                ->count() ;

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Revision::where('state', '3')
                ->where('site_id',$request->site)
                ->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type',2)
                ->where('site_id',$request->site)
                ->count();



            /* bon de sortie en attente de validation*/
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('diagnostics.site_id',$request->site)
                ->where('demands.state', '1')->orWhere('demands.state', '2')
                ->count();

            /* bon de sortie en attente de validation pour la reparation*/

            /*======nbre total de véhicule===========*/
            $nbrevehic=DB::table('buses')
                ->where('site_id',$request->site)
                ->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('demands.state','0')
                ->where('diagnostics.site_id',$request->site)
                ->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('diagnostics.site_id',$request->site)
                ->where('demands.state','3')->count();
            /*=======taux============== */
            /********B.S validé*******/
            $bsvalide=Approval::where('site_id',$request->site)
                ->count();
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')
                ->where('site_id',$request->site)
                ->count();
            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')->where('site_id',$request->site)->count();



            /*======Total reparation==========*/
            $repairs=Repair::where('site_id',$request->site)->count();


            /*=== Total encours de reparation===========*/
            $repairencours=Repair::where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })->count();


            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairs;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
//                ->where('site_id',$request->site)
                ->where('site_id',$request->site)
                ->count();
            /*======total revision en cours=========*/
            $revisionencours=Revision::where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })
                ->count();


            /*=========Total revision==========*/
            $revisionn=Revision::where('site_id',$request->site)
//                ->where('site_id',$request->site)
                ->count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '3')
//                ->where('site_id',$request->site)
                ->where('site_id',$request->site)
                ->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')
                ->where('site_id',$request->site)
                ->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })
                ->count();


            /*Total Visite Technique*/

            $visitetechni=Visit_technique::where('site_id',$request->site)
                ->count();
            /*===========total visite effectuer==============*/
            $visitecheffetc=Visit_technique::where('state', '3')
                ->where('site_id',$request->site)->count();


            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }

            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));

            $approbationenattente=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('diagnostics.site_id',$request->site)
                ->where('demands.state','0')->count();
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->where('diagnostics.site_id',$request->site)
                ->where('demands.state', '1')->orWhere('demands.state', '2')
                ->count();

            $totalbefor_test=Work::where('type','1')
                ->where('site_id',$request->site)
                ->count();
            $totalfournisseur=Supplier::where('site_id',$request->site)
                ->count();

            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->where('users.connected',1)
                ->where('employees.site_id',$request->site)
                ->count();

            $userTotal=User::join('employees','employees.id','=','users.employee_id')
                ->where('employees.site_id',$request->site)
                ->count();


            /*********expiration visite technique********/

            $datee=new Date();
            $dated=$datee->format('Y-m-d');
            $startdate= $datee->format('Y-m-d 00:00:00');
            $enddate= $datee->format('Y-m-d 23:59:59');
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

            /*********Assurance*/
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





            /********************/

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
                    $processes[$p++] = State::whereBetween('created_at',[$request->datedebu,$request->datefin])->where('site_id',$id_site)->where('id',$data[$q])->get();
                    $nbrevei++;

                }

            }


        }




        return Response::json([
             'nbrevei'=>$nbrevei,
            'nbr_panne_garage'=>$nbr_panne_garage,
            'pannekm'=>$pannekm,
            'totalaccidentkilometrage'=>$totalaccidentkilometrage,
            'nbreaccident'=>$nbreaccident,
            'revisioneffectuer'=>$revisioneffectuer,
            'num_visite_expiration'=>$num_visite_expiration,
            'approbationenattente'=>$approbationenattente,
            'totalbefor_test'=>$totalbefor_test,
            'totaldiagnostique'=>$totaldiagnostique,
            'num_insurance_expiration'=>$num_insurance_expiration,
            'nbrepairattent'=>$nbrepairattent,
            'nbrevisitattente'=>$nbrevisitattente,
            'nbrevisionattent'=>$nbrevisionattent,
            'afterTestAttent'=>$afterTestAttent,
            'totalfournisseur'=>$totalfournisseur,
            'userconnected'=>$userconnect,
            'totaluser'=>$userTotal,
            'bsvalide'=>$bsvalide,
            //  'releaseattentepair'=>$releaseattentepair,
            // 'releasevisiatten'=>$releasevisiatten,
            'releaserevisionattent'=>$releasattente,
            // 'releasevhicrepair'=>$releasevhicrepair,
            // 'releasevhicvisit'=>$releasevhicvisit,
            // 'releasevhicRevision'=>$releasevhicRevision,
            'nbrevehic'=>$nbrevehic,
            'pieceAvaliderr'=>$pieceAvaliderr,
            'pieceValider'=>$pieceValider,
            'taupieceAvalider'=>$taupieceAvalider,
            'taupiecevalider'=>$taupiecevalider,
            'repaittent'=>$repaittent,
            'repairEffectuer'=>$repairEffectuer,
            'repairencours'=>$repairencours,
            'tauxreparationoneffectuer'=>$tauxreparationoneffectuer,
            'tauxreparationencours'=>$tauxreparationencours,
            'revisionattente'=>$revisionattente,
            'revisionencours'=>$revisionencours,
            'tauxrevisioneffectuer'=>$tauxrevisioneffectuer,
            'tauxrevisionencours'=>$tauxrevisionencours,
            'visiteTechnattente'=>$visiteTechnattente,
            'visitechencours'=>$visitechencours,
            'tauxvisiteonecours'=>$tauxvisiteonecours,
            'tauxvisiteoneffectuer'=>$tauxvisiteoneffectuer,
            'visitecheffetc'=>$visitecheffetc

        ]);

    }
}

// Ajout de la route valeurs_notifications
    public function valeurs_notifications(Request $request){
        $poste = $request['poste'];
        $compteur_generale = 0;
        // Liste des véhicules en attente d'états
        $diagnostics = Diagnostic::where('state', '=', '1')->count();

        // Competur des Bons de sorties en attentes d'approbation
        $outputs = After_test::join('diagnostics', 'diagnostics.id', '=', 'after_tests.diagnostic_id')
          //  ->join('processes', 'processes.id', '=', 'diagnostics.process_id')
           // ->join('states', 'states.id', '=', 'processes.state_id')
           // ->join('vehicles', 'vehicles.id', '=', 'states.vehicle_id')
            ->join('models', 'models.id', '=', 'vehicles.model_id')
            ->select('after_tests.id as id', 'vehicles.matriculation as matriculation',
                'models.name as model', 'after_tests.observation as observation', 'after_tests.created_at as date', 'processes.reference as reference')
            ->where('after_tests.state', 1)->count();

        $compteur_generale =   $diagnostics + $outputs  ;
        return view('notification.header_notification',compact('diagnostics','poste','outputs','compteur_generale'));
    }
    // Ajout de la route valeurs_notifications
    public function nombre_notifications(Request $request){
        $compteur_generale = 0;
        // Liste des véhicules en attente d'états
        $diagnostics = Diagnostic::where('state', '=', '1')->count();

        // Competur des Bons de sorties en attentes d'approbation
        $outputs = After_test::join('diagnostics', 'diagnostics.id', '=', 'after_tests.diagnostic_id')
           // ->join('processes', 'processes.id', '=', 'diagnostics.process_id')
           // ->join('states', 'states.id', '=', 'processes.state_id')
           // ->join('vehicles', 'vehicles.id', '=', 'states.vehicle_id')
            ->join('models', 'models.id', '=', 'vehicles.model_id')
            ->select('after_tests.id as id', 'vehicles.matriculation as matriculation',
                'models.name as model', 'after_tests.observation as observation', 'after_tests.created_at as date', 'processes.reference as reference')
            ->where('after_tests.state', 1)->count();

        $compteur_generale =   $diagnostics + $outputs  ;

        return view('notification.nombre_notifications',compact('diagnostics','poste','outputs','compteur_generale'));
    }

    public function technicaldashboard(Request $request)
    {
        if($request->ajax())
        {
            /********************/
            $nbr_panne_garage = State::where('panne_gar','=',1)
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /**********************/
            $pannekm=State::where('accident','!=',1)
                ->where('kilometer','>',100000)
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /****nombre accident kilometrage >100000*****/
            $totalaccidentkilometrage = State::where('accident',1)
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('kilometer','>',100000)->count();

            /***********************nombre car dans le garage*********/


            $process= State::where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->get();
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

                    $processes[$p++] = State::where('site_id',$request->site)
                        ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                        ->where('id',$data[$q])->get();
                    $nbrevei++;



                    //        $processes[$p++] = ¨Process::where('site_id',$id_site)->where('id',$data[$q])->get();

                }

            }






            /******/
            $nbreaccident = State::where('accident',1)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /*****Total diagnostique***/
            $totaldiagnostique=DB::table('diagnostics')->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->count();
            /*Essai apres travaux effectuer*/
//            $totalbefor_test=Before_test::join('diagnostics','diagnostics.id','=','before_tests.diagnostic_id')
//               // ->join('processes','processes.id','=','diagnostics.process_id')
//               // ->join('states','states.id','=','processes.state_id')
//                ->where('diagnostics.state',5)
//                ->whereBetween('before_tests.created_at',[$request->datedebu,$request->datefin])
//                ->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count() ;

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Revision::where('state', '3')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type',2)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();



            /* bon de sortie en attente de validation*/
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                -> where('demands.state', '1')->orWhere('demands.state', '2')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
               // ->where('diagnostics.site_id',$request->site)
                ->count();

            /* bon de sortie en attente de validation pour la reparation*/




            /*total véhicule sortie apres revision*/



            /*======nbre total de véhicule===========*/
            $nbrevehic=DB::table('buses')->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
               ->where('demands.state','0')->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('demands.state','3')->count();
            /*=======taux============== */
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent= Diagnostic::whereBetween('active', ['1','2'])->where('type','1')->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();
            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();



            /*======Total reparation==========*/
            $repairs=Repair::whereBetween('created_at',[$request->datedebu,$request->datefin])->count();


            /*=== Total encours de reparation===========*/
            $repairencours=Repair::where('site_id',$request->site)
                ->where(function ($q){
                $q->where('state', '1')->orWhere('state', '2')
                    ->orWhere('state', '4');
                })
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();


            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairs;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();
            /*======total revision en cours=========*/
            $revisionencours=Revision::where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where(function ($q){
                    $q->where('state', '1')
                        ->orWhere('state', '2')->orWhere('state', '4');
                })
                ->count();


            /*=========Total revision==========*/
            $revisionn=Revision::whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '3')
//                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')
                    ->orWhere('state', '2')
                    ->orWhere('state', '4');
                })
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->count();



            /*Total Visite Technique*/

            $visitetechni=Visit_technique::whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->where('site_id',$request->site)
                ->count();


            /*===========total visite effectuer==============*/
            $visitecheffetc=Visit_technique::where('state', '3')
               // ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();


            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }

            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));

            $approbationenattente=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
               // ->where('diagnostics.site_id',$request->site)
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('demands.state',0)->count();
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
              //  ->where('diagnostics.site_id',$request->site)
            ->where('demands.state', '1')->orWhere('demands.state', '2')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
             //   ->where('diagnostics.site_id',$request->site)
                ->count();

            $totalbefor_test=Work::where('type',1)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
               // ->where('site_id',$request->site)
                ->count();
            $totalfournisseur=Supplier::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();
//            $totalfournisseur=Supplier::where('site_id',$request->site)
//                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
//                ->count();

            $userconnect=User::join('employees','employees.id','=','users.employee_id')
                ->where('users.connected',1)
              //  -> where('employees.site_id',$request->site)
                ->count();

            $userTotal=User::join('employees','employees.id','=','users.employee_id')
               // ->where('employees.site_id',$request->site)
                ->count();

            return Response::json([
                'nbrevei'=>$nbrevei,
                'nbr_panne_garage'=>$nbr_panne_garage,
                'pannekm'=>$pannekm,
                'nbreaccident'=>$nbreaccident,
                'revisioneffectuer'=>$revisioneffectuer,
                'approbationenattente'=>$approbationenattente,
                'totalbefor_test'=>$totalbefor_test,
                'totaldiagnostique'=>$totaldiagnostique,
                'nbrepairattent'=>$nbrepairattent,
                'nbrevisitattente'=>$nbrevisitattente,
                'nbrevisionattent'=>$nbrevisionattent,
                'afterTestAttent'=>$afterTestAttent,
                'totalfournisseur'=>$totalfournisseur,
                'userconnected'=>$userconnect,
                'totaluser'=>$userTotal,
              //  'releaseattentepair'=>$releaseattentepair,
               // 'releasevisiatten'=>$releasevisiatten,
               'releaserevisionattent'=>$releasattente,
               // 'releasevhicrepair'=>$releasevhicrepair,
               // 'releasevhicvisit'=>$releasevhicvisit,
               // 'releasevhicRevision'=>$releasevhicRevision,
                'nbrevehic'=>$nbrevehic,
                'pieceAvaliderr'=>$pieceAvaliderr,
                'pieceValider'=>$pieceValider,
                'taupieceAvalider'=>$taupieceAvalider,
                'taupiecevalider'=>$taupiecevalider,
                'repaittent'=>$repaittent,
                'repairEffectuer'=>$repairEffectuer,
                'repairencours'=>$repairencours,
                'tauxreparationoneffectuer'=>$tauxreparationoneffectuer,
                'tauxreparationencours'=>$tauxreparationencours,
                'revisionattente'=>$revisionattente,
                'revisionencours'=>$revisionencours,
                'tauxrevisioneffectuer'=>$tauxrevisioneffectuer,
                'tauxrevisionencours'=>$tauxrevisionencours,
                'visiteTechnattente'=>$visiteTechnattente,
                'visitechencours'=>$visitechencours,
                'tauxvisiteonecours'=>$tauxvisiteonecours,
                'tauxvisiteoneffectuer'=>$tauxvisiteoneffectuer,
                'visitecheffetc'=>$visitecheffetc,
                'totalaccidentkilometrage'=>$totalaccidentkilometrage

            ]);

        }
    }

    public function technicalManagerdashboard(Request $request)
    {
        if($request->ajax())
        {
            $request->site=Auth::user()->employee->site_id;
            /*****Total diagnostique***/
            $totaldiagnostique=DB::table('diagnostics')
                ->join('states','states.id','=','diagnostics.state_id')
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                  ->where('states.site_id',$request->site)
                ->count();

            /*===reparation effectuer en attente d'essai=======*/
            $nbrepairattent=Repair::where('state', '3')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->count();

            /* =======visite en attente d'essai==========*/
            $nbrevisitattente=Visit_technique::where('state', '3')
               ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count() ;

            /* revision en attente d'essai apres travo*/
            $nbrevisionattent=Revision::where('state', '3')
                 ->where('site_id', $request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();


            /*Essai apres travo en attente*/
            $afterTestAttent=Work::where('type',2)
                 ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();



            /* bon de sortie en attente de validation*/
            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                -> where('demands.state', '1')->orWhere('demands.state', '2')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('states.site_id',$request->site)
                ->count();

            /*======nbre total de véhicule===========*/
            $nbrevehic=DB::table('buses')
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();

            /*requette diagnostique et opertaion ,vehicule en attente de diagnostique et vehicule diagnostqué*/


            /*======total piece a valider=========*/
            $pieceAvaliderr=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
//                ->where('diagnostics.site_id',$request->site)
                ->where('demands.state','0')->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])->count();
            /*=========total piece valider==========*/
            $pieceValider=DB::table('demands')
                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
//                ->where('diagnostics.site_id',$request->site)
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('demands.state','3')->count();
            /*=======taux============== */
            /*etidité*/
            $totalpiece=$pieceAvaliderr+ $pieceValider;
            if($totalpiece==0)
            {
                $totalpiece=1;
            }
            $taupieceAvalider=round(($pieceAvaliderr* 100 /$totalpiece),PHP_ROUND_HALF_DOWN);
            /*valider*/
            $taupiecevalider=round((($pieceValider * 100)/ $totalpiece),PHP_ROUND_HALF_DOWN);



            //===========reparation=================//

            /*attente de reparation*/
            $repaittent= Diagnostic::join('states','states.id','=','diagnostics.state_id')
                ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type','1')

                  ->where('states.site_id',$request->site)
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])->count();
            /*=====total reparation effectuer============*/
            $repairEffectuer=Repair::where('state', '3')
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();



            /*======Total reparation==========*/
            $repairs=Repair::whereBetween('created_at',[$request->datedebu,$request->datefin])
                 ->where('site_id',$request->site)
                ->count();


            /*=== Total encours de reparation===========*/
            $repairencours=Repair::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')->orWhere('state', '2')
                        ->orWhere('state', '4');
                })
//                ->where('state', '1')->orWhere('state', '2')
//                ->orWhere('state', '4')
               ->count();


            //================TAUX REPARATION =============
            /*taux de reparation*/
            $nrepair=$repairs;
            if($nrepair==0)
            {
                $nrepair=1;
            }

            $tauxreparationoneffectuer=round(($repairEffectuer * 100)/($nrepair));
            /*taux en cours de revison*/
            $tauxreparationencours=round(($repairencours * 100)/($nrepair));



            /*========REVISION==========*/
            /*======attent de revision==========*/
            $revisionattente=Diagnostic::join('states','states.id','=','diagnostics.id')
                ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type','2')
                  ->where('states.site_id',$request->site)
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                ->count();
            /*======total revision en cours=========*/
            $revisionencours=Revision::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')
                        ->orWhere('state', '2')->orWhere('state', '4');
                })

                ->count();


            /*=========Total revision==========*/
            $revisionn=Revision::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->count();
            /*========total revision effectuer=========*/
            $revisioneffectuer=Revision::where('state', '3')
                 ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();
            /*=======total revision effectuer=========*/


            /*====calcule de taux======*/
            //================taux revision effectuer================
            $nbreviso=$revisionn;
            if($nbreviso==0)
            {
                $nbreviso=1;
            }
            $tauxrevisioneffectuer=round(($revisioneffectuer * 100)/($nbreviso));
            /*taux en cours de revison*/
            $tauxrevisionencours=round(($revisionencours * 100)/($nbreviso));

            /*========Total visite technique en attente========*/
            $visiteTechnattente=Diagnostic::join('states','states.id','=','diagnostics.state_id')
            ->whereBetween('diagnostics.active', ['1','2'])->where('diagnostics.type', '3')
                ->whereBetween('diagnostics.created_at',[$request->datedebu,$request->datefin])
                ->where('states.site_id',$request->site)
                ->count();
            /*en cours de  visite Technique*/
            $visitechencours=Visit_technique::whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->where(function ($q){
                    $q->where('state', '1')
                        ->orWhere('state', '2')
                        ->orWhere('state', '4');
                })
              //  ->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')
                ->count();



            /*Total Visite Technique*/

            $visitetechni=Visit_technique::whereBetween('created_at',[$request->datedebu,$request->datefin])
               ->where('site_id',$request->site)
                ->count();


            /*===========total visite effectuer==============*/
            $visitecheffetc=Visit_technique::where('state', '3')
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])->count();


            /*taux visite technique*/
            $nbrevisit=$visitecheffetc + $visitechencours;

            if($nbrevisit==0)
            {
                $nbrevisit=1;
            }

            //=========taux viste effectuer
            $tauxvisiteoneffectuer=round(($visitecheffetc * 100)/($nbrevisit));
            $tauxvisiteonecours=round(($visitechencours * 100)/($nbrevisit));

//            $approbationenattente=DB::table('demands')
//                ->join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
//                //->where('diagnostics.site_id',$request->site)
//                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
//                ->where('demands.state',0)->count();

            $approbationenattente= Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
                ->where('demands.state', '0')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                ->where('states.site_id',$request->site)
                ->count();


            $releasattente=Demand::join('diagnostics','diagnostics.id','=','demands.diagnostic_id')
                ->join('states','states.id','=','diagnostics.state_id')
           ->where('diagnostics.site_id',$request->site)
                ->where('demands.state', '1')->orWhere('demands.state', '2')
                ->whereBetween('demands.created_at',[$request->datedebu,$request->datefin])
                  ->where('states.site_id',$request->site)
                ->count();

            $totalbefor_test=Work::where('type','1')
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                 ->where('site_id',$request->site)
                ->count();




            /************************/
            $pannekm=State::where('accident','!=',1)
                ->where('kilometer','>',100000)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->count();
            /****nombre accident kilometrage >100000*****/
            $totalaccidentkilometrage = State::where('accident',1)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('kilometer','>',100000)
                ->where('site_id',$request->site)
                ->count();


            $nbr_panne_garage = State::where('panne_gar','=',1)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->where('site_id',$request->site)
                ->count();

            $nbreaccident = State::where('accident',1)
                ->where('site_id',$request->site)
                ->whereBetween('created_at',[$request->datedebu,$request->datefin])
                ->count();




            return Response::json([
                'totalaccidentkilometrage'=>$totalaccidentkilometrage,
                'pannekm'=>$pannekm,
                'nbreaccident'=>$nbreaccident,
                'nbr_panne_garage'=>$nbr_panne_garage,
                'nbr_panne_garage'=>$nbr_panne_garage,
                'revisioneffectuer'=>$revisioneffectuer,
                'approbationenattente'=>$approbationenattente,
                'totalbefor_test'=>$totalbefor_test,
                'totaldiagnostique'=>$totaldiagnostique,
                'nbrepairattent'=>$nbrepairattent,
                'nbrevisitattente'=>$nbrevisitattente,
                'nbrevisionattent'=>$nbrevisionattent,
                'afterTestAttent'=>$afterTestAttent,

                //  'releaseattentepair'=>$releaseattentepair,
                // 'releasevisiatten'=>$releasevisiatten,
                'releaserevisionattent'=>$releasattente,
                // 'releasevhicrepair'=>$releasevhicrepair,
                // 'releasevhicvisit'=>$releasevhicvisit,
                // 'releasevhicRevision'=>$releasevhicRevision,
                'nbrevehic'=>$nbrevehic,
                'pieceAvaliderr'=>$pieceAvaliderr,
                'pieceValider'=>$pieceValider,
                'taupieceAvalider'=>$taupieceAvalider,
                'taupiecevalider'=>$taupiecevalider,
                'repaittent'=>$repaittent,
                'repairEffectuer'=>$repairEffectuer,
                'repairencours'=>$repairencours,
                'tauxreparationoneffectuer'=>$tauxreparationoneffectuer,
                'tauxreparationencours'=>$tauxreparationencours,
                'revisionattente'=>$revisionattente,
                'revisionencours'=>$revisionencours,
                'tauxrevisioneffectuer'=>$tauxrevisioneffectuer,
                'tauxrevisionencours'=>$tauxrevisionencours,
                'visiteTechnattente'=>$visiteTechnattente,
                'visitechencours'=>$visitechencours,
                'tauxvisiteonecours'=>$tauxvisiteonecours,
                'tauxvisiteoneffectuer'=>$tauxvisiteoneffectuer,
                'visitecheffetc'=>$visitecheffetc

            ]);

        }
    }

public function historiqueapp()
{
    $vehicule=DB::table('buses')->get();
     $processe=State::all();
    $diagnostics=Diagnostic::all();
    $assurance=Assurance::all();
    $brand=Brand::all();
    $visit=Visit_technique::all();
    $repair=Repair::all();
    $revision=Revision::all();
    $state=State::all();
    $sites=Site::all();
    $stock=Stock::all();
    $suppliers=Supplier::all();
    $entreprises=Entreprise::all();
    $subcategorys=Sub_category::all();
    $postes=Post::all();
    $services=Service::all();
    $models=Models::all();
    $brands=Brand::all();
    $employes=Employee::all();
    $visite_techniques=Visit_technique::all();
    $revisions=Revision::all();
    $repairs=Repair::all();



    return view('historique.historiqueapp',compact('diagnostics','processe','vehicule','repairs','revisions','visite_techniques','suppliers','employes','entreprises','sites','subcategorys','postes','services','models','brands'));


}

}

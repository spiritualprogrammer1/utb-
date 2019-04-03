<?php

namespace App\Http\Controllers;

use App\After_work;
use App\Diagnostic;
use App\Visit;
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
        $id=Auth::user()->employee->site_id;

        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
             //   $technicians = Employee::where('post_id', '1')->where('site_id',$id)->get();

                $technicians = Employee::where('post_id', '1')->get();
                $repairs = Repair::where('state', '3')->where('site_id',$id)->get();

            }
            else{
                $technicians = Employee::where('post_id', '1')->get();
                $repairs = Repair::where('state', '3')->get();
            }
        }
        else{
           // $technicians = Employee::where('post_id', '1')->where('site_id',$id)->get();

            $technicians = Employee::where('post_id', '1')->get();

            $repairs = Repair::where('state', '3')->where('site_id',$id)->get();

        }
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
            $descriptions = Service_description::where('diagnostic_id', $id)->orderBy('created_at', 'desc')->get();
            return response()->json($descriptions);
        } else {
            return view('errors.500');
        }
    }


    public function edit($id)
    {
        $site_id=Auth::user()->employee->site_id;
        if ($id == 1) {

            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $repairs = Repair::where('state', '3')->where('site_id',$site_id)->get();

                }
                else{
                    $repairs = Repair::where('state', '3')->get();

                }
            }
            else
            {
                $repairs = Repair::where('state', '3')->where('site_id',$site_id)->get();

            }

            return view('afterworks.includes.repair', ['repairs' => $repairs]);
        } elseif ($id == 2) {
            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $revisions = Revision::where('state', '3')->where('site_id',$site_id)->get();
                }
                else{
                    $revisions = Revision::where('state', '3')->get();
                }
            }
            else{
                $revisions = Revision::where('state', '3')->where('site_id',$site_id)->get();

            }


            return view('afterworks.includes.revision', ['revisions' => $revisions]);
        } else {

            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $visits = Visit_technique::where('state', '3')->where('site_id',$site_id)->get();

                }
                else{
                    $visits = Visit_technique::where('state', '3')->get();

                }

            }
            else{
                $visits = Visit_technique::where('state', '3')->where('site_id',$site_id)->get();

            }

            return view('afterworks.includes.visit', ['visits' => $visits]);
        }
    }

    public function score()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {

                $testVisit=Visit_technique::where('site_id',$site_id)->where('state', '3')->count();
                $testRevision=Revision::where('site_id',$site_id)->where('state', '3')->count();
                $testRepaire=Repair::where('site_id',$site_id)->where('state', '3')->count();
                $repairencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $revisionencours=Revision::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $visitencours=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();
                $aftertestvisit=Visit_technique::where('state', '5')->where('site_id',$site_id)->count();
                $aftertestrevision=Revision::where('state', '5')->where('site_id',$site_id)->count();
                $aftertestrepair= Repair::where('state', '5')->where('site_id',$site_id)->count();


            }
            else{
                $testVisit=Visit_technique::where('state', '3')->count();
                $testRevision=Revision::where('state', '3')->count();
                $testRepaire=Repair::where('state', '3')->count();
                $repairencours=Repair::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $revisionencours=Revision::where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
                $visitencours=Visit_technique::where('state', '1')->orWhere('state', '2')->count();
                $aftertestvisit=Visit_technique::where('state', '5')->count();
                $aftertestrevision=Revision::where('state', '5')->count();
                $aftertestrepair= Repair::where('state', '5')->count();

            }
        }
        else{

            $testVisit=Visit_technique::where('site_id',$site_id)->where('state', '3')->count();
            $testRevision=Revision::where('site_id',$site_id)->where('state', '3')->count();
            $testRepaire=Repair::where('site_id',$site_id)->where('state', '3')->count();
            $repairencours=Repair::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
            $revisionencours=Revision::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->orWhere('state', '4')->count();
            $visitencours=Visit_technique::where('site_id',$site_id)->where('state', '1')->orWhere('state', '2')->count();
            $aftertestvisit=Visit_technique::where('state', '5')->where('site_id',$site_id)->count();
            $aftertestrevision=Revision::where('state', '5')->where('site_id',$site_id)->count();
            $aftertestrepair= Repair::where('state', '5')->where('site_id',$site_id)->count();


        }


        return response()->json(['aftertestrepair'=>$aftertestrepair,'aftertestrevision'=>$aftertestrevision,'aftertestvisit'=>$aftertestvisit,'testVisit'=>$testVisit,'visitencours'=>$visitencours,'revisionencours'=>$revisionencours,'repairencours'=>$repairencours,'testVist'=>$testVisit,'testRevision'=>$testRevision,'testRepaire'=>$testRepaire]);
    }


    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
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
            }
            else {
                if ($request->has('repair')) {
                    $diagnostic = Repair::findOrFail($id)->diagnostic_id;
                    $repair = Repair::findOrFail($id)->update(['state' => $request->valid]);
                } elseif ($request->has('revision')) {
                    $diagnostic = Revision::findOrFail($id)->diagnostic_id;
                    $revision = Revision::findOrFail($id)->update(['state' => $request->valid]);
                } else {
                    $diagnostic = Visit_technique::findOrFail($id)->diagnostic_id;
                    $visit = Visit_technique::findOrFail($id)->update(['state' => $request->valid]);
                }
                $reference = Diagnostic::findOrFail($diagnostic);
                $works = Work::create([
                    'ids' => Carbon::now()->timestamp,
                    'type' => '2',
                    'state' => $request->valid,
                    'distance' => $request->distance,
                    'arrive'=> $request->arrive,
                    'place' => $request->place,
                    'description' => $request->description,
                    'employee_id' => $request->tester,
                    'diagnostic_id' => $diagnostic,
                    'user_id' => Auth::user()->id,
                    'site_id' => Auth::user()->id,
                ]);
                return response()->json(['id' => $id, 'reference' => $reference,'work_id'=>$works->id]);
            }
        }
// else {
//            return view('errors.500');
//        }
    }

    public function filesafertworks(Request $request,$id)
    {

        $before_test=Work::where('id',$id)->where('type','2')->get();
        return view('afterworks.file.fileworksafter',compact('before_test'));

    }

    public function destroy($id)
    {
        //
    }
}

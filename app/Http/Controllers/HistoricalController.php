<?php

namespace App\Http\Controllers;

use App\Bus;
use App\State;
use Illuminate\Http\Request;

class HistoricalController extends Controller
{

    public function gethistoricalHome()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $buses =Bus::where('site_id',$site_id)->get();
            }
            else{
                $buses =Bus::all();
            }
        }
        else{
            $buses =Bus::where('site_id',$site_id)->get();
        }

        return view('historique.historicaltechnique',compact('buses'));
    }
    public function histoByVehicle(Request $request,$id){
        if ($request->ajax()) {
            $buses = Bus::findOrFail($id);
            return view('historique.include.histo_by_bus',compact('buses'));
        }
    }
    public function periodicalHisto(Request $request)
    {
        if($request->ajax())
        {
            $begin = $request->begin . ' 00:00:00';
            $end = $request->end . ' 23:59:59';
            $bus = Bus::findOrFail($request->car);

//            $diags = Diagnostic::join('states','states.id','diagnostics.state_id')
//                ->join('buses','buses.id','states.bus_id')
//                ->select('diagnostics.id as id','states.reference as reference')
//                ->where('buses.id',$bus->id)
//                ->whereBetween('states.created_at',[$begin, $end])
//                ->groupBy('diagnostics.id')
//                ->get();

            $diags= State::where('bus_id',$bus->id)->whereBetween('states.created_at',[$begin, $end])->get();


            return view('historique.include.periodical_histo', compact('diags','begin','end'));
        }
    }
}

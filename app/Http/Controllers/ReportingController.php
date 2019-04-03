<?php

namespace App\Http\Controllers;

use App\Bus;
use App\Diagnostic;
use App\State;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
   public function index()
   {
       $bus = Bus::all();


       return view ('reporting.index',compact('bus'));
   }

   public function reporting(Request $request)
   {

if(isset($request->datedebu) and !empty($request->datedebu) or isset($request->datefin) and !empty($request->datefin) )
{
    /*********total societe************/
    if($request->societe)
    {
        if($request->societe=="total" )

        {



            if($request->site=="total" and $request->car=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::whereBetween('created_at',[$request->datedebu,$request->datefin])->get();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->car !="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->car=="total" and $request->site!="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->site!="total"  and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->site=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->site !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->site=="total" and $request->car=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->car !="total" and $request->prestation!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total *********************/
            if($request->car=="total" and $request->site !="total"  and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->car !="total" and $request->site !="total"  )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->site=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }



    }

    /***********total site*******/

    /*********total site************/
    if($request->site)
    {
        if($request->site=="total")

        {



            if($request->societe=="total" and $request->car=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::whereBetween('created_at',[$request->datedebu,$request->datefin])->get();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->societe=="total" and $request->car!="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->car=="total" and $request->prestation !="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->car !="total" and $request->car !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->societe=="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->societe=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->societe=="total" and $request->car=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->societe=="total" and $request->car !="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total *********************/
            if($request->car=="total" and $request->prestation !="total" and $request->societe!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->car !="total" and !$request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->societe=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->societe=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /*********tous les chamsp existant**********/

            /***************prestation = total *********************/

            if($request->prestation!="total" and $request->car !="total" and !$request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }





        }



    }



    /*********total car************/
    if($request->car)
    {
        if($request->car=="total" )

        {



            if($request->site=="total" and $request->societe=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::whereBetween('created_at',[$request->datedebu,$request->datefin])->get();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->societe !="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->societe)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->societe=="total" and $request->site!="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->site!="total"  and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->societe=="total" and $request->site=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->site !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->site=="total" and $request->societe=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->car)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->societe !="total" and $request->prestation!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************societe = total *********************/
            if($request->societe=="total" and $request->site !="total"  and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->societe !="total" and $request->site !="total"  )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************societe = total and site=total**********/

            if($request->societe=="total" and $request->site=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])

                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->whereBetween('states.created_at',[$request->datedebu,$request->datefin])
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }



    }




}
else{
    /*********total societe************/
    if($request->societe)
    {
        if($request->societe=="total" )

        {



            if($request->site=="total" and $request->car=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::all();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->car !="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->car=="total" and $request->site!="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->site!="total"  and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->site=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->site !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->site=="total" and $request->car=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->car !="total" and $request->prestation!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total *********************/
            if($request->car=="total" and $request->site !="total"  and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->car !="total" and $request->site !="total"  )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->site=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }



    }

    /***********total site*******/

    /*********total site************/
    if($request->site)
    {
        if($request->site=="total")

        {



            if($request->societe=="total" and $request->car=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::all();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->societe=="total" and $request->car!="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->car=="total" and $request->prestation !="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->car !="total" and $request->car !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->societe=="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->societe=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->societe=="total" and $request->car=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->societe=="total" and $request->car !="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total *********************/
            if($request->car=="total" and $request->prestation !="total" and $request->societe!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->car !="total" and !$request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->car=="total" and $request->societe=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->societe=="total" and $request->prestation=="total" and $request->car !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /*********tous les chamsp existant**********/

            /***************prestation = total *********************/

            if($request->prestation!="total" and $request->car !="total" and !$request->societe !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }





        }



    }



    /*********total car************/
    if($request->car)
    {
        if($request->car=="total" )

        {



            if($request->site=="total" and $request->societe=="total" and  $request->prestation=="total" )
            {

                $diagnostics = Diagnostic::all();



                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->societe !="total" and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->societe)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************car = total and societe=total*********************/
            if($request->societe=="total" and $request->site!="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total and societe=total*********************/

            if($request->prestation=="total" and $request->site!="total"  and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->societe)
                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************car = total and site=total**********/

            if($request->societe=="total" and $request->site=="total" and $request->prestation !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" and $request->site !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" and $request->societe !="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }
        else{



            if($request->site=="total" and $request->societe=="total" and  $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.societe','=',$request->car)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

                //    return view('reporting.include.data',compact('diagnostics'));

            }
            /***************site = total and societe=total*********************/

            if($request->site=="total" and $request->societe !="total" and $request->prestation!="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('buses.id','=',$request->car)
                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }
            /***************societe = total *********************/
            if($request->societe=="total" and $request->site !="total"  and $request->prestation !="total")
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')

                    ->where('diagnostics.type','=',$request->prestation)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /***************prestation = total *********************/

            if($request->prestation=="total" and $request->societe !="total" and $request->site !="total"  )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('states.site_id','=',$request->site)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************niveau 3**********/

            /******************societe = total and site=total**********/

            if($request->societe=="total" and $request->site=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('diagnostics.type','=',$request->prestation)

                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************car = total and prestation=total**********/

            if($request->car=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.societe','=',$request->societe)

                    ->where('states.site_id','=',$request->site)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }

            /******************site = total and prestation=total**********/

            if($request->site=="total" and $request->prestation=="total" )
            {
                $diagnostics = Diagnostic::join('states','states.id','=','diagnostics.state_id')
                    ->join('buses','buses.id','=','states.bus_id')
                    ->where('buses.id','=',$request->car)
                    ->where('buses.societe','=',$request->societe)
                    ->get();

                return view('reporting.include.data',compact('diagnostics'));

            }




        }



    }



}


       //  }


       /*********car*******/







   }
}

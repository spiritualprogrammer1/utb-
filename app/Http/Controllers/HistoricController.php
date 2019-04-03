<?php

namespace App\Http\Controllers;


use App\Bus;
use App\State;
use App\Transformers\BusTransformer;
use Illuminate\Http\Request;
use Jenssegers\Date\Date;
use Spatie\Fractalistic\ArraySerializer;

class HistoricController extends Controller
{
    public function __construct()
    {
        Date::setLocale('fr');
    }

    public function index()
    {
        $bus = Bus::get();




        return view('historique.home');
    }

    public function edit($id)
    {
        echo $id;
    }

    public function create()
    {

        $bus = Bus::all();



        return fractal()
            ->collection($bus)
            ->parseIncludes(['children'])
            ->transformWith(new BusTransformer())
            ->serializeWith(new ArraySerializer())
            ->toArray();



    }

    public function show(Request $request, $id)
    {
        $states = State::where('reference', $id)->get();
        $path = '../../uploads/outsides/';
        return view('historique.timeline', ['states' => $states, 'path' => $path]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Block;
use App\Brand;
use App\Category;
use App\Delivery;
use App\Demand;
use App\Demand_piece;
use App\Diagnostic;
use App\Engine;
use App\Filestock;
use App\Item_stock;
use App\Inventory;
use App\Models;
use App\Movement_stock;
use App\Ray;
use App\Shelve;
use App\Stock;
use App\Sub_category;
use App\Supplier;
use App\Type;
use App\Typetire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validator;
use Jenssegers\Date\Date;

class StockController extends Controller
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
                $stocks = Stock::where('site_id',$site_id)->get();
            }
            else{
                $stocks = Stock::all();
            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get();
        }

        $suppliers = Supplier::select('id', 'name')->get();

        return view('stock.list', compact('suppliers', 'stocks'));
    }

    public function output()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
                $demands = Demand::whereHas('diagnostic',function ($query){
                    $query->whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);
                    });

                })->where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();

            }
            else{
                $stocks = Stock::where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
                $demands = Demand::where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();

            }
        }
        else{

            $stocks = Stock::where('site_id',$site_id)->where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
            $demands = Demand::whereHas('diagnostic',function ($query){
                $query->whereHas('statee',function ($q){
                    $site_id=Auth::user()->employee->site_id;
                    $q->where('site_id',$site_id);
                });

            })->where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();

        }
        return view('stock.output', [ 'stocks' => $stocks, 'demands' => $demands]);
    }

    public function show(Request $request, $id)
    {
        if ($id == "demand"){
            $site_id=Auth::user()->employee->site_id;
            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $stocks = Stock::where('site_id',$site_id)->where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
                    $demands = Demand::whereHas('diagnostic',function ($query){
                        $query->whereHas('statee',function ($q){
                            $site_id=Auth::user()->employee->site_id;
                            $q->where('site_id',$site_id);
                        });

                    })->where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();



                }
                else{
                    $stocks = Stock::where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
                    $demands = Demand::where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();

                }
            }
            else{
                $stocks = Stock::where('site_id',$site_id)->where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
                $demands = Demand::whereHas('diagnostic',function ($query){
                    $query->whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);
                    });

                })->where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();

            }
            return view('stock.includes.output', ['stocks' => $stocks, 'demands' => $demands])->with(['id'=>$id]);
        }elseif ($id == "delivered"){

            $site_id=Auth::user()->employee->site_id;
            if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
                if (Auth::user()->employee->action_site == 2) {
                    $demands = Demand::whereHas('diagnostic',function ($query){
                        $query->whereHas('statee',function ($q){
                            $site_id=Auth::user()->employee->site_id;
                            $q->where('site_id',$site_id);
                        });

                    })->where('state', '2')->orWhere('state', '3')->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'))->orderBy('updated_at', 'desc')->get();
                }
                else{
                    $demands = Demand::where('state', '2')->orWhere('state', '3')->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'))->orderBy('updated_at', 'desc')->get();

                }
            }
            else{
                $demands = Demand::whereHas('diagnostic',function ($query){
                    $query->whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);
                    });

                })->where('state', '2')->orWhere('state', '3')->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))->orderBy('updated_at', 'desc')->get();
            }




            return view('stock.includes.output', ['demands' => $demands])->with(['id'=>$id]);
        }else{
            $pieces = Demand_piece::where('demand_id', $id)->where('state', '0')->get();
            return response()->json($pieces);
        }
    }


    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $types = Type::all();

        $deliveries = Delivery::select('ids', 'number')->get();
        $suppliers = Supplier::where('type', '=', '0')->get();
        $rays = Ray::select('id', 'name')->get();

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->get();
            }
            else{
                $stocks = Stock::all()->sortByDesc("updated_at");
            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("updated_at");
        }




        return view('stock.create', compact('brands', 'categories', 'types', 'stocks', 'suppliers', 'rays', 'deliveries'));
    }

    public function saveEngine(Request $request)
    {
        $messages = array(
            'stock_delivery.required' => "Veuillez choisir un Bon de Livraison",
            'model.required' => "Veuillez choisir le Model du Moteur",
            'sub_category.required' => "Veuillez choisir la Sous Famille",
            'block.required' => "Veuillez Choisir un Casier",
            'type.required' => "Veuillez Choisir l'etat du moteur",
             'type.quantity' => "Veuillez Entrer la quantité svp!",
            'libelle.required'=>'Veuillez entrer un libelle svp!',
            'libelle.unique'=>'libelle exite déja!',
            'type_moteur.required'=>'Veuillez choisir un type de moteur',
        );
        $rules = array(
            'stock_delivery' => 'bail|required|min:1|max:255',
            'model' => 'bail|required|min:1|max:255|',
            'sub_category' => 'bail|required|min:1|max:255|',
            'block' => 'bail|required|min:1|max:255|',
            'type' => 'bail|required|min:1|max:255|',
            'quantity'=>'bail|required',
            'type_moteur'=>'bail|required',
            'libelle'=>'bail|required|min:3|unique:engines'
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



            if($request->hasFile('image_engine')) {
                $image = $request['image_engine'];

                $input['image_engine'] = time().'.'. $image->getClientOriginalExtension();
                $destinationPath = public_path('/picture');
                $image->move($destinationPath, $input['imagename']);
            }
            else{
                $input['image_engine']="";
            }


            $site=Auth::user()->employee->site_id;
            $engine= Stock::create([
                'ids' => Carbon::now()->timestamp,
                'reference' => $request->reference,
                'delivery_id' => $request->stock_delivery,
                'model_id' => $request->model,
                'sub_category_id' => $request->sub_category,
                'type_id' => $request->type,
                'block_id' => $request->block,
                'vitesse'=>$request->vitesse,
                'mileage'=>$request->mileage,
                'quantity'=>$request->quantity,
                'libelle'=>$request->libelle,
                'type_moteur'=>$request->type_moteur,
                'stock_type'=>$request->stock_type,
                'libelle'=>$request->libelle,
                'horse'=>$request->horse,
                'image_engine'=>$input['image_engine'],
                'site_id'=>$site,
                'displacement'=>$request->displacement,
                'power'=>$request->power,




            ]);
            return response()->json(['id' => $engine->id, 'reference' => $engine->reference,
                '' => $engine->type->name,  'type' => $engine->type->name, 'family' => $engine->sub_category->category->name,
                'sub' => $engine->sub_category->name, 'quantity' => $engine->quantity,
                'date' => Date::parse($engine->created_at)->format('j M Y')]);
        }

    }

    public function createEngine()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $types = Type::all();

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $engine =  Stock::where('stock_type',1)->where('site_id',$site_id)->get();
            }
            else{
                $engine =  Stock::where('stock_type',1)->get();
            }
        }
        else{
            $engine =  Stock::where('stock_type',1)->where('site_id',$site_id)->get();
        }

        $deliveries = Delivery::select('ids', 'number')->get();
        $suppliers = Supplier::where('type', '=', '0')->get();
        $rays = Ray::select('id', 'name')->get();
        return view('stock.engine.create', compact('brands', 'categories', 'types', 'engine', 'suppliers', 'rays', 'deliveries'));


    }

    public function createMoteur()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $types = Type::all();
        $engine =  Engine::all()->sortByDesc("updated_at");
        $deliveries = Delivery::select('ids', 'number')->get();
        $suppliers = Supplier::where('type', '=', '0')->get();
        $rays = Ray::select('id', 'name')->get();
        return view('stock.engine.createMoteur', compact('brands', 'categories', 'types', 'engine', 'suppliers', 'rays', 'deliveries'));


    }

    public function store(Request $request)
    {
        //if ($request->ajax()) {
            if ($request->has("delivery")) {
                $messages = array(
                    'number.required' => "La Référence de Bon est obligatoire",
                    'order.required' => "La Référence de la Commande est obligatoire",
                    'date.required' => "La Date d'Etablissement est obligatoire",
                    'supplier.required' => "Veuillez Choisir un Fournisseur",
                    'image.required' => "Veuillez Charge le Bon de Livraison",
                );
                $rules = array(
                    'number' => 'bail|required|min:3|max:255',
                    'order' => 'bail|required|min:2|max:255',
                    'date' => 'bail|required|min:1|max:255',
                    'supplier' => 'bail|required|min:1|max:255',
                    'image' => 'bail|required|min:1|max:10000',
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
                    if ($request->hasFile('image')) {
                        $image = $request->file('image');
                        $input['image'] = time() . "_" . uniqid() . '.' . $image->getClientOriginalExtension();
                        $filename = $input['image'];
                        $destinationPath = public_path('assets/uploads/delivery');
                        $image->move($destinationPath, $filename);
                    } else {
                        $filename = "";
                    }
                    $delivery = Delivery::create([
                        'ids' => Carbon::now()->timestamp,
                        'number' => $request->number,
                        'order' => $request->order,
                        'amount' => $request->amount,
                        'image' => $filename,
                        'supplier_id' => $request->supplier,
                        'delivered_at' => $request->date,
                        'user_id' => Auth::user()->id,
                    ]);
                    return response()->json(['ids' => $delivery->ids, 'number' => $delivery->number, 'amount' => number_format($delivery->amount),
                        'delivered' => Date::parse($delivery->delivered_at)->format('d/m/Y'), 'supplier' => $delivery->supplier->name,
                        'order' => $delivery->order, 'date' => $delivery->created_at->format('d/m/Y'), 'count' => $delivery->count()]);
                }
            }
            elseif ($request->has("output")) {
                $messages = array(
                    'demand.required' => "La reference de la demande est obligatoire ",
                    'reference.required' => "La Reférence du stock est obligatoire ",
                    'quantity.required' => "La Quantité est requise",
                );
                $rules = array(
                    'demand' => 'bail|required|min:1|max:255',
                    'reference' => 'bail|required|min:1|max:255',
                    'quantity' => 'bail|required|min:1|max:255|',#
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
                    $movement = Movement_stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => "srt-" . Carbon::now()->timestamp,
                        'demand_id' => $request->demand,
                    ]);

                    $demand = Demand::findOrFail($request->demand)->update(['state' => '2']);
                    $diagnostic = Demand::findOrFail($request->demand)->diagnostic->update(['active' => '2']);

                    for ($i = 0; $i < $count = count($request->reference); $i++) {
                        $demand_piece = Demand_piece::findOrFail($request->piece[$i]);
                        if ($demand_piece->state == '0') {
                            $demand_piece = Demand_piece::findOrFail($request->piece[$i])->update([
                                'delivered' => $request->delivered[$i] + $request->quantity[$i],
                            ]);
                            $stock_quantity = Stock::findOrFail($request->reference[$i]);
                            $quantity_old = $stock_quantity->quantity;
                            $result = $quantity_old - $request->quantity[$i];
                            $stock = Stock::findOrFail($request->reference[$i])->update(['quantity' => $result]);

                            $item_stock = Item_stock::create([
                                'ids' => Carbon::now()->timestamp,
                                'stock_id' => $request->reference[$i],
                                'movement_stock_id' => $movement->id,
                                'quantity' => $request->quantity[$i],
                                'quantity_old' => $quantity_old,
                                'state_id'=>$request->state_id
                            ]);
                        }
                        $demand_piece = Demand_piece::findOrFail($request->piece[$i]);
                        if ($demand_piece->quantity == $demand_piece->delivered) {
                            $demand_piece = Demand_piece::findOrFail($request->piece[$i])->update([
                                'state' => '1',
                            ]);
                        }
                    }
                    $demand_piece = Demand_piece::where('demand_id', $request->demand)->get();

                    if ($demand_piece->sum('quantity') == $demand_piece->sum('delivered')) {
                        $finished = '1';
                        $demand = Demand::findOrFail($request->demand)->update(['state' => '3']);
                    }else{
                        $finished = '';
                    }
                    $demand = Demand::findOrFail($request->demand);
                    return response()->json(['id' => $request->demand, 'finished' => $finished,
                        'bus' => $demand->diagnostic->statee->bus->model->brand->name . " " . $demand->diagnostic->statee->bus->model->name,
                        'reference' => $demand->diagnostic->statee->reference, 'quantity' => number_format($demand->demand_piece->sum('quantity')),
                        'delivered' => number_format($demand->demand_piece->sum('delivered')), 'demand' => $demand->reference,
                        'date'=>$demand->updated_at->format('d/m/Y')]);
                }
            } elseif ($request->has("input")) {
                $messages = array(
                    'deliveries.required' => "Le Numero du Bon de Livraison est obligatoire ",
                    'reference.required' => "La Reférence du stock est obligatoire ",
                    'quantity.required' => "La Quantité est requise",
                );
                $rules = array(
                    'deliveries' => 'bail|required|min:1|max:255',
                    'reference' => 'bail|required|min:1|max:255',
                    'quantity' => 'bail|required|min:1|max:255|',
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
                    $movement = Movement_stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => "etr-" . Carbon::now()->timestamp,
                        'delivery_id' => $request->deliveries,
                        'type' => '1',
                    ]);

                    for ($i = 0; $i < $count = count($request->reference); $i++) {

                        $stock_quantity = Stock::findOrFail($request->reference[$i]);
                        $quantity_old = $stock_quantity->quantity;
                        $result = $quantity_old + $request->quantity[$i];
                        $price_old = $stock_quantity->price;
                        /*******mise a jour du price unitaire******/
                        $new_price = ($stock_quantity->price + $request->price[$i])/($result) ;
                        $stock = Stock::findOrFail($request->reference[$i])->update(['quantity' => $result,'price'=>$new_price,'price_old'=>$price_old]);

                        $output = Item_stock::create([
                            'ids' => Carbon::now()->timestamp,
                            'stock_id' => $request->reference[$i],
                            'movement_stock_id' => $movement->id,
                            'quantity' => $request->quantity[$i],
                            'quantity_old' => $quantity_old,
                            'prix_unitaire'=>$request->price[$i],
                            'state_id'=>$request->state_id
                        ]);
                    }
                    return response()->json(['id' => $movement->id,'price'=> $movement->item_stock->sum('prix_unitaire'),'reference' => $movement->reference,
                        'delivery' => $movement->delivery->number, 'quantity' => $movement->item_stock->sum('quantity'),
                        'date' => Date::parse($movement->created_at)->format('j M Y')]);
                }
            } elseif ($request->has("back")) {
                $messages = array(
                    'reference.required' => "La Reférence du stock est obligatoire ",
                    'quantity.required' => "La Quantité est requise",
                );
                $rules = array(
                    'reference' => 'bail|required|min:1|max:255',
                    'quantity' => 'bail|required|min:1|max:255|',
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
                    $movement = Movement_stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => "rtr-" . Carbon::now()->timestamp,
                        'delivery_id' => $request->deliveries,
                        'type' => '2',
                    ]);

                    for ($i = 0; $i < $count = count($request->reference); $i++) {
                        $stock_quantity = Stock::findOrFail($request->reference[$i]);
                        $quantity_old = $stock_quantity->quantity;
                        $result = $quantity_old + $request->quantity[$i];
                        $stock = Stock::findOrFail($request->reference[$i])->update(['quantity' => $result]);

                        $output = Item_stock::create([
                            'ids' => Carbon::now()->timestamp,
                            'stock_id' => $request->reference[$i],
                            'movement_stock_id' => $movement->id,
                            'quantity' => $request->quantity[$i],
                            'quantity_old' => $quantity_old,
                            'state_id'=>$request->state_id
                        ]);
                    }
                    return response()->json(['id' => $movement->id, 'reference' => $movement->reference,
                        'quantity' => $movement->item_stock->sum('quantity'),
                        'date' => Date::parse($movement->created_at)->format('j M Y')]);
                }
            } elseif ($request->has('inventory')) {
                $messages = array(
                    'reference.required' => "La Reférence du stock est obligatoire ",
                    'quantity.required' => "La Quantité est requise",
                );
                $rules = array(
                    'reference' => 'bail|required|min:1|max:255',
                    'quantity' => 'bail|required|min:1|max:255|',
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
                    $movement = Movement_stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => "inv-" . Carbon::now()->timestamp,
                        'type' => '3',
                    ]);

                    for ($i = 0; $i < $count = count($request->reference); $i++) {
                        $stock_quantity = Stock::findOrFail($request->reference[$i]);
                        $quantity_old = $stock_quantity->quantity;
                        $result = $quantity_old + $request->quantity[$i];
                        $stock = Stock::findOrFail($request->reference[$i])->update(['quantity' => $result]);

                        $output = Item_stock::create([
                            'ids' => Carbon::now()->timestamp,
                            'stock_id' => $request->reference[$i],
                            'movement_stock_id' => $movement->id,
                            'quantity' => $request->quantity[$i],
                            'quantity_old' => $quantity_old,
                            'state_id'=>$request->state_id
                        ]);
                    }
                    return response()->json(['id' => $movement->id, 'reference' => $movement->reference,
                        'quantity' => $movement->item_stock->sum('quantity'),
                        'date' => Date::parse($movement->created_at)->format('j M Y')]);
                }
            } else {

                $messages = array(
                    'stock_delivery.required' => "Veuillez choisir un Bon de Livraison",
                    'model.required' => "Veuillez choisir le Model de Pièce",
                    'sub_category.required' => "Veuillez choisir la Sous Famille",
                    'block.required' => "Veuillez Choisir un Casier",
                    'quantity.required' => "La Quantité est requise",
                    'type.required' => "Veuillez Choisir le Type de Pièce",
                );
                $rules = array(
                    'stock_delivery' => 'bail|required|min:1|max:255',
                    'model' => 'bail|required|min:1|max:255|',
                    'sub_category' => 'bail|required|min:1|max:255|',
                    'quantity' => 'bail|required|min:1|max:255|',
                    'block' => 'bail|required|min:1|max:255|',
                    'type' => 'bail|required|min:1|max:255|',
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
                    $site=Auth::user()->employee->site_id;
                    $stock = Stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => $request->reference,
                        'delivery_id' => $request->stock_delivery,
                        'model_id' => $request->model,
                        'sub_category_id' => $request->sub_category,
                        'type_id' => $request->type,
                        'quantity' => $request->quantity,
                        'block_id' => $request->block,
                        'total'=>$request->total,
                        'tva'=>$request->ttva,
                        'annex'=>$request->annex,
                        'site_id'=>$site


                    ]);
                    return response()->json(['id' => $stock->id, 'reference' => $stock->reference,
                        'type' => $stock->type->name, 'family' => $stock->sub_category->category->name,
                        'sub' => $stock->sub_category->name, 'quantity' => $stock->quantity,
                        'date' => Date::parse($stock->created_at)->format('j M Y')]);
                }
            }
        /*} else {
            return view('errors.500');
        }*/
    }

    public function movement(Request $request, $id, $type)
    {
        //if ($request->ajax()) {
            if ($type == "output") {
                //$demand = Demand::findOrFail($id);
                $movements = Movement_stock::where('demand_id', $id)->orderBy('created_at','desc')->get();
                return view('stock.partials.output', ['movements' => $movements]);
            } elseif ($type == "back") {
                $movement = Movement_stock::findOrFail($id);
                $items = Item_stock::where('movement_stock_id', $id)->get();
                return view('stock.partials.back', ['items' => $items, 'movement' => $movement]);
            } elseif ($type == 'inventory') {
                $movement = Movement_stock::findOrFail($id);
                $items = Item_stock::where('movement_stock_id', $id)->get();
                return view('stock.partials.inventory', ['items' => $items, 'movement' => $movement]);
            } else {
                $movement = Movement_stock::findOrFail($id);
                $items = Item_stock::where('movement_stock_id', $id)->get();
                return view('stock.partials.input', ['items' => $items, 'movement' => $movement]);
            }
        /*} else {
            return view('errors.500');
        }*/
    }

    public function filesouputstock(Request $request,$id)
    {
        $movements = Movement_stock::where('demand_id', $id)->orderBy('created_at','desc')->get();
        $demand=Demand::findOrFail($id);
        return view('stock.file.stockouput', ['movements' => $movements,'demand'=>$demand]);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('delivered')) {
                $begin = $request->begin . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $demands = Demand::whereBetween('created_at', [$begin, $end])->where('state', '2')->orWhere('state', '3')
                    ->orderBy('updated_at', 'desc')->get();
                return view('stock.includes.output', ['demands' => $demands])->with(['id'=>$request->delivered]);
            } elseif ($request->has('delivery')) {
                $begin = $request->begin;
                $end = $request->end;
                $deliveries = Delivery::whereBetween('created_at', [$begin, $end])->orderBy('created_at', 'desc')->get();
                return view('stock.includes.delivery', compact('deliveries'));
            } elseif ($request->has('back')) {
                $begin = $request->begin . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $movements = Movement_stock::whereBetween('created_at', [$begin, $end])->where('type', '2')
                    ->orderBy('created_at', 'desc')->get();
                return view('stock.includes.back', ['movements' => $movements]);
            } elseif ($request->has('inventory')) {
                $begin = $request->begin . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $movements = Movement_stock::whereBetween('created_at', [$begin, $end])->where('type', '3')
                    ->orderBy('created_at', 'desc')->get();
                return view('stock.includes.inventory', ['movements' => $movements]);
            } else {
                $begin = $request->begin . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $movements = Movement_stock::whereBetween('created_at', [$begin, $end])->where('type', '1')
                    ->orderBy('created_at', 'desc')->get();
                return view('stock.includes.input', ['movements' => $movements]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function searchstock(Request $request)
    {
        if ($request->ajax()) {

                $begin = $request->begin . ' 00:00:00';
                $end = $request->end . ' 23:59:59';
                $stocks = Stock::whereBetween('created_at', [$begin, $end])->get();
                return view('stock.includes.listing', ['stocks' => $stocks]);


        } else {
            return view('errors.500');
        }
    }

    public function deliveryBy(Request $request, $id)
    {
        if ($request->ajax()) {
            $delivery = Delivery::where('ids', $id)->first();
            return response()->json(['supplier' => $delivery->supplier->name, 'order' => $delivery->order]);
        } else {
            return view('errors.500');
        }
    }

    public function modelBy(Request $request, $id)
    {
        if ($request->ajax()) {
            $models = Models::where('brand_id', $id)->get();
            return response()->json($models);
        } else {
            return view('errors.500');
        }
    }

    public function subFamily(Request $request, $id)
    {
        if ($request->ajax()) {
            $subs = Sub_category::where('category_id', $id)->get();
            return response()->json($subs);
        } else {
            return view('errors.500');
        }
    }

    public function shelves(Request $request, $id)
    {
        if ($request->ajax()) {
            $shelves = Shelve::where('ray_id', $id)->get();
            return response()->json($shelves);
        } else {
            return view('errors.500');
        }
    }

    public function blocs(Request $request, $id)
    {
        if ($request->ajax()) {
            $blocs = Block::where('shelf_id', $id)->get();
            return response()->json($blocs);
        } else {
            return view('errors.500');
        }
    }

    public function references(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == "delivery") {
                $info = Delivery::findOrFail($id);
                return response()->json(['supplier' => $info->supplier->name]);
            } else {
                $info = Stock::findOrFail($id);
                return response()->json(['family' => $info->sub_category->category->name,'types'=>$info->stock_type,
                    'subfamily' => $info->sub_category->name, 'qty' => $info->quantity,'etage'=>$info->block->shelf->ray->name,'casier'=>$info->block->name]);


            }
        } else {
            return view('errors.500');
        }
    }

    public function input()
    {

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
                $deliveries = Delivery::select('id', 'number')->orderBy('created_at', 'desc')->get();
                $movements = Movement_stock::where('type', '1')->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();


            }
            else{
                $stocks = Stock::all()->sortByDesc("created_at");
                $deliveries = Delivery::select('id', 'number')->orderBy('created_at', 'desc')->get();
                $movements = Movement_stock::where('type', '1')->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();

            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
            $deliveries = Delivery::select('id', 'number')->orderBy('created_at', 'desc')->get();
            $movements = Movement_stock::where('type', '1')->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();


        }


        $stocks = Stock::all()->sortByDesc("created_at");
        $deliveries = Delivery::select('id', 'number')->orderBy('created_at', 'desc')->get();
        $movements = Movement_stock::where('type', '1')->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();



        return view('stock.input', ['movements' => $movements, 'stocks' => $stocks, 'deliveries' => $deliveries]);
    }

    public function delivery()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $suppliers = Supplier::select('id', 'name')->get();
                $deliveries = Delivery::whereMonth('delivered_at', date('m'))->whereYear('delivered_at', date('Y'))->orderBy('created_at', 'desc')->get();

            }
            else{
                $suppliers = Supplier::select('id', 'name')->get();
                $deliveries = Delivery::whereMonth('delivered_at', date('m'))->whereYear('delivered_at', date('Y'))->orderBy('created_at', 'desc')->get();


            }
        }
        else{
            $suppliers = Supplier::select('id', 'name')->get();
            $deliveries = Delivery::whereMonth('delivered_at', date('m'))->whereYear('delivered_at', date('Y'))->orderBy('created_at', 'desc')->get();

        }
        return view('stock.delivery', compact('suppliers', 'deliveries'));
    }

    public function back()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
                $movements = Movement_stock::where('type', '2')->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();
            }
            else{
                $stocks = Stock::all()->sortByDesc("created_at");
                $movements = Movement_stock::where('type', '2')->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();
            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
            $movements = Movement_stock::where('type', '2')->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();

        }


        return view('stock.back', ['movements' => $movements, 'stocks' => $stocks]);
    }

    public function inventory()
    {

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
                $movements = Movement_stock::where('type', '3')->orderBy('created_at', 'desc')->get();
            }
            else{
                $stocks = Stock::all()->sortByDesc("created_at");
                $movements = Movement_stock::where('type', '3')->orderBy('created_at', 'desc')->get();
            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");
            $movements = Movement_stock::where('type', '3')->orderBy('created_at', 'desc')->get();
        }

        return view('stock.inventory', ['movements' => $movements, 'stocks' => $stocks]);
    }

    public function listing()
    {
        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");

            }
            else{
                $stocks = Stock::all()->sortByDesc("created_at");

            }
        }
        else{
            $stocks = Stock::where('site_id',$site_id)->get()->sortByDesc("created_at");

        }
        return view('stock.listing', ['stocks' => $stocks]);
    }

    public function score()
    {

        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $pieceenattente = Demand::whereHas('diagnostic',function ($query){
                    $query->whereHas('statee',function ($q){
                        $site_id=Auth::user()->employee->site_id;
                        $q->where('site_id',$site_id);
                    });

                })->where('state', '1')->orWhere('state', '2')->count();
                $reparationattente=Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('state_id',$site_id);
                })->whereBetween('active', ['1','2'])->where('type','1')->count();

                $revisionattente=Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('state_id',$site_id);
                })->whereBetween('active', ['1','2'])->where('type','2')->count();
                $visiteattente=Diagnostic::whereHas('statee',function ($query){
                    $site_id=Auth::user()->employee->site_id;
                    $query->where('state_id',$site_id);
                })->whereBetween('active', ['1','2'])->where('type', '3')->count();


            }
            else{
                $pieceenattente = Demand::where('state', '1')->orWhere('state', '2')->count();
                $reparationattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','1')->count();
                $revisionattente=Diagnostic::whereBetween('active', ['1','2'])->where('type','2')->count();
                $visiteattente=Diagnostic::whereBetween('active', ['1','2'])->where('type', '3')->count();

            }
        }
        else{
            $pieceenattente = Demand::whereHas('diagnostic',function ($query){
                $query->whereHas('statee',function ($q){
                    $site_id=Auth::user()->employee->site_id;
                    $q->where('site_id',$site_id);
                });

            })->where('state', '1')->orWhere('state', '2')->count();
            $reparationattente=Diagnostic::whereHas('statee',function ($query){
                $site_id=Auth::user()->employee->site_id;
                $query->where('state_id',$site_id);
            })->whereBetween('active', ['1','2'])->where('type','1')->count();

            $revisionattente=Diagnostic::whereHas('statee',function ($query){
                $site_id=Auth::user()->employee->site_id;
                $query->where('state_id',$site_id);
            })->whereBetween('active', ['1','2'])->where('type','2')->count();
            $visiteattente=Diagnostic::whereHas('statee',function ($query){
                $site_id=Auth::user()->employee->site_id;
                $query->where('state_id',$site_id);
            })->whereBetween('active', ['1','2'])->where('type', '3')->count();

        }




        return response()->json(['pieceenattente'=>$pieceenattente,'reparationattente'=>$reparationattente,'revisionattente'=>$revisionattente,'visiteattente'=>$visiteattente]);
    }
    public function category_subcategories(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == "get") {
                $sub_categories = Sub_category::where('category_id', '=', $id)->get();
                return response()->json($sub_categories);
            } else {
                $sub_category = Sub_category::findOrFail($id);
                $sub_categories = Sub_category::where('category_id', $sub_category->category_id)->get();
                return response()->json($sub_categories);
            }
        } else {
            return view('errors.404');
        }
    }

    public function type_pneu(Request $request,$id, $type)
    {

        if ($request->ajax()) {
            if ($type == "get") {
                $typtires = Typetire::FindOrFail($id);
                return response()->json($typtires);
            } else {
                $typtires = Typetire::FindOrFail($id);
                return response()->json($typtires);
            }
        } else {
            return view('errors.404');
        }

    }
    public function suppliers(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == "get") {
                $suppliers = Supplier::findOrFail($id);
                return response()->json($suppliers);
            } else {
                $suppliers = Supplier::findOrFail($id);
                return response()->json($suppliers);
            }
        } else {
            return view('errors.404');
        }
    }


    public function deliveryget(Request $request,$id,$type)
    {
//        if ($request->ajax()) {
            if ($type == "get") {
                $delivery = Delivery::where('ids', $id)->get();
                return response()->json($delivery);
            } else {
                $delivery = Delivery::where('ids', $id)->get();
               //$sub_categories = Delivery::where('ids', $sub_category->category_id)->get();
                return response()->json($delivery);
         //   }
//        } else {
//            return view('errors.404');
       }
    }



    public function edit(Request $request, $id)
    {
        if ($request->ajax()) {
            $stock = Stock::findOrFail($id);

            return response()->json($stock);
        } else {
            return view('errors.404');
        }
    }

    public function brand_models(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == "get") {
                $models = Models::where('brand_id', '=', $id)->get();
                return response()->json($models);
            } else {
                $model = Models::findOrFail($id);
                $models = Models::where('brand_id', $model->brand_id)->get();
                return response()->json($models);
            }
        } else {
            return view('errors.404');
        }
    }
    public function shelving(Request $request, $id, $type)
    {
        if ($request->ajax()) {
            if ($type == "ray") {
                $ray = Ray::findOrFail($id);
                $shelves = Shelve::where('ray_id', $ray->id)->get();
                return response()->json($shelves);
            } elseif ($type == "shelf") {
                $shelf = Shelve::findOrFail($id);
                $blocks = Block::where('shelf_id', $shelf->id)->get();
                return response()->json($blocks);
            } else if ($type == "block") {
                $stock = Stock::findOrFail($id);
                $block = Block::findOrFail($stock->block_id);
                $blocks = Block::where('shelf_id', $block->shelf_id)->get();
                return response()->json($blocks);
            } else {
                $block = Block::findOrFail($id);
                $shelf = Shelve::findOrFail($block->shelf_id);
                $ray = Ray::findOrFail($shelf->ray_id);
                $shelves = Shelve::where('ray_id', $ray->id)->get();
                return response()->json($shelves);
            }
        } else {
            return view('errors.404');
        }
    }

    public function editstock(Request $request, $id)
    {
        if ($request->ajax()) {
            $stock = Stock::findOrFail($id);
            return response()->json($stock);
        } else {
            return view('errors.404');
        }

    }

    public function upatestock(Request $request, $id)
    {
        if ($request->ajax()) {

            if($request->stock_type==1)
            {
                $messages = array(
                    'stock_delivery.required' => "Veuillez choisir un Bon de Livraison",
                    'model.required' => "Veuillez choisir le Model du Moteur",
                    'sub_category.required' => "Veuillez choisir la Sous Famille",
                    'block.required' => "Veuillez Choisir un Casier",
                    'type.required' => "Veuillez Choisir l'etat du moteur",
                    'type.quantity' => "Veuillez Entrer la quantité svp!",
                    'libelle.required'=>'Veuillez entrer un libelle svp!',
                    'libelle.unique'=>'libelle exite déja!',
                    'type_moteur.required'=>'Veuillez choisir un type de moteur',
                );
                $rules = array(
                    'stock_delivery' => 'bail|required|min:1|max:255',
                    'model' => 'bail|required|min:1|max:255|',
                    'sub_category' => 'bail|required|min:1|max:255|',
                    'block' => 'bail|required|min:1|max:255|',
                    'type' => 'bail|required|min:1|max:255|',
                    'quantity'=>'bail|required',
                    'type_moteur'=>'bail|required',
                    'libelle'=>'bail|required|min:3|unique:engines'
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
                    if($request->hasFile('image_engine')) {
                        $image = $request['image_engine'];

                        $input['image_engine'] = time().'.'. $image->getClientOriginalExtension();
                        $destinationPath = public_path('/picture');
                        $image->move($destinationPath, $input['imagename']);
                    }
                    else{
                        $input['image_engine']="";
                    }

                        $stock = Stock::findOrFail($id);

                    $stock->type_moteur = $request->type_moteur;
                    $stock->stock_type = $request->stock_type;
                    $stock->displacement = $request->displacement;
                    $stock->power = $request->power;
                    $stock->vitesse = $request->vitesse;
                    $stock->mileage = $request->mileage;
                    $stock->horse = $request->horse;
                    $stock->libelle = $request->libelle;
                    $stock->image_engine = $input['image_engine'];
                    $stock->quantity = $request->quantity;
                     $stock->delivery_id = $request->delivery_id;
                    /****/
                    $stock->model_id = $request->model;
                    $stock->sub_category_id = $request->sub_category;
                    $stock->type_id = $request->type;
                    $stock->reference = $request->reference;
                //    $stock->quantity = $request->quantity;
//                    $stock->price = $request->price;
//                    $stock->transport = $request->transport;
//                    $stock->annex = $request->annex;
//                    $stock->tva_rate = $request->ttva;
//                    $stock->total = $request->total;
//                    $stock->tva = $request->tva;
                    $stock->block_id = $request->block;
//                    $stock->famillypiece_id = $request->famillypiece_id;
//                    $stock->priceventeunitaire = $request->priceventeunitaire;
//                    $stock->priceventemarge =$request->priceventemarge;
//                    $stock->marge = $request->marge;
                    $stock->save();
                    return response()->json(['id' => $stock->id, 'reference' => $stock->reference,
                        '' => $stock->type->name,  'type' => $stock->type->name, 'family' => $stock->sub_category->category->name,
                        'sub' => $stock->sub_category->name, 'quantity' => $stock->quantity,
                        'date' => Date::parse($stock->created_at)->format('j M Y')]);
                }
            }

            elseif($request->stock_type==2)
            {

                $messages = array(
                    'stock_delivery.required' => "Veuillez choisir un Bon de Livraison",
                    'model.required' => "Veuillez choisir le Model du pneu",
                    'sub_category.required' => "Veuillez choisir la Sous Famille",
                    'block.required' => "Veuillez Choisir un Casier",
                    'type.required' => "Veuillez Choisir l'etat du moteur",
                    'type.quantity' => "Veuillez Entrer la quantité svp!",
                    'libelle.required'=>'Veuillez entrer un libelle svp!',
                    'libelle.unique'=>'libelle exite déja!',
                    'typtire_id.required'=>'Veuillez choisir un type de pneu',
                    'dot.required'=>'Veuillez entrer un dot!',
                );
                $rules = array(
                    'stock_delivery' => 'bail|required|min:1|max:255',
                    'dot' => 'bail|required|min:1|max:255',
                    'model' => 'bail|required|min:1|max:255|',
                    'sub_category' => 'bail|required|min:1|max:255|',
                    'block' => 'bail|required|min:1|max:255|',
                    'type' => 'bail|required|min:1|max:255|',
                    'quantity'=>'bail|required',
                    'typtire_id'=>'bail|required',
                    'libelle'=>'bail|required|min:3|unique:engines'
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


                    $stock = Stock::findOrFail($id);
                    $stock->reference =$request->reference;
                    $stock->weight =$request->weight;
                    $stock->typtire_id =$request->typtire_id;
                    $stock->libelle =$request->libelle;
                    $stock->quantity =$request->quantity;
                    $stock->mileage =$request->mileage;
                    $stock->vitesse =$request->vitesse;
                    $stock->block_id =$request->block;
                    $stock->type_id =$request->type;
                    $stock->sub_category_id =$request->sub_category;
                    $stock->model_id = $request->model;
                    $stock->dot =$request->dot;
                    $stock->diametre =$request->diametre;
                    $stock->hauteur =$request->hauteur;
                    $stock->charge =$request->charge;
                    $stock->width =$request->width;
                    $stock->weight =$request->weight;
                    $stock->sens_tire=$request->sens_tire;
                    $stock->save();


                    return response()->json(['id' => $stock->id, 'reference' => $stock->reference,
                          'type' => $stock->type->name, 'family' => $stock->sub_category->category->name,
                        'sub' => $stock->sub_category->name, 'quantity' => $stock->quantity,
                        'date' => Date::parse($stock->created_at)->format('j M Y')]);
                }

            }



        } else {
            return view('errors.404');
        }
    }

    public function gettire()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $types = Type::all();


        $site_id=Auth::user()->employee->site_id;
        if(Auth::user()->can(['tableau de bord administration générale','tableau de bord admin'])) {
            if (Auth::user()->employee->action_site == 2) {
                $engine =  Stock::where('stock_type',2)->where('site_id','=',$site_id)->get();
            }
            else{
                $engine =  Stock::where('stock_type',2)->get();
            }
        }
        else{
            $engine =  Stock::where('stock_type',2)->where('site_id',$site_id)->get();

        }


        $deliveries = Delivery::select('ids', 'number')->get();
        $suppliers = Supplier::where('type', '=', '0')->get();
        $rays = Ray::select('id', 'name')->get();
        $typetires= Typetire::select('id','name')->get();
        return view('stock.tire.create', compact('typetires','brands', 'categories', 'types', 'engine', 'suppliers', 'rays', 'deliveries'));


    }

    public function savetire(Request $request)
    {
        $messages = array(
            'stock_delivery.required' => "Veuillez choisir un Bon de Livraison",
            'model.required' => "Veuillez choisir le Model du pneu",
            'sub_category.required' => "Veuillez choisir la Sous Famille",
            'block.required' => "Veuillez Choisir un Casier",
            'type.required' => "Veuillez Choisir l'etat du moteur",
            'type.quantity' => "Veuillez Entrer la quantité svp!",
            'libelle.required'=>'Veuillez entrer un libelle svp!',
            'libelle.unique'=>'libelle exite déja!',
            'typtire_id.required'=>'Veuillez choisir un type de pneu',
            'dot.required'=>'Veuillez entrer un dot!',
        );
        $rules = array(
            'stock_delivery' => 'bail|required|min:1|max:255',
            'dot' => 'bail|required|min:1|max:255',
            'model' => 'bail|required|min:1|max:255|',
            'sub_category' => 'bail|required|min:1|max:255|',
            'block' => 'bail|required|min:1|max:255|',
            'type' => 'bail|required|min:1|max:255|',
            'quantity'=>'bail|required',
            'typtire_id'=>'bail|required',
            'libelle'=>'bail|required|min:3|unique:engines'
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
            $site=Auth::user()->employee->site_id;
            $engine= Stock::create([
                'ids' => Carbon::now()->timestamp,
                'reference' => $request->reference,
                'delivery_id' => $request->stock_delivery,
                'model_id' => $request->model,
                'sub_category_id' => $request->sub_category,
                'type_id' => $request->type,
                'block_id' => $request->block,
                'vitesse'=>$request->vitesse,
                'mileage'=>$request->mileage,
                'quantity'=>$request->quantity,
                'libelle'=>$request->libelle,
                'typtire_id'=>$request->typtire_id,
                'stock_type'=>$request->stock_type,
                'weight'=>$request->weight,
                'site_id'=>$site,
                'width'=>$request->width,
                'charge'=>$request->charge,
                'hauteur'=>$request->hauteur,
                 'diametre'=>$request->diametre,
                 'dot'=>$request->dot,
                'sens_tire'=>$request->sens_tire



            ]);
            return response()->json(['id' => $engine->id, 'reference' => $engine->reference,
                '' => $engine->type->name,  'type' => $engine->type->name, 'family' => $engine->sub_category->category->name,
                'sub' => $engine->sub_category->name, 'quantity' => $engine->quantity,
                'date' => Date::parse($engine->created_at)->format('j M Y')]);
        }

    }

//    public function searchlisting(Request $request,$id)
//    {
//        if($request->)
//        {
//
//        }
//
//    }

    public function destroy($id)
    {

    }
    public function excelstock()
    {
        $filestocks = Filestock::all();
        return view('stock.excelstock',compact('filestocks'));
    }

    public function importExcel(Request $request)
    {

        if($request->hasFile('import_file'))
        {
            $file = Input::file('import_file');
            $input['file'] = uniqid().'.'. $file->getClientOriginalExtension();
            $destinationPath = public_path('/picture');
            $file->move($destinationPath, $input['file']);

            $path = public_path('/picture/'. $input['file']);


            $data = Excel::load($path, function($reader) {
            })->get();
        }


        if(!empty($data) && $data->count()){
            foreach ($data as $key => $value) {


                $insert[] = ['reference' => $value->reference, 'libelle' => $value->libelle,'quantite' => $value->quantite,
                    'prix' => $value->prix];

            }
            if(!empty($insert)){
                DB::table('filestocks')->insert($insert);
            }
            Session::flash('mgs',"fichier enregistré");
            return Redirect::back();
        }
        else{
            Session::flash('mgserror',"fichier non enregistrer");
            return Redirect::back();
        }


    }
}

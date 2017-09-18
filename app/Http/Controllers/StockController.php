<?php

namespace App\Http\Controllers;

use App\Block;
use App\Brand;
use App\Category;
use App\Delivery;
use App\Demand;
use App\Demand_piece;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
        $suppliers = Supplier::select('id', 'name')->get();
        $stocks = Stock::all();
        return view('stock.list', compact('suppliers', 'stocks'));
    }

    public function output()
    {
        $stocks = Stock::where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
        $demands = Demand::where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();
        return view('stock.output', [ 'stocks' => $stocks, 'demands' => $demands]);
    }

    public function show(Request $request, $id)
    {
        if ($id == "demand"){
            $stocks = Stock::where('quantity', '>', '0')->orderBy("created_at", 'desc')->get();
            $demands = Demand::where('state', '1')->orWhere('state', '2')->orderBy('updated_at', 'desc')->get();
            return view('stock.includes.output', ['stocks' => $stocks, 'demands' => $demands])->with(['id'=>$id]);
        }elseif ($id == "delivered"){
            $demands = Demand::where('state', '2')->orWhere('state', '3')->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))->orderBy('updated_at', 'desc')->get();
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
        $stocks = Stock::all()->sortByDesc("updated_at");
        $deliveries = Delivery::select('ids', 'number')->get();
        $suppliers = Supplier::where('type', '=', '0')->get();
        $rays = Ray::select('id', 'name')->get();
        return view('stock.create', compact('brands', 'categories', 'types', 'stocks', 'suppliers', 'rays', 'deliveries'));
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
            } elseif ($request->has("output")) {
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
                        'bus' => $demand->diagnostic->state->bus->model->brand->name . " " . $demand->diagnostic->state->bus->model->name,
                        'reference' => $demand->diagnostic->state->reference, 'quantity' => number_format($demand->demand_piece->sum('quantity')),
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
                        $stock = Stock::findOrFail($request->reference[$i])->update(['quantity' => $result]);

                        $output = Item_stock::create([
                            'ids' => Carbon::now()->timestamp,
                            'stock_id' => $request->reference[$i],
                            'movement_stock_id' => $movement->id,
                            'quantity' => $request->quantity[$i],
                            'quantity_old' => $quantity_old,
                        ]);
                    }
                    return response()->json(['id' => $movement->id, 'reference' => $movement->reference,
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
                    $stock = Stock::create([
                        'ids' => Carbon::now()->timestamp,
                        'reference' => $request->reference,
                        'delivery_id' => $request->stock_delivery,
                        'model_id' => $request->model,
                        'sub_category_id' => $request->sub_category,
                        'type_id' => $request->type,
                        'quantity' => $request->quantity,
                        'block_id' => $request->block
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
                return response()->json(['family' => $info->sub_category->category->name,
                    'subfamily' => $info->sub_category->name, 'qty' => $info->quantity]);
            }
        } else {
            return view('errors.500');
        }
    }

    public function input()
    {
        $stocks = Stock::all()->sortByDesc("created_at");
        $deliveries = Delivery::select('id', 'number')->orderBy('created_at', 'desc')->get();
        $movements = Movement_stock::where('type', '1')->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();
        return view('stock.input', ['movements' => $movements, 'stocks' => $stocks, 'deliveries' => $deliveries]);
    }

    public function delivery()
    {
        $suppliers = Supplier::select('id', 'name')->get();
        $deliveries = Delivery::whereMonth('delivered_at', date('m'))->whereYear('delivered_at', date('Y'))->orderBy('created_at', 'desc')->get();
        return view('stock.delivery', compact('suppliers', 'deliveries'));
    }

    public function back()
    {
        $stocks = Stock::all()->sortByDesc("created_at");
        $movements = Movement_stock::where('type', '2')->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))->orderBy('created_at', 'desc')->get();
        return view('stock.back', ['movements' => $movements, 'stocks' => $stocks]);
    }

    public function inventory()
    {
        $stocks = Stock::all()->sortByDesc("created_at");
        $movements = Movement_stock::where('type', '3')->orderBy('created_at', 'desc')->get();
        return view('stock.inventory', ['movements' => $movements, 'stocks' => $stocks]);
    }

    public function listing()
    {
        $stocks = Stock::all()->sortByDesc("created_at");
        return view('stock.listing', ['stocks' => $stocks]);
    }

    public function edit(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        //
    }
}

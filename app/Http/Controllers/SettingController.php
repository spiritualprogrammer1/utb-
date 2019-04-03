<?php

namespace App\Http\Controllers;

use App\Block;
use App\Brand;
use App\Category;
use App\Entreprise;
use App\Model;
use App\Models;
use App\Post;
use App\Ray;
use App\Role;
use App\Service;
use App\Shelve;
use App\Site;
use App\Sub_category;
use App\Type;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:stock');
    }

    /*** VEHICLE FUNCTIONS ***/
    public function vehicle()
    {
        $brands = Brand::all()->sortByDesc("created_at");
        $models = Models::with('brand')->get();
        $categories = Category::all();
        $subs = Sub_category::with('category')->get();
        $types = Type::all();
        return view('setting.vehicle', compact('brands', 'models', 'categories', 'subs', 'types'));
    }
    public function service()
    {

        $service=Service::all();
        $services=Service::all();
        $postes=Post::all();

        return view('setting.service',compact('service','postes','services'));
    }
    public function serviceCreate(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|min:3|max:255|unique:services',
                'display_name'=>'bail|required|min:3|max:255'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $service = Service::create([
                    'name' => htmlspecialchars(strtolower($request->name)),
                    'display_name'=>htmlspecialchars(strtolower($request->display_name))
                ]);
                return response()->json(['id' => $service->id, 'name' => $service->display_name, 'date' => $service->created_at->format('d/m/Y H:i:s')]);
            }
        }
    }
    public function serviceUpdated(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|min:1|max:255',
                'display_name'=>'bail|required'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors =  json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $service = Service::find($request->service_id);
                $service->name = htmlspecialchars(strtolower($request->name));
                $service->display_name = htmlspecialchars(strtolower($request->display_name));
                $service->save();
                return Response(['id'=>$service->id, 'name'=>$service->name, 'date' => $service->created_at->format('d/m/Y H:i:s')]);
            }
        }
    }
    public function createPoste(Request $request)
    {
        if($request->ajax())
        {
            $validator = Validator::make($request->all(),[
                'name'=>'bail|required',
                'service'=>'bail|required'
            ],
                [
                    'name.required'=>'le libelle est obligatoire',
                    'service_id.required'=>'le champs service est obligatoire'
                ]);
            if($validator->fails())
            {
                $errors = $validator->errors();
                $errors= json_decode($errors);

                return response()->json([
                    'success'=> false,
                    'message'=> $errors
                ],422);

            }
            else{

                $postes = Post::create([
                    'name'=>strtolower($request->name),
                    'service_id'=>$request->service,

                ]);
                $roles = Role::create([
                    'name'=>strtolower($request->name),
                    'display_name'=>strtolower($request->name),
                    'description'=>strtolower($request->name),
                ]);


                return response()->json(['service'=>$postes->service->name,'id'=>$postes->id,'name'=>$postes->name,'date'=>$postes->created_at->format('d/m/Y H:i:s')]);
            }

        }

    }
    public function UpdatePoste(Request $request)
    {
        if($request->ajax())
        {
            $validator= Validator::make($request->all(),[
                'name'=>'bail|required'
            ]);

            if($validator->fails())
            {
                $errors = $validator->errors();
                $errors= json_decode($errors);

                return response()->json([
                    'success'=> false,
                    'message'=> $errors
                ],422);
            }
            else {

                $postes = Post::find($request->poste_id);
                $postes->name = $request->name;
                $postes->service_id= $request->service;
                $postes->save();

                return response()->json(['id'=>$postes->id,'name'=>$postes->name,'service'=>$postes->service->name,'date'=>$postes->created_at->format('d/m/Y H:i:s')]);

            }
        }

    }
    /*******data entreprise**********/
    public function getEntreprise(Request $request)
    {
        $entreprise=Entreprise::all();
        $entreprisecount=Entreprise::count();
        return view('setting.entreprise',compact('entreprise','entreprisecount'));
    }
    public function postEntreprise(Request $request)
    {
        if($request->ajax())
        {
            $rules=array( 'name'=>'bail|required|min:3',
                'display_name'=>'bail|required|min:4',
                'picture'=>'bail|required',
                  'footer'=>'bail|required');
            $messages = array(
                'name.required'=>'le libelle est obligatoire',
                'display_name.required'=>'la description est obligatoire',
                'picture.required'=>'choisir un logo'
            );

            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {

                if($request->hasFile('picture')) {
                    $image = $request['picture'];

                    $input['imagename'] = time().'.'. $image->getClientOriginalExtension();
                    $destinationPath = public_path('/picture_employe');
                    $image->move($destinationPath, $input['imagename']);
                }

                $entreprise = Entreprise::create([
                    'name'=> $request->name,
                    'display_name'=> $request->display_name,
                    'picture'=>$input['imagename'],
                    'footer'=>$request->footer

                ]);
                $entreprisecount=Entreprise::count();
                return response()->json(['entreprisecount'=>$entreprisecount,'date'=>$entreprise->created_at->format('d/m/Y H:i:s'),'id'=>$entreprise->id,'name'=>$entreprise->name,'display_name'=>$entreprise->display_name]);

            }
        }
    }

    public function updateEntreprise(Request $request)
    {
        if($request->ajax())
        {
            $rules=array( 'name'=>'bail|required|min:3',
                'display_name'=>'bail|required|min:4',
            );
            $messages = array(
                'name.required'=>'le libelle est obligatoire',
                'display_name.required'=>'la description est obligatoire',

            );

            $validator = Validator::make($request->all(),$rules,$messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {

                if($request->hasFile('picture')) {
                    $image = $request['picture'];

                    $input['imagename'] = time().'.'. $image->getClientOriginalExtension();
                    $destinationPath = public_path('/picture_employe');
                    $image->move($destinationPath, $input['imagename']);
                }


                $entreprise=Entreprise::find($request->entreprise_id);
                $entreprise->name=$request->name;
                $entreprise->display_name=$request->display_name;
                $entreprise->footer=$request->footer;
                $entreprise->picture=$input['imagename'];
                $entreprise->save();

                return response()->json(['date'=>$entreprise->created_at->format('d/m/Y H:i:s'),'id'=>$entreprise->id,'name'=>$entreprise->name,'display_name'=>$entreprise->display_name]);

            }
        }
    }
    public function site()
    {
        $site = Site::all()->sortByDesc("created_at");
        return view('setting.site',compact('site'));
    }
    public function siteCreate(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|min:3|max:255|unique:sites',
                'ville' => 'bail|required|min:3|max:255',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $site = Site::create([
                    'name' => htmlspecialchars(strtolower($request->name)),
                    'ville'=>htmlspecialchars(strtolower($request->ville))
                ]);
                return response()->json(['id' => $site->id, 'ville'=>$site->ville,'name' => $site->name, 'date' => $site->created_at->format('d/m/Y H:i:s')]);
            }
        }


    }

    public function siteUpdate(Request $request)
    {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required|min:3|max:255',
                'ville' => 'bail|required|min:1|max:255',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors =  json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                $site = Site::find($request->site_id);
                $site->id = $request->site_id;
                $site->name = strtolower($request->name);
                $site->ville = strtolower($request->ville);
                $site->save();
                return Response(['id'=>$site->id, 'name'=>$site->name, 'date' => $site->created_at->format('d/m/Y H:i:s'), 'ville'=>$site->ville]);
            }
        }

    }
    public function vehicle_store(Request $request){
        if ($request->ajax()) {
            if ($request->has("brand")) {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:brands',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $brand = Brand::create([
                        'name' => $request->name,
                    ]);
                    return response()->json(['id' => $brand->id, 'name' => $brand->name, 'date' => $brand->created_at->format('d/m/Y H:i:s')]);
                }
            } else {
                $messages = array(
                    'model_brand.required' => "Le choix d'une Marque est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:2|max:255|unique:models',
                    'model_brand' => 'bail|required|min:1|max:255',
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
                    $model = Models::create([
                        'name' => $request->name,
                        'brand_id' => $request->model_brand,
                    ]);
                    return response()->json(['id' => $model->id, 'name' => $model->name, 'date' => $model->created_at->format('d/m/Y H:i:s'), 'brand' => $model->brand->name]);
                }
            }
        }else{
            return view('errors.500');
        }
    }

    public function vehicle_update(Request $request, $id){
        if ($request->ajax()) {
            if ($request->has("brand")) {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:brands',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $brand = Brand::findOrFail($id);
                    $brand->name = $request->name;
                    $brand->save();
                    return response()->json(['id' => $brand->id, 'name' => $brand->name, 'date' => $brand->created_at->format('d/m/Y H:i:s')]);
                }
            } else {
                $messages = array(
                    'model_brand.required' => "Le choix d'une Marque est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:2|max:255|unique:models',
                    'model_brand' => 'bail|required|min:1|max:255',
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
                    $model = Models::findOrFail($id);
                    $model->brand_id = $request->model_brand;
                    $model->name = $request->name;
                    $model->save();
                    return Response(['id' => $model->id, 'name' => $model->name, 'date' => $model->created_at->format('d/m/Y H:i:s'), 'brand' => $model->brand->name]);
                }
            }
        }else{
            return view('errors.500');
        }
    }

    public function vehicle_edit(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            if ($type == "brand") {
                $brand = Brand::findOrFail($id);
                return response()->json($brand);
            } else {
                $model = Models::findOrFail($id);
                return response()->json($model);
            }
        } else {
            return view('errors.500');
        }
    }

    public function brands (Request $request){
        if ($request->ajax()){
            $brands = Brand::select('id', 'name')->get();
            return response()->json($brands);
        }else{
            return view('errors.500');
        }
    }
    /*** END ***/

    /*** STOCK FUNCTIONS ***/
    public function stock()
    {
        $categories = Category::all();
        $subs = Sub_category::with('category')->get();
        $types = Type::all();
        return view('setting.stock', compact('categories', 'subs', 'types'));
    }

    public function stock_store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('family')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:categories',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $category = Category::create([
                        'name' => $request->name,
                    ]);
                    return response()->json(['id' => $category->id, 'name' => $category->name, 'date' => $category->created_at->format('d/m/Y')]);
                }
            } elseif ($request->has('sub_family')) {
                $messages = array(
                    'category.required' => "La valeur du champ Famille est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255|unique:sub_categories',
                    'category' => 'bail|required|min:1|max:255',
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
                    $sub = Sub_category::create([
                        'name' => Input::get('name'),
                        'category_id' => Input::get('category'),
                    ]);
                    return response()->json(['id' => $sub->id, 'name' => $sub->name, 'date' => $sub->created_at->format('d/m/Y'), 'category' => $sub->category->name]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:types',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $types = Type::create([
                        'name' => $request->name,
                        'description' => $request->description,
                    ]);
                    return response()->json(['id' => $types->id, 'name' => $types->name, 'description' => $types->description, 'date' => $types->created_at->format('d/m/Y')]);
                }
            }
        } else {
            return view('errors.500');
        }
    }

    public function stock_update(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->has('family')) {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:categories',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $category = Category::findOrFail($id);
                    $category->name = $request->name;
                    $category->save();
                    return response()->json(['id' => $category->id, 'name' => $category->name, 'date' => $category->created_at->format('d/m/Y')]);
                }
            } elseif ($request->has('sub_family')) {
                $messages = array(
                    'category.required' => "La valeur du champ Famille est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255|unique:sub_categories',
                    'category' => 'bail|required|min:1|max:255',
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
                    $sub = Sub_category::findOrFail($id);
                    $sub->category_id = $request->category;
                    $sub->name = $request->name;
                    $sub->save();
                    return Response(['id' => $sub->id, 'name' => $sub->name, 'date' => $sub->created_at->format('d/m/Y'), 'category' => $sub->category->name]);
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'name' => 'bail|required|min:3|max:255|unique:types',
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    $errors = json_decode($errors);

                    return response()->json([
                        'success' => false,
                        'message' => $errors
                    ], 422);
                } else {
                    $types = Type::findOrFail($id);
                    $types->description = $request->description;
                    $types->name = $request->name;
                    $types->save();
                    return response()->json(['id' => $types->id, 'name' => $types->name, 'description' => $types->description, 'date' => $types->created_at->format('d/m/Y')]);
                }
            }

        } else {
            return view('errors.500');
        }
    }

    public function stock_edit(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            if ($type == "family") {
                $category = Category::findOrFail($id);
                return response()->json($category);
            } elseif ($type == 'sub_family') {
                $sub = Sub_category::findOrFail($id);
                return response()->json($sub);
            } else {
                $type = Type::findOrFail($id);
                return response()->json($type);
            }
        } else {
            return view('errors.500');
        }
    }

    public function families(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select('id', 'name')->get();
            return response()->json($categories);
        } else {
            return view('errors.500');
        }
    }
    /*** END ***/

    /*** WAREHOUSE FUNCTIONS ***/
    public function warehouse()
    {
        $rays = Ray::all()->sortByDesc("created_at");
        $shelves = Shelve::with('ray')->get();
        $blocks = Block::with('shelf')->get();
        return view('setting.warehouse', compact('rays', 'shelves', 'blocks'));
    }

    public function warehouse_store(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has("ray")) {
                $messages = array(
                    'name.required' => "La valeur du champ Designation est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255|unique:sub_categories',
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
                    $ray = Ray::create([
                        'name' => strtolower($request->name),
                    ]);
                    return response()->json(['id' => $ray->id, 'name' => $ray->name, 'date' => $ray->created_at->format('d/m/Y H:i:s')]);
                }
            } elseif ($request->has("shelf")) {
                $messages = array(
                    'name.required' => "La valeur du champ Designation est obligatoire",
                    'name.unique' => "La valeur du champ Designation est déjà utilisée",
                    'rays.required' => "Le choix d'un Rayon est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255|unique:shelves',
                    'rays' => 'bail|required|min:1|max:255',
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
                    $shelf = Shelve::create([
                        'name' => $request->name,
                        'ray_id' => $request->rays,
                    ]);
                    return response()->json(['id' => $shelf->id, 'name' => $shelf->name, 'date' => $shelf->created_at->format('d/m/Y H:i:s'), 'ray' => $shelf->ray->name]);
                }
            }else{
                $messages = array(
                    //'name.required' => "La valeur du champ Designation est obligatoire",
                    //'name.unique' => "La valeur du champ Designation est déjà utilisée",
                    'bloc_shelf.required' => "Le choix d'une Etagère est obligatoire",
                );
                $rules = array(
                    //'name' => 'bail|required|min:3|max:255|unique:blocks',
                    'bloc_shelf' => 'bail|required|min:1|max:255',
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
                    $block = Block::create([
                        'name' => $request->name,
                        'shelf_id' => $request->bloc_shelf,
                    ]);
                    return response()->json(['id' => $block->id, 'name' => $block->name, 'date' => $block->created_at->format('d/m/Y H:i:s'), 'shelf' => $block->shelf->name, 'ray' => $block->shelf->ray->name]);
                }
            }
        } else {
            return view('errors.500');
        }
    }

    public function warehouse_edit(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            if ($type == "ray") {
                $ray = Ray::findOrFail($id);
                return response()->json($ray);
            } elseif ($type == 'shelf') {
                $shelve = Shelve::findOrFail($id);
                return response()->json($shelve);
            } else {
                $block = Block::findOrFail($id);
                return response()->json($block);
            }
        } else {
            return view('errors.500');
        }
    }

    public function warehouse_update(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($request->has('ray')) {
                $messages = array(
                    'name.required' => "La valeur du champ Designation est obligatoire",
                    'name.unique' => "La valeur du champ Designation est déjà utilisée",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255|unique:rays',
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
                    $ray = Ray::findOrFail($id);
                    $ray->name = $request->name;
                    $ray->save();
                    return response()->json(['id' => $ray->id, 'name' => $ray->name, 'date' => $ray->created_at->format('d/m/Y H:i:s')]);
                }
            } elseif ($request->has('shelf')) {

                $messages = array(
                    'name.required' => "La valeur du champ Designation est obligatoire",
                    'name.unique' => "La valeur du champ Designation est déjà utilisée",
                    'rays.required' => "Le choix d'un Rayon est obligatoire",
                );
                $rules = array(
                    'name' => 'bail|required|min:3|max:255',
                    'rays' => 'bail|required|min:1|max:255',
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
                    $shelf = Shelve::findOrFail($request->shelf_id);
                    $shelf->ray_id = $request->rays;
                    $shelf->name = strtolower($request->name);
                    $shelf->save();
                    return Response(['id' => $shelf->id, 'name' => $shelf->name, 'date' => $shelf->created_at->format('d/m/Y H:i:s'), 'ray' => $shelf->ray->name]);
                }
            } else {
                $messages = array(
                   // 'name.required' => "La valeur du champ Designation est obligatoire",
                    //'name.unique' => "La valeur du champ Designation est déjà utilisée",
                    'bloc_shelf.required' => "Le choix d'une Etagère est obligatoire",
                );
                $rules = array(
                    //'name' => 'bail|required|min:3|max:255|unique:blocks',
                    'bloc_shelf' => 'bail|required|min:1|max:255',
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
                    $block = Block::findOrFail($id);
                    $block->shelf_id = $request->bloc_shelf;
                    $block->name = $request->name;
                    $block->save();
                    return Response(['id' => $block->id, 'name' => $block->name, 'date' => $block->created_at->format('d/m/Y H:i:s'), 'shelf' => $block->shelf->name, 'ray' => $block->shelf->ray->name]);
                }
            }

        } else {
            return view('errors.500');
        }
    }

    function rays(Request $request, $type)
    {
        if ($request->ajax()) {
            if ($type == "all") {
                $rays = Ray::select('id', 'name')->get();
                return response()->json($rays);
            }
        } else {
            return view('errors.500');
        }
    }

    function shelves(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            if ($type == "all") {
                $shelves = Shelve::select('id', 'name')->where('ray_id', $id)->get();
                return response()->json($shelves);
            }else{
                $shelve = Shelve::findOrFail($id);
                $shelves = Shelve::where('ray_id', $shelve->ray_id)->get();
                return response()->json($shelves);
            }
        } else {
            return view('errors.500');
        }
    }

    function blocs(Request $request, $id)
    {
        if ($request->ajax()) {
                $bloc = Block::findOrFail($id);
                return response()->json($bloc);
        } else {
            return view('errors.500');
        }
    }
    /*** END ***/

}

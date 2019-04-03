<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Permission;
use App\Post;
use App\Role;
use App\Service;
use App\Site;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Jenssegers\Date\Date;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all()->sortBy('created_at');
        $roles = Role::select('id', 'name')->where('state',"!=",1)->get();
        $sites=Site::all();
        $services=Service::all();
        $employes=Employee::all()->sortBy('created_at');
        return view('users.home', ['users' => $users, 'roles' => $roles,'sites'=>$sites,'services'=>$services,'employes'=>$employes]);
    }

    public function roles()
    {
        $roles = Role::all()->sortBy('created_at');
        $permissions = Permission::all()->sortBy('created_at');
        return view('users.role', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function account()
    {
        $users = User::all();
        return view('users.account', compact('users'));
    }
    public function activecompte(Request $request)
    {
        if($request->ajax())
        {
            $user=User::FindOrfail($request->id_user);
            if($request->datacompte==1)
            {
                $user->status=1;
                $user->save();

            }
            elseif($request->datacompte==0)
            {
                $user->status=0;
                $user->save();
            }
            return response($user);
        }

    }
    public function getuser()
    {
        $id=Input::get('id');
        $user = User::find($id);
        $roles=Role::pluck('name','id');
        $sites = Site::all();

        $userRole = $user->roles->pluck('id','id')->toArray();

        return view('users.include.userinfo',compact('roles','user','userRole','sites'));
    }
    public function create()
    {
        $services = Role::select('id', 'display_name')->get();
        $posts = Post::select('id', 'name')->get();
        $employees = Employee::orderBy('created_at')->get();
        return view('employees.home', compact('services', 'posts', 'employees'));
    }
    public function updateuser(Request $request)
    {
        $messages = [
            'username.required' => 'le champ nom est obligatoire',
            'username.mni' => 'le champ nom doit conténir au moins 5 caractères',
            'password_confirmation.same:password' => 'le mot de passe et confirmation de mot doivent etre identique',
            'email.email'=>"entrer un email valide",

        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4',
            'email' => 'required|email',
            //'password' => 'min:4',
            'password_confirmation' => 'same:password',
          //  'roles' => 'required'
        ],
            $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors);

            return response()->json([
                'success' => false,
                'message' => $errors
            ], 422);
        }
        else
        {

            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = bcrypt($input['password']);
            } else {
                $input = array_except($input, array('password'));
            }
            $user = User::findOrFail($request['id']);
            $user->update($input);

            if($request->hasFile('image') and !empty($request->hasFile('image'))) {
                $image = $request['image'];

                $input['imagename'] = time().'.'. $image->getClientOriginalExtension();
                $destinationPath = public_path('/picture_employe');
                $image->move($destinationPath, $input['imagename']);
            }

            else{
                $id=$user->employee->id;
                $employe=Employee::findOrFail($id);
                $input['imagename']=$employe->image;
            }

            $employe_id=$user->employee->id;
            $employe=Employee::findOrFail($employe_id);
            $employe->image=$input['imagename'];
            $employe->save();

            DB::table('role_user')->where('user_id', $request['id'])->delete();

//            foreach ($request->input('roles') as $key => $value) {
//
//                $user->attachRole($value);
//            }
            return response()->json([
                'reponse' => 'ok',
                'user' => $user,
                'mobile' => $user->employee->mobile,
                //'roles' => $user->roles->first(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
        if ($request->has('access'))
        {
            $messages = array(
                'last_name.required' => "Le nom de l'employé est obligatoire",
                'last_name.min:3' => "Le nom doit contenir au moins 3 caratères",
                'first_name.required' => "le prenom est obligatoire",
                'first_name.min:3' => "le prenom doit contenier au moins 3 caractères",
                'service.required' => "le service est obligatoire",
                'poste.required' => "le choix du poste est obligatoire",
                'email.email'=>"entrer un email valide"
            );
            $rules = array(
                'last_name' => 'bail|required|min:3|',
                'site'=>'bail|required|',
                'first_name' => 'bail|required|min:3',
                'email' => 'bail|required|email|max:255|unique:users',
                'password' => 'required|min:4',
                'password_confirmation' => 'required|min:6|same:password',
                'service' => 'bail|required|min:1|max:255|',
                'poste' => 'bail|required|min:1|max:255|',
                'mobile'=>'bail|required|unique:employees',
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
//                $messages = array(
//                    'last_name.required' => "Le nom de l'utilisateur est obligatoire",
//                    'first_name.required' => "Le Prenom de l'utilisateur est obligatoire",
//                );
//                $rules = array(
//                    'last_name' => 'bail|required|min:3',
//                    'first_name' => 'bail|required|min:3',
//                    'email' => 'bail|required|min:1|max:255|unique:users',
//                    'password' => 'required|min:6',
//                    'password_confirmation' => 'required|min:6|same:password'
//                );
//                $validator = Validator::make($request->all(), $rules, $messages);
//                if ($validator->fails()) {
//                    $errors = $validator->errors();
//                    $errors = json_decode($errors);
//
//                    return response()->json([
//                        'success' => false,
//                        'message' => $errors
//                    ], 422);
//                }

                    if(empty($request->email))
                    {
                        $num=substr($request->mobile,0,3);
                        $request->email=$request->last_name.$num.@utb.com;
                    }


                if($request->hasFile('image')) {
                    $image = $request['image'];

                    $input['imagename'] = time().'.'. $image->getClientOriginalExtension();
                    $destinationPath = public_path('/picture_employe');
                    $image->move($destinationPath, $input['imagename']);
                }
                else{
                    $input['imagename']="";
                }

                 //   $role = Role::where('id', $request->poste)->first();
                    $employee = Employee::create([
                        'last_name' => $request->last_name,
                        'first_name' => $request->first_name,
                        'mobile' => $request->mobile,
                        'post_id' => $request->poste,
                        'service_id' => $request->service,
                        'email' => $request->email,
                        'site_id'=>$request->site,
                        'username' => $request->last_name . " " . $request->first_name,
                         'image'=>$input['imagename'],
                    ]);
                    $user = User::create([
                        'last_name' => $request->last_name,
                        'first_name' => $request->first_name,
                        'mobile' => $request->mobile,
                        'email' => $request->email,
                        'username' => $request->last_name. " " .$request->first_name,
                        'password' => bcrypt($request->password),
                        'employee_id'=>$employee->id,
                        'status'=>1
                    ]);


                    $roless = Role::create([
                        'name'=> $user->username,
                        'type'=> $user->username,
                        'user_id'=> $user->id,
                        'state'=> 1,

                    ]);


                    $user->roles()->attach($roless);

                //    $user->roles()->attach($role);

                    return response()->json(['username' => $employee->username, 'email' => $employee->email, 'mobile' => $employee->mobile,
                         'date' => $employee->created_at->format('d/m/y'), 'service' => $employee->service->name]);



//            else {
//                $user = User::create([
//                    'last_name' => $request->last_name,
//                    'first_name' => $request->first_name,
//                    'mobile' => $request->mobile,
//                    'email' => $request->email,
//                    'username' => $request->last_name . " " . $request->first_name,
//                    'password' => bcrypt($request->password),
//                ]);
//                $user->roles()->attach($request->role);
//
//                return response()->json(['id' => $user->id, 'username' => $user->username, 'email' => $user->email,
//                    'mobile' => $user->smobile, 'date' => Date::parse($user->created_at)->format('j M Y'),
//                    'index' => $user->count()]);
//            }
            }
        }
//
        else {

            $messages = array(
                'last_name.required' => "Le nom de l'employé est obligatoire",
                'last_name.min:3' => "Le nom doit contenir au moins 3 caratères",
                'first_name.required' => "le prenom est obligatoire",
                'first_name.min:3' => "le prenom doit contenier au moins 3 caractères",
                'service.required' => "le service est obligatoire",
                'poste.required' => "le choix du poste est obligatoire",
                'site.required' => "le choix du site est obligatoire",
                'mobile.required' => "entrer le numero de telephone SVP!",
                'mobile.unique:employees' => "Numero de telephone déja utilisé",
            );
            $rules = array(
                'last_name' => 'bail|required|min:3|',
                'first_name' => 'bail|required|min:3',
                'service' => 'bail|required|min:1|max:255|',
                'mobile'=>'bail|required|unique:employees',
                'service' => 'bail|required|min:1|max:255|',
                'poste' => 'bail|required|min:1|max:255|',
                'site'=>'bail|required|',
            );



            $validator = Validator::make($request->all(), $rules,$messages);


            if ($validator->fails()) {
                $errors = $validator->errors();
                $errors = json_decode($errors);

                return response()->json([
                    'success' => false,
                    'message' => $errors
                ], 422);
            } else {
                if(empty($request->email))
                {
                    $num=substr($request->mobile,0,3);
                    $request->email=$request->last_name.$num."@utb.com";
                }
                if($request->hasFile('image') and !empty($request->hasFile('image'))) {
                    $image = $request['image'];

                    $input['imagename'] = time().'.'. $image->getClientOriginalExtension();
                    $destinationPath = public_path('/picture_employe');
                    $image->move($destinationPath, $input['imagename']);
                }
                else{
                    $input['imagename']="";


                }
                $employee = Employee::create([
                    'last_name' => strtolower($request->last_name),
                    'first_name' => strtolower($request->first_name),
                    'mobile' => strtolower($request->mobile),
                    'post_id' => strtolower($request->poste),
                    'service_id' => strtolower($request->service),
                    'email' => strtolower($request->email),
                    'site_id'=>strtolower($request->site_id),
                    'username' => strtolower($request->last_name . " " . $request->first_name),
                    'image'=>$input['imagename'],
                ]);
                return response()->json(['username' => $employee->username, 'email' => $employee->email, 'mobile' => $employee->mobile,
                     'date' => $employee->created_at->format('d/m/Y'),'service' => $employee->service->name]);

            }
        }
        }


        /*}else{
            return view('errors.500');
        } */
    }

    public function permission()
    {
        $postes=Post::all();
        $permissions= Permission::all();
        $roles=Role::all();
        return view('users.permission',compact('postes','permissions','roles'));
    }
    public function editPermission(Request $request)
    {

        $role = Role::findOrFail($request['id_permission']);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$request['id_permission'])
            ->pluck('permission_role.permission_id','permission_role.permission_id');

        return view('users.include.permissionModal',compact('role','permission','rolePermissions'));
    }

    public function editPermissionuser(Request $request)
    {

        $role = Role::findOrFail(1);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$request['id_permission'])
            ->pluck('permission_role.permission_id','permission_role.permission_id');

        $users = User::all();

        return view('users.Updateuser',compact('role','permission','rolePermissions','users'));
    }


    public function fetch_data_user(Request $request)
    {
        if($request->ajax())
        {
            $id = Input::get('id');
            $user = User::findOrFail($id);

            $role = Role::where('user_id',$id)->get();
           // dd($role);

            $permission = Permission::get();
            $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$role[0]->id)
                ->pluck('permission_role.permission_id','permission_role.permission_id');


            return view('users.include.updateroleuser',compact('role','permission','rolePermissions','user'));

        }

    }

    /**********post_permission user**********/
    public function post_permission_user(Request $request)
    {
        if($request->ajax())
        {
            $role = Role::find($request['id']);
            $role->display_name = $request->input('display_name');
            $role->description = $request->input('description');
            $role->save();
            if($request['id'])
            {
                DB::table("permission_role")->where("permission_role.role_id",$request['id'])
                    ->delete();

            }
            if($request->input('permission'))
            {
                foreach ($request->input('permission') as $key => $value) {
                    $role->attachPermission($value);

                }

            }

            return response()->json([
                'reponse'=>'ok'
            ]);
        }
    }

    public function post_permission(Request $request)
    {
        if($request->ajax())
        {
            $role = Role::find($request['id']);
            $role->display_name = $request->input('display_name');
            $role->description = $request->input('description');
            $role->save();
            if($request['id'])
            {
                DB::table("permission_role")->where("permission_role.role_id",$request['id'])
                    ->delete();

            }
            if($request->input('permission'))
            {
                foreach ($request->input('permission') as $key => $value) {
                    $role->attachPermission($value);

                }

            }

            return response()->json([
                'reponse'=>'ok'
            ]);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}

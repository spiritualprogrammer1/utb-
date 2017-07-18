<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Input;


Auth::routes();

Route::get('/', 'HomeController@index');

// Ajout de la route valeurs_notifications
Route::get('valeurs_notifgenerale', 'HomeController@valeurs_notifications');
Route::get('nombre_notifgenerale', 'HomeController@nombre_notifications');


Route::group(['middleware' => ['auth']], function () {

    /***********************
     *** Ajax Request ***
     ********************/
    Route::get('/fetch_countries', function () {
        $countries = App\Country::all();
        return Response::json($countries);
    });
    /**********  END ***************/


    /************* End ***************/

    /***********************
     ** SUPPLIER ROUTE **
     ********************/
    Route::group(['prefix' => 'supplier'], function () {
        Route::resource('supplier', 'SupplierController');
        Route::get('/supplier/phonecode/{id}', 'SupplierController@phonecode');
        Route::get('listing/{id}', 'SupplierController@listing');
        Route::get('score', 'SupplierController@score');
    });
    /*********** End ************/


    /***********************
     ** SETTINGS ROUTES **
     ********************/
    Route::group(['prefix' => 'setting'], function () {
        /*** VEHICLE SETTINGS ***/
        Route::get('vehicle', 'SettingController@vehicle');
        Route::post('vehicle_store', 'SettingController@vehicle_store')->name('vehicle_store');
        Route::put('vehicle_update/{id}', 'SettingController@vehicle_update')->name('vehicle_update');
        Route::get('vehicle_edit/{type}/{id}', 'SettingController@vehicle_edit');
        Route::get('brands', 'SettingController@brands');
        /*** END ***/

        /*** STOCK SETTINGS ***/
        Route::get('stock', 'SettingController@stock');
        Route::post('stock_store', 'SettingController@stock_store')->name('stock_store');
        Route::put('stock_update/{id}', 'SettingController@stock_update')->name('warehouse_update');
        Route::get('stock_edit/{type}/{id}', 'SettingController@stock_edit');
        Route::get('families', 'SettingController@families');
        /*** END ***/

        /*** WAREHOUSE SETTINGS ***/
        Route::get('warehouse', 'SettingController@warehouse');
        Route::post('warehouse_store', 'SettingController@warehouse_store')->name('warehouse_store');
        Route::get('warehouse_edit/{type}/{id}', 'SettingController@warehouse_edit');
        Route::put('warehouse_update/{id}', 'SettingController@warehouse_update')->name('warehouse_update');
        Route::get('rays/{type}', 'SettingController@rays');
        Route::get('shelves/{type}/{id}', 'SettingController@shelves');
        Route::get('blocs/{id}', 'SettingController@blocs');
        /*** END ***/
    });
    /************* END SETTINGS ****************/

    /***********************
     ** Stock Routes **
     ********************/
    Route::group(['prefix' => 'stock'], function () {
        Route::resource('/stock', 'StockController');
        Route::get('/action', 'StockController@action');
		Route::get('/inventory', 'StockController@inventory');
        Route::post('/adjust', ['uses' => 'StockController@adjust','as' => '/adjust']);
        Route::get('/fetch_inventory', function () {
            $id = Input::get('id');
            $inventories = App\Inventory::where('stock_id', $id)->orderBy('created_at', 'desc')->get();
            $stock = App\Stock::findOrFail($id);
            return view('stock.file.inventory', compact('inventories', 'stock'));
        });
        Route::get('/fetch_stock', function () {
            $stock_id = Input::get('id');
            $stock = App\Stock::where('id', '=', $stock_id)->with('sub_category')->with('block')->get();
            return Response::json($stock);
        });
        Route::post('/in', [
            'uses' => 'StockController@in',
            'as' => '/in'
        ]);

        Route::get('fetch_supplier', function () {
            $type = Input::get('type');
            $suppliers = App\Supplier::where('type', $type)->get();
            return Response::json($suppliers);
        });


        Route::get('fetch_History', function () {
            $stock_id = Input::get('stock_id');
            $in_stock = App\In_stock::where('stock_id', '=', $stock_id)->with('supplier')->get();
            return Response::json($in_stock);
            //return Response::json(['reference'=>$in_stock->stock->reference]);
        });

        Route::get('fetch_modele', function () {
            $brand_id = Input::get('id');
            $models = App\Models::where('brand_id', '=', $brand_id)->get();
            return Response::json($models);
        });

        Route::get('fetch_sub', function () {
            $category_id = Input::get('id');
            $categories = App\Sub_category::where('category_id', '=', $category_id)->get();
            return Response::json($categories);
        });


        /**********************************
         ********** SUPPLIERS *************
         **********************************/
        Route::get('fetch_supplierStock', function () {
            $supplier_id = Input::get('id');
            $stocks = App\Stock::where('supplier_id', '=', $supplier_id)->get();
            return view('stock.includes.tbody', compact('stocks'));
        });

        Route::get('fetch_suppliersStock', function () {
            $stocks = App\Stock::all();
            return view('stock.includes.tbody', compact('stocks'));
        });

        Route::get('fetch_outHistory', function () {
            $stock_id = Input::get('stock_id');
            $in_stock = App\In_stock::where('stock_id', '=', $stock_id)->where('type', 1)->get();
            return Response::json($in_stock);
            //return Response::json(['reference'=>$in_stock->stock->reference]);
        });
        Route::get('fetch_stock', function () {
            $stock_id = Input::get('id');
            $stock = App\Stock::where('id', '=', $stock_id)->with('sub_category')->with('block')->get();
            return Response::json($stock);
        });

        Route::get('fetch_inHistory', function () {
            $stock_id = Input::get('stock_id');
            $in_stock = App\In_stock::where('stock_id', '=', $stock_id)->where('type', 0)->with('supplier')->get();
            return Response::json($in_stock);
            //return Response::json(['reference'=>$in_stock->stock->reference]);
        });

        Route::post('/out', [
            'uses' => 'StockController@out',
            'as' => '/out'
        ]);
        Route::post('/stock_update', [
            'uses' => 'StockController@stockUpdate',
            'as' => '/stock_update'
        ]);

        Route::get('/stock_get', function () {
            $id = Input::get('id');
            $stock = App\Stock::findOrFail($id);
            return Response::json($stock);
        });

        Route::get('/supplier_change', function () {
            $id = Input::get('id');
            $supplier = App\Supplier::where('id', $id)->get();
            $suppliers = App\Supplier::where('type', $supplier[0]->type)->get();
            return Response::json($suppliers);
        });
        Route::get('/model_change', function () {
            $id = Input::get('id');
            $model = App\Models::where('id', $id)->get();
            $models = App\Models::where('brand_id', $model[0]->brand_id)->get();
            return Response::json($models);
        });
        Route::get('/sub_category_change', function () {
            $id = Input::get('id');
            $sub_category = App\Sub_category::where('id', $id)->get();
            $sub_categories = App\Sub_category::where('category_id', $sub_category[0]->category_id)->get();
            return Response::json($sub_categories);
        });
        Route::get('/shelves_get', function () {
            $id = Input::get('id');
            $ray = App\Ray::findOrFail($id);
            $shelves = App\Shelve::where('ray_id',$ray->id)->get();
            return Response::json($shelves);
        });
        Route::get('/blocks_get', function () {
            $id = Input::get('id');
            $shelf = App\Shelve::findOrFail($id);
            $blocks = App\Block::where('shelf_id',$shelf->id)->get();
            return Response::json($blocks);
        });
        Route::get('/block_change', function () {
            $id = Input::get('id');
            $stock = App\Stock::findOrFail($id);
            $block = App\Block::where('id', $stock->block_id)->first();
            $blocks = App\Block::where('shelf_id', $block->shelf_id)->get();
            return Response::json($blocks);
        });
        Route::get('/shelf_change', function () {
            $id = Input::get('id');
            $stock = App\Stock::findOrFail($id);
            $block = App\Block::where('id', $id)->first();
            $shelf = App\Shelve::where('id', $block->shelf_id)->first();
            $ray = App\Ray::findOrFail($shelf->ray_id);
            $shelves = App\Shelve::where('ray_id', $ray->id)->get();
            return Response::json($shelves);
        });
    });
    /************* End ****************/


    /***********************
     ** Perfermance Routes **
     ********************/
    Route::group(['prefix' => 'performance'], function () {
        Route::resource('/performance', 'PerformanceController');
        Route::resource('/revision', 'RevisionController');
        Route::resource('/repair', 'RepairController');
        Route::get('fetch_model', function () {
            $brand_id = Input::get('id');
            $models = App\Models::where('brand_id', '=', $brand_id)->get();
            return Response::json($models);
        });
        Route::get('/fetch_operations', function () {
            $type_id = Input::get('id');
            $operations = App\Operation_technique::where('type_operation_id', '=', $type_id)->get();
            return Response::json($operations);
        });



        /*****************PDF*****/
        Route::get('diagnostic_file','PerformanceController@diagnostic_file');

        Route::get('beforeTest_file','PerformanceController@beforeTest_file');
        Route::get('repair_file','RepairController@repairFile');
        Route::get('visit_file','VisitController@visitFile');
        Route::get('operationtechniq_file','VisitController@operationtechniq_file');
        Route::get('revision_file','RevisionController@revisionFile');
        Route::get('operationrevision_file','RevisionController@operationrevision_file');
        Route::get('after_test_file','TestController@after_test_file');


        Route::get('fetch_technician', function () {
            $id = Input::get('id');
            $technician = explode(",", $id);
            $technicians = array();
            foreach ($technician as $value) {
                $employee = App\Employee::find($value);
                $technicians[] = $employee;
            }
            return view('performance.includes.work', compact('technicians'));
        });

        Route::get('state_file','PerformanceController@state_file');


        Route::get('visit_filee','VisitController@visitFile');
        Route::get('revision_filee','RevisionController@revisionFile');
        Route::get('repair_filee','RepairController@repairFile');
        // Ajout de la notification
        Route::get('/valeurs_notifications', 'HomeController@valeurs_notifications');
        Route::get('/nombre_notifications', 'HomeController@nombre_notifications');



        Route::get('searchchvehic','PerformanceController@historivehicule');
        // Notification
        Route::get('/diagnostic', 'PerformanceController@diagnostic');
        Route::get('/process_get', 'PerformanceController@processGet');

        Route::post('/diagnosticCreate', [
            'uses' => 'PerformanceController@diagnosticCreate',
            'as' => '/diagnosticCreate'
        ]);
        Route::post('/postTest', [
            'uses' => 'TestController@postTest',
            'as' => '/postTest'
        ]);

        /*********** REVISION REQUEST ***********/
        Route::get('/get_revision',function (){
            $id = Input::get('id');
            $revision = App\Revision::findOrFail($id);
            $diagnostic=$revision->diagnostic;
            $diagbackTest=$diagnostic->back_testing;
            $afterTest=$diagnostic->after_test;
            return Response::json(['diagbackTest'=>$diagbackTest,'afterTest'=>$afterTest,'id' => $revision->id,'reference' => $revision->diagnostic->process->reference,
                'matriculation' => $revision->diagnostic->process->state->vehicle->matriculation,
                'model' => $revision->diagnostic->process->state->vehicle->model->name]);
        });
        Route::get('/get_operation_revision', function () {
            $id = Input::get('id');
            $technicians = App\Observation_revision::where('revision_id', '=', $id)->with('employee')->get();
            $revision= App\Revision::find($id);
            $diagnostics = $revision->diagnostic;
            return view('performance.includes.revision_modal', compact('technicians','diagnostics'));
        });
        Route::post('/revision_update', [
            'uses' => 'RevisionController@revisionUpdate',
            'as' => '/revision_update'
        ]);
        Route::get('/fet_operation_revision', function () {
            $id = Input::get('id');
            $operations = App\Observation_operation_revision::where('revision_id', $id)->get();
            return view('performance.includes.operations', compact('operations'));
        });

        /*********** END *********************/



        Route::get('/get_vehicle', function () {
            $id = Input::get('reference');
            $diagnostic = App\Diagnostic::findOrFail($id);
            $vehicle = $diagnostic->process->state->vehicle->model->name;
            return Response::json(['id' => $diagnostic->id, 'vehicle' => $vehicle, 'matriculation' =>$diagnostic->process->state->vehicle->matriculation]);
        });

        Route::get('/get_repair', function () {
            $id = Input::get('id');
            $repair = App\Repair::findOrFail($id);
            $diagnostic=$repair->diagnostic;
            $diagbackTest=$diagnostic->back_testing;
            $afterTest=$diagnostic->after_test;
            return Response::json(['afterTest'=>$afterTest,'diagbackTest'=>$diagbackTest,'id' => $repair->id, 'reference' => $repair->diagnostic->process->reference, 'matriculation' => $repair->diagnostic->process->state->vehicle->matriculation,
                'model' => $repair->diagnostic->process->state->vehicle->model->name]);
        });

        Route::get('/get_operations', function () {
            $id = Input::get('id');
            $operations = App\Observation_operation_technique::where('visit_technique_id', $id)->get();
            return view('performance.includes.operations', compact('operations'));
        });

        /*edit visite technique*/
        Route::get('/get_visit', function () {
            $id = Input::get('id');
            $visit = App\Visit_Technique::findOrFail($id);
            $diagnostic=$visit->diagnostic;
            $diagbackTest=$diagnostic->back_testing;
            $afterTest=$diagnostic->after_test;
            return Response::json(['afterTest'=>$afterTest,'diagbackTest'=>$diagbackTest,'id' => $visit->id,'reference' => $visit->diagnostic->process->reference,
                'matriculation' => $visit->diagnostic->process->state->vehicle->matriculation,
                'model' => $visit->diagnostic->process->state->vehicle->model->name]);
        });
        /*edit revison*/


        Route::get('/get_technicians', function () {
            $id = Input::get('id');
            $technicians = App\Observation_repair::where('repair_id', '=', $id)->with('employee')->get();
            $repair= App\Repair::find($id);
            $diagn=$repair->diagnostic;
            return view('performance.includes.modal', compact('technicians','diagn'));
        });
        /*get operation revision*/


        /*get operation visite technique*/
        Route::get('/get_visit_operation', function () {
            $id = Input::get('id');
            $technicians = App\Observation_technique::where('visit_technique_id', '=', $id)->with('employee')->get();
            $operation= App\Visit_Technique::find($id);
            $diagnostics = $operation->diagnostic;
            return view('performance.includes.technique_modal', compact('technicians','diagnostics'));
        });

        Route::get('visit','VisitController@index');

        Route::get('/test', function () {
            return view('performance.test');
        });

        Route::get('/work', function () {
            $name = Input::get('filter');
            if ($name == 'repair') {
                $reps = App\Repair::join('observation_repairs','observation_repairs.repair_id','=','repairs.id')
                    ->join('diagnostics','diagnostics.id','=','repairs.diagnostic_id')
                    ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('employees','employees.id','=','observation_repairs.employee_id')
                    ->select('diagnostics.id as iddiagnostique','repairs.id as id','repairs.date as datereparation','processes.reference as reference',
                        'models.name as name','vehicles.matriculation as matriculation','repairs.date as date')
                    ->where('diagnostics.state',3)
                    ->groupBy('diagnostics.id')
                    ->get();

                return view('performance.includes.repair',compact('reps'));
            }
            if ($name == 'revision') {
                $revision=App\Revision::join('observation_revisions','observation_revisions.revision_id','=','revisions.id')
                    ->join('diagnostics','diagnostics.id','=','revisions.diagnostic_id')
                    ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('employees','employees.id','=','observation_revisions.employee_id')
                    ->select('diagnostics.id as diagnostic_id','revisions.id as id','revisions.date as date','processes.reference as reference',
                        'models.name as name','vehicles.matriculation as matriculation','revisions.date as date')
                    ->where('diagnostics.state',3)
                    ->where('diagnostics.prestation',3)
                    ->groupBy('diagnostics.id')
                    ->get();
                return view('performance.includes.revision',compact('revision'));
            }
            if ($name == 'visit') {
                $visits = App\Visit_Technique::join('observation_techniques','observation_techniques.visit_technique_id','=','visit_techniques.id')
                    ->join('diagnostics','diagnostics.id','=','visit_techniques.diagnostic_id')
                    ->join('processes','processes.id','=','diagnostics.process_id')
                    ->join('states','states.id','=','processes.state_id')
                    ->join('vehicles','vehicles.id','=','states.vehicle_id')
                    ->join('models','models.id','=','vehicles.model_id')
                    ->join('employees','employees.id','=','observation_techniques.employee_id')
                    ->select('diagnostics.id as diagnostic_id','visit_techniques.id as id','visit_techniques.date as date','processes.reference as reference',
                        'models.name as name','vehicles.matriculation as matriculation','visit_techniques.date as date')
                    ->where('diagnostics.state',3)
                    ->where('diagnostics.prestation',2)
                    ->groupBy('diagnostics.id')
                    ->get();
                return view('performance.includes.visit',compact('visits'));
            }
        });



        Route::get('testRepair',function (){
            $id = Input::get('id');
            $repair = App\Repair::findOrFail($id);
            $diagnostic = $repair->diagnostic;
            $observations=App\Repair::join('observation_repairs','observation_repairs.repair_id','=','repairs.id')
                ->join('diagnostics','diagnostics.id','=','repairs.diagnostic_id')
                ->join('employees','employees.id','=','observation_repairs.employee_id')
                ->join('processes','processes.id','=','diagnostics.process_id')
                ->select('processes.reference as references','employees.first_name as username',
                    'observation_repairs.date as date','observation_repairs.hours as hours','observation_repairs.observation as observation')
                ->where('diagnostics.id',$diagnostic->id)
                ->get();
            $vehicle = $repair->diagnostic->process->state->vehicle;
            return view('performance.includes.test_modal', compact('repair','vehicle','observations','diagnostic'));
        });

        Route::get('testVisit',function (){
            $id = Input::get('id');
            $repair = App\Visit_Technique::findOrFail($id);
            $diagnostic = $repair->diagnostic;
            $observations = App\Visit_Technique::join('observation_techniques','observation_techniques.visit_technique_id','=','visit_techniques.id')
                ->join('diagnostics','diagnostics.id','=','visit_techniques.diagnostic_id')
                ->join('employees','employees.id','=','observation_techniques.employee_id')
                ->join('processes','processes.id','=','diagnostics.process_id')
                ->select('processes.reference as references','employees.username as username',
                    'observation_techniques.date as date','observation_techniques.hours as hours','observation_techniques.observation as observation')
                ->where('diagnostics.id',$diagnostic->id)
                ->get();
            $vehicle = $repair->diagnostic->process->state->vehicle;
            return view('performance.includes.test_modal', compact('repair','vehicle','observations','diagnostic'));

        });
        Route::get('testRevision',function (){
            $id=Input::get('id');
            $repair=App\Revision::findOrFail($id);
            $diagnostic = $repair->diagnostic;
            $observations = App\Revision::join('observation_revisions','observation_revisions.revision_id','=','revisions.id')
                ->join('diagnostics','diagnostics.id','=','revisions.diagnostic_id')
                ->join('employees','employees.id','=','observation_revisions.employee_id')
                ->join('processes','processes.id','=','diagnostics.process_id')
                ->select('processes.reference as references','employees.username as username',
                    'observation_revisions.date as date','observation_revisions.hours as hours','observation_revisions.observation as observation')
                ->where('diagnostics.id',$diagnostic->id)
                ->get();
            $vehicle = $repair->diagnostic->process->state->vehicle;
            return view('performance.includes.test_modal', compact('repair','vehicle','observations','diagnostic'));


        });

       // Route::get('/work','TestController@getview');


    });
    /*********** End ************/


    /***********************
     ** Approval Routes **
     ********************/
    Route::group(['prefix' => 'approval'], function () {
        Route::resource('/approval', 'ApprovalController');
        Route::get('/get', 'ApprovalController@approval');
        Route::get('/output', 'ApprovalController@output');
        Route::get('diagnostic_filee','PerformanceController@diagnostic_file');

        Route::get('/valeurs_notifapproval', 'HomeController@valeurs_notifications');
        Route::get('/nombre_notifapproval', 'HomeController@nombre_notifications');
        /******PDF***/
        Route::get('file_ouput','TestController@file_ouput');

        Route::get('/diagnostic_get', function () {
            $id = Input::get('id');
            $diagnostic = App\Diagnostic::findOrFail($id);
            return view('approval.includes.modal', compact('diagnostic'));
        });
        Route::get('output_show','ApprovalController@outputGet');
        Route::get('output_get',function (){
            $id = Input::get('id');
            return response()->json($id);
        });

        Route::post('/release', [
            'uses' => 'ApprovalController@release',
            'as' => '/release'
        ]);
    });

    /*********  END **********/

    /***********************
     ** EMPLOYEE Routes **
     ********************/
    Route::group(['prefix' => 'users'], function () {
        Route::resource('/user', 'UserController');
        Route::get('/account', 'UserController@account');
    });
    /********** END ***********/


    /*ajout observation reparation*/
    Route::post('repair_observation','RepairController@repairObservation');
    /*********** End ************/

    /*route vistetechniq controller*/

    //Route::resource('/visit', 'VisitController');
    /*Enregistrement visite technique*/
    Route::post('visit_store','VisitController@store');
    /*enregistrement revison*/
   // Route::post('storevision','RevisionController@store');

    /*observationvisite*/
    Route::post('visit_update','VisitController@visitUpdate');
    /*observation revision*/
    Route::post('observarevision','RevisionController@observarevision');
    /**/
    Route::post('approvacreate','ApprovalController@approvacreate');




    /*******************DATA DASHBOARD**************************/

//==========technical============
    Route::get('technicaldashboard','HomeController@technicaldashboard');
    //======total diagnostique==
    Route::get('totaldiagnostic','DashboardController@totaldiagnostic');
    //===========total befor test=======
    Route::get('totalbefor_test','DashboardController@totalbefor_test');
    Route::get('nbrepairattent','DashboardController@nbrepairattent');
    Route::get('nbrevisitattente','DashboardController@nbrevisitattente');
    Route::get('releasattente','DashboardController@releasattente');
    Route::get('releaseattentepair','DashboardController@releaseattentepair');
    Route::get('releasevisiatten','DashboardController@releasevisiatten');
    Route::get('releasevhicrepair','DashboardController@releasevhicrepair');
    Route::get('releasevhicvisit','DashboardController@releasevhicvisit');
    Route::get('releasevhicRevision','DashboardController@releasevhicRevision');
    Route::get('nbrevehic','DashboardController@nbrevehic');
    Route::get('pieceAvaliderr','DashboardController@pieceAvaliderr');
    Route::get('pieceValider','DashboardController@pieceValider');
    Route::get('repaittent','DashboardController@repaittent');
    Route::get('repairEffectuer','DashboardController@repairEffectuer');
    Route::get('repairencours','DashboardController@repairencours');
    Route::get('revisionattente','DashboardController@revisionattente');
    Route::get('revisionencours','DashboardController@revisionencours');
    Route::get('visitecheffetc','DashboardController@visitecheffetc');
    Route::get('releaserevisionattent','DashboardController@releaserevisionattent');
    Route::get('totaldiagnostique','DashboardController@totaldiagnostique');
    Route::get('visitechencours','DashboardController@visitechencours');
    Route::get('visiteTechnattente','DashboardController@visiteTechnattente');
    Route::get('revisionattentessai','DashboardController@revisionattentessai');
    Route::get('aftertestattent','DashboardController@aftertestattent');
    Route::get('revisioneffectuer','DashboardController@revisioneffectuer');




    /******************Historical*****************/

    /***********historical******/

    Route::get('gethistorical','PerformanceController@gethistorical');

    Route::get('searchhistoprestation','PerformanceController@getHistPrestation');

    /*********************ARCHIVE*************/
    /***consulter archives****/
    Route::get('consult_archives','ArchiveController@getConsultArchivesPage');
    Route::get('searcharhopers','ArchiveController@getArchiveOperations');
    Route::get('searcharhprest','ArchiveController@getArchiveDiagPrestation');
    Route::get('searcharhrep','ArchiveController@getArchiveDiagReparation');
    Route::get('searcharhdiags','ArchiveController@getArchiveDiags');
    Route::get('searcharhrep','ArchiveController@getArchiveDiagReparation');
    Route::get('searcharhvisit','ArchiveController@getArchiveDiagVisite');
    Route::get('searcharhrevis','ArchiveController@getArchiveDiagRevision');
    Route::get('searcharheat', 'ArchiveController@getArchiveDiagEssaisApresT');
    Route::get('searcharheavt','ArchiveController@getArchiveDiagEssaisAvantT');
    Route::get('searcharchvoit', 'ArchiveController@getArchiveVoiture');
    Route::get('searcharchvoits', 'ArchiveController@getArchiveVoitures');
    Route::get('searcharhoper', 'ArchiveController@getArchiveOperation');
    Route::get('searcharhrelease', 'ArchiveController@getArchiveRelease');
    Route::get('searcharhotpres', 'ArchiveController@getArchiveOTPrestations');
    /***********************DOCUMENTS*************************/
    //Consulter les documents
    Route::get('getdocument', 'documentController@getConsultDocumentsPage');



});
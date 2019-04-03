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



Route::group(['middleware' => ['auth']], function () {
    /******************/
    Route::get('historiqueapp','HomeController@historiqueapp');
    /***********/
    /***********************
     ** STATE ROUTE **
     ********************/
    Route::group(['prefix' => 'state'], function () {
        Route::resource('home', 'StateController');
        Route::get('state/{id}','StateController@stateFile');
        Route::get('score','StateController@score');
        Route::get('filestate/{id}','StateController@filestate');

        Route::get('data_car/{id}','StateController@data_car');


         Route::get('test_essai','StateController@test_essai');
    });
    /************* End ****************/

    /***********************
     ** DIAGNOSTIC ROUTE **
     ********************/
    Route::group(['prefix' => 'diagnostic'], function () {
        Route::resource('home', 'DiagnosticController');
        Route::get('score','DiagnosticController@score');
        Route::get('filesdiagnostique/{id}','DiagnosticController@filesdiagnostique');
        Route::get('savetest/{state_id}/{leaving}/{distance}/{lieu}/{tester}/{descrip}/{arrive}','DiagnosticController@savetest');

        Route::get('filesworks/{id}','DiagnosticController@filesworks');
        Route::get('bus_history/{id}','DiagnosticController@bus_history');
        Route::get('historiqueot/{id}','DiagnosticController@historiqueot');
    });
    /************* End ****************/

    /***********************
     ** REPAIR ROUTE **
     ********************/
    Route::group(['prefix' => 'repair'], function () {
        Route::resource('home', 'RepairController');
        Route::get('score','RepairController@score');
        Route::get('scoree','RepairController@scoree');
        Route::get('filesrepaire/{id}','RepairController@filesrepaire');

    });
    /************* End ****************/

    /***********************
     ** REVISION ROUTE **
     ********************/
    Route::group(['prefix' => 'revision'], function () {
        Route::resource('home', 'RevisionController');
        Route::get('score','RevisionController@score');
        Route::get('scoree','RevisionController@scoree');
        Route::get('filesrevision/{id}','RevisionController@filesrevision');
    });
    /************* End ****************/

    /***********************
     ** VISIT ROUTE **
     ********************/
    Route::group(['prefix' => 'visit'], function () {
        Route::resource('home', 'VisitController');
        Route::get('score','VisitController@score');
        Route::get('scoree','VisitController@scoree');
        Route::get('filesvisit/{id}','VisitController@filesvisit');
    });
    /************* End ****************/

    /***********************
     ** APPROVAL ROUTE **
     ********************/
    Route::group(['prefix' => 'approval'], function () {
        Route::resource('home', 'ApprovalController');
        Route::get('descriptions/{id}/{type}', 'ApprovalController@descriptions');
        Route::get('score','ApprovalController@score');
        Route::get('filesapprovalhome/{id}','ApprovalController@filesapprovalhome');
    });
    /************* End ****************/

    /***********************
     ** AFTER WORKS ROUTE **
     ********************/
    Route::group(['prefix' => 'afterworks'], function () {
        Route::resource('home', 'AfterWorksController');
        Route::get('score','AfterWorksController@score');
        Route::get('filesafertworks/{id}','AfterWorksController@filesafertworks');
    });
    /************* End ****************/


    /***********************
     ** USER ROUTE **
     ********************/
    Route::group(['prefix' => 'user'], function () {
        Route::resource('index', 'UserController');

        Route::post('store','UserController@store')->name('store');


        Route::get('/account', 'UserController@account');
        Route::get('updateuser','UserController@editPermissionuser');
        Route::get('fetch_data_user','UserController@fetch_data_user');
        Route::post('post_permission_user','UserController@post_permission_user')->name('post_permission_user');
        Route::get('activecompte','UserController@activecompte');
        Route::get('role', 'UserController@roles');
        Route::get('fetch_poste',function () {
            $service_id = Input::get('id');
            $posts = App\Post::where('service_id', '=', $service_id)->get();
            return Response::json($posts);
        });
        Route::get('/getinfouser', 'UserController@getuser');
        Route::get('permission','UserController@permission');
        Route::get('edit_permission','UserController@editPermission');
        Route::post('post_permission', [
            'uses' => 'UserController@post_permission',
            'as' => 'post_permission'
        ]);
        Route::post('updateuser','UserController@updateuser');
    });
    /********** END ***********/

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
        /*********ENTREPRISE******/
        Route::get('get_entreprise','SettingController@getEntreprise');
        Route::post('post_entreprise', [
            'uses' => 'SettingController@postEntreprise',
            'as' => 'post_entreprise'
        ]);
        Route::post('update_entreprise', [
            'uses' => 'SettingController@updateEntreprise',
            'as' => 'update_entreprise'
        ]);

        Route::get('entreprise_get',function () {
            $id = Input::get('id');
            $entreprise = App\Entreprise::findOrFail($id);
            return Response::json($entreprise);
        });
        /**********/

/*******SITE********/
        Route::get('site', 'SettingController@site');
        Route::post('/siteCreate', [
            'uses' => 'SettingController@sitecreate',
            'as' => '/siteCreate'
        ]);
        Route::get('activesite','SettingController@activesite');
        Route::post('/site_update', [
            'uses' => 'SettingController@siteUpdate',
            'as' => '/site_update'
        ]);
        Route::get('site_get', function () {
            $id = Input::get('id');
            $site = App\Site::findOrFail($id);
            return Response::json($site);
        });
/******END****/

        /************  SERVICE SETTINGS************/
        Route::get('/service_get', function () {
            $id = Input::get('id');
            $service = App\Service::findOrFail($id);
            return Response::json($service);
        });
        Route::get('service','SettingController@service');
        Route::post('/service_create', [
            'uses' => 'SettingController@serviceCreate',
            'as' => '/service_create'
        ]);
        Route::post('/service_updated', [
            'uses' => 'SettingController@serviceUpdated',
            'as' => '/service_updated'
        ]);
        Route::get('fetch_services', function () {
            $services = App\Service::select('id', 'name')->get();
            return Response::json($services);
        });
/******END****/

/**********Poste Setting********/
        Route::get('/postes_get', function () {
            $id = Input::get('id');
            $sub = App\Post::findOrFail($id);
            return Response::json($sub);
        });
        Route::post('/create_postes',[
            'uses'=>'SettingController@createPoste',
            'as'=>'/create_postes'
        ]);

        Route::post('/updateposte',['uses'=>'SettingController@UpdatePoste',
            'as'=>'/updateposte']);
/****END**/
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
     ** STOCK ROUTE **
     ********************/
    Route::group(['prefix' => 'stock'], function () {
        Route::resource('home', 'StockController');
        Route::post('saveengine','StockController@saveEngine');
        Route::post('upatestock/{id}','StockController@upatestock');
        Route::get('createengine','StockController@createEngine');
        Route::get('editstock/{id}','StockController@editstock');
        Route::get('/suppliers/{id}/{type}', 'StockController@suppliers');

        Route::get('excelstock','StockController@excelstock');
        Route::post('importExcel','StockController@importExcel')->name('importExcel');

        /******/
        Route::post('savetire','StockController@savetire');
        Route::get('tire','StockController@gettire');



        /************search listing******/
         Route::get('searchlisting/{id}', 'StockController@searchlisting');
        /*******************/

        Route::get('brand_models/{id}/{type}', 'StockController@brand_models');
        Route::get('shelving/{id}/{type}', 'StockController@shelving');
        Route::get('category_subcategories/{id}/{type}', 'StockController@category_subcategories');
        Route::get('type_pneu/{id}/{type}', 'StockController@type_pneu');
          Route::get('deliveryget/{id}/{type}', 'StockController@deliveryget');


        /*** Create ***/
        Route::get('deliveryBy/{id}', 'StockController@deliveryBy');
        Route::get('modelBy/{id}', 'StockController@modelBy');
        Route::get('subFamily/{id}', 'StockController@subFamily');
        Route::get('shelves/{id}', 'StockController@shelves');
        Route::get('blocs/{id}', 'StockController@blocs');
        Route::post('savedelivery','StockController@savedelivery');
        Route::get('filesouputstock/{id}','StockController@filesouputstock');
        /*** End ***/
        /*********stock***/
        Route::get('score','StockController@score');

        /*** Output Stock ***/
        Route::get('output', 'StockController@output');
        Route::get('movement/{id}/{type}', 'StockController@movement');
        Route::get('search', 'StockController@search');
        Route::get('references/{id}/{type}', 'StockController@references');

        Route::get('searchstock', 'StockController@searchstock');


        /*** End ***/

        /*** Input Stock ***/
        Route::get('input', 'StockController@input');
        /*** End ***/

        /*** Back Stock ***/
        Route::get('back', 'StockController@back');
        /*** End ***/

        /*** Delivery ***/
        Route::get('delivery', 'StockController@delivery');
        Route::get('preview/{id}', 'StockController@preview');
        /*** End ***/

        /*** Listing ***/
        Route::get('listing', 'StockController@listing');
        /*** End ***/

        /*** Inventory ***/
        Route::get('inventory', 'StockController@inventory');
        /*** End ***/
    });
    /************* End ****************/

    /***********************
     ** VEHICULE ROUTE **
     ********************/
    Route::group(['prefix' => 'vehicle'], function () {
        Route::resource('vehicle', 'VehicleController');
        Route::get('models/{id}', 'VehicleController@models');

        Route::get('assurance_expire','VehicleController@assurance_expire');
        Route::get('visit_expire','VehicleController@viste_expire');

        Route::get('score','VehicleController@score');
    });
    /************* End ****************/


/*********Historique***********/
    Route::get('gethistoricalhome','HistoricalController@gethistoricalHome');
    Route::get('histobyvehicle/{id}','HistoricalController@histoByVehicle');
    Route::get('periodicalhisto','HistoricalController@periodicalHisto');



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



/*************administrator**************/
    /*******************DATA DASHBOARD**************************/
    Route::get('administratordashboardsite','HomeController@administratordashboardsite');


//==========technical============
    Route::get('technicaldashboard','HomeController@technicaldashboard');
    Route::get('technicalManagerdashboard','HomeController@technicalManagerdashboard');
    //======total diagnostique==
    Route::get('totaldiagnostic','DashboardController@totaldiagnostic');
    Route::get('totaldiagnosticManager','DashboardController@totaldiagnosticManager');
    Route::get('nbrevehicmanager','DashboardController@nbrevehicmanager');
    Route::get('bondesortievalideManag','DashboardController@bondesortievalideManag');
    Route::get('releaserevisionattmanager','DashboardController@releaserevisionattmanager');
    //===========total befor test=======
    Route::get('totalbefor_test','DashboardController@totalbefor_test');
    Route::get('fournisseur','DashboardController@fournisseur');
    Route::get('nbrepairattent','DashboardController@nbrepairattent');
    Route::get('nbrepairattentManage','DashboardController@nbrepairattentManage');
    Route::get('repairencoursMang','DashboardController@repairencoursMang');
    Route::get('aftertestattentManager','DashboardController@aftertestattentManager');
    Route::get('totalbefortestManager','DashboardController@totalbefortestManager');
    Route::get('nbrevisitattenteManage','DashboardController@nbrevisitattenteManage');
    Route::get('revisionattentessaiManag','DashboardController@revisionattentessaiManag');
    Route::get('nbrevisitattente','DashboardController@nbrevisitattente');
    Route::get('releasattente','DashboardController@releasattente');
    Route::get('releaseattentepair','DashboardController@releaseattentepair');
    Route::get('releasevisiatten','DashboardController@releasevisiatten');
    Route::get('releasevhicrepair','DashboardController@releasevhicrepair');
    Route::get('releasevhicvisit','DashboardController@releasevhicvisit');
    Route::get('totalaccident','DashboardController@totalaccident');
    Route::get('pannekm','DashboardController@pannekm');
    Route::get('pannekmtechn','DashboardController@pannekmtechn');

    Route::get('nbr_panne_garagetech','DashboardController@nbr_panne_garagetech');

    Route::get('totalaccidentkilometech','DashboardController@totalaccidentkilometech');

    Route::get('totalaccidentech','DashboardController@totalaccidentech');





      Route::get('nbr_panne_garage','DashboardController@nbr_panne_garage');
     Route::get('totalaccidentkilometrage','DashboardController@totalaccidentkilometrage');
    Route::get('releasevhicRevision','DashboardController@releasevhicRevision');
    Route::get('nbrevehic','DashboardController@nbrevehic');
    Route::get('vehic_garage','DashboardController@vehic_garage');
    Route::get('pieceAvaliderr','DashboardController@pieceAvaliderr');
    Route::get('pieceValider','DashboardController@pieceValider');
    Route::get('repaittent','DashboardController@repaittent');
    Route::get('repaittentManager','DashboardController@repaittentManager');
    Route::get('repairEffectuer','DashboardController@repairEffectuer');
    Route::get('repairEffectuerManager','DashboardController@repairEffectuerManager');
    Route::get('stockminimal','DashboardController@stockminimal');
    Route::get('fournisseurMagasini','DashboardController@fournisseurMagasini');
    Route::get('approbationattenteStock','DashboardController@approbationattenteStock');
    Route::get('revisioneffectuerManag','DashboardController@revisioneffectuerManag');
    Route::get('revisionattenteManag','DashboardController@revisionattenteManag');
    Route::get('revisionencoursManag','DashboardController@revisionencoursManag');
        Route::get('visitechencoursMang','DashboardController@visitechencoursMang');
    Route::get('visitecheffetcManag','DashboardController@visitecheffetcManag');
    Route::get('visiteTechnattenteMang','DashboardController@visiteTechnattenteMang');
    Route::get('repairencours','DashboardController@repairencours');
    Route::get('revisionattente','DashboardController@revisionattente');
    Route::get('revisionencours','DashboardController@revisionencours');
    Route::get('bondesortievalide','DashboardController@bondesortievalide');
    Route::get('visitecheffetc','DashboardController@visitecheffetc');
    Route::get('releaserevisionattent','DashboardController@releaserevisionattent');
    Route::get('totaldiagnostique','DashboardController@totaldiagnostique');
    Route::get('expirassurane','DashboardController@assuranceexpired');
    Route::get('expirationvisi','DashboardController@expirationvisi');
    Route::get('visitechencours','DashboardController@visitechencours');
    Route::get('visiteTechnattente','DashboardController@visiteTechnattente');
    Route::get('revisionattentessai','DashboardController@revisionattentessai');
    Route::get('aftertestattent','DashboardController@aftertestattent');
    Route::get('revisioneffectuer','DashboardController@revisioneffectuer');
    Route::get('userconnected','DashboardController@userconnected');
    Route::get('totaluser','DashboardController@totaluser');
    Route::get('technicaldashboardsite','HomeController@technicaldashboardsite');
    Route::get('approbationattente','DashboardController@approbationattente');
    Route::get('historiqueapp','HomeController@historiqueapp');


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



    Route::group(['prefix' => 'historic'], function () {
        Route::resource('index', 'HistoricController');
    });


    Route::group(['prefix' => 'reporting'], function () {
        Route::get('index', 'ReportingController@index');

        Route::post('reporting','ReportingController@reporting')->name('reporting');
    });

});
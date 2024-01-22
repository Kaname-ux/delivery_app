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

Route::get('/', function () {
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function(){

Route::post('/addlivreur','Admin\DashboardController@addlivreur');


Route::post('/makecertifier','CertificationController@setcertifier');
Route::post('unset-certifier','CertificationController@unsetcertifier');
	
	
Route::get('/dashboard','Admin\DashboardController@start');
Route::post('/getactions','Admin\DashboardController@actions');
Route::get('/start','Admin\DashboardController@start');
Route::post('/refreshnotes','Admin\DashboardController@refreshnotes');
Route::post('/refreshlivreurs','Admin\DashboardController@refreshlivreurs');
Route::post('/send','SmsController@send');

Route::get('/sms','SmsController@sms');

Route::get('/subscriptions','SubscriptionController@subscriptions');

Route::post('/confirm','SubscriptionController@confirm');

Route::post('/cancel','SubscriptionController@cancel');
Route::post('/pend','SubscriptionController@pend');
Route::get('/role-register', 'Admin\DashboardController@registered');

Route::get('/role-edit/{id}', 'Admin\DashboardController@registeredit');
Route::put('/role-register-update/{id}', 'Admin\DashboardController@registerupdate');

Route::delete('/role-delete/{id}', 'Admin\DashboardController@registerdelete');
Route::get('/user-form','Admin\DashboardController@userform');
Route::post('/user-add', 'Admin\DashboardController@adduser');
Route::post('set-livreur-account', 'Admin\DashboardController@setlivreuraccout');
Route::post('unset-livreur-account/{id}', 'Admin\DashboardController@unsetlivreuraccount');


Route::post('set-client-account', 'Admin\DashboardController@setclientaccout');
Route::post('unset-client-account/{id}', 'Admin\DashboardController@unsetclientaccount');


Route::put('/command-register', 'Admin\DashboardController@commandregister');
Route::post('/command-fast-register', 'CommandController@commandfastregister');
Route::get('/command-form', 'Admin\DashboardController@commandform');
Route::get('/commandedit/{id}', 'Admin\DashboardController@commandedit');
Route::post('/command-update/{id}', 'Admin\DashboardController@commandupdate');
Route::delete('/command-delete/{id}', 'Admin\DashboardController@commandelete');
Route::post('/etat-update/{id}', 'Admin\DashboardController@etatupdate');
Route::post('/bulk-annule', 'Admin\DashboardController@bulkannule');
Route::post('/bulk-attente', 'Admin\DashboardController@bulkattente');
Route::post('/bulk-assign', 'Admin\DashboardController@bulkassign');

Route::post('/bulk-status', 'Admin\DashboardController@bulkstatus');

Route::get('/client','Admin\DashboardController@clientlist');

Route::get('/managers','Admin\DashboardController@manager');
Route::get('/users','Admin\DashboardController@users');
Route::get('/userstat','Admin\DashboardController@userstat');
Route::get('/salesmen','Admin\DashboardController@salesmen');
Route::post('/client-register', 'Admin\DashboardController@clientregister');

Route::get('/client-form', 'Admin\DashboardController@clientform');
Route::get('/clientedit/{id}', 'Admin\DashboardController@clientedit');
Route::put('/client-update/{id}', 'Admin\DashboardController@clientupdate');
Route::delete('/client-delete/{id}', 'Admin\DashboardController@clientdelete');
Route::get('/client-detail/{id}','Admin\DashboardController@clientdetail');


Route::get('/laroutes/{id}', 'Admin\DashboardController@laroutes');
Route::get('/laroutesbydate/{id}', 'Admin\DashboardController@laroutesbydate');

Route::put('/action-register', 'Admin\DashboardController@larouteregister');


Route::get('/fee','Admin\DashboardController@feelist');
Route::get('/fees','Admin\DashboardController@fees');
Route::post('/updateprice','Admin\DashboardController@updateprice');
Route::post('/updatetarif','Admin\DashboardController@updatetarif');
Route::post('/deletetarif','Admin\DashboardController@deletetarif');

Route::put('/fee-register', 'Admin\DashboardController@feeregister');
Route::get('/fee-form', 'Admin\DashboardController@feeform');
Route::get('/feeedit/{id}', 'Admin\DashboardController@feeedit');
Route::put('/fee-update/{id}', 'Admin\DashboardController@feeupdate');
Route::delete('/fee-delete/{id}', 'Admin\DashboardController@feedelete');

Route::get('/livreur','Admin\DashboardController@livreurlist');
Route::get('/livreurs','Admin\DashboardController@livreurs');
Route::post('/livreur-register', 'Admin\DashboardController@livreurregister');
Route::get('/livreur-form', 'Admin\DashboardController@livreurform');
Route::get('/livreuredit/{id}', 'Admin\DashboardController@livreuredit');
Route::put('/livreur-update/{id}', 'Admin\DashboardController@livreurupdate');
Route::delete('/livreur-delete/{id}', 'Admin\DashboardController@livreurdelete');
Route::get('/livreur-stat/{id}','Admin\DashboardController@livreurstat');

Route::get('/moto','Admin\DashboardController@motolist');
Route::put('/moto-register', 'Admin\DashboardController@motoregister');
Route::get('/moto-form', 'Admin\DashboardController@motoform');
Route::get('/motoedit/{id}', 'Admin\DashboardController@motoedit');
Route::put('/moto-update/{id}', 'Admin\DashboardController@motoupdate');
Route::delete('/moto-delete/{id}', 'Admin\DashboardController@motodelete');
Route::put('/vidange-update/{id}', 'Admin\DashboardController@motovidandeupdate');


Route::get('/payment','Admin\DashboardController@paymentlist');
Route::get('/payments','PaymentController@payments');
Route::get('/payements','PaymentController@payements');
Route::post('/paydetail','PaymentController@paydetail');
Route::post('/paydetailc','PaymentController@paydetailc');
Route::put('/payment-register', 'Admin\DashboardController@paymentregister');
Route::get('/payment-form', 'Admin\DashboardController@paymentform');
Route::get('/paymentedit/{id}', 'Admin\DashboardController@paymentedit');
Route::put('/payment-update/{id}', 'Admin\DashboardController@paymentupdate');
Route::delete('/payment-delete/{id}', 'Admin\DashboardController@paymentdelete');
Route::post('/paymentdone/{id}', 'Admin\DashboardController@paymentdone');
Route::post('/payment-assign/{id}', 'Admin\DashboardController@paymentassign');
Route::post('/payall', 'PaymentController@payall');
Route::post('/assignall', 'Admin\DashboardController@assignall');

Route::get('/fuel', 'Admin\DashboardController@fuelist');
Route::post('/fuel-add', 'Admin\DashboardController@fuelregister');
Route::post('/fuel-update', 'Admin\DashboardController@fuelupdate');
Route::post('/deliv-note', 'Admin\DashboardController@delivnote');





Route::get('/charge','Admin\DashboardController@chargelist');
Route::put('/charge-register', 'Admin\DashboardController@chargeregister');
Route::get('/charge-form', 'Admin\DashboardController@chargeform');
Route::get('/chargeedit/{id}', 'Admin\DashboardController@chargeedit');
Route::put('/charge-update/{id}', 'Admin\DashboardController@chargeupdate');
Route::delete('/charge-delete/{id}', 'Admin\DashboardController@chargedelete');



Route::post('/etat-update/{id}', 'Admin\DashboardController@etatupdatel');
Route::post('/command-payment/{id}', 'Admin\DashboardController@payupdate');

Route::post('/bulk-recup', 'Admin\DashboardController@bulketatupdate');
Route::post('/bulk-pay', 'Admin\DashboardController@bulkpayupdate');
Route::post('/relay/{id}', 'Admin\DashboardController@relay');

Route::get('/rapport', 'Admin\DashboardController@rapport');
Route::get('/rapports', 'Admin\DashboardController@rapports');
Route::get('/etiquettes', 'Admin\DashboardController@etiquettes');
Route::get('/printing', 'Admin\DashboardController@printing');
Route::post('/updateuser', 'Admin\DashboardController@updateuser');

Route::get('/certifications','CertificationController@certifications');
Route::post('/certify','CertificationController@certify');
Route::post('/refused','CertificationController@refused');



Route::post('/assigncommand', 'CommandController@assigncommand');
Route::post('assigncmd', 'CommandController@assigncommand');
Route::post('bulkassigncmd', 'CommandController@bulkassigncmd');
Route::post('bulkdifusion', 'CommandController@bulkdifusion');
Route::post('assigncmdbulk', 'CommandController@assigncommandbulk');
Route::post('bulkreset', 'CommandController@bulkreset');
Route::post('showlivreurs', 'CommandController@showlivreurs');
Route::post('/updatestatus', 'CommandController@updatestatus');
Route::post('updateprovider', 'CommandController@updateprovider');
Route::get('/commands','CommandController@commands');
Route::post('getnote', 'CommandController@getnote');
Route::post('getevent', 'CommandController@getevent');
Route::post('assign', 'CommandController@assign');
Route::post('updatedate', 'CommandController@updatedate');
Route::post('updatedescription', 'CommandController@updatedescription');
Route::post('updateclient', 'CommandController@updateclient');
Route::post('updatecost', 'CommandController@updatecost');
Route::post('updateliv', 'CommandController@updateliv');
Route::post('updateobservation', 'CommandController@updateobservation');
Route::post('updatesource', 'CommandController@updatesource');
Route::post('deletecmd', 'CommandController@deletecmd');
Route::post('getlivreurcmds', 'CommandController@getlivreurcmds');
Route::post('bulkreport', 'CommandController@bulkreport');


Route::get('/products','ProductsController@products');
Route::post('/setsecstock','ProductsController@setsecstock');
Route::post('/phonecheck', 'Admin\DashboardController@phonecheck');
Route::post('/createproduct', 'ProductsController@create');
Route::post('/editproduct', 'ProductsController@edit');
Route::post('/mooving', 'ProductsController@mooving');
Route::post('updatecmdprod', 'ProductsController@updatecmdprod');
Route::post('/addcategory','ProductsController@addcategory');
Route::post('/removecategory','ProductsController@removecategory');
Route::post('/removeproduct','ProductsController@removeproduct');
Route::get('/roles', 'RolesController@roles');
Route::get('/useractions', 'RolesController@useractions');
Route::post('/addrole', 'RolesController@add');
Route::post('/switchrole', 'RolesController@switchrole');
Route::post('/permissions', 'RolesController@permissions');
Route::post('/setgoal', 'RolesController@setgoal');
Route::post('/set-conseiller', 'Admin\DashboardController@setconseiller');

Route::get('/canaux','CanauxController@canaux');
Route::post('/createcanal', 'CanauxController@create');
Route::post('/editcanal', 'CanauxController@edit');
Route::post('/deletecanal', 'CanauxController@delete');



Route::get('/clients','CostumersController@costumers');
Route::post('/createcostumer','CostumersController@create');
Route::post('/editcostumer','CostumersController@edit');


Route::get('/suppliers','SuppliersController@suppliers');
Route::post('/createsupplier','SuppliersController@create');
Route::post('/editsupplier','SuppliersController@edit');


Route::get('/shops','ShopController@shops');
Route::get('/shop-form','ShopController@shopform');
Route::get('/shop-edit-form/{id}','ShopController@shopeditform');
Route::post('/shop-create','ShopController@create');
Route::post('/shop-edit','ShopController@edit');
Route::post('/setshop','ShopController@setshop');

Route::get('/marketing', 'MarketingController@marketing');
Route::post('sendsms', 'MarketingController@sendsms');
Route::post('/countprospects', 'MarketingController@countprospects');
Route::post('testsms', 'MarketingController@testsms');

Route::match(array('GET','POST'),'/notify', 'SouscriptionsController@notify');
Route::match(array('GET','POST'),'/return', 'MarketingController@marketing');
Route::post('/subscribe', 'SouscriptionsController@subscribe');



Route::get('/settings', 'SettingsController@settings');

Route::post('/switchsetting', 'SettingsController@switchsetting');
Route::post('/setmessage', 'SettingsController@setmessage');

Route::post('/updatecompany', 'CompanyController@updatecompany');
 }); 

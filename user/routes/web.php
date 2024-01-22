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
Route::get('tracking/{id}', 'BuyerController@tracking');
Route::get('livreurs_public', 'PublicController@livreurs');
Route::post('loc','BuyerController@setloc');
Route::post('getglobalnearby', 'PublicController@getglobalnearby');
Route::post('publicdifuse', 'PublicController@publicdifuse');
Route::post('difusecheck', 'PublicController@difusecheck');
Route::get('catalog', 'PublicController@catalog');
Route::get('/productdetail', 'PublicController@detail');
Route::post('/updatesession', 'PublicController@updatesession');
Route::post('/productavailability', 'PublicController@productavailability');
Route::post('/command-from-catalog', 'PublicController@commandfastregister');

Route::group(['middleware' => ['auth', 'client']], function(){
Route::post('getmadlivreurs', 'CommandController@getmadlivreurs');
Route::post('getclientdepartments', 'CommandController@getclientdepartments');
Route::post('updateprovider', 'CommandController@updateprovider');
Route::post('updateram', 'CommandController@updateram');
Route::get('/livreurs','Admin\DashboardController@livreurs');

Route::get('/managers','Admin\DashboardController@managers');   
Route::get('/dashboard','CommandController@commands');
Route::get('/commands','CommandController@commands');
Route::post('/getmanagerfees','CommandController@getmanagerfees');





Route::post('/command-fast-register', 'CommandController@commandfastregister');

Route::post('/difuse', 'CommandController@difuse');
Route::post('/command-update', 'CommandController@commandupdate');
Route::get('/point', 'CommandController@point');
Route::get('/usersales', 'CommandController@usersales');

Route::post('/setmanager', 'CommandController@setmanager');

Route::post('/unsetmanager', 'CommandController@unsetmanager');
Route::get('/daily', 'Admin\DashboardController@daily');
Route::get('/checkout', 'CommandController@checkout');

Route::get('/difusions', 'DifusionsController@difusions');
Route::post('/candidates', 'DifusionsController@candidates');
Route::post('ready', 'CommandController@setready');
Route::post('returncmd', 'CommandController@returncmd');
Route::post('livreurcmd', 'CommandController@livreurcmd');
Route::post('reportcmd', 'CommandController@reportcmd');
Route::post('statuscmd', 'CommandController@statuscmd');
Route::post('cancel', 'Admin\DashboardController@cancel');
Route::post('cancel_cmd', 'CommandController@cancelcmd');
Route::post('reset', 'CommandController@reset');
Route::post('unready', 'CommandController@unsetready');
Route::post('/relay/{id}', 'Admin\DashboardController@relay');
Route::post('/send-friend-request', 'Admin\DashboardController@sendfriendrequest');
Route::post('/assigncommand', 'CommandController@assigncommand');
Route::post('assigncmd', 'CommandController@assigncommand');
Route::post('bulkassigncmd', 'CommandController@bulkassigncmd');
Route::post('bulkdifusion', 'CommandController@bulkdifusion');
Route::post('assigncmdbulk', 'CommandController@assigncommandbulk');
Route::post('bulkreset', 'CommandController@bulkreset');
Route::post('showlivreurs', 'CommandController@showlivreurs');
Route::post('/updatestatus', 'CommandController@updatestatus');
Route::post('/updatepay', 'CommandController@updatepay');
Route::post('/updatedescription', 'CommandController@updatedescription');
Route::post('/updateadresse', 'CommandController@updateadresse');
Route::post('/updatephone', 'CommandController@updatephone');
Route::post('/updatecost', 'CommandController@updatecost');
Route::post('/updatesource', 'CommandController@updatesource');
Route::post('/updatedate', 'CommandController@updatedate');
Route::post('/updateclient', 'CommandController@updateclient');
Route::post('/updateobservation', 'CommandController@updateobservation');
Route::post('/deletecmd', 'CommandController@deletecmd');
Route::post('/getlivreurcmds', 'CommandController@getlivreurcmds');

Route::post('assign', 'CommandController@assign');
Route::post('/addlivreur', 'Admin\DashboardController@addlivreur');
Route::post('/unassigncommand', 'CommandController@unassigncommand');
Route::post('/removelivreur', 'Admin\DashboardController@removelivreur');
Route::post('bydatedetail', 'Admin\DashboardController@bydatedetail');
Route::post('pay', 'PayController@pay');
Route::post('report', 'CommandController@report');
Route::post('bulkreport', 'CommandController@bulkreport');

Route::post('verify', 'Admin\DashboardController@verify');
Route::post('unverify', 'Admin\DashboardController@unverify');
Route::post('setloc', 'Admin\DashboardController@setloc');
Route::post('getnearby', 'Admin\DashboardController@getnearby');

Route::post('currentpay', 'PaymentController@currentpay');
Route::post('payall', 'PaymentController@payall');
Route::post('allpay', 'PaymentController@allpay');
Route::post('dailypay', 'PaymentController@dailypay');
Route::post('paydetail', 'PaymentController@paydetail');
Route::post('paydetailc', 'PaymentController@paydetailc');
Route::post('singlepay', 'PaymentController@singlepay');
Route::post('cmdrtrn', 'CommandController@cmdrtrn');
Route::post('cmdrtrndetail', 'CommandController@cmdrtrndetail');
Route::post('bulkassign', 'CommandController@bulkassign');
Route::post('addfast', 'CommandController@addfast');
Route::post('add-new-fast', 'CommandController@addnewfast');
Route::post('deletefast', 'CommandController@deletefast');
Route::get('printing', 'CommandController@printing');
Route::post('cmddel', 'CommandController@cmddel');
Route::post('getnote', 'CommandController@getnote');
Route::post('getevent', 'CommandController@getevent');

Route::get('fees', 'Admin\DashboardController@fees');
Route::get('fee-form', 'Admin\DashboardController@feeform');
Route::post('fee-register', 'Admin\DashboardController@feeregister');
Route::get('/feeedit/{id}', 'Admin\DashboardController@feeedit');
Route::put('/fee-update/{id}', 'Admin\DashboardController@feeupdate');
Route::delete('/fee-delete/{id}', 'Admin\DashboardController@feedelete');
Route::get('search', 'Admin\DashboardController@search');
Route::get('account', 'Admin\DashboardController@account');
Route::get('meslivreurs', 'Admin\DashboardController@meslivreurs');
Route::get('/payements','PaymentController@payements');
Route::post('/payedbylivreur','PaymentController@payedbylivreur');
Route::post('/payedbyclient','PaymentController@payedbyclient');
Route::post('/receipt','PaymentController@receipt');
Route::post('/cancelpay','PaymentController@cancelpay');
Route::post('/moneypay','PaymentController@moneypay');
Route::post('/moneyreceipt','PaymentController@moneyreceipt');
Route::post('/cancelmoneypay','PaymentController@cancelmoneypay');
Route::post('donedetail', 'Admin\DashboardController@donedetail');
Route::post('changepassword', 'ChangePasswordController@changepassword');

Route::post('/editaccount', 'Admin\DashboardController@editaccount');
Route::post('/editpassword', 'Admin\DashboardController@editpassword');
Route::post('/photo_upload', 'Admin\DashboardController@photoupload');


Route::post('ratelivreur', 'Admin\DashboardController@ratelivreur');

Route::post('delete', 'DifusionsController@delete');
Route::post('changestatus', 'DifusionsController@changestatus');

Route::get('showfees', 'FeesController@show');
Route::post('/certify','CertificationController@certify');
Route::post('/refused','CertificationController@refused');
Route::post('signal','SignalingsController@signal');
Route::get('/certifications','CertificationController@certifications');


Route::get('/products','ProductsController@products');
Route::post('/addcategory','ProductsController@addcategory');
Route::post('/removecategory','ProductsController@removecategory');
Route::post('/removeproduct','ProductsController@removeproduct');

Route::post('/createproductfirststep','ProductsController@createproductfirststep');

Route::post('/phonecheck', 'Admin\DashboardController@phonecheck');
Route::post('/createproduct', 'ProductsController@create');
Route::post('/editproduct', 'ProductsController@edit');
Route::post('/mooving', 'ProductsController@mooving');
Route::post('updatecmdprod', 'ProductsController@updatecmdprod');
Route::get('printproducts', 'ProductsController@printproducts');

Route::get('/canaux','CanauxController@canaux');
Route::post('/createcanal', 'CanauxController@create');
Route::post('/editcanal', 'CanauxController@edit');
Route::post('/deletecanal', 'CanauxController@delete');



 }); 







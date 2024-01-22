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
Route::get('tracking/{id}', 'Admin\DashboardController@tracking');

Route::group(['middleware' => ['auth', 'client']], function(){


Route::get('/livreurs','Admin\DashboardController@livreurs');	
Route::get('/dashboard','Admin\DashboardController@commandlist');
Route::get('/enattente','Admin\DashboardController@commandlistattente');
Route::get('/enchemin','Admin\DashboardController@commandlistenchemin');
Route::get('/recupere','Admin\DashboardController@commandlistrecupere');
Route::get('/encours','Admin\DashboardController@commandlistencours');
Route::get('/termine','Admin\DashboardController@commandlisttermine');
Route::get('/annule','Admin\DashboardController@commandlistannule');




Route::post('/command-fast-register', 'Admin\DashboardController@commandfastregister');
Route::post('/command-update', 'Admin\DashboardController@commandupdate');
Route::get('/point', 'Admin\DashboardController@point');
Route::get('/daily', 'Admin\DashboardController@daily');
Route::post('ready', 'Admin\DashboardController@setready');
Route::post('cancel', 'Admin\DashboardController@cancel');
Route::post('cancel_cmd', 'Admin\DashboardController@cancelcmd');
Route::post('reset', 'Admin\DashboardController@reset');
Route::post('unready', 'Admin\DashboardController@unsetready');
Route::post('/relay/{id}', 'Admin\DashboardController@relay');
Route::post('/send-friend-request', 'Admin\DashboardController@sendfriendrequest');
Route::post('/assigncommand', 'Admin\DashboardController@assigncommand');
Route::post('assigncmd', 'Admin\DashboardController@assigncommand');
Route::post('assign', 'Admin\DashboardController@assign');
Route::post('/addlivreur', 'Admin\DashboardController@addlivreur');
Route::post('/unassigncommand', 'Admin\DashboardController@unassigncommand');
Route::post('/removelivreur', 'Admin\DashboardController@removelivreur');
Route::post('bydatedetail', 'Admin\DashboardController@bydatedetail');
Route::post('pay', 'Admin\DashboardController@pay');
Route::post('report', 'Admin\DashboardController@report');

Route::post('verify', 'Admin\DashboardController@verify');
Route::post('unverify', 'Admin\DashboardController@unverify');
Route::post('setloc', 'Admin\DashboardController@setloc');
Route::post('getnearby', 'Admin\DashboardController@getnearby');
Route::post('paydetail', 'Admin\DashboardController@paydetail');
 }); 







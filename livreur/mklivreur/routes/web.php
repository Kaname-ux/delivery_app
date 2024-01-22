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



Auth::routes(['verify' => true]);
Route::post('/send', 'CertificationsController@send');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('notify_url', 'SouscriptionsController@notify_url');
Route::post('/return', 'SouscriptionsController@return');
Route::get('/souscriptions', 'SouscriptionsController@souscriptions');
Route::post('/subscribe', 'SouscriptionsController@subscribe'); 

Route::group(['middleware' => ['auth', 'livreur']], function(){




Route::post('/checksubscription', 'SouscriptionsController@checksubscription');   
Route::get('/commencer', 'Admin\DashboardController@commencer');
Route::get('/livraisons', 'Admin\DashboardController@livraisons');	
Route::get('/dashboard','Admin\DashboardController@commandlist');
Route::get('/payment','Admin\DashboardController@paymentlist');
Route::post('/pay-update/{id}','Admin\DashboardController@payupdate');
Route::post('/retour','Admin\DashboardController@retour');
Route::post('codecreate','Admin\DashboardController@codecreate');


Route::post('/command-update/{id}', 'Admin\DashboardController@etatupdate');
Route::post('/command-payment/{id}', 'Admin\DashboardController@payupdate');

Route::post('/bulk-recup', 'Admin\DashboardController@bulketatupdate');
Route::post('/bulk-pay', 'Admin\DashboardController@bulkpayupdate');
Route::post('/relay/{id}', 'Admin\DashboardController@relay');
Route::get('/livreur-stat','Admin\DashboardController@livreurstat');
Route::post('/bulk-assign', 'Admin\DashboardController@bulkassign');
Route::post('/deliv-note', 'Admin\DashboardController@delivnote');
Route::post('/setloc', 'Admin\DashboardController@setloc');
Route::post('/setdom', 'Admin\DashboardController@setdom');
Route::post('/getloc', 'Admin\DashboardController@getloc');
Route::post('/recup', 'Admin\DashboardController@recup');
Route::post('/photo_upload', 'Admin\DashboardController@photoupload');
Route::get('/compte', 'Admin\DashboardController@compte');
Route::post('/editaccount', 'Admin\DashboardController@editaccount');
Route::post('/editpassword', 'Admin\DashboardController@editpassword');



Route::post('upload', 'ImageController@postUpload')->name('uploadfile');
Route::get('/difusions', 'DifusionsController@difusions');
Route::post('/postule', 'DifusionsController@postule');
Route::get('/certification', 'CertificationsController@certification');


 }); 







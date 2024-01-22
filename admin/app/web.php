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
	
Route::get('/dashboard','Admin\DashboardController@commandlist');

Route::get('/role-register', 'Admin\DashboardController@registered');

Route::get('/role-edit/{id}', 'Admin\DashboardController@registeredit');
Route::put('/role-register-update/{id}', 'Admin\DashboardController@registerupdate');
Route::delete('/role-delete/{id}', 'Admin\DashboardController@registerdelete');
Route::get('/user-form','Admin\DashboardController@userform');
Route::post('/user-add', 'Admin\DashboardController@adduser');
Route::post('set-livreur-account', 'Admin\DashboardController@setlivreuraccout');

Route::put('/command-register', 'Admin\DashboardController@commandregister');
Route::get('/command-form', 'Admin\DashboardController@commandform');
Route::get('/commandedit/{id}', 'Admin\DashboardController@commandedit');
Route::put('/command-update/{id}', 'Admin\DashboardController@commandupdate');
Route::delete('/command-delete/{id}', 'Admin\DashboardController@commandelete');
Route::put('/etat-update/{id}', 'Admin\DashboardController@etatupdate');

Route::get('/client','Admin\DashboardController@clientlist');
Route::put('/client-register', 'Admin\DashboardController@clientregister');
Route::get('/client-form', 'Admin\DashboardController@clientform');
Route::get('/clientedit/{id}', 'Admin\DashboardController@clientedit');
Route::put('/client-update/{id}', 'Admin\DashboardController@clientupdate');
Route::delete('/client-delete/{id}', 'Admin\DashboardController@clientdelete');
Route::get('/laroutes/{id}', 'Admin\DashboardController@laroutes');
Route::put('/action-register', 'Admin\DashboardController@larouteregister');


Route::get('/fee','Admin\DashboardController@feelist');
Route::put('/fee-register', 'Admin\DashboardController@feeregister');
Route::get('/fee-form', 'Admin\DashboardController@feeform');
Route::get('/feeedit/{id}', 'Admin\DashboardController@feeedit');
Route::put('/fee-update/{id}', 'Admin\DashboardController@feeupdate');
Route::delete('/fee-delete/{id}', 'Admin\DashboardController@feedelete');

Route::get('/livreur','Admin\DashboardController@livreurlist');
Route::put('/livreur-register', 'Admin\DashboardController@livreurregister');
Route::get('/livreur-form', 'Admin\DashboardController@livreurform');
Route::get('/livreuredit/{id}', 'Admin\DashboardController@livreuredit');
Route::put('/livreur-update/{id}', 'Admin\DashboardController@livreurupdate');
Route::delete('/livreur-delete/{id}', 'Admin\DashboardController@livreurdelete');

Route::get('/moto','Admin\DashboardController@motolist');
Route::put('/moto-register', 'Admin\DashboardController@motoregister');
Route::get('/moto-form', 'Admin\DashboardController@motoform');
Route::get('/motoedit/{id}', 'Admin\DashboardController@motoedit');
Route::put('/moto-update/{id}', 'Admin\DashboardController@motoupdate');
Route::delete('/moto-delete/{id}', 'Admin\DashboardController@motodelete');
Route::put('/vidange-update/{id}', 'Admin\DashboardController@motovidandeupdate');


Route::get('/payment','Admin\DashboardController@paymentlist');
Route::put('/payment-register', 'Admin\DashboardController@paymentregister');
Route::get('/payment-form', 'Admin\DashboardController@paymentform');
Route::get('/paymentedit/{id}', 'Admin\DashboardController@paymentedit');
Route::put('/payment-update/{id}', 'Admin\DashboardController@paymentupdate');
Route::delete('/payment-delete/{id}', 'Admin\DashboardController@paymentdelete');


Route::get('/charge','Admin\DashboardController@chargelist');
Route::put('/charge-register', 'Admin\DashboardController@chargeregister');
Route::get('/charge-form', 'Admin\DashboardController@chargeform');
Route::get('/chargeedit/{id}', 'Admin\DashboardController@chargeedit');
Route::put('/charge-update/{id}', 'Admin\DashboardController@chargeupdate');
Route::delete('/charge-delete/{id}', 'Admin\DashboardController@chargedelete');


 }); 

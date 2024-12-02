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
Route::middleware('auth')->group(function() {

	// Workshop
 Route::view('/dashboard','AutoCare.dashboard');
 Route::get('/AutoCare/workshop/add','WorkshopController@save');
 Route::get('/AutoCare/workshop/add/{id}','WorkshopController@save');
 Route::post('/AutoCare/workshop/add','WorkshopController@save');
 Route::get('/AutoCare/workshop/search','WorkshopController@view');
 Route::post('/AutoCare/workshop/search','WorkshopController@view');
 Route::post('/AutoCare/workshop/update','WorkshopController@save');
 Route::get('/AutoCare/workshop/trash/{id}','WorkshopController@trash');
 Route::get('/AutoCare/workshop/delete','WorkshopController@trashedList');
 Route::get('/AutoCare/workshop/delete/{id}','WorkshopController@permanemetDelete');
 Route::get('/AutoCare/workshop/view/{id}','WorkshopController@viewIndivisual');

// Supplier Details
 
 Route::get('/AutoCare/supplier/add','SupplierController@save');
 Route::post('/AutoCare/supplier/add','SupplierController@save');
 Route::post('/AutoCare/supplier/update','SupplierController@save');
 Route::get('/AutoCare/supplier/add/{id}','SupplierController@save');
 Route::get('/AutoCare/supplier/search','SupplierController@view');
 Route::post('/AutoCare/supplier/search','SupplierController@view');
 Route::get('/AutoCare/supplier/trash/{id}','SupplierController@trash');
 Route::get('/AutoCare/supplier/delete','SupplierController@trashedList');
 Route::get('/AutoCare/supplier/delete/{id}','SupplierController@permanemetDelete');

 // Purchase Details
 
 Route::get('/AutoCare/purchase/add','PurchaseController@save');
 Route::post('/AutoCare/purchase/add','PurchaseController@save');
 Route::post('/AutoCare/purchase/update','PurchaseController@update');
 Route::get('/AutoCare/purchase/add/{id}','PurchaseController@save');
 Route::get('/AutoCare/purchase/search','PurchaseController@view');
 Route::post('/AutoCare/purchase/search','PurchaseController@view');
 Route::get('/AutoCare/purchase/trash/{id}','PurchaseController@trash');
 Route::get('/AutoCare/purchase/delete','PurchaseController@trashedList');
 Route::get('/AutoCare/purchase/delete/{id}','PurchaseController@permanemetDelete');

 // Product Details
 
 Route::get('/AutoCare/product/add','ProductController@save');
 Route::post('/AutoCare/product/add','ProductController@save');
 Route::post('/AutoCare/product/update','ProductController@save');
 Route::get('/AutoCare/product/add/{id}','ProductController@save');
 Route::get('/AutoCare/product/search','ProductController@view');
 Route::post('/AutoCare/product/search','ProductController@view');
 Route::get('/AutoCare/product/trash/{id}','ProductController@trash');
 Route::get('/AutoCare/product/delete','ProductController@trashedList');
 Route::get('/AutoCare/product/delete/{id}','ProductController@permanemetDelete');
 Route::post('/ajax/getProduct','AjaxController@getProduct');

 //Route::view('/AutoCare/purchase/add','AutoCare.purchase.add');
 // Route::post('/AutoCare/supplier/add','SupplierController@save');
 // Route::post('/AutoCare/supplier/update','SupplierController@save');
 // Route::get('/AutoCare/supplier/add/{id}','SupplierController@save');
 // Route::get('/AutoCare/supplier/search','SupplierController@view');
 // Route::post('/AutoCare/supplier/search','SupplierController@view');
 // Route::get('/AutoCare/supplier/trash/{id}','SupplierController@trash');
 // Route::get('/AutoCare/supplier/delete','SupplierController@trashedList');
 // Route::get('/AutoCare/supplier/delete/{id}','SupplierController@permanemetDelete');
 // Route::get('/AutoCare/workshop/add/{id}','WorkshopController@save');
 // Route::post('/AutoCare/workshop/add','WorkshopController@save');
 // Route::get('/AutoCare/workshop/search','WorkshopController@view');
 // Route::post('/AutoCare/workshop/search','WorkshopController@view');
 // Route::post('/AutoCare/workshop/update','WorkshopController@save');
 // Route::get('/AutoCare/workshop/trash/{id}','WorkshopController@trash');
 // Route::get('/AutoCare/workshop/delete','WorkshopController@trashedList');
 // Route::view('/sample/dashboard','samples.buttons');
	// Route::view('/sample/social','samples.social');
	 Route::view('/sample/cards','samples.cards');
	 Route::view('/sample/forms','samples.forms');
	// Route::view('/sample/modals','samples.modals');
	// Route::view('/sample/switches','samples.switches');
	// Route::view('/sample/tables','samples.tables');
	// Route::view('/sample/tabs','samples.tabs');
	// Route::view('/sample/icons-font-awesome', 'samples.font-awesome-icons');
	// Route::view('/sample/icons-simple-line', 'samples.simple-line-icons');
	// Route::view('/sample/widgets','samples.widgets');
	// Route::view('/sample/charts','samples.charts');
	
});

Route::get('/home', 'HomeController@index')->name('home');

<?php

use App\Http\Controllers\ViewController\HomeController;
use App\Http\Controllers\ViewController\ServiceController;
use App\Http\Controllers\ViewController\TyresProductController;
use App\Http\Controllers\TyresController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ViewController\CalendarController;
use App\Http\Controllers\ViewController\CartController;
use App\Http\Controllers\ViewController\CheckoutController;
use App\Http\Controllers\SupplierController;
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
/*
 *  File Name              :
 *  Type                   :   
 *  Description            :   
 *  Author                 : Ashtosh Kumar Choubey
 *  Contact                : 9658476170
 *  Email                  : contact@worldgyan.com
 *  Date                   : 12/12/2018  
 *  Modified By            :       
 *  Date of Modification   :     
 *  Purpose of Modification: 
 * 
 */


Route::get('/', function () {
	return view('welcome');
});
// Start: Frontend Routes

// Route::post('AutoCare/supplier/import', [SupplierController::class, 'import'])->name('supplier.import');
Route::post('tyres/import', [SupplierController::class, 'importTyres'])->name('tyres.import');



Route::get('/tyreslist', [TyresProductController::class, 'tyreslist'])->name('tyres.tyreslist');
Route::get('/tyreslist/filter', [TyresProductController::class, 'filter'])->name('tyres.filter');
// Route::get('tyres/get-profiles', [TyresProductController::class, 'getProfiles'])->name('tyres.getProfiles');
// Route::get('tyres/get-diameters', [TyresProductController::class, 'getDiameters'])->name('tyres.getDiameters');
// Route::get('tyreslist', [TyresProductController::class, 'filter'])->name('tyres.filter');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('view.checkout');

Route::post('/checkout/submit', [CheckoutController::class, 'submitOrder'])->name('checkout.submit');

Route::post('/checkout/store-in-session', [CheckoutController::class, 'storeInSession'])->name('checkout.storeInSession');
Route::post('/checkout/submit', [CheckoutController::class, 'submitCheckout'])->name('checkout.submit');
Route::post('/checkout/auto-save-customer', [CheckoutController::class, 'autoSaveCustomer'])->name('checkout.autoSaveCustomer');


Route::get('/calendar', [CalendarController::class, 'index']);
Route::post('/calendar/book', [CalendarController::class, 'book']);


Route::get('tyreslist/get-profiles', [TyresProductController::class, 'getProfiles'])->name('tyres.getProfiles');
Route::get('tyreslist/get-diameters', [TyresProductController::class, 'getDiameters'])->name('tyres.getDiameters');
Route::get('tyre-cards', [TyresProductController::class, 'filter'])->name('tyres.filter');


// Route to the home page
Route::get('/', 'ViewController\HomeController@index')->name('home');

Route::get('/service', [ServiceController::class, 'services'])->name('service');  // Homepage showing services
Route::get('/service/{id}', [ServiceController::class, 'show'])->name('service.show');  // Service details page
Route::get('/about', [HomeController::class, 'aboutUs'])->name('aboutUs');  // Service details page
Route::get('/cart/fetch', [CartController::class, 'fetchCartItems'])->name('cart.fetch');

// Route::get('/checkout', [CheckoutController::class, 'showCheckoutPage'])->name('checkout.page');

// Route for handling the form submission
// Route::post('/checkout/submit', [CheckoutController::class, 'submitOrder'])->name('checkout.submit');
Route::post('/checkout', [CheckoutController::class, 'submit'])->name('checkout.submit');
Route::post('/save-booking', [CalendarController::class, 'saveBooking'])->name('save.booking');

// Route::get('/checkout', [CheckoutController::class, 'calendar'])->name('view.checkout');

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
// 	return view('view.home');
// })->name('home');

// Route::get('/about-us', function () {
// 	return view('about'); // Ensure `resources/views/about.blade.php` exists
// })->name('aboutUs');

Route::get('/contact', function () {
	return view('view.contact'); // Ensure `resources/views/contact.blade.php` exists
})->name('contact');

Route::get('/checkout/ordersuccess', function () {
	return view('view.ordersuccess');
})->name('checkout.ordersuccess');


Route::get('/checkout/session-data', function () {
	// Dump all session data for debugging
	return response()->json(session()->all());
})->name('checkout.sessionData');


// Route::get('/services', function () {
// 	return view('view.services'); // Ensure `resources/views/services.blade.php` exists
// })->name('services');

Route::get('/tyres', function () {
	return view('view.tyres'); // Ensure `resources/views/tyres.blade.php` exists
})->name('tyres');


Route::get('/searchVehicle', function () {
	return view('searchVehicle'); // Ensure `resources/views/contact.blade.php` exists
})->name('searchVehicle');

Route::get('/searchByMakeYear', function () {
	return view('searchByMakeYear'); // Ensure `resources/views/contact.blade.php` exists
})->name('searchByMakeYear');

Route::get('/services', function () {
	return view('service'); // Ensure `resources/views/contact.blade.php` exists
})->name('services');


// End: Frontend Routes



Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
Route::get('/pages/{id}', [PageController::class, 'show'])->name('pages.show');

// Optional: For creating and storing pages
Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
Route::post('/pages', [PageController::class, 'store'])->name('pages.store');

// In routes/web.php
Auth::routes();

Route::middleware('auth')->group(function () {
	// Route::any('test',function(){
// print_r(Auth::user()->role_id);
// });


	// Workshop :start
	Route::get('/dashboard', 'MasterformsController@dashboard');
	Route::get('/AutoCare/workshop/add', 'WorkshopController@save');
	Route::get('/AutoCare/workshop/add/{id}', 'WorkshopController@save');
	Route::post('/AutoCare/workshop/add', 'WorkshopController@save');
	Route::get('/AutoCare/workshop/search', 'WorkshopController@view');
	Route::post('/AutoCare/workshop/search', 'WorkshopController@view');
	Route::post('/AutoCare/workshop/update', 'WorkshopController@save');
	Route::get('/AutoCare/workshop/trash/{id}', 'WorkshopController@trash');
	Route::get('/AutoCare/workshop/delete', 'WorkshopController@trashedList');
	Route::get('/AutoCare/workshop/delete/{id}', 'WorkshopController@permanemetDelete');
	Route::get('/AutoCare/workshop/view/{id}', 'WorkshopController@viewIndivisual');
	Route::get('/AutoCare/workshop/payment_history/{id}', 'WorkshopController@viewpaymenthistory');
	// Wokshop :stop


	// tyre product data :start


	// In routes/web.php
	Route::get('/AutoCare/tyres/search', [TyresController::class, 'search'])->name('AutoCare.tyres.search');
	// Edit tyre
	Route::get('/AutoCare/tyres/edit/{product_id}', [TyresController::class, 'edit'])->name('AutoCare.tyres.edit');
	Route::put('/AutoCare/tyres/edit/{product_id}', [TyresController::class, 'update'])->name('AutoCare.tyres.update');
	Route::delete('/AutoCare/tyres/delete/{product_id}', [TyresController::class, 'destroy'])->name('AutoCare.tyres.delete');


	// Route::get('/AutoCare/tyres/search', 'TyresController@search');

	// tyre product data :stop

	// product sale:sale
	Route::get('/AutoCare/sale/add', 'SaleProductController@index');
	Route::get('/AutoCare/sale/edit/{id}', 'SaleProductController@edit');
	Route::post('/AutoCare/sale/create', 'SaleProductController@create');
	Route::get('/AutoCare/sale/search', 'SaleProductController@view');
	Route::post('/AutoCare/sale/search', 'SaleProductController@view');
	Route::post('/AutoCare/sale/update', 'SaleProductController@update');
	Route::get('/AutoCare/sale/trash/{id}', 'SaleProductController@trash');
	Route::get('/AutoCare/sale/delete', 'SaleProductController@trashedList');
	Route::get('/AutoCare/sale/delete/{id}', 'SaleProductController@permanemetDelete');
	Route::get('/AutoCare/sale/view/{id}', 'SaleProductController@viewIndivisual');
	Route::get('/AutoCare/sale/sale_return', 'SalesReturnController@show');
	Route::post('/AutoCare/sale/sale_return', 'SalesReturnController@show');
	// Product Sale :stop

	// Start: Supplier Details
	Route::get('/AutoCare/supplier/add', 'SupplierController@save');
	Route::post('/AutoCare/supplier/add', 'SupplierController@save');
	Route::post('/AutoCare/supplier/update', 'SupplierController@save');
	Route::get('/AutoCare/supplier/add/{id}', 'SupplierController@save');
	Route::get('/AutoCare/supplier/search', 'SupplierController@view');
	Route::post('/AutoCare/supplier/search', 'SupplierController@view');
	Route::get('/AutoCare/supplier/trash/{id}', 'SupplierController@trash');
	Route::get('/AutoCare/supplier/delete', 'SupplierController@trashedList');
	Route::get('/AutoCare/supplier/delete/{id}', 'SupplierController@permanemetDelete');
	// End: Supplier Details

	// Purchase Details

	Route::get('/AutoCare/purchase/add', 'PurchaseController@save');
	Route::post('/AutoCare/purchase/add', 'PurchaseController@save');
	Route::post('/AutoCare/purchase/update', 'PurchaseController@update');
	Route::get('/AutoCare/purchase/add/{id}', 'PurchaseController@save');
	Route::get('/AutoCare/purchase/search', 'PurchaseController@view');
	Route::post('/AutoCare/purchase/search', 'PurchaseController@view');
	Route::get('/AutoCare/purchase/trash/{id}', 'PurchaseController@trash');
	Route::get('/AutoCare/purchase/delete', 'PurchaseController@trashedList');
	Route::get('/AutoCare/purchase/delete/{id}', 'PurchaseController@permanemetDelete');
	Route::get('/AutoCare/purchase/purhase_return', 'PurchaseReturnController@show');
	Route::post('/AutoCare/purchase/purhase_return', 'PurchaseReturnController@show');
	//Start: Product Details

	Route::get('/AutoCare/product/add', 'ProductController@save');
	Route::post('/AutoCare/product/add', 'ProductController@save');
	Route::post('/AutoCare/product/update', 'ProductController@save');
	Route::get('/AutoCare/product/add/{id}', 'ProductController@save');
	Route::get('/AutoCare/product/search', 'ProductController@view');
	Route::post('/AutoCare/product/search', 'ProductController@view');
	Route::get('/AutoCare/product/trash/{id}', 'ProductController@trash');
	Route::get('/AutoCare/product/delete', 'ProductController@trashedList');
	Route::get('/AutoCare/product/delete/{id}', 'ProductController@permanemetDelete');
	//End: Product Details

	// Start: Service Details
	Route::get('/AutoCare/service/add', 'ServiceController@save');
	Route::post('/AutoCare/service/add', 'ServiceController@save');
	Route::post('/AutoCare/service/update', 'ServiceController@update');
	Route::get('/AutoCare/service/add/{id}', 'ServiceController@update');
	Route::get('/AutoCare/service/search', 'ServiceController@view');
	Route::post('/AutoCare/service/search', 'ServiceController@view');
	Route::get('/AutoCare/service/trash/{id}', 'ServiceController@trash');
	Route::get('/AutoCare/service/delete', 'ServiceController@trashedList');
	Route::get('/AutoCare/service/delete/{id}', 'ServiceController@permanemetDelete');
	Route::post('AutoCare/model/add', 'ServiceController@model');
	Route::post('/AutoCare/brand/add', 'ServiceController@brand');
	Route::post('/AutoCare/service_name/add', 'ServiceController@service');
	Route::post('/AutoCare/serviceType/add', 'ServiceController@serviceType');
	// End: Service Details

	// Start: Supplier Details
	Route::get('/AutoCare/customer/add', 'CustomerController@save');
	Route::post('/AutoCare/customer/add', 'CustomerController@save');
	Route::post('/AutoCare/customer/update', 'CustomerController@update');
	Route::get('/AutoCare/customer/add/{id}', 'CustomerController@save');
	Route::get('/AutoCare/customer/search', 'CustomerController@view');
	Route::post('/AutoCare/customer/search', 'CustomerController@view');
	Route::get('/AutoCare/customer/trash/{id}', 'CustomerController@trash');
	Route::get('/AutoCare/customer/delete', 'CustomerController@trashedList');
	Route::get('/AutoCare/customer/delete/{id}', 'CustomerController@permanemetDelete');
	// End: Supplier Details

	// Start: Master Form Details
	Route::post('/master/brands', 'MasterController@brand');
	Route::post('/master/modal', 'MasterController@modal');
	Route::post('/master/service_name', 'MasterController@service');
	Route::post('/master/service_type', 'MasterController@serviceType');
	Route::get('/master/brands', 'MasterController@brand');
	Route::get('/master/modal', 'MasterController@modal');
	Route::get('/master/service_name', 'MasterController@service');
	Route::get('/master/service_type', 'MasterController@serviceType');
	Route::get('/master/brands/{id}', 'MasterController@brandUpdate');
	Route::get('/master/modal/{id}', 'MasterController@modalUpdate');
	Route::get('/master/service_name/{id}', 'MasterController@serviceUpdate');
	Route::get('/master/service_type/{id}', 'MasterController@serviceTypeUpdate');
	Route::get('/master/brands/update/{id}', 'MasterController@brandUpdate');
	Route::get('/master/modal/update/{id}', 'MasterController@modalUpdate');
	Route::get('/master/service_name/update/{id}', 'MasterController@serviceUpdate');
	Route::get('/master/service_type/update/{id}', 'MasterController@serviceTypeUpdate');
	Route::post('/master/brands/update', 'MasterController@brandUpdate');
	Route::post('/master/modal/update', 'MasterController@modalUpdate');
	Route::post('/master/service_name/update', 'MasterController@serviceUpdate');
	Route::post('/master/service_type/update', 'MasterController@serviceTypeUpdate');

	// End: Master Form Details


	// Start:  Marketing Details
	Route::post('/marketing/add', 'MarketingController@save');
	Route::post('/marketing/update', 'MarketingController@update');
	Route::post('/marketing/search', 'MarketingController@view');
	Route::get('/marketing/add', 'MarketingController@save');
	Route::get('/marketing/add/{id}', 'MarketingController@save');
	Route::get('/marketing/search', 'MarketingController@view');
	Route::get('/marketing/delete', 'MarketingController@trashedList');
	Route::get('/marketing/trash/{id}', 'MarketingController@trash');
	Route::get('/marketing/delete/{id}', 'MarketingController@permanemetDelete');
	// End: Marketing Details
	// Start:  Marketing Details
	Route::post('/credit-debit/add', 'CreditDebitController@save');
	Route::post('/credit-debit/update', 'CreditDebitController@update');
	Route::post('/credit-debit/search', 'CreditDebitController@view');
	Route::get('/credit-debit/add', 'CreditDebitController@save');
	Route::get('/credit-debit/add/{id}', 'CreditDebitController@save');
	Route::get('/credit-debit/search', 'CreditDebitController@view');
	Route::get('/credit-debit/delete', 'CreditDebitController@trashedList');
	Route::get('/credit-debit/trash/{id}', 'CreditDebitController@trash');
	Route::get('/credit-debit/delete/{id}', 'CreditDebitController@permanemetDelete');
	// End: Marketing Details


	// Start:  Marketing Details
	Route::post('/SupplierCreditDebitLog/add', 'SupplierCreditDebitLog@save');
	Route::post('/SupplierCreditDebitLog/update', 'SupplierCreditDebitLog@update');
	Route::post('/SupplierCreditDebitLog/search', 'SupplierCreditDebitLog@view');
	Route::get('/SupplierCreditDebitLog/add', 'SupplierCreditDebitLog@save');
	Route::get('/SupplierCreditDebitLog/add/{id}', 'SupplierCreditDebitLog@save');
	Route::get('/SupplierCreditDebitLog/search', 'SupplierCreditDebitLog@view');
	Route::get('/SupplierCreditDebitLog/delete', 'SupplierCreditDebitLog@trashedList');
	Route::get('/SupplierCreditDebitLog/trash/{id}', 'SupplierCreditDebitLog@trash');
	Route::get('/cSupplierCreditDebitLog/delete/{id}', 'SupplierCreditDebitLog@permanemetDelete');
	// End: Marketing Details

	// Start:  CustomerCreditDebitLog Details
	Route::post('/CustomerCreditDebitLog/add', 'CustomerCreditDebitLog@save');
	Route::post('/CustomerCreditDebitLog/update', 'CustomerCreditDebitLog@update');
	Route::post('/CustomerCreditDebitLog/search', 'CustomerCreditDebitLog@view');
	Route::get('/CustomerCreditDebitLog/add', 'CustomerCreditDebitLog@save');
	Route::get('/CustomerCreditDebitLog/add/{id}', 'CustomerCreditDebitLog@save');
	Route::get('/CustomerCreditDebitLog/search', 'CustomerCreditDebitLog@view');
	Route::get('/CustomerCreditDebitLog/delete', 'CustomerCreditDebitLog@trashedList');
	Route::get('/CustomerCreditDebitLog/trash/{id}', 'CustomerCreditDebitLog@trash');
	Route::get('/CustomerCreditDebitLog/delete/{id}', 'CustomerCreditDebitLog@permanemetDelete');
	// End: Marketing Details

	// Start:  Marketing Details
	// Route::post('/credit-debit/add','CreditDebitDetailController@save');
	// Route::post('/credit-debit/update','CreditDebitDetailController@update');
	// Route::post('/credit-debit/search','CreditDebitDetailController@view');
	// Route::get('/credit-debit/add','CreditDebitDetailController@save');
	// Route::get('/credit-debit/add/{id}','CreditDebitDetailController@save');
	// Route::get('/credit-debit/search','CreditDebitDetailController@view');
	// Route::get('/credit-debit/delete','CreditDebitDetailController@trashedList');
	// Route::get('/credit-debit/trash/{id}','CreditDebitDetailController@trash');
	// Route::get('/credit-debit/delete/{id}','CreditDebitDetailController@permanemetDelete');
// End: Marketing Details

	// Start: Ajax Related
	Route::post('/ajax/getPurchase', 'AjaxController@getPurchase');
	Route::post('/ajax/getCustomerForWorkshop', 'AjaxController@getCustomerForWorkshop');
	Route::post('/ajax/getProductForworkshop', 'AjaxController@getProductForworkshop');
	Route::post('/ajax/getService', 'AjaxController@getService');
	Route::post('/ajax/getProduct', 'AjaxController@getProduct');
	Route::post('/ajax/getModal', 'AjaxController@getModal');
	Route::post('/ajax/getServiceThroughServiceId', 'AjaxController@getServiceThroughServiceId');
	Route::post('/ajax/getServiceTypeForWorkshop', 'AjaxController@getServiceTypeForWorkshop');
	Route::post('/ajax/getServiceTypeForWorkshopThroughModel', 'AjaxController@getServiceTypeForWorkshopThroughModel');
	Route::post('/ajax/getProductThroughModelAndBrand', 'AjaxController@getProductThroughModelAndBrand');
	Route::post('/ajax/submitSupplierDetail', 'AjaxController@submitSupplierDetail');
	Route::post('/ajax/submitCustomerPaymentDetail', 'AjaxController@submitCustomerPaymentDetail');
	Route::post('/ajax/GetVehicleDetailFromWorkshop', 'AjaxController@GetVehicleDetailFromWorkshop');
	Route::post('/ajax/GetVehicleRegFromWorkshop', 'AjaxController@GetVehicleRegFromWorkshop');
	Route::post('/ajax/submitPurchaseReturn', 'AjaxController@submitPurchaseReturn');
	Route::post('/ajax/submitSaleReturn', 'AjaxController@submitSaleReturn');
	Route::post('/ajax/getWorkshopReport', 'AjaxController@getWorkshopReport');
	Route::post('/ajax/paymentForWorkshop', 'AjaxController@paymentForWorkshop');
	Route::post('/ajax/updateWorkshopBalance', 'AjaxController@updateWorkshopBalance');
	Route::post('/ajax/discountForWorkshop', 'AjaxController@discountForWorkshop');


	// End: Ajax Related 

	/**
	 * Start: Employee Module
	 */

	Route::get('/employee', 'MasterformsController@addUser')->name('employee');
	Route::post('/employee-save', 'MasterformsController@addUser')->name('employee-save');
	Route::get('/employee-list', 'MasterformsController@userList')->name('employee-list');
	Route::get('/employee-edit/{id}', 'MasterformsController@addUser')->name('employee-edit');
	Route::get('/employee/block/{type}/{id}', 'MasterformsController@blockUser')->name('employee-edit');
	Route::get('/employee/trash/{type}/{id}', 'MasterformsController@trashUser')->name('employee-edit');
	Route::get('/employee/{id}/{view}', 'MasterformsController@addUser')->name('employee-edit');

	// Route::get('/get-payment-overview/{sid}', 'StudentController@paymentOverview')->name('get-payment-overview');
	// Route::get('/get-payment-overview-by-year-id/{sid}/{year}', 'StudentController@paymentOverview')->name('get-payment-overview');
	/**
	 * End: Employee Module
	 */

	Route::get('/send', 'SendEmailController@send');
	Route::view('/sample/cards', 'samples.cards');
	Route::view('/sample/forms', 'samples.forms');

	// Route::view('/sample/modals','samples.modals');
	// Route::view('/sample/switches','samples.switches');
	// Route::view('/sample/tables','samples.tables');
	// Route::view('/sample/tabs','samples.tabs');
	// Route::view('/sample/icons-font-awesome', 'samples.font-awesome-icons');
	// Route::view('/sample/icons-simple-line', 'samples.simple-line-icons');
	// Route::view('/sample/widgets','samples.widgets');
	// Route::view('/sample/charts','samples.charts');

});

// Route::get('/home', 'HomeController@index')->name('home');

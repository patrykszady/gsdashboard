<?php

use App\Vendor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
Auth::routes();

Route::get('/', function () {
	// Will return a ModelNotFoundException if no user with that id
	try
	{
	    $vendor = Vendor::findOrFail(Auth::user());
	}
	// catch(Exception $e) catch any exception
	catch(ModelNotFoundException $e)
	{
	    return redirect('/login');
	}
	    return redirect(route('vendors.show', Vendor::findOrFail(Auth::user()->primary_vendor)));
});

//run receips automaticly 
Route::get('hd', 'ReceiptController@index');

Route::get('/home', 'HomeController@index');

Route::get('hours/payment/{id}', ['uses' => 'HourController@hoursPayment', 'as' => 'hours.payment']);
 //get action for this URI called TWICE!
Route::post('hours/storepayment', ['uses' => 'HourController@storePayment', 'as' => 'hours.payment']);
Route::get('hours/timesheets/print', ['uses' => 'HourController@printTimesheets', 'as' => 'hours.print']);
/*
Route::get('carbon', 'ExpenseController@carbon');*/

Route::get('clients/createcontact', 'ClientController@createcontact');

Route::get('expenses/input', 'ExpenseController@input');
Route::post('expenses/input', ['uses' => 'ExpenseController@inputStore', 'as' => 'expenses.inputStore']);
Route::resource('expenses', 'ExpenseController');
Route::get('expenses/receipts/{receipt}', ['uses' => 'ExpenseController@receipt', 'as' => 'expenses.receipt']);
Route::get('expenses/temp_receipts/{receipt}', ['uses' => 'ExpenseController@temp_receipt', 'as' => 'expenses.temp_receipt']);
Route::get('expenses/original_receipts/{receipt}', ['uses' => 'ExpenseController@original_receipt', 'as' => 'expenses.original_receipt']);

Route::get('expenses/reimbursments/print/{project}', ['uses' => 'ExpenseController@printReimbursment', 'as' => 'expenses.printReimbursment']);

Route::get('expensesplits/create/{expense}', ['uses' => 'ExpenseSplitController@create', 'as' => 'expensesplits.create']);
Route::get('expensesplits/{expense}/edit', ['uses' => 'ExpenseSplitController@edit', 'as' => 'expensesplits.edit']);
Route::patch('expensesplits/{expense}', ['uses' => 'ExpenseSplitController@update', 'as' => 'expensesplits.update']);

Route::resource('expensesplits', 'ExpenseSplitController', [
    'except' => ['create', 'edit', 'update']
]);

Route::resource('projects', 'ProjectController');

Route::resource('vendors', 'VendorController');
Route::get('vendors/payment/{vendor}', 'VendorController@vendorPayment');
Route::post('vendors/payment', ['uses' => 'VendorController@vendorStorePayment', 'as' => 'vendors.payment']);

Route::resource('distributions', 'DistributionController');
Route::get('distributions/project/{project}', 'DistributionController@projectCreate');
Route::post('distributions/project', ['uses' => 'DistributionController@projectStore', 'as' => 'distributions.projectStore']);
Route::get('distributions/project/{project}/edit',
	['uses' => 'DistributionController@projectEdit', 'as' => 'distributions.projectEdit']);
Route::patch('distributions/project/{project}', ['uses' => 'DistributionController@projectUpdate', 'as' => 'distributions.projectUpdate']);

Route::resource('hours', 'HourController');
Route::resource('checks', 'CheckController');
Route::get('receipts/makepdf', 'ReceiptController@makePdfReceipt');
Route::resource('receipts', 'ReceiptController');


Route::resource('bids', 'BidController');
Route::get('bids/create/{vendor}', 'BidController@create');

Route::resource('projectstatuses', 'ProjectstatusController');

Route::resource('clientpayments', 'ClientPaymentController');

Route::resource('clients', 'ClientController');

Route::resource('users', 'UserController');
//Send $client to users/create view
Route::get('users/create/{id}', 'UserController@createassociate');

Route::get('clients/create/{user}', 'ClientController@createassociate');
Route::get('vendors/create/{user}', 'VendorController@create');
Route::get('projects/create/{client}', 'ProjectController@create');

Route::get('users/remove_from_client/{user}', 'UserController@remove_from_client');
Route::get('users/remove_from_vendor/{user}', 'UserController@remove_from_vendor');




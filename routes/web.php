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
    return view('index');
});

Route::prefix('expense')->group(function(){
	Route::get('/',function(){
		return view('expense');
	});	
	Route::any('/data', 'ExpenseController@viewExpense');
	Route::post('/add', 'ExpenseController@addExpense');
	Route::any('/edit', 'ExpenseController@editExpense');	
	Route::any('/delete/{id}', 'ExpenseController@deleteExpense');	
	Route::get('/try', 'ExpenseController@try');
});


Route::prefix('custom')->group(function(){
	Route::get('/',function(){
		return view('custom');
	});	
	Route::any('/data', 'CustomController@viewGroup');
	Route::post('/add', 'CustomController@addGroup');
	Route::any('/delete/{id}', 'CustomController@deleteGroup');
	Route::any('/edit', 'CustomController@editGroup');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

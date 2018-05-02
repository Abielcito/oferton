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

//Route::get('/', function () {
//  return redirect('home');
//});


Auth::routes();

Route::get('/home', 'HomeController@index');



Route::get('/', function () {
    return view('welcome');
});


//RAFAEL
Route::resource('/hites', 'HitesController');

//DANIEL
Route::resource('/paris', 'ParisController');
Route::get('/parisLink', 'ParisController@getLinksParis');


//ALEX
Route::resource('/ripley', 'RipleyController');

//SEBASTIAN
Route::resource('/falabella', 'FalabellaController');

//EJEMPLO
Route::resource('/example', 'ExampleController');










Route::resource('stores', 'StoreController');

Route::resource('storesTypes', 'StoresTypesController');

Route::resource('storeCategories', 'StoreCategoryController');
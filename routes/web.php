<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    return view('welcomorg');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/customerhome', 'CustomerController@index')->name('customerhome');

Route::get('{path}','HomeController@index')->where( 'path', '([A-z]+)?' );
Route::get('{path}','CustomerController@index')->where( 'path', '([A-z]+)?' );




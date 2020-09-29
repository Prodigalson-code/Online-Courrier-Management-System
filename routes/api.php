<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

Route::middleware('auth:api')->get('/branch', function (Request $request) {

    return $request->branch();
});

Route::middleware('auth:api')->get('/company', function (Request $request) {

    return $request->company();
});

Route::middleware('auth:api')->get('/items', function (Request $request) {

    return $request->item();
});

Route::middleware('auth:api')->get('/location', function (Request $request) {

    return $request->location();
});

Route::middleware('auth:api')->get('/parselinfo', function (Request $request) {

    return $request->parselinfo();
});

Route::middleware('auth:api')->get('/blog', function (Request $request) {

    return $request->blog();
});

Route::middleware('auth:api')->get('/about', function (Request $request) {

    return $request->aboutus();
});

Route::middleware('auth:api')->get('/service', function (Request $request) {

    return $request->service();
});



Route::apiResources([
    'user' => 'API\UserController',
    'branch' => 'API\BranchController',
    'company' => 'API\CompanyController',
    'items' => 'API\ItemController',
    'location' => 'API\LocationController',
    'parselinfo' => 'API\OrderController',
    'setting'=>'API\LandingpageController',
    'blog'=>'API\blogController',
    'about'=>'API\AboutusController',
    'service'=>'API\ServiceController',

]);

Route::get('profile','API\UserController@profile');
Route::post('save','API\UserController@customerstore');
Route::put('updateCustomer/{id}','API\UserController@getcustomerupdate');
Route::DELETE('destroy/{id}','API\UserController@customerdestroy');
Route::put('profile','API\UserController@updateProfile');
Route::get('customer','API\UserController@customer');
Route::get('customer','API\UserController@customerindex');
//Route::get('itemsorder','API\ItemController@getitems');
Route::get('destination','API\LocationController@getlocations');
Route::get('getuser','API\UserController@getuser');
Route::get('findUser','API\UserController@search');
Route::get('findCustomer','API\UserController@searchCustomer');
Route::get('findOrder','API\OrderController@search');
Route::get('findLocation','API\LocationController@search');
Route::get('findItem','API\ItemController@search');
Route::get('findBlog','API\blogController@search');
Route::get('findBranch','API\BranchController@search');
Route::get('getuserorder','API\OrderController@getuserorder');




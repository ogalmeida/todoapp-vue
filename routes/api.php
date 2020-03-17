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


Route::get('tasks', 'TaskController@index');
Route::get('finished', 'TaskController@finished');
Route::group(['prefix' => 'task'], function () {
    Route::post('add', 'TaskController@add');
    Route::post('update/{id}', 'TaskController@update');
    Route::get('finish/{id}', 'TaskController@finishTask');
    Route::get('unfinish/{id}', 'TaskController@unfinishTask');
    Route::delete('delete/{id}', 'TaskController@delete');
});
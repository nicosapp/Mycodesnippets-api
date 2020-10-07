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

Route::group(['prefix' => 'snippets', 'namespace' => 'Snippets'], function () {
  Route::post('', 'SnippetController@store');
  Route::get('{snippet}', 'SnippetController@show');
  Route::patch('{snippet}', 'SnippetController@update');
  Route::delete('{snippet}', 'SnippetController@destroy');
  Route::post('{snippet}/steps', 'StepController@store');
  Route::delete('{snippet}/steps/{step}', 'StepController@destroy');
});

Route::group(['prefix' => 'steps', 'namespace' => 'Snippets'], function () {

  Route::get('{step}', 'StepController@show');
  Route::patch('{step}', 'StepController@update');
});

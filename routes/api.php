<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return new UserResource($request->user());
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  Route::post('signin', 'SignInController');
  Route::post('signout', 'SignOutController');

  // Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
  // Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'snippets', 'namespace' => 'Snippets'], function () {
  Route::post('', 'SnippetController@store');
  Route::get('', 'SnippetController@index');
  Route::get('{snippet}', 'SnippetController@show');
  Route::patch('{snippet}', 'SnippetController@update');
  Route::delete('{snippet}', 'SnippetController@destroy');
  Route::post('{snippet}/steps', 'StepController@store');
  Route::delete('{snippet}/steps/{step}', 'StepController@destroy');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'steps', 'namespace' => 'Snippets'], function () {
  Route::get('{step}', 'StepController@show');
  Route::patch('{step}', 'StepController@update');
});

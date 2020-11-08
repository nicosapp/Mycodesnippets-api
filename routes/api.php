<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
  'register' => false,
  'verify' => true,
  'reset' => true
]);

Route::middleware('auth:sanctum')->get('user', function (Request $request) {
  return new UserResource($request->user());
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
  Route::post('signup', 'SignUpController');
  // Route::post('signin', 'SignInController');
  // Route::post('signout', 'SignOutController');

  // Route::get('email/verify/{numbers}', 'ApiVerificationController@verify')->name('verificationapi.verify');
  // Route::get('email/resend', 'ApiVerificationController@resend')->name('verificationapi.resend');
});

Route::group(['prefix' => 'snippets', 'namespace' => 'Snippets'], function () {
  Route::get('titleAvailable', 'SnippetController@titleAvailable');
  Route::get('home', 'HomeSnippetsTimelineController');
  Route::get('', 'SearchSnippetsController');
  Route::post('', 'SnippetController@store');
  Route::get('{snippet}', 'SnippetController@show');
  Route::patch('{snippet}', 'SnippetController@update');
  Route::delete('{snippet}', 'SnippetController@destroy');
  Route::post('{snippet}/cover', 'SnippetController@cover');

  Route::post('{snippet}/steps', 'StepController@store');
  Route::delete('{snippet}/steps/{step}', 'StepController@destroy');
});

Route::group(['prefix' => 'steps', 'namespace' => 'Snippets'], function () {
  Route::get('{step}', 'StepController@show');
  Route::patch('{step}', 'StepController@update');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'users', 'namespace' => 'Users'], function () {
  Route::get('{user}', 'UserController@show');
  Route::patch('{user}', 'UserController@update');
  Route::patch('{user}/profile', 'UserController@updateProfile');
  Route::patch('{user}/password', 'UserController@updatePassword');
  Route::post('{user}/avatar', 'UserController@avatar');

  Route::get('{user}/snippets', 'UserController@snippets');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'dashboard', 'namespace' => 'Dashboard'], function () {
  Route::get('statistics', 'DashboardController@statistics');
  Route::get('lastUpdated', 'DashboardController@lastUpdated');
  Route::get('lastCreated', 'DashboardController@lastCreated');
  Route::get('mostViewed', 'DashboardController@mostViewed');
});

Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
  Route::get('config', 'MediaConfigController@index');
});

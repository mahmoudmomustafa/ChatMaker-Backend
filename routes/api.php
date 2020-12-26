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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('signup', 'Auth\AuthController@signup')->name('signup');
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::get('me', 'Auth\AuthController@profile')->name('profile');
});

Route::group(['prefix' => 'cvs'], function ($router) {
    Route::get('index', 'Cv\CvController@index')->name('index');
    Route::post('create', 'Cv\CvController@create')->name('create');

    Route::get('{cv}', 'Cv\CvController@getCv');

    Route::put('{cv}', 'Cv\CvController@update');

    Route::delete('{cv}', 'Cv\CvController@destroy');
    Route::delete('{cv}/edu/{education}', 'Cv\CvController@deleteEducation');
    Route::delete('{cv}/exp/{experience}', 'Cv\CvController@deleteEXp');
    Route::delete('{cv}/sec/{section}', 'Cv\CvController@deleteSection');
    Route::delete('{cv}/datedsec/{datedSection}', 'Cv\CvController@deleteDateSec');
    Route::delete('{datedSection}/datedData/{datedData}', 'Cv\CvController@deleteDateData');
});

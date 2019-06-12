<?php

use Illuminate\Http\Request;

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

Route::post('/postSignUp','UserController@postSignUp')->name('postSignUp');
Route::post('/Login','UserController@Login')->name('Login');

Route::get('/getArticles','AndroidController@GetArticles')->name('getArticles');
Route::post('/PostArticle','AndroidController@PostArticle')->name('PostArticle');
Route::post('/ParentLogIn','AndroidController@ParentLogIn')->name('ParentLogIn');
Route::post('/ParentSignUp','AndroidController@ParentSignUp')->name('ParentSignUp');
<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('index',['as' => 'index','uses' =>'Login@index']);

Route::post('login',['as' => 'login','uses' => 'Login@login']);

Route::get('logout',['as' => 'logout','uses' => 'Login@logout']);

Route::resource('signup','Signup');

Route::resource('dashboard','Dashboard');

Route::resource('stripe','Stripecontroller');

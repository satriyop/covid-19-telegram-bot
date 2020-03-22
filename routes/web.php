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

Route::get('/', function () {
    $provincesData = \App\NationalReport::latest()->first()->provinces;
    return view('welcome', compact('provincesData'));
});

Route::get('reports/national/refresh', 'NationalReportController@refresh');
Route::get('reports/province/refresh', 'ProvinceReportController@refresh');

Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::get('/botman/tinker', 'BotManController@tinker');

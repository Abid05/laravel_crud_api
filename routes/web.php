<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//api test
Route::get('/api-test', function () {

    // $response =Http::withHeaders([

    //     'Authorization' => 'Bearer 4|0DMAIbtSnXAb2S1FaIFJesSOBEvFNdHd4pMIReBK06bf19a0',

    // ])->get('http://127.0.0.1:8000/api/user');

    $response =Http::post('http://127.0.0.1:8000/api/login',[

        'email' => 'sazzad@gmail.com',
        'password' => '12345678',
    ]);

    return $response->object();
});

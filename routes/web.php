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
    return view('home.index', []);
})->name('home.index');


Route::get('/contact', function () {
    return view('home.contact');
})->name('contact');


Route::get('/posts/{id}', function ($id) {
    return 'Post '.$id;
});


Route::get('/recent-posts/{days?}', function ($days=20) {
    return 'Recent days = '.$days;
});



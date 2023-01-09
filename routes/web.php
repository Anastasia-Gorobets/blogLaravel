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

Route::get('/contact', function () {
    return view('home.contact');
})->name('contact');


Route::view('/', 'home.index')->name('home.index');
Route::view('/contact', 'home.contact')->name('home.contact');


$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new'=>true,
        'has_comments'=>true,
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new'=>false,
    ],
    3 => [
        'title' => 'Intro to Vue',
        'content' => 'This is a short intro to Vue',
        'is_new'=>false,
    ]
];


Route::get('/posts/{id}', function ($id) use ($posts) {
    abort_if(!isset($posts[$id]), 404);
    return  view('posts.show', ['post'=>$posts[$id]]);
});

Route::get('/posts', function () use ($posts) {
    return  view('posts.index', compact('posts'));
});




Route::get('/recent-posts/{days?}', function ($days=20) {
    return 'Recent days = '.$days;
});



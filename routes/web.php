<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/posts', function (Request $request) use ($posts) {
    return  view('posts.index', compact('posts'));
});


Route::get('/recent-posts/{days?}', function ($days=20) {
    return 'Recent days = '.$days;
});



Route::prefix('/fun')->name('fun.')->group(function () use ($posts){

    Route::get('/responses', function () use ($posts) {
        return response($posts, 201)->header('Content-Type', 'application/json')->cookie('MY_COOKIE','Nastya', 3600);
    });

    Route::get('/redirect', function () use ($posts) {
        return redirect('/contact');
    });

    Route::get('/back', function () use ($posts) {
        return back();
    });

    Route::get('/named-route', function () use ($posts) {
        return redirect()->route('home.contact');
    });

    Route::get('/json', function () use ($posts) {
        return response()->json($posts);
    });

    Route::get('/download', function () use ($posts) {
        return response()->download(public_path('/coupon.png'), 'newFile.png');
    });
});







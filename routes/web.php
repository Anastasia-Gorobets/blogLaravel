<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostsController;

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

Route::get('/',[HomeController::class, 'index'])->name('home.index');
Route::get('/contact',[HomeController::class, 'contact'])->name('home.contact');

Route::get('/single',AboutController::class)->name('single');

Route::resource('posts',PostsController::class);


/*
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
*/

/*Route::prefix('/fun')->name('fun.')->group(function () use ($posts){

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
*/






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

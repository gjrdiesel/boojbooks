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

Route::get('/api/welcome', function () {
    return [
        'authors' => \App\Models\Author::orderByRaw('RAND()')->paginate(3),
        'books' => \App\Models\Book::orderByRaw('RAND()')->with('author')->paginate(3),
        'users' => \App\Models\User::orderByRaw('RAND()')->paginate(3),
        'lists' => \App\Models\ReadingList::orderByRaw('RAND()')->paginate(3),
    ];
});

Route::post('/api/login', [\App\Http\Controllers\LoginController::class, 'authenticate']);
Route::post('/api/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
Route::get('/api/user', [\App\Http\Controllers\LoginController::class, 'user']);

Route::apiResource('/api/list', \App\Http\Controllers\ListController::class);
Route::post('/api/list/{list}/move', [\App\Http\Controllers\ListController::class, 'move']);

Route::fallback(function () {
    return view('welcome');
});

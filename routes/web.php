<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\JoinController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    Route::get('/movies', [MovieController::class, 'getMovies'])->name('movies.index');
    Route::post('/movies/search', [MovieController::class, 'index']);
    Route::get('/movies/trash', [MovieController::class, 'deletelist']);
    Route::post('/movies/trash/restore/{id}', [MovieController::class, 'restore']);
    Route::delete('/movies/trash/forcedelete/{id}', [MovieController::class, 'deleteforce']);
    Route::get('/movies/create',[MovieController::class, 'create']);
    Route::post('/movies/create',[MovieController::class, 'store']);
    Route::get('movies/edit/{id}', [MovieController::class, 'edit']);
    Route::post('/movies/edit/{id}', [MovieController::class, 'update']);
    Route::delete('/movies/delete/{id}', [MovieController::class,'destroy']);
    Route::get('movies/show/{id}', [MovieController::class, 'show']);


    Route::get('/genres', [GenreController::class, 'getGenres'])->name('genres.index');
    Route::post('/genres/search', [GenreController::class, 'index']);
    Route::get('/genres/trash', [GenreController::class, 'deletelist']);
    Route::post('/genres/trash/restore/{id}', [GenreController::class, 'restore']);
    Route::delete('/genres/trash/forcedelete/{id}', [GenreController::class, 'deleteforce']);
    Route::get('/genres/create',[GenreController::class, 'create']);
    Route::post('/genres/create',[GenreController::class, 'store']);
    Route::get('genres/edit/{id}', [GenreController::class, 'edit']);
    Route::post('/genres/edit/{id}', [GenreController::class, 'update']);
    Route::delete('/genres/delete/{id}', [GenreController::class,'destroy']);
    Route::get('genres/show/{id}', [GenreController::class, 'show']);


    Route::get('/directors', [DirectorController::class, 'getDirectors'])->name('directors.index');
    Route::post('/directors/search', [DirectorController::class, 'index']);
    Route::get('/directors/trash', [DirectorController::class, 'deletelist']);
    Route::post('/directors/trash/restore/{id}', [DirectorController::class, 'restore']);
    Route::delete('/directors/trash/forcedelete/{id}', [DirectorController::class, 'deleteforce']);
    Route::get('/directors/create',[DirectorController::class, 'create']);
    Route::post('/directors/create',[DirectorController::class, 'store']);
    Route::get('directors/edit/{id}', [DirectorController::class, 'edit']);
    Route::post('/directors/edit/{id}', [DirectorController::class, 'update']);
    Route::delete('/directors/delete/{id}', [DirectorController::class,'destroy']);
    Route::get('directors/show/{id}', [DirectorController::class, 'show']);


    Route::get('/totals', [JoinController::class, 'index']);
    
});
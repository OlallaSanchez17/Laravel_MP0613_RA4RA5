<?php

use App\Http\Controllers\FilmController;
use App\Http\Middleware\ValidateYear;
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

Route::middleware('year')->group(function() {
    Route::group(['prefix'=>'filmout'], function(){
        // Routes included with prefix "filmout"
        Route::get('oldFilms/{year?}',[FilmController::class, "listOldFilms"])->name('oldFilms');
        Route::get('newFilms/{year?}',[FilmController::class, "listNewFilms"])->name('newFilms');
        Route::get('allFilms/{year?}/{genre?}',[FilmController::class, "listAllFilms"])->name('allFilms');

        //Lista peliculas por genero y año
        Route::get('filmsByYear/{year?}', [FilmController::class, "listFilmsByYear"])->name('filmsByYear');
        Route::get('filmsByGenre/{genre?}', [FilmController::class, "listFilmsByGenre"])->name('filmsByGenre');

        //Contar peliculas
        Route::get('/countFilms', [FilmController::class, 'countFilms']);

        //Peliculas por año
        Route::get('/sortFilms', [FilmController::class, 'sortFilms']);
    
    });
});

Route::prefix('filmin')->group(function () {
    Route::post('/add-film', [FilmController::class, 'createFile'])
        ->name('filmin.addFilm');
});




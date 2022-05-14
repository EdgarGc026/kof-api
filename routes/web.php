<?php

use App\Http\Controllers\Scraping\Characters\CharacterScrapingController;
use App\Http\Controllers\Web\CharacterWeb;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Para mostrar los datos desde una pagina web
Route::get('/web', [ CharacterWeb::class, 'index']);

//Para obtener los atributos de los personajes a scrapear (nombre, id, url)
Route::get('/characterSync', [CharacterScrapingController::class, 'characterSync']);
Route::post('/chacterSync', [CharacterScrapingController::class, 'characterSync']);

//Hara el scraping de los personajes
Route::get('/characterScraping', [CharacterScrapingController::class, 'characterScraping']);
Route::post('/characterScraping', [CharacterScrapingController::class, 'characterScraping']);


//Probar por personaje
Route::get('/singleCharacter', [CharacterScrapingController::class, 'singleCharacter']);
Route::post('/singleCharacter', [CharacterScrapingController::class, 'singleCharacter']);

<?php

use App\Http\Controllers\RankingController;
use App\Product\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Classements
|--------------------------------------------------------------------------
*/

// Enregistrer un nouveau score
Route::post('/scores', [RankingController::class, 'store']);

// Consulter le Top 10 d'un mode de jeu
Route::get('/rankings/{mode}', [RankingController::class, 'top10']);

// Récupérer la position d'un joueur précis
Route::get('/rankings/{mode}/player/{name}', [RankingController::class, 'playerRank']);

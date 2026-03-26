<?php

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Joueurs & Classements
|--------------------------------------------------------------------------
*/

// Enregistrer un joueur (retourne son id ou 409 si pseudo déjà pris)
Route::post('/players', [PlayerController::class, 'store']);

// Enregistrer un score
Route::post('/scores', [RankingController::class, 'store']);

// Consulter le Top 10 d'un mode de jeu
Route::get('/rankings/{mode}', [RankingController::class, 'top10']);

// Récupérer la position d'un joueur précis
Route::get('/rankings/{mode}/player/{playerId}', [RankingController::class, 'playerRank']);

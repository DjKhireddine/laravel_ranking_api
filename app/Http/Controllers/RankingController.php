<?php

namespace App\Http\Controllers;

use App\Services\RankingService;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function store(Request $request, RankingService $service)
    {
        $validated = $request->validate([
            'player_id'   => 'required|integer|exists:players,id',
            'player_name' => 'required|string',
            'game_mode'   => 'required|string',
            'score'       => 'required|integer|min:0',
        ]);

        return response()->json($service->recordScore($validated), 201);
    }

    public function top10($mode, RankingService $service)
    {
        return response()->json($service->getTop10($mode));
    }

    public function playerRank($mode, $playerId, RankingService $service)
    {
        $result = $service->getPlayerRank((int) $playerId, $mode);

        if ($result === null) {
            return response()->json(['message' => 'Joueur introuvable ou pas encore de score.'], 404);
        }

        return response()->json($result);
    }
}

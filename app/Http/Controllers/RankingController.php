<?php

namespace App\Http\Controllers;

use App\Services\RankingService;
use http\Client\Request;

class RankingController
{
    public function store(Request $request, RankingService $service) {
        $validated = $request->validate([
            'player_name' => 'required|string',
            'game_mode' => 'required|string',
            'score' => 'required|integer',
        ]);
        return response()->json($service->recordScore($validated), 201);
    }

    public function top10($mode, RankingService $service) {
        return response()->json($service->getTop10($mode));
    }

    public function playerRank($mode, $name, RankingService $service) {
        $rank = $service->getPlayerRank($name, $mode);
        return $rank
            ? response()->json(['player' => $name, 'rank' => $rank])
            : response()->json(['message' => 'Not found'], 404);
    }
}

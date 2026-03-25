<?php

namespace App\Services;

use App\Models\Score;

class RankingService {
    public function recordScore(array $data) {
        return Score::create($data);
    }

    public function getTop10(string $mode) {
        return Score::where('game_mode', $mode)
            ->orderByDesc('score')
            ->limit(10)
            ->get();
    }

    public function getPlayerRank(string $name, string $mode) {
        $playerScore = Score::where('player_name', $name)
            ->where('game_mode', $mode)
            ->first();

        if (!$playerScore) {
            return "Vous n'êtes pas dans le Top 100 ou n'avez pas encore de score.";
        }

        $rank = Score::where('game_mode', $mode)
                ->where('score', '>', $playerScore->score)
                ->count() + 1;

        return $rank;
    }
}

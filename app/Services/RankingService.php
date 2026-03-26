<?php

namespace App\Services;

use App\Models\Score;

class RankingService {
    public function recordScore(array $data)
    {
        return Score::create($data);
    }

    public function getTop10(string $mode)
    {
        return Score::where('game_mode', $mode)
            ->orderByDesc('score')
            ->limit(10)
            ->get(['player_id', 'player_name', 'score', 'created_at']);
    }

    public function getPlayerRank(int $playerId, string $mode)
    {
        $playerScore = Score::where('player_id', $playerId)
            ->where('game_mode', $mode)
            ->orderByDesc('score')
            ->first();

        if (!$playerScore) {
            return null;
        }

        $rank = Score::where('game_mode', $mode)
            ->where('score', '>', $playerScore->score)
            ->count() + 1;

        return [
            'player_id'   => $playerId,
            'player_name' => $playerScore->player_name,
            'score'       => $playerScore->score,
            'rank'        => $rank,
        ];
    }
}

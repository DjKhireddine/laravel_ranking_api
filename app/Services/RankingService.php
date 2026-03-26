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
        return Score::where('scores.game_mode', $mode)
            ->join('players', 'players.id', '=', 'scores.player_id')
            ->orderByDesc('scores.score')
            ->limit(10)
            ->get(['players.id as player_id', 'players.name as player_name', 'scores.score', 'scores.created_at']);
    }

    public function getPlayerRank(int $playerId, string $mode)
    {
        $playerScore = Score::where('scores.player_id', $playerId)
            ->where('scores.game_mode', $mode)
            ->join('players', 'players.id', '=', 'scores.player_id')
            ->orderByDesc('scores.score')
            ->first(['players.name as player_name', 'scores.score']);

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model {
    protected $fillable = ['player_name', 'game_mode', 'score'];
}

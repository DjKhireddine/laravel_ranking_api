<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('CREATE PROCEDURE insert_and_trim_score(
            IN p_name VARCHAR(255),
            IN p_mode VARCHAR(255),
            IN p_score INT
        )
        BEGIN
            -- 1. On insère le nouveau score
            INSERT INTO scores (player_name, game_mode, score, created_at, updated_at) 
            VALUES (p_name, p_mode, p_score, NOW(), NOW());
        
            -- 2. On nettoie pour ne garder que les 100 meilleurs
            DELETE FROM scores 
            WHERE game_mode = p_mode 
            AND id NOT IN (
                SELECT id FROM (
                    SELECT id FROM scores 
                    WHERE game_mode = p_mode 
                    ORDER BY score DESC 
                    LIMIT 100
                ) as temp
            );
        END;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS insert_and_trim_score');
    }
};

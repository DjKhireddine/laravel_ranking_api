<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER limit_scores_after_insert
        AFTER INSERT ON scores
        FOR EACH ROW
        BEGIN
            -- On ne garde que les 100 meilleurs scores pour ce mode
            DELETE FROM scores 
            WHERE game_mode = NEW.game_mode 
            AND id NOT IN (
                SELECT id FROM (
                    SELECT id FROM scores 
                    WHERE game_mode = NEW.game_mode 
                    ORDER BY score DESC 
                    LIMIT 100
                ) as temp_tab
            );
        END
    ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS limit_scores_after_insert');
    }
};

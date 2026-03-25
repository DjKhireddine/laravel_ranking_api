<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    public function run()
    {
        // Nettoyage initial de la table
        DB::table('scores')->truncate();

        $modes = ['classic', 'time_attack'];

        foreach ($modes as $mode) {
            $this->command->info("Génération de 100 joueurs pour le mode : $mode...");

            for ($i = 1; $i <= 100; $i++) {
                // On appelle la procédure stockée
                DB::select('CALL insert_and_trim_score(?, ?, ?)', [
                    "Joueur_{$mode}_{$i}",
                    $mode,
                    rand(1000, 99000)
                ]);
            }
        }

        $this->command->info("Succès : 200 scores enregistrés.");
    }
}

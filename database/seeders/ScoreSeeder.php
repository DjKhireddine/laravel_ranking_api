<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ScoreSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('fr_FR'); // On utilise la locale française pour plus de réalisme

        // Nettoyage de la table avant de commencer
        DB::table('scores')->truncate();

        $modes = ['classic', 'time_attack'];

        foreach ($modes as $mode) {
            $this->command->info("Génération de l'élite pour le mode : $mode...");

            for ($i = 1; $i <= 100; $i++) {
                // On génère un pseudo réaliste (ex: Jean.Dupont, Gamer42, etc.)
                $playerName = $this->generateGamerTag($faker);

                // On génère un score aléatoire
                $score = $faker->numberBetween(5000, 95000);

                // Appel de ta procédure stockée (qui gère le Top 100 auto)
                DB::select('CALL insert_and_trim_score(?, ?, ?)', [
                    $playerName,
                    $mode,
                    $score
                ]);
            }
        }

        $this->command->info("Base de données peuplée avec 200 joueurs réalistes !");
    }

    /**
     * Petite fonction helper pour créer des pseudos de joueurs variés
     */
    private function generateGamerTag($faker)
    {
        $formats = [
            $faker->userName,           // ex: jerome.leduc
            $faker->lastName . $faker->numberBetween(10, 99), // ex: Durand45
            "Shadow" . $faker->firstName, // ex: ShadowMarine
            $faker->firstName . "_FR",   // ex: Thomas_FR
            "Ultra" . $faker->word       // ex: UltraVitesse
        ];

        return $faker->randomElement($formats);
    }
}

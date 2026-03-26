<?php

namespace Database\Seeders;

use App\Models\Player;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('scores')->truncate();

        $faker = Faker::create('fr_FR');
        $players = Player::all();

        if ($players->isEmpty()) {
            $this->command->warn('Aucun joueur trouvé. Lancez PlayerSeeder d\'abord.');
            return;
        }

        $modes = ['classic', 'timeattack'];

        foreach ($modes as $mode) {
            $this->command->info("Génération des scores pour le mode : $mode...");

            foreach ($players as $player) {
                DB::table('scores')->insert([
                    'player_id'  => $player->id,
                    'game_mode'  => $mode,
                    'score'      => $faker->numberBetween(5000, 95000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Scores générés et liés aux joueurs.');
    }
}

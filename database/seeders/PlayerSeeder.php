<?php

namespace Database\Seeders;

use App\Models\Player;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlayerSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Player::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = Faker::create('fr_FR');
        $names = [];

        while (count($names) < 100) {
            $tag = $this->generateGamerTag($faker);
            if (!in_array($tag, $names)) {
                $names[] = $tag;
            }
        }

        foreach ($names as $name) {
            Player::create(['name' => $name]);
        }

        $this->command->info('100 joueurs créés.');
    }

    private function generateGamerTag($faker): string
    {
        $formats = [
            $faker->userName,
            $faker->lastName . $faker->numberBetween(10, 99),
            'Shadow' . $faker->firstName,
            $faker->firstName . '_FR',
            'Ultra' . $faker->word,
        ];

        return $faker->randomElement($formats);
    }
}

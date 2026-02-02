<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FilmActorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $filmIds = DB::table('films')->pluck('id')->toArray();
        $actorIds = DB::table('actors')->pluck('id')->toArray();

        if (empty($filmIds) || empty($actorIds)) {
            $this->command->warn("No se encontraron películas o actores. Saltando la siembra de la tabla pivote.");
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            DB::table('films_actor')->insert([
                'film_id' => $faker->randomElement($filmIds),
                'actor_id' => $faker->randomElement($actorIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

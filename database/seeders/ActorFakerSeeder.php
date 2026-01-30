<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActorFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); 
        
        $filmIds = DB::table('films')->pluck('id')->toArray();
        $actorIds = DB::table('actors')->pluck('id')->toArray();

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

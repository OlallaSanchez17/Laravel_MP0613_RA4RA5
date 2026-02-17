<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ActorFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

            $agency = $faker->company() . " Agency";
            \Log::info("Improvement: Seeding actor with agency: $agency");

            DB::table('actors')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName(),
                'birthdate' => $faker->year(),
                'country' => $faker->country(),
                'agency' => $agency,
                'img_url' => $faker->imageUrl(400, 400, 'people'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}

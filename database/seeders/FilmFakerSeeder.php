<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class FilmFakerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('films')->insert([
                'name' => $faker->sentence(3),
                'year' => $faker->numberBetween(1950, 2025),
                'genre' => $faker->randomElement([
                    'Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi', 'Romance'
                ]),
                'country' => $faker->country,
                'duration' => $faker->numberBetween(80, 180),
                'img_url' => $faker->imageUrl(300, 450, 'movies', true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}


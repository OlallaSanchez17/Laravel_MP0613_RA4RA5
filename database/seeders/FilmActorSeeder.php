<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmActorSeeder extends Seeder
{
    public function run(): void
    {
    $faker = Faker::create();

    for ($i = 0; $i < 10; $i++) {
        DB::table('actors')->insert([
            'name' => $faker->firstName,
            'surname' => $faker->lastName,
            'birthdate' => $faker->year,
            'country' => $faker->country,
            'img_url' => $faker->imageUrl(300, 300, 'people', true),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}

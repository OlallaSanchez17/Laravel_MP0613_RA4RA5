<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
            $faker = Faker::create();
            $lastInsertedId = DB::table("films")->max("discount_id");
            for ($i = $lastInsertedId; $i < $lastInsertedId+20; $i++) {
                DB::table("discounts")->insert(
                    [
                        "discount_id" => $i + 1,
                        "discount_amount" => $faker->randomFloat(2, 1, 100),
                        "start_date" => $faker->dateTimeBetween("-1 month", "now")->format('Y-m-d'),
                        "end_date" => $faker->dateTimeBetween("now", "+1 month")->format('Y-m-d'),
                    ]
                );
            }
    }
}
    
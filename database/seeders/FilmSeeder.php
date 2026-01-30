<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=10; $i<20; $i++){
            DB::table('films')->insert(array(
                "name" => "pelicula$i",
                "year" => 200$i, 
                "genre" => "Genero $i",
                "duration" => "10$i min", 
                "country" => "Pais $i",
                "img_url" => "img/cine$i.png"
            ));
        }
        $this->command->info("Mi tabla usuarios ha sido rellenada por defecto");
    }
}

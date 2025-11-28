<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    public static function readFilms(): array {
        $films = Storage::json('/public/films.json');
        return $films;
    }
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {        
        $old_films = [];
        if (is_null($year))
        $year = 2000;
    
        $title = "Listado de Pelis Antiguas (Antes de $year)";    
        $films = FilmController::readFilms();

        foreach ($films as $film) {
        //foreach ($this->datasource as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }
    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */

    //Listar por genero y año
    public function listFilmsByYear($year = null)
    {
        $films_filtered = [];
        $title = "Listado de películas por año";

        $films = FilmController::readFilms();

        if (is_null($year)) {
            $title = "Listado de todas las películas (sin filtrar por año)";
            return view("films.list", ["films" => $films, "title" => $title]);
        }

        foreach ($films as $film) {
            if ($film['year'] == $year) {
                $films_filtered[] = $film;
            }
        }

        $title = "Listado de películas del año $year";
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    public function listFilmsByGenre($genre = null)
    {
        $films_filtered = [];
        $title = "Listado de películas por género";

        $films = FilmController::readFilms();

        if (is_null($genre)) {
            $title = "Listado de todas las películas (sin filtrar por género)";
            return view("films.list", ["films" => $films, "title" => $title]);
        }

        foreach ($films as $film) {
            if (strtolower($film['genre']) == strtolower($genre)) {
                $films_filtered[] = $film;
            }
        }

        $title = "Listado de películas del género $genre";
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    //contar pelis
    public function countFilms()
    {
        $films = self::readFilms(); 
        $count = count($films);

        return "Total de películas registradas: $count";
    }

    //peliculas por año
    public function sortFilms()
    {
        $films = self::readFilms();

        usort($films, function($a, $b) {
            return $b['year'] <=> $a['year'];
        });

        $output = "Películas ordenadas por año (de más nueva a más antigua):\n\n";
        foreach ($films as $film) {
            $output .= $film['name'] . " — " . $film['year'] . "\n";
        }

        return nl2br($output);
    }
}

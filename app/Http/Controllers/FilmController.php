<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    public static function readFilms(): array
    {
        $jsonFile = __DIR__ . '/films.json';

        if (!file_exists($jsonFile)) {
            return [];
        }

        $films = json_decode(file_get_contents($jsonFile), true);

        return is_array($films) ? $films : [];
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

    public function listAllFilms()
    {
        $title = "Listado de todas las películas";
       
        $films = FilmController::readFilms();
 
        if (empty($films)) {
            $title = "No hay películas disponibles";
            return view("films.list", [
                "films" => [],
                "title" => $title
            ]);
        }
 
        return view("films.list", [
            "films" => $films,
            "title" => $title
        ]);
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
        $title = "Total de películas";

        return view('films.count', [ 'count' => $count, 'title' => $title]);     
    }

    //peliculas por año
    public function sortFilms()
    {
        $films_sort = [];
        $films = self::readFilms();

        usort($films, function($a, $b) {
            return $b['year'] <=> $a['year'];
        });


        $films_sort = $films;
        $title = "Peliculas ordenadas";
        return view("films.list", ["films" => $films_sort, "title" => $title]);
    }

    public function createFile(Request $request ){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = __DIR__ . '/uploads/';
    $jsonFile = __DIR__ . '/films.json'; 

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $films = [];
    if (file_exists($jsonFile)) {
        $films = json_decode(file_get_contents($jsonFile), true);
    }

    foreach ($films as $film) {
        if (strcasecmp($film['name'], $_POST['name']) === 0) {
            return view('welcome', [
                'error' => 'La película ya existe en la lista'
            ]);
        }
    }

    $targetFile = $_POST['img_url'];

    $year = (int)$_POST['year'];
    if ($year < 1900 || $year > 2024) {
        \Log::error("Attempted to add film with invalid year: $year");
        return view('welcome', [
            'error' => 'El año de la película debe estar entre 1900 y 2024'
        ]);
    }

    $newFilm = [
        'name' => $_POST['name'],
        'year' => $year,
        'genre' => $_POST['genre'],
        'country' => $_POST['country'],
        'duration' => $_POST['duration'],
        'img_url' => $targetFile
    ];

    $films[] = $newFilm;

    $saved = file_put_contents($jsonFile, json_encode($films, JSON_PRETTY_PRINT));

    if ($saved == false) {
        return view('welcome', ['error' => 'Error saving the film list']);
    }

    return $this->listAllFilms();
    }   
    }
}


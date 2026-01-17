<!DOCTYPE html>
<html lang="en">
@include('partials.header')

@yield('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">

    <!-- Include any additional stylesheets or scripts here -->
</head>

<body class="container">

    <h1 class="mt-4">Lista de Peliculas</h1>
    @if(isset($error))
        <div class="alert-popup" id="alertPopup">
            <span class="alert-text">{{ $error }}</span>
            <button class="alert-close" onclick="document.getElementById('alertPopup').style.display='none'"></button>
        </div>
    @endif
    <ul>
        <li><a href=/filmout/oldFilms>Pelis antiguas</a></li>
        <li><a href=/filmout/newFilms>Pelis nuevas</a></li>
        <li><a href=/filmout/allFilms>Pelis</a></li>

        {{-- listar por genero y año --}}
        <li><a href="/filmout/filmsByYear">Pelis por año</a></li>
        <li><a href="/filmout/filmsByGenre">Pelis por género</a></li>

        {{-- contar peliculas --}}
        <li><a href="/filmout/countFilms">Contador de Películas</a></li>

        {{-- peliculas ordenadas por años  --}}
        <li><a href="/filmout/sortFilms">Películas Ordenadas</a></li>

    </ul>
    <!-- Include any additional HTML or Blade directives here -->

    <div class="mt-4 mb-4">
        <form action="{{ route('filmin.addFilm') }}" method="POST" enctype="multipart/form-data" class="mt-4 mb-4">
            @csrf
            <div class="form-group mr-2">
                <label for="name" class="mr-2">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name"
                    placeholder="Nombre de la película" required>
            </div>

            <div class="form-group mr-2">
                <label for="year" class="mr-2">Año:</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="Año" required
                    min="1000" max="9999"
                    oninput="if(this.value.length > 4) this.value = this.value.slice(0,4);">
            </div>

            <div class="form-group mr-2">
                <label for="genre" class="mr-2">Género:</label>
                <input type="text" class="form-control" id="genre" name="genre" placeholder="Género" required>
            </div>

            <div class="form-group mr-2">
                <label for="country" class="mr-2">País:</label>
                <input type="text" class="form-control" id="country" name="country" placeholder="País" required>
            </div>

            <div class="form-group mr-2">
                <label for="duration" class="mr-2">Duración:</label>
                <input type="text" class="form-control" id="duration" name="duration"
                    placeholder="Duración (ej. 120 minutos)" required>
            </div>

            <div class="form-group mr-2">
                <label for="img_url" class="mr-2">URL de la imagen:</label>
                <input type="url" class="form-control" id="img_url" name="img_url"
                    placeholder="https://ejemplo.com/imagen.jpg" required>
            </div>
            <button type="submit" class="btn btn-success mt-2">Añadir Película</button>
        </form>
    </div>
    @include('partials.footer')

    @yield('content')


    <!-- Add Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

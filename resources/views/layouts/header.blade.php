<header class="headerPrincipal">
    <a href="#mainContent" class="skipLink">Saltar al contenido principal</a>

    <nav class="navPrincipal contenedor">
        <div class="navContenedor">
            <a class="navLogo" href="{{ url('/biblioteca') }}">Biblioteca DAW</a>

            <button class="btnMenu" id="btnMenu" aria-expanded="false"><i class="bi bi-list"></i></button>

            <ul class="navLista" id="navLista">
                <li class="navItem"><a href="{{ url('/biblioteca') }}" class="navEnlace">Inicio</a></li>
                <li class="navItem"><a href="{{ url('/catalogo') }}" class="navEnlace">Catálogo</a></li>
                <li class="navItem"><a href="{{ url('/actividades') }}" class="navEnlace">Actividades</a></li>
                <li class="navItem"><a href="{{ url('/contacto') }}" class="navEnlace">Contacto</a></li>
                <li class="navItem"><a href="{{ url('/login') }}" class="navEnlace">Login</a></li>
                <li class="navItem"><a href="{{ url('/registro') }}" class="navEnlace">Registro</a></li>
            </ul>

            <form class="navBuscador" role="search" method="GET" action="{{ url('/buscar') }}">
                <input class="inputBuscador" type="search" placeholder="Buscar libro..." aria-label="Buscar libro" name="query">
                <button class="btn-base btn-primario" type="submit">Buscar</button>
            </form>
        </div>
    </nav>
</header>
<header>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/biblioteca') }}"> Biblioteca DAW</a>
            <ul class="nav d-flex justify-content-evenly align-items-center w-50">
                <li class="nav-item"><a href="{{ url('/biblioteca') }}" class="nav-link text-dark">Inicio</a></li>
                <li class="nav-item"><a href="{{ url('/catalogo') }}" class="nav-link text-dark">Catálogo</a></li>
                <li class="nav-item"><a href="{{ url('/actividades') }}" class="nav-link text-dark">Actividades</a></li>
                <li class="nav-item"><a href="{{ url('/contacto') }}" class="nav-link text-dark">Contacto</a></li>
                <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link text-dark">Login</a></li>
                <li class="nav-item"><a href="{{ url('/registro') }}" class="nav-link text-dark">Registro</a></li>
            </ul>
            <form class="d-flex" role="search" method="GET" action="{{ url('/buscar') }}">
                <input class="form-control me-2" type="search" placeholder="Buscar libro..." aria-label="Search"
                    name="q" />
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
        </div>
    </nav>
</header>
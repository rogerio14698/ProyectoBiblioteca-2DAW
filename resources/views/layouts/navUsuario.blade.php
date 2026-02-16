<nav>
    <div class="logo_y_fotoPerfil">
        <img src="" alt="Logo de la Biblioteca DAW">
        <img src="" alt="Foto de perfil del usuario">
        <p>Aqui va el logo + la foto de pergil del usuario</p>
    </div>
    <ul class="nav-perfil">
        <li><a href="{{ route('usuario.perfil') }}">Perfil</a></li>
        <li><a href="{{ route('usuario.alquilar') }}">Alquilar</a></li>
        <li><a href="{{ route('usuario.comprar') }}">Comprar</a></li>
        <li><a href="{{ route('usuario.organizarEvento') }}">Organizar Evento</a></li>
        <li>
            <form method="POST" action="{{ route('usuario.logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>
    </ul>
</nav>
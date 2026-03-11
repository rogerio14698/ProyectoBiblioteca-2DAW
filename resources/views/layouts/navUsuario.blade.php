<nav class="nav-usuarioAutenticado">
    <div class="logo_y_fotoPerfil">
        <img src="" alt="Logo_Biblioteca DAW">
        <img src="" alt="Foto_perfil_usuario {{ Auth::user()->name }}">
        <p>Aqui va el logo + la foto de perfil del usuario</p>
    </div>
    <div class="nav-perfil">
        <ul class="nav-links">
        <li><a href="{{ route('usuario.perfil') }}">Perfil</a></li>
        <li><a href="{{ route('usuario.alquilar') }}">Alquilar</a></li>
        <li><a href="{{ route('usuario.comprar') }}">Comprar</a></li>
        <li><a href="{{ route('usuario.organizarEvento') }}">Organizar Evento</a></li>
        <li>
            <form method="POST" action="{{ route('usuario.logout') }}">
                @csrf
                <button type="submit" class="btn-base btn-logout">Logout</button>
            </form>
        </li>
    </ul>
    </div>
</nav>
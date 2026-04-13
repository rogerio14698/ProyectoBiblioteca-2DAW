<nav class="nav-usuarioAutenticado">
    <div class="logoYperfil">
        <a href="{{ route('usuario.inicio') }}"><img src="{{ asset('img/logoDAW-conTransparencia.png') }}" alt="Logo_Biblioteca DAW" class="foto-logoDAW" width="40" height="40"></a>
        <a href="{{ route('usuario.perfil') }}"><img src="{{ Auth::user()->profile_photo_url ?? asset('img/default.png') }}" alt="Foto_perfil_usuario {{ Auth::user()->name }}" class="foto-perfilNavUsuario" width="40" height="40"></a>

    </div>
    <div class="nav-perfil">
        <ul class="nav-links">
            <li><a href="{{ route('usuario.inicio') }}">Inicio</a></li>
        <li><a href="{{ route('usuario.perfil') }}">Perfil</a></li>
        <li><a href="{{ route('usuario.perfilEditar') }}">Editar Perfil</a></li>
        <li><a href="{{ route('usuario.prestamos') }}">Préstamos</a></li>
        <li><a href="{{ route('usuario.alquilar') }}">Alquilar</a></li>
        <li><a href="{{ route('usuario.comprar') }}">Comprar</a></li>
        <li><a href="{{ route('usuario.publicar') }}">Publicar</a></li>
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
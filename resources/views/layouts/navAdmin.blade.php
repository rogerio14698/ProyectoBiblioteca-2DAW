<nav class="navAdmin">
    <div class="navContenidoWeb">
        <input type="checkbox" id="menu-toggle" class="menu-checkbox">
        <label for="menu-toggle" class="menu-button"><span>☰</span> Menu Contenido Web</label>
        <ul class="menu-items">
            <li>
                <h3>Gestionar Home</h3>
                <ul class="sub-menu-items">
                    <li><a href="{{ route('admin.gestionHome') }}">Gestionar Home</a></li>
                    <li><a href="{{ route('admin.gestionAgenda') }}">Gestionar Agenda</a></li>
                    <li><a href="{{ route('admin.gestionCarrusel') }}">Carrusel Home</a></li>
                    <li><a href="{{ route('admin.gestionNoticias') }}">Noticias</a></li>
                </ul>
                <h3>Contenido Fijos</h3>
            <li><a href="{{ route('admin.gestionHeader') }}">Header y Footer</a></li>
            </li>
            <h3>Otros contenidos</h3>
            <li>
                <ul>
                    <li><a href="{{ route('admin.gestionCatalogo') }}">Contenido Catálogo</a></li>
                    <li><a href="{{ route('admin.gestionActividades') }}">Contenido Actividades</a></li>
                    <li><a href="{{ route('admin.gestionServicios') }}">Contenido Servicios Digitales</a></li>
                    <li><a href="{{ route('admin.gestionContacto') }}">Contenido Contacto</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--Fin de contenido web -->
    <div class="navContenidoUsuario">
        <input type="checkbox" id="menu-toggle-usuario" class="menu-checkbox">
        <label for="menu-toggle-usuario" class="menu-button"><span>☰</span> Menu Contenido Usuarios</label>
        <ul class="menu-items">
            <li>
                <h3>Gestión de Usuarios</h3>
                <ul>
                    <li><a href="{{ route('admin.gestionUsuarios') }}">Usuarios Registrados</a></li>
                    <li><a href="{{ route('admin.gestionSanciones') }}">Sanciones</a></li>
                    <li><a href="{{ route('admin.gestionRoles') }}">Roles y Permisos</a></li>
                </ul>
            </li>
            <li>
                <h3>Gestión de Reservas</h3>
                <ul>
                    <li><a href="{{ route('admin.reservasActivas') }}">Reservas Activas</a></li>
                    <li><a href="{{ route('admin.historialReservas') }}">Historial de Reservas</a></li>
                    <li><a href="{{ route('admin.gestionarCancelaciones') }}">Cancelaciones</a></li>
                    <li><a href="{{ route('admin.publicacionesUser') }}">Publicaciones</a></li>
                </ul>
            </li>
            <!-- Agrega más enlaces según las funcionalidades que quieras ofrecer -->
        </ul>
    </div>
    <!--Fin de contenido usuarios -->

    <div class="navContenidoLibro">
        <input type="checkbox" id="menu-toggle-libro" class="menu-checkbox">
        <label for="menu-toggle-libro" class="menu-button"><span>☰</span> Menu Contenido Libros</label>
        <ul class="menu-items">
            <h1>Gestión de Libros</h1>
            <li><a href="{{ route('admin.inventario') }}">Inventario</a></li>
            <li><a href="{{ route('admin.librosPerdidos') }}">Libros Perdidos</a></li>
            <li><a href="{{ route('admin.librosNuevos') }}">Libros Nuevos</a></li>
            <li><a href="{{ route('admin.librosPrestados') }}">Libros Prestados</a></li>
        </ul>
    </div>
    <!--Fin de contenido libros -->
    <div class="navContenidoSesion">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Cerrar sesión</button>
        </form>
    </div>
</nav>
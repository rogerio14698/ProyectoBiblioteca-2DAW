<nav class="navAdmin">
    <div class="navContenidoWeb">
        <input type="checkbox" id="menu-toggle" class="menu-checkbox">
        <label for="menu-toggle" class="menu-button"><span>☰</span> Menu Contenido Web</label>
        <ul class="menu-items">
            <li>
                <a href="#">Contenido Principal</a>
                <ul class="sub-menu-items">
                    <li><a href="#">Noticias o Destacados</a></li>
                    <li><a href="#">Avisos Importantes</a></li>
                    <li><a href="#">Horarios</a></li>
                </ul>
            </li>
            <li><a href="#">Contenido Catálogo</a></li>
            <li><a href="#">Contenido Actividades</a></li>
            <li><a href="#">Contenido Servicios Digitales</a></li>
            <li><a href="#">Contenido Contacto</a></li>
        </ul>
    </div>
    <!--Fin de contenido web -->
    <div class="navContenidoUsuario">
        <input type="checkbox" id="menu-toggle-usuario" class="menu-checkbox">
        <label for="menu-toggle-usuario" class="menu-button"><span>☰</span> Menu Contenido Usuarios</label>
        <ul class="menu-items">
            <li><a href="#">Gestionar Libros</a></li>
            <li><a href="#">Gestionar Usuarios</a></li>
            <li><a href="#">Gestionar Préstamos</a></li>
            <li><a href="#">Gestionar Inventario</a></li>
            <li><a href="#">Gestionar Reservas</a></li>
            <li><a href="#">Gestionar Publicaciones</a></li>
            <li><a href="#">Gestionar Devoluciones</a></li>
            <li><a href="#">Gestionar Sanciones</a></li>
            <!-- Agrega más enlaces según las funcionalidades que quieras ofrecer -->
        </ul>
    </div>
    <!--Fin de contenido usuarios -->

    <div class="navContenidoLibro">
        <input type="checkbox" id="menu-toggle-libro" class="menu-checkbox">
        <label for="menu-toggle-libro" class="menu-button"><span>☰</span> Menu Contenido Libros</label>
        <ul class="menu-items">
            <li><a href="#">Gestionar Libros Perdidos</a></li>
            <li><a href="#">Gestionar Libros Encontrados</a></li>
            <li><a href="#">Gestionar Libros Nuevos</a></li>
            <li><a href="#">Inventario de Libros</a></li>
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
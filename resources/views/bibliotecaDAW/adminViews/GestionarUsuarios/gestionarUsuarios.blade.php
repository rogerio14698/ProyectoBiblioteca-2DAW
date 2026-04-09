@extends('layouts.app')

@section('title', 'Gestionar Usuarios')

@section('content')
    <!-- Contenedor principal de la página de gestión de usuarios -->
    <main class="contenedor gestionUsuarios">

        <!-- Título principal de la sección -->
        <div class="gestionUsuariosEncabezado">
            <h1>Gestionar Usuarios</h1>
            <p>Desde aquí puedes gestionar los usuarios de la Biblioteca DAW.</p>
        </div>

        <!-- Mensajes flash de éxito o error tras una operación -->
        @if (session('success'))
            <div class="alertaExito">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alertaError">{{ session('error') }}</div>
        @endif

        <!-- ========== BUSCADOR DE USUARIOS ========== -->
        <form action="{{ route('admin.gestionUsuarios') }}" method="GET" class="gestionUsuariosBuscador">
            <h2>Buscar Usuarios</h2>
            <div class="gestionUsuariosFiltros">
                <!-- Filtro por nombre -->
                <div class="gestionUsuariosGrupoFiltro">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                        value="{{ request('nombre') }}"
                        placeholder="Nombre del usuario">
                </div>
                <!-- Filtro por nº socio -->
                <div class="gestionUsuariosGrupoFiltro">
                    <label for="nSocio">Nº Socio</label>
                    <input type="text" id="nSocio" name="nSocio"
                        value="{{ request('nSocio') }}"
                        placeholder="Nº Socio">
                </div>
                <!-- Filtro por DNI -->
                <div class="gestionUsuariosGrupoFiltro">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" name="dni"
                        value="{{ request('dni') }}"
                        placeholder="DNI">
                </div>
                <!-- Filtro por correo electrónico -->
                <div class="gestionUsuariosGrupoFiltro">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email"
                        value="{{ request('email') }}"
                        placeholder="correo@ejemplo.com">
                </div>
            </div>
            <div class="gestionUsuariosBotonesFiltr">
                <button class="btn-base btn-primario" type="submit">Buscar</button>
                <a href="{{ route('admin.gestionUsuarios') }}" class="btn-base btn-amarillo">Limpiar</a>
            </div>
        </form>

        <!-- ========== LAYOUT: FORMULARIO EDICIÓN + LISTADO ========== -->
        <div class="gestionUsuariosLayout">

            <!-- ========== COLUMNA IZQUIERDA: FORMULARIO DE EDICIÓN ========== -->
            @if (isset($usuarioEditar) && $usuarioEditar)
                <div class="gestionUsuariosFormulario">
                    <form action="{{ route('admin.gestionUsuarios.update', $usuarioEditar->id) }}" method="POST" class="gestionUsuariosFormInner">
                        @csrf
                        @method('PUT')
                        <h2>Editar Usuario #{{ $usuarioEditar->id }}</h2>

                        <!-- Campo: Nombre -->
                        <div class="gestionUsuariosGrupoForm">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $usuarioEditar->name) }}" required>
                            @error('name')
                                <span class="gestionUsuariosError">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Email -->
                        <div class="gestionUsuariosGrupoForm">
                            <label for="editEmail">Correo Electrónico</label>
                            <input type="email" id="editEmail" name="email"
                                value="{{ old('email', $usuarioEditar->email) }}" required>
                            @error('email')
                                <span class="gestionUsuariosError">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: DNI -->
                        <div class="gestionUsuariosGrupoForm">
                            <label for="editDni">DNI</label>
                            <input type="text" id="editDni" name="dni"
                                value="{{ old('dni', $usuarioEditar->dni) }}" required>
                            @error('dni')
                                <span class="gestionUsuariosError">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Campo: Móvil -->
                        <div class="gestionUsuariosGrupoForm">
                            <label for="editMovil">Teléfono Móvil</label>
                            <input type="text" id="editMovil" name="movil"
                                value="{{ old('movil', $usuarioEditar->movil) }}">
                        </div>

                        <!-- Info: Nº Socio (solo lectura) -->
                        <div class="gestionUsuariosGrupoForm">
                            <label>Nº Socio</label>
                            <input type="text" value="{{ $usuarioEditar->nSocio }}" disabled>
                        </div>

                        <!-- Botones del formulario -->
                        <button class="gestionUsuariosBotonEnvio" type="submit">Actualizar Usuario</button>
                        <a href="{{ route('admin.gestionUsuarios') }}" class="btn-base btn-amarillo gestionUsuariosBtnCancelar">Cancelar Edición</a>
                    </form>
                </div>
            @endif

            <!-- ========== COLUMNA DERECHA (o completa): LISTADO DE USUARIOS ========== -->
            <div class="gestionUsuariosListado">
                <h2>Usuarios Registrados ({{ $usuarios->count() }})</h2>

                <!-- Contenedor con scroll para las tarjetas de usuarios -->
                <div class="gestionUsuariosCards">
                    @forelse ($usuarios as $usuario)
                        <!-- Tarjeta individual de usuario -->
                        <article class="usuarioCard">
                            <div class="usuarioCardInfo">
                                <!-- Cabecera: ID + nombre + nº socio -->
                                <div class="usuarioCardCabecera">
                                    <span class="usuarioCardId">#{{ $usuario->id }}</span>
                                    <h3 class="usuarioCardNombre">{{ $usuario->name }}</h3>
                                    @if ($usuario->nSocio)
                                        <span class="usuarioCardSocio">{{ $usuario->nSocio }}</span>
                                    @endif
                                </div>

                                <!-- Datos del usuario -->
                                <div class="usuarioCardMeta">
                                    <span class="usuarioCardMetaItem">📧 {{ $usuario->email }}</span>
                                    @if ($usuario->dni)
                                        <span class="usuarioCardMetaItem">🪪 {{ $usuario->dni }}</span>
                                    @endif
                                    @if ($usuario->movil)
                                        <span class="usuarioCardMetaItem">📱 {{ $usuario->movil }}</span>
                                    @endif
                                    <span class="usuarioCardMetaItem">📅 {{ $usuario->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="usuarioCardAcciones">
                                <!-- Enlace de edición: redirige a la misma vista con ?edit=ID -->
                                <a href="{{ route('admin.gestionUsuarios', ['edit' => $usuario->id]) }}"
                                    class="btn-base btn-azul btnEditarUsuario">Editar</a>

                                <!-- Formulario de eliminación con confirmación JS -->
                                <form action="{{ route('admin.gestionUsuarios.destroy', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-base btn-rojo btnEliminarUsuario" type="submit"
                                        onclick="return confirm('¿Estás seguro de dar de baja a {{ $usuario->name }}?')">
                                        Dar de Baja
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <!-- Mensaje cuando no hay usuarios -->
                        <p class="usuarioCardVacio">No se encontraron usuarios con los filtros aplicados.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- ========== SECCIÓN: LISTADO DE ADMINISTRADORES ========== -->
        <div class="gestionAdminsSeccion">
            <h2>Administradores del Sistema ({{ $admins->count() }})</h2>

            <div class="gestionAdminsCards">
                @forelse ($admins as $admin)
                    <!-- Tarjeta individual de administrador -->
                    <article class="adminCard">
                        <div class="adminCardInfo">
                            <div class="adminCardCabecera">
                                <span class="adminCardId">#{{ $admin->id }}</span>
                                <h3 class="adminCardNombre">{{ $admin->name }}</h3>
                                <!-- Badge del rol del administrador -->
                                <span class="adminCardRol adminCardRol--{{ $admin->rol }}">
                                    {{ ucfirst($admin->rol) }}
                                </span>
                            </div>
                            <div class="adminCardMeta">
                                <span class="adminCardMetaItem">📧 {{ $admin->email }}</span>
                                @if ($admin->last_login)
                                    <span class="adminCardMetaItem">🕐 Último login: {{ \Carbon\Carbon::parse($admin->last_login)->format('d/m/Y H:i') }}</span>
                                @endif
                                @if ($admin->is_demo)
                                    <span class="adminCardMetaItemDemo">🔒 Cuenta Demo</span>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="adminCardVacio">No hay administradores registrados.</p>
                @endforelse
            </div>
        </div>

    </main>
@endsection

@extends('layouts.admin')

@section('title', 'Gestionar usuarios')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Gestionar usuarios</h1><p class="a-subtitulo">Consulta socios, datos de contacto y accesos al sistema.</p></div></header>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Buscar usuarios</h2></div></header>
<form action="{{ route('admin.gestionUsuarios') }}" method="GET" class="a-form">
            <div class="a-form__fila a-form__fila--3">
                <div class="a-campo">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                        value="{{ request('nombre') }}"
                        placeholder="Nombre del usuario">
                </div>
                <div class="a-campo">
                    <label for="nSocio">Nº Socio</label>
                    <input type="text" id="nSocio" name="nSocio"
                        value="{{ request('nSocio') }}"
                        placeholder="Nº Socio">
                </div>
                <div class="a-campo">
                    <label for="dni">DNI</label>
                    <input type="text" id="dni" name="dni"
                        value="{{ request('dni') }}"
                        placeholder="DNI">
                </div>
                <div class="a-campo">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                        value="{{ request('email') }}"
                        placeholder="correo@ejemplo.com">
                </div>
            </div>
            <div class="a-form__acciones">
                <button class="a-boton a-boton--primario" type="submit">Buscar</button>
                <a href="{{ route('admin.gestionUsuarios') }}" class="a-boton a-boton--fantasma">Limpiar</a>
            </div>
        </form>
</section>
@if (isset($usuarioEditar) && $usuarioEditar)
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Editar usuario #{{ $usuarioEditar->id }}</h2></div></header>
<form action="{{ route('admin.gestionUsuarios.update', $usuarioEditar->id) }}" method="POST" class="a-form">
                        @csrf
                        @method('PUT')

                        <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $usuarioEditar->name) }}" required>
                            @error('name')
                                <span class="a-campo__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="a-campo">
                            <label for="editEmail">Correo electrónico</label>
                            <input type="email" id="editEmail" name="email"
                                value="{{ old('email', $usuarioEditar->email) }}" required>
                            @error('email')
                                <span class="a-campo__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="a-campo">
                            <label for="editDni">DNI</label>
                            <input type="text" id="editDni" name="dni"
                                value="{{ old('dni', $usuarioEditar->dni) }}" required>
                            @error('dni')
                                <span class="a-campo__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="a-campo">
                            <label for="editMovil">Teléfono móvil</label>
                            <input type="text" id="editMovil" name="movil"
                                value="{{ old('movil', $usuarioEditar->movil) }}">
                        </div>

                        <div class="a-campo">
                            <label>Nº Socio</label>
                            <input type="text" value="{{ $usuarioEditar->nSocio }}" disabled>
                        </div>


</div>
<div class="a-form__acciones"><button class="a-boton a-boton--primario" type="submit">Actualizar usuario</button>
                        <a href="{{ route('admin.gestionUsuarios') }}" class="a-boton a-boton--fantasma gestionUsuariosBtnCancelar">Cancelar edición</a>

</div>
</form>
</section>
@endif
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Usuarios registrados ({{ $usuarios->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Usuarios registrados"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col" class="a-num">ID</th>
    <th scope="col">Usuario</th>
    <th scope="col">Nº de socio</th>
    <th scope="col">Correo electrónico</th>
    <th scope="col">DNI</th>
    <th scope="col">Móvil</th>
    <th scope="col">Alta</th>
    <th scope="col">Acciones</th></tr></thead><tbody>
@forelse ($usuarios as $usuario)<tr><td class="a-num">{{ $usuario->id }}</td>
    <td><div class="a-tabla__identidad"><strong>{{ $usuario->name }}</strong></div></td>
    <td>{{ $usuario->nSocio ?: '—' }}</td>
    <td>{{ $usuario->email }}</td>
    <td>{{ $usuario->dni ?: '—' }}</td>
    <td>{{ $usuario->movil ?: '—' }}</td>
    <td class="a-fecha">{{ $usuario->created_at->format('d/m/Y') }}</td>
    <td><div class="a-acciones-fila">
                                <a href="{{ route('admin.gestionUsuarios', ['edit' => $usuario->id]) }}"
                                    class="a-boton btnEditarUsuario">Editar</a>

                                <form class="a-form" action="{{ route('admin.gestionUsuarios.destroy', $usuario->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="a-boton a-boton--peligro btnEliminarUsuario" type="submit"
                                        onclick="return confirm('¿Estás seguro de dar de baja a {{ $usuario->name }}?')">
                                        Dar de baja
                                    </button>
                                </form>
                            </div></td></tr>
@empty<tr><td colspan="8"><p class="a-vacio">No se encontraron usuarios con los filtros aplicados.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Administradores del sistema ({{ $admins->count() }})</h2></div></header>
<div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Administrador"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Administrador</th>
    <th scope="col">Correo electrónico</th>
    <th scope="col">Rol</th>
    <th scope="col">Último acceso</th>
    <th scope="col">Cuenta</th></tr></thead><tbody>
@forelse ($admins as $admin)<tr><td><div class="a-tabla__identidad"><div><strong>{{ $admin->name }}</strong><span>#{{ $admin->id }}</span></div></div></td>
    <td>{{ $admin->email }}</td>
    <td><span class="a-pill">{{ ucfirst($admin->rol) }}</span></td>
    <td class="a-fecha">{{ $admin->last_login ? \Carbon\Carbon::parse($admin->last_login)->format('d/m/Y H:i') : '—' }}</td>
    <td>@if ($admin->is_demo)<span class="a-pill a-pill--aviso">Demo</span>@else<span class="a-muted">Estándar</span>@endif</td></tr>
@empty<tr><td colspan="5"><p class="a-vacio">No hay administradores registrados.</p></td></tr>
@endforelse
</tbody></table></div>
</section>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Gestionar publicaciones')

@section('content')
<div class="a-vista-admin">
    <header class="a-titulo"><div><h1>Gestionar publicaciones</h1><p class="a-subtitulo">Publicaciones de usuarios escritores y del equipo de la biblioteca.</p></div></header>
<dl class="a-kpis a-kpis--cinco"><div><dt>Publicaciones</dt><dd>{{ $resumen['total'] }}</dd></div><div><dt>De usuarios</dt><dd>{{ $resumen['usuarios'] }}</dd></div><div><dt>De administración</dt><dd>{{ $resumen['admin'] }}</dd></div><div><dt>Autores profesionales</dt><dd>{{ $resumen['profesional'] }}</dd></div><div><dt>Autores por afición</dt><dd>{{ $resumen['aficion'] }}</dd></div></dl><section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Nueva publicación</h2><p>Solo se admiten archivos PDF, de hasta 10 MB.</p></div></header>
<form action="{{ route('admin.publicacionesUser.store') }}" method="POST" enctype="multipart/form-data" class="a-form">
                    @csrf

                    <div class="a-form__fila a-form__fila--3">
<div class="a-campo">
                        <label for="publicado_por">Tipo de publicación</label>
                        <select id="publicado_por" name="publicado_por" required>
                            <option value="usuario" {{ old('publicado_por', 'usuario') === 'usuario' ? 'selected' : '' }}>Publicar como usuario escritor</option>
                            <option value="admin" {{ old('publicado_por') === 'admin' ? 'selected' : '' }}>Publicar como administrador</option>
                        </select>
                    </div>

                    <div class="a-campo">
                        <label for="usuario_id">Usuario escritor verificado</label>
                        <select id="usuario_id" name="usuario_id">
                            <option value="">Seleccionar usuario...</option>
                            @foreach ($usuariosEscritores as $usuario)
                                <option value="{{ $usuario->id }}" {{ (string) old('usuario_id') === (string) $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->nSocio }}) - {{ ucfirst($usuario->tipo_escritor) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="a-campo__ayuda">Este campo es obligatorio cuando se publica como usuario.</p>
                        @error('usuario_id')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="nombre_libro">Libro o ensayo asociado</label>
                        <input type="text" id="nombre_libro" name="nombre_libro" value="{{ old('nombre_libro') }}" placeholder="Ej: Don Quijote, Ensayo sobre la ceguera..." required>
                        <p class="a-campo__ayuda">Escribe el nombre del libro o ensayo. Puede ser externo a la biblioteca.</p>
                        @error('nombre_libro')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="titulo_publicacion">Título de la publicación</label>
                        <input type="text" id="titulo_publicacion" name="titulo_publicacion" value="{{ old('titulo_publicacion') }}" required>
                        @error('titulo_publicacion')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="resumen_publicacion">Resumen de lo publicado</label>
                        <textarea id="resumen_publicacion" name="resumen_publicacion" required>{{ old('resumen_publicacion') }}</textarea>
                        @error('resumen_publicacion')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="a-campo">
                        <label for="archivo_publicacion">Archivo de publicación</label>
                        <input type="file" id="archivo_publicacion" name="archivo_publicacion" accept=".pdf" required>
                        <p class="a-campo__ayuda">No se permite publicar texto plano en web. Máximo 10MB.</p>
                        @error('archivo_publicacion')
                            <span class="a-campo__error">{{ $message }}</span>
                        @enderror
                    </div>


</div>
<div class="a-form__acciones"><button type="submit" class="a-boton a-boton--primario">Guardar publicación</button>

</div>
</form>
</section>
<section class="a-tarjeta"><header class="a-tarjeta__cabecera"><div><h2>Publicaciones por autor</h2></div></header>
@php
    $agrupadas = $publicaciones->groupBy(function ($publicacion) {
        if ($publicacion->publicado_por === 'admin') {
            return 'admin_' . ($publicacion->admin_id ?? 'sin_admin');
        }
        return 'usuario_' . ($publicacion->usuario_id ?? 'sin_usuario');
    });
@endphp
@forelse ($agrupadas as $claveGrupo => $itemsGrupo)
    @php $primera = $itemsGrupo->first(); @endphp
    <section class="a-grupo-tabla">
        <header class="a-tarjeta__cabecera"><div>
            @if ($primera->publicado_por === 'admin')
                <h3>Administrador: {{ $primera->admin->name ?? 'Administrador no disponible' }}</h3><p>Publicaciones institucionales</p>
            @else
                <h3>Usuario: {{ $primera->usuario->name ?? 'Usuario no disponible' }}</h3><p>Nº de socio: {{ $primera->usuario->nSocio ?? 'Sin dato' }} · Tipo de escritor: {{ ucfirst($primera->usuario->tipo_escritor ?? 'No definido') }}</p>
            @endif
        </div></header>
        <div class="a-tabla-envoltura" tabindex="0" role="region" aria-label="Tabla: Publicación"><table class="a-tabla a-tabla--gestion"><thead>
<tr><th scope="col">Publicación</th>
    <th scope="col">Libro o ensayo</th>
    <th scope="col">Tipo de autor</th>
    <th scope="col">Resumen</th>
    <th scope="col">Publicada</th>
    <th scope="col">Archivo</th></tr></thead><tbody>
@foreach ($itemsGrupo as $publicacion)<tr><td><div class="a-tabla__identidad"><strong>{{ $publicacion->titulo_publicacion }}</strong></div></td>
    <td>{{ $publicacion->nombre_libro }}</td>
    <td><span class="a-pill">@if ($publicacion->publicado_por === 'admin')Admin @elseif (($publicacion->usuario->tipo_escritor ?? null) === 'profesional')Profesional @else Afición @endif</span></td>
    <td class="a-texto-tabla"><div>{{ $publicacion->resumen_publicacion }}</div></td>
    <td class="a-fecha">{{ optional($publicacion->fecha_publicacion)->format('d/m/Y H:i') }}</td>
    <td><a class="a-boton" href="{{ asset('storage/' . $publicacion->archivo_ruta) }}" target="_blank" rel="noopener">{{ $publicacion->archivo_original }}</a></td></tr>@endforeach
</tbody></table></div>
    </section>
@empty<p class="a-vacio">Todavía no hay publicaciones registradas.</p>@endforelse
</section>
</div>
@endsection

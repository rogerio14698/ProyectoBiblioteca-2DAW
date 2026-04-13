@extends('layouts.app')

@section('title', 'Alquilar: ' . $libro->titulo)

@section('content')

    <section class="alquilarInterno separador">

        {{-- Dos columnas: resumen del libro (izq) + formulario o aviso (der) --}}
        <div class="alquilarInternoGrid">

            {{-- Columna izquierda: ficha del libro que se va a alquilar --}}
            <article class="alquilarInternoFicha">
                <div class="alquilarInternoPortada">
                    <img src="{{ $libro->portada_url }}" alt="Portada de {{ $libro->titulo }}" class="alquilarInternoImg"
                        width="200" height="300">
                </div>
                <div class="alquilarInternoDetalles">
                    <h1 class="alquilarInternoTitulo">{{ $libro->titulo }}</h1>
                    <p class="alquilarInternoAutor">{{ $libro->autor }}</p>

                    <div class="alquilarInternoDatos">
                        <div class="alquilarInternoDato">
                            <span class="alquilarInternoDatoLabel">Editorial</span>
                            <span class="alquilarInternoDatoValor">{{ $libro->editorial }}</span>
                        </div>
                        <div class="alquilarInternoDato">
                            <span class="alquilarInternoDatoLabel">ISBN</span>
                            <span class="alquilarInternoDatoValor">{{ $libro->isbn }}</span>
                        </div>
                        <div class="alquilarInternoDato">
                            <span class="alquilarInternoDatoLabel">Género</span>
                            <span class="alquilarInternoDatoValor">{{ $libro->genero }}</span>
                        </div>
                        <div class="alquilarInternoDato">
                            <span class="alquilarInternoDatoLabel">Año</span>
                            <span class="alquilarInternoDatoValor">{{ $libro->anio }}</span>
                        </div>
                    </div>

                    {{-- Estado del libro --}}
                    <div class="alquilarInternoEstado">
                        @if ($libro->disponibilidad === 'disponible')
                            <span class="alquilarInternoBadge alquilarInternoDisponible">
                                <i class="bi bi-check-circle-fill"></i> Disponible
                            </span>
                        @else
                            <span class="alquilarInternoBadge alquilarInternoNoDisponible">
                                <i class="bi bi-x-circle-fill"></i> Prestado
                            </span>
                        @endif
                        <span class="alquilarInternoEjemplares">
                            {{ $libro->cantidad_ejemplares }} {{ $libro->cantidad_ejemplares === 1 ? 'ejemplar' : 'ejemplares' }}
                        </span>
                    </div>
                </div>
            </article>

            {{-- Columna derecha: formulario de alquiler o aviso de login --}}
            <aside class="alquilarInternoAccion">

                @auth('web')
                    {{-- Usuario autenticado: formulario de alquiler --}}
                    <div class="alquilarInternoFormCard">
                        <div class="alquilarInternoFormHeader">
                            <i class="bi bi-shield-check"></i>
                            <h2 class="alquilarInternoFormTitulo">Solicitud de alquiler</h2>
                        </div>

                        <p class="alquilarInternoSaludo">
                            Hola, <strong>{{ Auth::user()->name }}</strong>. Confirma los datos para tu solicitud.
                        </p>

                        <form action="#" method="POST" class="alquilarInternoForm">
                            @csrf
                            <div class="alquilarInternoCampo">
                                <label for="fechaInicio">Fecha de recogida</label>
                                <input type="date" id="fechaInicio" name="fecha_inicio"
                                       min="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="alquilarInternoCampo">
                                <label for="fechaDevolucion">Fecha de devolución</label>
                                <input type="date" id="fechaDevolucion" name="fecha_devolucion"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>

                            <div class="alquilarInternoCampo">
                                <label for="formatoAlquiler">Formato preferido</label>
                                <select id="formatoAlquiler" name="formato">
                                    @if ($libro->formato === 'fisico' || $libro->formato === 'ambos')
                                        <option value="fisico">Físico</option>
                                    @endif
                                    @if ($libro->formato === 'digital' || $libro->formato === 'ambos')
                                        <option value="digital">Digital</option>
                                    @endif
                                </select>
                            </div>

                            {{-- Resumen visual: genera confianza al usuario --}}
                            <div class="alquilarInternoResumen">
                                <div class="alquilarInternoResumenItem">
                                    <i class="bi bi-book"></i>
                                    <span>{{ $libro->titulo }}</span>
                                </div>
                                <div class="alquilarInternoResumenItem">
                                    <i class="bi bi-currency-euro"></i>
                                    <span>Gratuito (préstamo bibliotecario)</span>
                                </div>
                                <div class="alquilarInternoResumenItem">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <span>Renovable hasta 2 veces</span>
                                </div>
                            </div>

                            @if ($libro->disponibilidad === 'disponible')
                                <button type="submit" class="btn-base btn-verde alquilarInternoBtn">
                                    <i class="bi bi-check2-circle"></i> Confirmar alquiler
                                </button>
                            @else
                                <p class="alquilarInternoNoDisponibleMsg">
                                    <i class="bi bi-info-circle"></i>
                                    Este libro no está disponible actualmente. Puedes añadirlo a tu lista de espera.
                                </p>
                                <button type="button" class="btn-base btn-azul alquilarInternoBtn">
                                    <i class="bi bi-bell"></i> Notificarme cuando esté disponible
                                </button>
                            @endif
                        </form>
                    </div>

                @else
                    {{-- Usuario no autenticado: invitación a iniciar sesión --}}
                    <div class="alquilarInternoLoginCard">
                        <i class="bi bi-lock alquilarInternoLockIcon"></i>
                        <h2 class="alquilarInternoLoginTitulo">Inicia sesión para alquilar</h2>
                        <p class="alquilarInternoLoginTexto">
                            Para solicitar el alquiler de este libro necesitas una cuenta de socio de la biblioteca.
                            El registro es gratuito y en menos de un minuto.
                        </p>
                        <div class="alquilarInternoLoginBotones">
                            <a href="{{ route('usuario.login.mostrar') }}" class="btn-base btn-verde alquilarInternoBtn">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                            </a>
                            <a href="{{ route('usuario.show') }}" class="btn-base btn-azul alquilarInternoBtn">
                                <i class="bi bi-person-plus"></i> Registrarse
                            </a>
                        </div>

                        {{-- Garantías para generar confianza --}}
                        <div class="alquilarInternoGarantias">
                            <div class="alquilarInternoGarantia">
                                <i class="bi bi-shield-lock"></i>
                                <span>Datos protegidos</span>
                            </div>
                            <div class="alquilarInternoGarantia">
                                <i class="bi bi-clock-history"></i>
                                <span>Proceso en 1 minuto</span>
                            </div>
                            <div class="alquilarInternoGarantia">
                                <i class="bi bi-gift"></i>
                                <span>100% gratuito</span>
                            </div>
                        </div>
                    </div>
                @endauth

            </aside>
        </div>

        {{-- Enlace para volver al catálogo --}}
        <div class="alquilarInternoVolver">
            <a href="{{ route('libro.paginaInterna', $libro->id) }}" class="btn-base btn-azul">
                <i class="bi bi-arrow-left"></i> Volver al libro
            </a>
        </div>

    </section>

@endsection
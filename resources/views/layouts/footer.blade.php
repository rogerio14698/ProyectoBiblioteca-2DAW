<footer class="pie">
    <div class="pie__tablero">
        <div class="baldosa baldosa--declaracion">
            <h2>{{ $footerConfig->titulo ?: 'Biblioteca DAW' }}</h2>
            <p class="baldosa__frase">Una biblioteca abierta para leer, aprender y encontrarse.</p>
            <p>{{ $footerConfig->direccion }}</p>
        </div>

        <nav class="baldosa baldosa--nav" aria-label="Pie de página">
            <h2>Explorar</h2>
            <ul>
                <li><a href="{{ url('/catalogo') }}">Catálogo</a></li>
                <li><a href="{{ url('/actividades') }}">Actividades</a></li>
                <li><a href="{{ route('publicaciones.index') }}">Publicaciones</a></li>
                <li><a href="{{ url('/contacto') }}">Contacto</a></li>
                <li><a href="{{ url('/registro') }}">Hazte socio</a></li>
            </ul>
        </nav>

        <div class="baldosa baldosa--horario">
            <h2>Horario</h2>
            <dl>
                <div><dt>Lunes a viernes</dt><dd>{{ $footerConfig->horario_semana }}</dd></div>
                <div><dt>Sábado</dt><dd>{{ $footerConfig->horario_sabado }}</dd></div>
                <div><dt>Domingo</dt><dd>{{ $footerConfig->horario_domingo }}</dd></div>
            </dl>
        </div>

        <div class="baldosa baldosa--contacto">
            <h2>Contacto</h2>
            <div>
                @if ($footerConfig->email_contacto)
                    <a class="baldosa__correo" href="mailto:{{ $footerConfig->email_contacto }}">{{ $footerConfig->email_contacto }}</a>
                @endif
                @if ($footerConfig->telefono)
                    <p><a href="tel:{{ preg_replace('/\s+/', '', $footerConfig->telefono) }}">{{ $footerConfig->telefono }}</a></p>
                @endif
            </div>
            <div class="redes">
                @if ($footerConfig->instagram_url)
                    <a href="{{ $footerConfig->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="bi bi-instagram" aria-hidden="true"></i></a>
                @endif
                @if ($footerConfig->linkedin_url)
                    <a href="{{ $footerConfig->linkedin_url }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="bi bi-linkedin" aria-hidden="true"></i></a>
                @endif
                @if ($footerConfig->twitter_url)
                    <a href="{{ $footerConfig->twitter_url }}" target="_blank" rel="noopener noreferrer" aria-label="X"><i class="bi bi-twitter-x" aria-hidden="true"></i></a>
                @endif
                @if ($footerConfig->youtube_url)
                    <a href="{{ $footerConfig->youtube_url }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>
                @endif
            </div>
        </div>

        <div class="baldosa baldosa--marca" aria-hidden="true">
            <span>Biblioteca <em>DAW</em></span>
        </div>

        <a class="baldosa baldosa--accion" href="{{ url('/catalogo') }}">
            Entra en el catálogo
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true"><path d="M5 19L19 5M8 5h11v11" /></svg>
        </a>
    </div>

    <div class="pie__legal">
        <p>&copy; {{ date('Y') }} {{ $footerConfig->titulo ?: 'Biblioteca DAW' }}.
            @if ($footerConfig->aviso_legal_url)
                <a href="{{ url($footerConfig->aviso_legal_url) }}">Aviso legal</a> ·
            @endif
            @if ($footerConfig->politica_cookies_url)
                <a href="{{ url($footerConfig->politica_cookies_url) }}">Política de cookies</a>
            @endif
        </p>
        <p>Grabados y pinturas de dominio público: The Met, Art Institute of Chicago, Rijksmuseum y Wikimedia Commons.</p>
    </div>
</footer>